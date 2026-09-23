<?php
/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * api/create_document.php - Enregistrement d'un document et upload du PDF (POST)
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once __DIR__ . '/../config/database.php';

// Restriction : Seule la méthode POST est autorisée
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Méthode non autorisée. Seule la méthode POST est acceptée.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // 1. Récupération et nettoyage des données textuelles
    $code           = trim($_POST['code'] ?? '');
    $title          = trim($_POST['title'] ?? '');
    $type           = trim($_POST['type'] ?? '');
    $process_code   = trim($_POST['process_code'] ?? '');
    $version        = trim($_POST['version'] ?? '01');
    $status         = trim($_POST['status'] ?? 'brouillon');
    $process_owner  = trim($_POST['process_owner'] ?? '');
    $approver       = trim($_POST['approver'] ?? '');
    $effective_date = !empty($_POST['effective_date']) ? $_POST['effective_date'] : null;
    $review_date    = !empty($_POST['review_date']) ? $_POST['review_date'] : null;
    $origin         = trim($_POST['origin'] ?? 'interne');
    $change_reason  = trim($_POST['change_reason'] ?? 'Création initiale du document'); // Récupération de la raison de modification

    // Validation des champs obligatoires
    if (empty($code) || empty($title) || empty($type)) {
        http_response_code(400);
        echo json_encode([
            'error' => 'Champs obligatoires manquants : Code, Titre et Type sont requis.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. Traitement du fichier PDF joint
    $filePath = null;

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['file']['tmp_name'];
        $fileName      = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Vérification de l'extension
        if ($fileExtension !== 'pdf') {
            http_response_code(400);
            echo json_encode([
                'error' => 'Format invalide : Seuls les fichiers PDF (.pdf) sont autorisés.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Vérification du type MIME
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileTmpPath);
        finfo_close($finfo);

        if ($mimeType !== 'application/pdf') {
            http_response_code(400);
            echo json_encode([
                'error' => 'Le fichier fourni n\'est pas un document PDF valide.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Génération d'un nom de fichier unique et sécurisé
        $cleanCode     = preg_replace('/[^A-Za-z0-9\-]/', '_', $code);
        $newFileName   = 'DOC_' . $cleanCode . '_' . time() . '.pdf';
        $uploadDir     = __DIR__ . '/../uploads/';

        // Création du répertoire uploads s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $filePath = 'uploads/' . $newFileName;
        } else {
            http_response_code(500);
            echo json_encode([
                'error' => 'Échec du transfert du fichier vers le dossier /uploads.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // 3. Insertion en base de données MariaDB (Table documents)
    $query = "
        INSERT INTO documents (
            code, title, type, process_code, version, status, 
            process_owner, approver, effective_date, review_date, file_path, origin
        ) VALUES (
            :code, :title, :type, :process_code, :version, :status, 
            :process_owner, :approver, :effective_date, :review_date, :file_path, :origin
        )
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':code'           => $code,
        ':title'          => $title,
        ':type'           => $type,
        ':process_code'   => $process_code,
        ':version'        => $version,
        ':status'         => $status,
        ':process_owner'  => $process_owner,
        ':approver'       => $approver,
        ':effective_date' => $effective_date,
        ':review_date'    => $review_date,
        ':file_path'      => $filePath,
        ':origin'         => $origin
    ]);

    $newId = (int) $pdo->lastInsertId();

    // 4. Enregistrement automatique dans la table d'historique (Traçabilité ISO 17025)
    $queryHistory = "
        INSERT INTO document_history (
            document_id, code, title, version, status, 
            process_owner, approver, effective_date, review_date, file_path, change_reason
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";
    $stmtHistory = $pdo->prepare($queryHistory);
    $stmtHistory->execute([
        $newId,
        $code,
        $title,
        $version,
        $status,
        $process_owner,
        $approver,
        $effective_date,
        $review_date,
        $filePath,
        $change_reason
    ]);

    // Réponse HTTP 201 Created
    http_response_code(201);
    echo json_encode([
        'success'   => true,
        'message'   => 'Document enregistré et tracé avec succès.',
        'id'        => $newId,
        'file_path' => $filePath
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error'   => 'Erreur BDD lors de l\'enregistrement.',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
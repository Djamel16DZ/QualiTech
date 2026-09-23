<?php
/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * api/revise_document.php - Passage à une nouvelle version et archivage de l'ancienne (POST)
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Méthode non autorisée. Seule la méthode POST est acceptée.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $document_id    = filter_input(INPUT_POST, 'document_id', FILTER_VALIDATE_INT);
    $title          = trim($_POST['title'] ?? '');
    $version        = trim($_POST['version'] ?? '');
    $process_owner  = trim($_POST['process_owner'] ?? '');
    $approver       = trim($_POST['approver'] ?? '');
    $effective_date = !empty($_POST['effective_date']) ? $_POST['effective_date'] : null;
    $review_date    = !empty($_POST['review_date']) ? $_POST['review_date'] : null;
    $change_reason  = trim($_POST['change_reason'] ?? '');

    if (!$document_id || empty($title) || empty($version) || empty($change_reason)) {
        http_response_code(400);
        echo json_encode([
            'error' => 'Champs obligatoires manquants : ID, Titre, Version et Motif de modification requis.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 1. Récupérer l'état actuel du document avant de l'écraser/réviser
    $stmtSelect = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
    $stmtSelect->execute([$document_id]);
    $currentDoc = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    if (!$currentDoc) {
        http_response_code(404);
        echo json_encode(['error' => 'Document introuvable dans la base de données.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2. Archiver l'ancienne version dans document_history
    $stmtHistory = $pdo->prepare("
        INSERT INTO document_history (
            document_id, code, title, version, status, 
            process_owner, approver, effective_date, review_date, file_path, change_reason
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmtHistory->execute([
        $currentDoc['id'],
        $currentDoc['code'],
        $currentDoc['title'],
        $currentDoc['version'],
        $currentDoc['status'],
        $currentDoc['process_owner'],
        $currentDoc['approver'],
        $currentDoc['effective_date'],
        $currentDoc['review_date'],
        $currentDoc['file_path'],
        'Archivé suite au passage à la version ' . $version . ' : ' . $change_reason
    ]);

    // 3. Gérer l'upload du nouveau fichier PDF si fourni
    $filePath = $currentDoc['file_path']; // Par défaut, garde l'ancien fichier si aucun nouveau n'est uploadé

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['file']['tmp_name'];
        $fileName      = $_FILES['file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension !== 'pdf') {
            http_response_code(400);
            echo json_encode(['error' => 'Format invalide : Seuls les fichiers PDF (.pdf) sont autorisés.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fileTmpPath);
        finfo_close($finfo);

        if ($mimeType !== 'application/pdf') {
            http_response_code(400);
            echo json_encode(['error' => 'Le fichier fourni n\'est pas un document PDF valide.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $cleanCode   = preg_replace('/[^A-Za-z0-9\-]/', '_', $currentDoc['code']);
        $newFileName = 'DOC_' . $cleanCode . '_v' . $version . '_' . time() . '.pdf';
        $uploadDir   = __DIR__ . '/../uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $filePath = 'uploads/' . $newFileName;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Échec du transfert du nouveau fichier PDF.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // 4. Mettre à jour la table principale documents avec la nouvelle version
    $stmtUpdate = $pdo->prepare("
        UPDATE documents SET 
            title = ?, 
            version = ?, 
            process_owner = ?, 
            approver = ?, 
            effective_date = ?, 
            review_date = ?, 
            file_path = ?,
            status = 'en_vigueur'
        WHERE id = ?
    ");
    $stmtUpdate->execute([
        $title,
        $version,
        $process_owner,
        $approver,
        $effective_date,
        $review_date,
        $filePath,
        $document_id
    ]);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Document révisé avec succès vers la version v' . $version
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error'   => 'Erreur BDD lors de la révision.',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
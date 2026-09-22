<?php
// api/create_document.php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
    exit;
}

try {
    $pdo = getPDO();

    // Récupération des champs textes
    $code = trim($_POST['code'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $version = trim($_POST['version'] ?? '01');
    $status = trim($_POST['status'] ?? 'en_vigueur');
    $process_owner = trim($_POST['process_owner'] ?? '');
    $approver = trim($_POST['approver'] ?? '');
    $effective_date = !empty($_POST['effective_date']) ? $_POST['effective_date'] : null;
    $review_date = !empty($_POST['review_date']) ? $_POST['review_date'] : null;

    if (empty($code) || empty($title) || empty($type)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir les champs obligatoires (Code, Type, Intitulé).']);
        exit;
    }

    // Gestion du fichier PDF téléversé
    $filePath = null;
    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['doc_file']['tmp_name'];
        $fileName = $_FILES['doc_file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension !== 'pdf') {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Seuls les fichiers au format PDF sont autorisés.']);
            exit;
        }

        $uploadDir = __DIR__ . '/../uploads/';
        // Nom de fichier unique pour éviter les collisions
        $newFileName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $code) . '_' . time() . '.pdf';
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $filePath = 'uploads/' . $newFileName;
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors du déplacement du fichier PDF.']);
            exit;
        }
    }

    // Insertion dans la base de données
    $sql = "INSERT INTO quality_documents 
            (code, type, title, version, status, process_owner, approver, effective_date, review_date, file_path, created_at) 
            VALUES (:code, :type, :title, :version, :status, :process_owner, :approver, :effective_date, :review_date, :file_path, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':code' => $code,
        ':type' => $type,
        ':title' => $title,
        ':version' => $version,
        ':status' => $status,
        ':process_owner' => $process_owner,
        ':approver' => $approver,
        ':effective_date' => $effective_date,
        ':review_date' => $review_date,
        ':file_path' => $filePath
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Document créé avec succès.',
        'id' => $pdo->lastInsertId()
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur SQL : ' . $e->getMessage()
    ]);
}

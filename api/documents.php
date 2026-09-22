<?php
// api/documents.php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getPDO();
    
    // Requête ciblant la table 'quality_documents'
    $stmt = $pdo->query("SELECT * FROM quality_documents ORDER BY created_at DESC");
    $documents = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'count'  => count($documents),
        'data'   => $documents
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Erreur SQL : ' . $e->getMessage()
    ]);
}
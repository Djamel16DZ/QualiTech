<?php
/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * api/get_history.php - Récupération de l'historique des versions d'un document (GET)
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../config/database.php';

try {
    // Récupération et validation du paramètre document_id
    $documentId = filter_input(INPUT_GET, 'document_id', FILTER_VALIDATE_INT);

    if (!$documentId) {
        http_response_code(400);
        echo json_encode([
            'error' => 'Identifiant de document invalide ou manquant.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Requête pour récupérer l'historique incluant le file_path pour consultation des anciennes versions
    $stmt = $pdo->prepare('
        SELECT version, title, change_reason, process_owner AS author, effective_date, file_path, created_at 
        FROM document_history 
        WHERE document_id = ? 
        ORDER BY id DESC
    ');
    $stmt->execute([$documentId]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Rendu de la réponse JSON réussie
    echo json_encode($history, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error'   => 'Erreur BDD lors de la récupération de l\'historique.',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
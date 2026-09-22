<?php
/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * api/documents.php - Récupération de la liste des documents (GET)
 */

// En-têtes HTTP pour réponse JSON et encodage UTF-8
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Inclusion du fichier de connexion à la base de données ($pdo)
require_once __DIR__ . '/../config/database.php';

// Restriction : Seule la méthode GET est autorisée
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Méthode non autorisée. Seule la méthode GET est acceptée.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Requête pour extraire l'ensemble des métadonnées des documents
    $query = "
        SELECT 
            id, 
            code, 
            title, 
            type, 
            process_code, 
            version, 
            status, 
            process_owner, 
            approver, 
            effective_date, 
            review_date, 
            file_path, 
            origin 
        FROM documents 
        ORDER BY id DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cast explicite de l'ID en entier pour le JavaScript
    foreach ($documents as &$doc) {
        $doc['id'] = (int) $doc['id'];
    }

    // Réponse HTTP 200 OK avec le tableau JSON
    http_response_code(200);
    echo json_encode($documents, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Gestion des erreurs de base de données
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur lors de la récupération des documents.',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
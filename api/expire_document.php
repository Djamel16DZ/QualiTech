<?php
/**
 * QualiTech - API de déclassement d'un document (Passage au statut "Périmé")
 * api/expire_document.php
 */

header('Content-Type: application/json; charset=utf-8');

// Inclusion de la connexion à la base de données MariaDB (adaptez le chemin si besoin)
require_once __DIR__ . '/../config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode HTTP non autorisée (POST requis)']);
    exit;
}

$document_id = isset($_POST['document_id']) ? intval($_POST['document_id']) : 0;
$reason = isset($_POST['expiry_reason']) ? trim($_POST['expiry_reason']) : '';

if ($document_id <= 0) {
    echo json_encode(['error' => 'ID de document invalide.']);
    exit;
}

if (empty($reason)) {
    echo json_encode(['error' => 'Le motif du retrait / de la péremption est obligatoire (exigence ISO 17025).']);
    exit;
}

try {
    // 1. Vérifier si le document existe et récupérer ses infos
    $stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
    $stmt->execute([$document_id]);
    $doc = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doc) {
        echo json_encode(['error' => 'Document introuvable dans la base de données.']);
        exit;
    }

    if ($doc['status'] === 'perime') {
        echo json_encode(['error' => 'Ce document est déjà marqué comme périmé.']);
        exit;
    }

    // 2. Mettre à jour le statut du document en 'perime'
    // On peut aussi stocker le motif dans un champ de notes/historique si votre table le permet
    $updateStmt = $pdo->prepare("
        UPDATE documents 
        SET status = 'perime', updated_at = NOW() 
        WHERE id = ?
    ");
    $updateStmt->execute([$document_id]);

    // 3. Optionnel mais recommandé : Enregistrer l'événement dans la table d'historique 
    // pour garder la trace du retrait et de la justification
    try {
        $historyStmt = $pdo->prepare("
            INSERT INTO document_history (document_id, version, change_reason, author, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $historyStmt->execute([
            $document_id, 
            $doc['version'] ?? '01', 
            '[RETRAIT / PÉREMPTION] ' . $reason, 
            $doc['process_owner'] ?? 'Qualité'
        ]);
    } catch (Exception $e) {
        // La table d'historique n'est pas bloquante si elle a une structure légèrement différente
    }

    echo json_encode([
        'success' => true,
        'message' => 'Le document a été mis au rebut avec succès.'
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur de base de données MariaDB',
        'details' => $e->getMessage()
    ]);
}
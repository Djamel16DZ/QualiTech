<?php
// Activer l'affichage direct des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// Inclusion du fichier de configuration DB
require_once __DIR__ . '/../config/database.php';

try {
    // Obtenir la connexion PDO via la fonction getPDO()
    $pdo = getPDO();

    // Récupération des filtres depuis l'URL
    $process = isset($_GET['process']) ? trim($_GET['process']) : '';
    $type    = isset($_GET['type']) ? trim($_GET['type']) : '';
    $status  = isset($_GET['status']) ? trim($_GET['status']) : '';
    $origin  = isset($_GET['origin']) ? trim($_GET['origin']) : '';
    $search  = isset($_GET['search']) ? trim($_GET['search']) : '';

    $whereClauses = [];
    $params = [];

    if (!empty($process)) {
        $whereClauses[] = "process_code = :process";
        $params[':process'] = $process;
    }

    if (!empty($type)) {
        $whereClauses[] = "type = :type";
        $params[':type'] = $type;
    }

    if (!empty($status)) {
        $whereClauses[] = "status = :status";
        $params[':status'] = $status;
    }

    if (!empty($origin)) {
        $whereClauses[] = "origin = :origin";
        $params[':origin'] = $origin;
    }

    if (!empty($search)) {
        $whereClauses[] = "(code LIKE :search OR title LIKE :search OR process_owner LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    $sql = "SELECT * FROM documents";
    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    $sql .= " ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
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
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Erreur : ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
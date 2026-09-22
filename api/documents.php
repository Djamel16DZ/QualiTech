<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getPDO();

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

    // Sélection avec calcul dynamique de l'échéance de révision
    $sql = "SELECT d.*, 
            DATEDIFF(d.review_date, CURDATE()) AS days_until_review
            FROM documents d";

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    $sql .= " ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement pour qualifier l'état de révision
    foreach ($documents as &$doc) {
        if (empty($doc['review_date'])) {
            $doc['review_status'] = 'none';
        } elseif ($doc['days_until_review'] < 0) {
            $doc['review_status'] = 'overdue'; // En retard
        } elseif ($doc['days_until_review'] <= 30) {
            $doc['review_status'] = 'warning'; // Révision proche (<= 30 jours)
        } else {
            $doc['review_status'] = 'ok';
        }
    }

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
<?php
// config/database.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'qualitech_db');
define('DB_USER', 'root'); // Remplacez par votre utilisateur MariaDB si différent
define('DB_PASS', 'root');     // Remplacez par votre mot de passe MariaDB

function getPDO(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status'  => 'error',
                'message' => 'Erreur de connexion à la base de données : ' . $e->getMessage()
            ]);
            exit;
        }
    }

    return $pdo;
}

-- Désactivation temporaire des vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Vidage des tables (suppression de toutes les données existantes)
TRUNCATE TABLE document_history;
TRUNCATE TABLE documents;

-- Réactivation des vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;
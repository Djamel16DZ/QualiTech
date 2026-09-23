-- Insertion de documents de démonstration pour QualiTech ISO 17025
INSERT INTO documents (id, code, title, type, version, status, process_code, process_owner, approver, effective_date, review_date, origin, file_path) VALUES
(1, 'PROC-MQ-01', 'Manuel Qualité et Politique Qualité ISO 17025', 'manuel', '02', 'en_vigueur', 'MANAGEMENT', 'Jean Dupont', 'Marie Curie', '2025-01-15', '2026-12-31', 'interne', 'uploads/proc_mq_01_v02.pdf'),
(2, 'PRO-ESS-01', 'Procédure d''étalonnage des balances de précision', 'procedure', '01', 'en_vigueur', 'TECHNIQUE', 'Alice Martin', 'Jean Dupont', '2025-03-10', '2026-03-10', 'interne', 'uploads/pro_ess_01_v01.pdf'),
(3, 'MO-MET-04', 'Mode opératoire pour la vérification des micropipettes', 'mode_operatoire', '01', 'en_vigueur', 'TECHNIQUE', 'Marc Leroy', 'Alice Martin', '2025-06-01', '2026-06-01', 'interne', 'uploads/mo_met_04_v01.pdf'),
(4, 'FOR-LAB-12', 'Fiche de vie et d''enregistrement des étalons', 'formulaire', '03', 'perime', 'TECHNIQUE', 'Sophie Bernard', 'Jean Dupont', '2024-01-10', '2025-01-10', 'interne', 'uploads/for_lab_12_v03.pdf'),
(5, 'POL-SEC-01', 'Politique de sécurité informatique et intégrité des données', 'politique', '01', 'en_vigueur', 'MANAGEMENT', 'Admin IT', 'Direction', '2026-01-01', '2027-01-01', 'interne', 'uploads/pol_sec_01_v01.pdf'),
(6, 'EXT-ISO-02', 'Norme ISO/IEC 17025:2017 - Exigences générales', 'externe', '01', 'en_vigueur', 'REGLEMENTAIRE', 'Comité ISO', 'Direction', '2017-11-30', '2028-11-30', 'externe', 'uploads/ext_iso_02.pdf'),
(7, 'PRO-ACH-02', 'Gestion et qualification des fournisseurs critiques', 'procedure', '01', 'en_revision', 'ACHAT', 'Lucie Robert', 'Jean Dupont', '2025-04-15', '2026-04-15', 'interne', 'uploads/pro_ach_02_v01.pdf'),
(8, 'FOR-AUD-01', 'Rapport d''audit interne qualité', 'formulaire', '01', 'brouillon', 'QUALITE', 'Auditeur Interne', 'Responsable Qualité', NULL, NULL, 'interne', NULL);

-- Insertion de l'historique associé pour illustrer le versioning et la traçabilité
INSERT INTO document_history (document_id, version, change_reason, author, file_path, created_at) VALUES
(1, '01', 'Création initiale du Manuel Qualité', 'Jean Dupont', 'uploads/proc_mq_01_v01.pdf', '2024-01-10 10:00:00'),
(1, '02', 'Mise à jour suite à l''audit de renouvellement', 'Jean Dupont', 'uploads/proc_mq_01_v02.pdf', '2025-01-15 14:30:00'),
(4, '01', 'Version initiale', 'Sophie Bernard', NULL, '2022-01-10 09:00:00'),
(4, '02', 'Révision annuelle mineure', 'Sophie Bernard', NULL, '2023-01-10 09:00:00'),
(4, '03', 'Mise à jour des champs de traçabilité métrologique', 'Sophie Bernard', 'uploads/for_lab_12_v03.pdf', '2024-01-10 09:00:00');
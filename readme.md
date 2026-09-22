Voici une adaptation complète du README pour votre système de gestion documentaire selon la norme ISO 17025 (exigences relatives aux laboratoires d'étalonnages et d'essais).

Le projet est renommé **QualiTech 17025** et remplace la gestion des livres par une gestion stricte des documents de la qualité (Manuel Qualité, Procédures, Modes Opératoires, Formulaires, Enregistrements, etc.) tout en conservant l'architecture technique performante et légère.

---

# QualiTech 17025 — Système de Gestion Documentaire Qualité (ISO/IEC 17025)

Une interface web haute densité, réactive et prête pour la production, conçue pour la gestion documentaire réglementaire des laboratoires d'essais et d'étalonnages selon la norme **ISO/IEC 17025:2017**. Développé avec Tailwind CSS, Vanilla JavaScript et PHP (MariaDB), **QualiTech 17025** offre une expérience utilisateur rapide et axée sur le clavier pour contrôler, réviser et diffuser la documentation qualité.

---

## 🌟 Fonctionnalités Clés

* **Registre Central de la Documentation (Master Catalog Grid) :** Tableau principal à en-tête fixe avec tri rapide, badges de statut/type de document (Procédures, Modes Opératoires, Formulaires) et suivi de la version/révision en vigueur.
* **Navigation par Système Qualité :** Barre latérale repliable organisée par processus et exigences de la norme ISO 17025 (Exigences relatives aux ressources, aux processus, au système de management). Raccourci clavier (`Ctrl + B` ou `Cmd + B`).
* **Panneau d'Inspection Documentaire (Slide-Over Detail Drawer) :** Aperçu au clic des métadonnées ISO : codification/référence, indice de révision, statut d'approbation, rédacteur/vérificateur/approbateur, dates d'effet et actions de téléchargement/visuel.
* **Recherche Globale Instantanée :** Barre de recherche avec focus automatique (`/`) et filtres avancés par type de document, statut (En vigueur, En révision, Périmé) ou processus.
* **Gestion du Statut des Documents :** Vues séparées pour les documents d'origine interne (Procédure, MO, Polytique) et les documents d'origine externe (Normes, modes d'emploi d'équipements, guides COFRAC/BELAC/TUNAC).
* **Outils d'Ingestion & Métadonnées :** Interfaces d'importation massive (CSV/JSON), vérification automatique des échéances de révision et file d'attente d'audit des modifications.
* **Poids Plume & Sécurité :** Développé exclusivement avec des primitives web natives pour garantir un chargement instantané et une traçabilité sans dépendances lourdes.

---

## 📁 Architecture du Projet

```text
.
├── index.php             # Dashboard principal & table de la documentation qualité
├── README.md             # Documentation du projet
└── assets/               # Ressources statiques
    ├── css/              # Règles de mise en page & ajustements graphiques
    └── js/               # Gestion des vues, raccourcis clavier, tiroir d'aperçu

```

---

## ⚙️ Stack Technique & Prérequis

* **Frontend :** HTML5, Tailwind CSS (via CDN), FontAwesome 6.4 (Icônes), JavaScript Native (ES6+).
* **Backend :** PHP 8.x
* **Base de données :** MariaDB / MySQL (avec indexation `FULLTEXT` recommandée pour les recherches rapides).
* **Serveurs de développement supportés :** Laragon, XAMPP, Apache, Nginx, ou le serveur intégré de PHP.

---

## 🚀 Guide de Démarrage Rapide

### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-nom-utilisateur/qualitech-17025.git
cd qualitech-17025

```

### 2. Lancer en local via le serveur intégré PHP

Si PHP est déjà installé sur votre machine :

```bash
php -S localhost:8000

```

Rendez-vous sur `http://localhost:8000` dans votre navigateur.

### 3. Déploiement sur XAMPP / Laragon

1. Déplacez le dossier `qualitech-17025` dans le répertoire web racine (`htdocs` pour XAMPP ou `www` pour Laragon).
2. Ouvrez votre adresse locale dans le navigateur (ex: `http://localhost/qualitech-17025`).

---

## ⌨️ Raccourcis Clavier Globaux

| Raccourci | Action |
| --- | --- |
| `/` | Mettre le focus sur la barre de recherche principale |
| `Ctrl + B` / `Cmd + B` | Agrandir ou réduire le panneau de navigation |
| `Esc` | Fermer le panneau latéral d'aperçu du document |

---

## 🔧 Structure Suggérée de la Base de Données

Pour gérer la documentation ISO 17025 avec MariaDB, voici la structure recommandée :

```sql
CREATE TABLE `quality_documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(64) NOT NULL UNIQUE,                       -- Ex: PR-QUAL-001, MO-METH-005
  `title` VARCHAR(255) NOT NULL,                            -- Intitulé du document
  `type` ENUM('politique', 'manuel', 'procedure', 'mode_operatoire', 'formulaire', 'externe') NOT NULL DEFAULT 'procedure',
  `version` VARCHAR(16) NOT NULL DEFAULT '01',              -- Indice de révision (ex: A.1 ou 01)
  `status` ENUM('brouillon', 'en_revision', 'en_vigueur', 'perime') NOT NULL DEFAULT 'en_vigueur',
  `process_owner` VARCHAR(150) DEFAULT NULL,               -- Pilote du processus / Rédacteur
  `approver` VARCHAR(150) DEFAULT NULL,                    -- Responsable Qualité / Approbateur
  `effective_date` DATE DEFAULT NULL,                       -- Date d'application / d'effet
  `review_date` DATE DEFAULT NULL,                          -- Date prévue pour la prochaine révision
  `file_path` VARCHAR(512) DEFAULT NULL,                    -- Chemin vers le fichier PDF sécurisé
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FULLTEXT KEY `ft_doc_search` (`code`, `title`, `process_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

```

---

## 📜 Licence

Distribué sous la licence MIT. Libre d'utilisation pour des besoins personnels, académiques et commerciaux.

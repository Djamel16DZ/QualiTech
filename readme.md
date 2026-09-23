<p align="center">
  <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80" alt="QualiTech Banner" width="100%" style="border-radius: 8px;" />
</p>

<h1 align="center">QualiTech — Système de Gestion Documentaire (SGD)</h1>

<p align="center">
  <b>Solution open-source de maîtrise des informations documentées dédiée aux laboratoires d'essais et d'étalonnages.</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP Version" />
  <img src="https://img.shields.io/badge/MariaDB-10.4%2B-003545?style=flat-square&logo=mariadb&logoColor=white" alt="MariaDB" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Conformité-ISO%2FIEC%2017025-blue?style=flat-square" alt="ISO 17025 Compliant" />
  <img src="https://img.shields.io/badge/License-MIT-green.svg?style=flat-square" alt="License MIT" />
</p>

---

## 📋 Table des Matières

1. [Introduction & Proposition de Valeur](#-introduction--proposition-de-valeur)
2. [Aperçu de l'Interface (Dashboard)](#-aperçu-de-linterface-dashboard)
3. [Matrice de Conformité ISO 17025 (Chapitre 7.5)](#-matrice-de-conformité-iso-17025-chapitre-75)
4. [Spécifications Techniques & Architecture](#-spécifications-techniques--architecture)
5. [Arborescence du Projet](#-arborescence-du-projet)
6. [Fonctionnalités Clés](#-fonctionnalités-clés)
7. [Feuille de Route (Roadmap)](#-feuille-de-route--déploiement-de-qualitech-17025)
8. [Guide d'Installation Rapide](#-guide-dinstallation-rapide)
9. [Contribuer & Respect de la Conformité](#-contribuer--respect-de-la-conformité)

---

## 🎯 Introduction & Proposition de Valeur

Dans un laboratoire accrédité selon la norme **ISO/IEC 17025**, la gestion rigoureuse des documents qualité (procédures, modes opératoires, formulaires, manuels) est une exigence critique pour garantir la fiabilité des résultats. **QualiTech** offre un contrôle total du cycle de vie documentaire : rédaction, approbation, diffusion maîtrisée, versioning et mise au rebut.

---

## 🖥️ Aperçu de l'Interface (Dashboard)

```text
+---------------------------------------------------------------------------------------------------+
| [QualiTech]  Tableau de Bord ISO 17025                      Recherche globale (Code, Titre, Pilote) [Q] |
+---------------------------------------------------------------------------------------------------+
|  [ En Vigueur: 14 ]    [ En Révision: 3 ]    [ Brouillons: 2 ]    [ Périmés: 5 ]    [ Alertes: 1 ]  |
+---------------------------------------------------------------------------------------------------+
|  REGISTRE DOCUMENTAIRE                                              [ + Nouveau Document ]        |
|  +------------+-----------------------------------+----------------+---------+----------+-------+ |
|  | Code       | Titre du Document                 | Type           | Version | Statut   | Action| |
|  +------------+-----------------------------------+----------------+---------+----------+-------+ |
|  | PROC-MQ-01 | Manuel Qualité et Politique ISO   | Manuel         | v02     | Vigueur  |  [👁️] | |
|  | PRO-ESS-01 | Étalonnage des balances de préc.  | Procédure      | v01     | Vigueur  |  [👁️] | |
|  | PRO-ACH-02 | Qualification des fournisseurs    | Procédure      | v01     | Révision |  [👁️] | |
|  +------------+-----------------------------------+----------------+---------+----------+-------+ |
+---------------------------------------------------------------------------------------------------+
```

---

## 🛡️ Matrice de Conformité ISO 17025 (Chapitre 7.5)

| Exigence Normative (ISO 17025 §7.5) | Implémentation Concrète dans QualiTech | Statut |
| :--- | :--- | :--- |
| **7.5.1** — Maîtrise générale | Centralisation des documents dans une base MariaDB unique et sécurisée. | ✅ Implémenté |
| **7.5.2 a)** — Identification & Approbation | Attribution d'un code unique, de métadonnées (Pilote, Approbateur) et de dates d'effet. | ✅ Implémenté |
| **7.5.2 b)** — Revue & Mise à jour | Alertes visuelles automatiques pour les révisions à échéance ≤ 30 jours. | ✅ Implémenté |
| **7.5.2 c)** — Identification des modifications | Traçabilité de l'historique des versions (`document_history`) avec motif. | ✅ Implémenté |
| **7.5.2 d)** — Disponibilité des versions | Tiroir latéral (*Drawer*) interactif affichant les versions et l'accès aux PDF. | ✅ Implémenté |
| **7.5.2 e)** — Prévention de l'usage obsolète | Module de mise au rebut retirant instantanément le document du circuit actif. | ✅ Implémenté |

---

## ⚙️ Spécifications Techniques & Architecture

* **Front-End :** HTML5 sémantique, Tailwind CSS (Dark Mode), Vanilla JS modulaire (`window.AppState`, Fetch API), Font Awesome 6.
* **Back-End :** PHP orienté services pour l'API REST minimaliste et la validation stricte des uploads.
* **Base de Données :** MariaDB / MySQL relationnelle avec indexation des codes documents et table de versioning.
* **Sécurité & Stockage :** Isolation et nommage sécurisé des fichiers PDF joints dans `/uploads/`.

---

## 📁 Arborescence du Projet

```text
qualitech-17025/
├── api/
│   ├── create_document.php       # Ajout de nouveau document
│   ├── db.php                    # Connexion MariaDB mutualisée
│   ├── documents.php             # API de récupération et filtrage
│   ├── expire_document.php       # API de péremption
│   ├── get_history.php           # API historique des versions
│   └── revise_document.php       # Workflow de révision & versioning
├── assets/
│   ├── js/app.js                 # Logique front-end (AppState, rendu, modals, drawer)
│   └── css/                      # Styles complémentaires
├── database/
│   ├── clean_data.sql            # Script de nettoyage
│   └── seed_data.sql             # Script de peuplement (Mockup ISO 17025)
├── uploads/                      # Stockage des PDF joints
├── index.html                    # SPA point d'entrée
└── README.md                     # Documentation officielle
```

---

## 🚀 Fonctionnalités Clés

* **📊 KPIs Dynamiques :** Volumes par statut et alertes d'échéance en temps réel.
* **🔍 Recherche Avancée :** Filtrage multi-critères instantané.
* **📂 Tiroir de Consultation (*Drawer*) :** Fiche descriptive complète et historique des versions.
* **🔄 Workflow de Révision :** Passage de version (ex: `v01` $\rightarrow$ `v02`) avec archivage automatique.
* **🗑️ Gestion de la Péremption :** Bascule sécurisée vers le statut "Périmé" avec traçabilité.

---

## 🗺️ Feuille de Route — Déploiement de QualiTech 17025

* **Phase 1 : Socle Technique & Base de Données** (✅ Terminé)
* **Phase 2 : Backend PHP & API REST / Services** (✅ Terminé)
* **Phase 3 : Dynamisation du Frontend & Ergonomie** (✅ Terminé)
* **Phase 4 : Modules ISO 17025 Avancés & Traçabilité** (🚧 En cours / Prochaine étape)
* **Phase 5 : Sécurité, Rôles (RBAC) & Authentification** (📅 Planifié)
* **Phase 6 : Recette, Performance & Déploiement** (🔮 Vision)

---

## 🛠️ Guide d'Installation Rapide

### Prérequis
* Serveur local PHP (ex: XAMPP, Laragon) avec MariaDB / MySQL.
* Navigateur web moderne.

### Étapes d'installation
1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/Djamel16DZ/QualiTech.git
   ```
2. **Placer le dossier** sous la racine de votre serveur (`htdocs/qualitech-17025` ou `www/qualitech-17025`).
3. **Initialiser la base de données :**
   * Créer une base vide `qualitech` via phpMyAdmin.
   * Exécuter `database/clean_data.sql` puis `database/seed_data.sql`.
4. **Configurer la connexion :** Ajuster `api/db.php` si nécessaire.
5. **Lancer :** Ouvrir `http://localhost/qualitech-17025/`.

---

## 🤝 Contribuer & Respect de la Conformité

### Processus de Pull Request (PR)
1. **Issue :** Ouvrir une issue pour les modifications majeures.
2. **Fork & Branch :** `git checkout -b feature/nom-de-la-fonctionnalite` ou `fix/description-du-bug`.
3. **Développement :** Respecter l'architecture (PHP orienté services, Vanilla JS avec `AppState`). Tester en local.
4. **Commit :** Messages explicites (ex: `feat: ajout de l'alerte J-30 révision`).
5. **Soumission :** Ouvrir une PR vers `main` / `master` avec contexte et tests.

### 🛡️ Règle d'or ISO 17025
Toute modification touchant au versioning, aux métadonnées ou à la péremption doit impérativement préserver :
* L'intégrité de la table `document_history`.
* L'immutabilité logique des documents en vigueur.
* La sécurité des uploads dans `/uploads/`.

### 🐛 Rapport de Bugs
Ouvrir une issue en précisant environnement (PHP/OS), étapes de reproduction et comportement attendu vs observé.
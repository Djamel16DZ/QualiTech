## 🗺️ Feuille de Route — Déploiement de QualiTech 17025

### Phase 1 : Socle Technique & Base de Données (Jours 1 - 3)

* **Configuration de l'environnement local :**
* Structure des dossiers du projet.
* Base de données MariaDB sous XAMPP / Laragon.


* **Modélisation de la base de données :**
* Création de la table `quality_documents` (définie dans le README).
* Ajout de la table `users` (Rôles : Administrateur, Responsable Qualité, Technicien, Auditeur).
* Ajout de la table `document_history` (pour l'historique des révisions et le suivi des modifications exigé par l'ISO 17025).


* **Jeux de données de test (Seeders) :**
* Insertion de 20 à 30 vrais exemples de documents (PR-QUAL-001, MO-LAB-012, etc.) pour valider l'affichage.



---

### Phase 2 : Backend PHP & API REST / Services (Jours 4 - 7)

* **Architecture Backend :**
* Mise en place d'un système de routage simple ou de contrôleurs PHP (`DocumentController.php`).


* **CRUD Documentaire :**
* `GET /api/documents` : Récupération filtrée (statut, type, recherche globale avec SQL `FULLTEXT`).
* `POST /api/documents` : Enregistrement d'un nouveau document avec dépôt sécurisé de fichier PDF.
* `PUT /api/documents/{id}` : Révision / mise à jour des métadonnées (passage d'une version 01 à 02).
* `DELETE /api/documents/{id}` : Archiving / Obsolescence (principe ISO : on ne supprime pas, on passe le statut en `périmé`).


* **Gestion des Fichiers PDF :**
* Dossier de stockage sécurisé avec renommage automatique (`PR-QUAL-001_v02.pdf`).



---

### Phase 3 : Dynamisation du Frontend (Jours 8 - 11)

* **Liaison UI / Backend (AJAX / Fetch) :**
* Remplacement des données statiques d'Exemple dans `index.php` et `app.js` par des requêtes `fetch()` vers l'API PHP.


* **Recherche et Filtres Dynamiques :**
* Recherche instantanée à la saisie dans le header.
* Filtre rapide par Processus (Navigation latérale) et par Statut (En vigueur, En révision, Périmé).


* **Composants d'Interaction :**
* Remplissage dynamique du tiroir d'inspection (`Slide-Over Drawer`) au clic sur une ligne.
* Formulaire modal pour la création / révision d'un document.



---

### Phase 4 : Modules ISO 17025 Avancés (Jours 12 - 15)

* **Système d'Approbation & Workflow :**
* Circuit de validation : Rédacteur ➔ Vérificateur ➔ Approbateur Qualité.
* Horodatage des signatures/validations.


* **Alerte de Révision / Péremption :**
* Calcul automatique des échéances de révision annuelle ou biannuelle.
* Indicateurs visuels (badge orange/rouge) pour les documents proches de l'échéance.


* **Registre des Documents Externes :**
* Gestion spécifique des normes (ISO 17025, ISO 9001), notices constructeurs, guides d'incertitude.



---

### Phase 5 : Sécurité & Contrôle d'Accès (Jours 16 - 18)

* **Authentification & Session :**
* Connexion/Déconnexion utilisateur sécurisée (Sessions PHP / JWT).


* **Matrice des Droits (RBAC) :**
* **Lecteur/Technicien :** Consultation/Téléchargement des versions "En vigueur" uniquement.
* **Qualité/Admin :** Création, Révision, Modification des statuts, Gestion des accès.
* **Auditeur :** Accès en lecture seule à l'historique complet et aux versions périmées.



---

### Phase 6 : Recette & Déploiement (Jours 19 - 20)

* **Tests de conformité ISO :**
* Vérification de la non-altérabilité des documents en vigueur.
* Vérification de la traçabilité complète des révisions.


* **Optimisation des performances :**
* Vérification des temps de réponse sur les listes volumineuses.


* **Mise en production :**
* Configuration du serveur (Apache/Nginx), sécurisation du dossier d'upload PDF, et mise en place des sauvegardes de la base MariaDB.

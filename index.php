<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualiTech - Système de Gestion Documentaire ISO 17025</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        slate: {
                            850: '#111827',
                            950: '#0b0f19'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col font-sans antialiased">

    <!-- En-tête Principal (Plein écran) -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-30 w-full">
        <div class="w-full px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button id="btn-toggle-sidebar" onclick="toggleSidebar()" class="text-slate-400 hover:text-slate-100 hover:bg-slate-800 p-2 rounded-lg transition" title="Masquer/Afficher le panneau latéral">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="bg-blue-600/20 border border-blue-500/30 p-2 rounded-lg text-blue-400">
                    <i class="fa-solid fa-flask-vial text-xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-100 leading-tight">QualiTech <span class="text-xs font-normal text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded ml-2">ISO 17025</span></h1>
                    <p class="text-xs text-slate-400">Gestion Documentaire & Traçabilité Qualité</p>
                </div>
            </div>

            <!-- Recherche globale & Action rapide -->
            <div class="flex items-center space-x-4">
                <div class="relative w-64 md:w-80">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    <input type="text" id="global-search" placeholder="Rechercher code, titre, pilote... (/)" 
                           class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3 py-1.5 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
                </div>
                <button id="btn-open-modal" class="bg-blue-600 hover:bg-blue-500 text-white text-xs px-3.5 py-2 rounded-lg font-medium flex items-center space-x-2 transition shadow-lg shadow-blue-600/20 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nouveau Document</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Structure Principale pleine largeur avec Sidebar épinglée à gauche -->
    <div class="flex-1 w-full flex overflow-hidden">

        <!-- Barre Latérale Épinglée à Gauche -->
        <aside id="sidebar-nav" class="w-72 shrink-0 border-r border-slate-800/80 bg-slate-900/30 p-4 space-y-4 overflow-y-auto max-h-[calc(100vh-4rem)] transition-all duration-200">
            <!-- Navigation par Processus ISO 17025 -->
            <div class="space-y-3">
                <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-between px-1">
                    <span>Cartographie des Processus</span>
                    <i class="fa-solid fa-diagram-project text-slate-600"></i>
                </h2>
                
                <nav class="space-y-3 text-xs">
                    <!-- Option Tous -->
                    <a href="#" class="nav-item flex items-center justify-between px-2.5 py-1.5 rounded-lg text-slate-300 hover:bg-slate-800 transition bg-slate-800/60 font-medium" data-nav-filter="">
                        <span>Tous les processus</span>
                        <i class="fa-solid fa-layer-group text-[10px] text-slate-500"></i>
                    </a>

                    <!-- 1. Processus de Pilotage -->
                    <div>
                        <span class="text-[10px] font-semibold text-blue-400 uppercase tracking-wider px-2 block mb-1">Processus de Pilotage</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P1">
                                <span class="truncate pr-2">P1 - Planifier, organiser et communiquer</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P2">
                                <span class="truncate pr-2">P2 - Maîtriser les documents, enregistrements et docs ext.</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P3">
                                <span class="truncate pr-2">P3 - Écouter les clients</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P3</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P4">
                                <span class="truncate pr-2">P4 - Gérer et améliorer le système de management</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P4</span>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Processus de Réalisation -->
                    <div>
                        <span class="text-[10px] font-semibold text-emerald-400 uppercase tracking-wider px-2 block mb-1">Processus de Réalisation</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R1">
                                <span class="truncate pr-2">R1 - Préparer les objets d'essai</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R2">
                                <span class="truncate pr-2">R2 - Réaliser les essais</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R3">
                                <span class="truncate pr-2">R3 - Rédiger les rapports d'essai</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R3</span>
                            </a>
                        </div>
                    </div>

                    <!-- 3. Processus de Support -->
                    <div>
                        <span class="text-[10px] font-semibold text-amber-400 uppercase tracking-wider px-2 block mb-1">Processus de Support</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S1">
                                <span class="truncate pr-2">S1 - Gérer les incertitudes et la qualité des résultats</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S2">
                                <span class="truncate pr-2">S2 - Gérer le parc des instruments de mesure</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S3">
                                <span class="truncate pr-2">S3 - Gérer les ressources humaines</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S3</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S4">
                                <span class="truncate pr-2">S4 - Gérer les achats et les approvisionnements</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S4</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S5">
                                <span class="truncate pr-2">S5 - Gérer la maintenance</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S5</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S6">
                                <span class="truncate pr-2">S6 - Gérer le système d'information</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S6</span>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Navigation par Origine Documentaire -->
                <div class="border-t border-slate-800/80 pt-3 mt-3">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5 px-1">Origine</h3>
                    <nav class="space-y-0.5 text-xs">
                        <a href="#" class="nav-type flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-type="">
                            <span>Toutes les origines</span>
                            <i class="fa-solid fa-border-all text-[9px]"></i>
                        </a>
                        <a href="#" class="nav-type flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-type="interne">
                            <span>Interne (Ged)</span>
                            <i class="fa-solid fa-house text-[9px]"></i>
                        </a>
                        <a href="#" class="nav-type flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-type="externe">
                            <span>Externe (Normes, Client)</span>
                            <i class="fa-solid fa-globe text-[9px]"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </aside>

        <!-- Zone Contenu Principal (Prend toute la largeur restante) -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6 min-w-0">

            <!-- Grille des 5 Statistiques ISO 17025 -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                <!-- Carte 1 : En Vigueur -->
                <div id="card-vigueur" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-emerald-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">En Vigueur</p>
                        <h3 id="stat-vigueur" class="text-2xl font-bold text-emerald-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                </div>

                <!-- Carte 2 : En Révision -->
                <div id="card-revision" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-amber-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">En Révision</p>
                        <h3 id="stat-revision" class="text-2xl font-bold text-amber-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                        <i class="fa-solid fa-arrows-rotate text-sm"></i>
                    </div>
                </div>

                <!-- Carte 3 : Brouillons -->
                <div id="card-brouillon" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-slate-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Brouillons</p>
                        <h3 id="stat-brouillon" class="text-2xl font-bold text-slate-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-slate-500/10 border border-slate-500/20 flex items-center justify-center text-slate-400 shrink-0">
                        <i class="fa-solid fa-pen-ruler text-sm"></i>
                    </div>
                </div>

                <!-- Carte 4 : Périmés -->
                <div id="card-perime" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-rose-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Périmés</p>
                        <h3 id="stat-perime" class="text-2xl font-bold text-rose-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                        <i class="fa-solid fa-box-archive text-sm"></i>
                    </div>
                </div>

                <!-- Carte 5 : Échéances (-30j & Dépassées) -->
                <div id="card-alertes" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-amber-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Échéances -30j</p>
                        <h3 id="stat-alertes" class="text-2xl font-bold text-amber-500 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 shrink-0">
                        <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Zone de Filtres du Tableau -->
            <div class="bg-slate-900/40 border border-slate-800/80 rounded-xl p-4 flex flex-wrap gap-4 items-center justify-between">
                <div class="flex items-center space-x-3 text-xs">
                    <span class="text-slate-400 font-medium">Filtrer par :</span>
                    
                    <!-- Filtre Type -->
                    <select id="filter-type" class="bg-slate-950 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition">
                        <option value="">Tous les types</option>
                        <option value="procedure">Procédure</option>
                        <option value="mode_operatoire">Mode Opératoire</option>
                        <option value="formulaire">Formulaire</option>
                        <option value="manuel">Manuel</option>
                        <option value="politique">Politique</option>
                        <option value="externe">Doc. Externe</option>
                    </select>

                    <!-- Filtre Statut -->
                    <select id="filter-status" class="bg-slate-950 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition">
                        <option value="">Tous les statuts</option>
                        <option value="en_vigueur">En Vigueur</option>
                        <option value="en_revision">En Révision</option>
                        <option value="brouillon">Brouillon</option>
                        <option value="perime">Périmé</option>
                    </select>
                </div>

                <div class="text-xs text-slate-400">
                    Affichage : <span id="current-count" class="font-bold text-slate-200">0</span> / <span id="total-count" class="font-bold text-slate-200">0</span> document(s)
                </div>
            </div>

            <!-- Tableau Principal des Documents ISO 17025 -->
            <div class="bg-slate-900/40 border border-slate-800/80 rounded-xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-950/80 text-slate-400 border-b border-slate-800 uppercase text-[10px] tracking-wider font-semibold">
                            <tr>
                                <th class="p-3 whitespace-nowrap">Code</th>
                                <th class="p-3 min-w-[250px]">Titre du Document</th>
                                <th class="p-3 whitespace-nowrap">Type</th>
                                <th class="p-3 text-center whitespace-nowrap">Ver.</th>
                                <th class="p-3 whitespace-nowrap">Statut</th>
                                <th class="p-3 whitespace-nowrap">Pilote</th>
                                <th class="p-3 whitespace-nowrap">Prochaine Révision</th>
                                <th class="p-3 text-center whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="document-table-body" class="divide-y divide-slate-800/50">
                            <!-- Rendu dynamique via app.js -->
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-500">
                                    <i class="fa-solid fa-spinner fa-spin mr-2"></i> Chargement du registre documentaire...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modale : Création / Téléversement d'un Document -->
    <div id="modal-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-xl max-w-lg w-full p-6 shadow-2xl relative">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                <h3 class="font-bold text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-file-circle-plus text-blue-400"></i>
                    Nouveau Document Qualité
                </h3>
                <button id="close-modal" class="text-slate-400 hover:text-slate-200 transition">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form id="form-document" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Code Document *</label>
                        <input type="text" name="code" required placeholder="ex: PR-QUAL-005" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Processus *</label>
                        <select name="process_code" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                            <optgroup label="Pilotage">
                                <option value="P1">P1 - Planifier, organiser et communiquer</option>
                                <option value="P2">P2 - Maîtriser les documents, enregistrements et docs ext.</option>
                                <option value="P3">P3 - Écouter les clients</option>
                                <option value="P4">P4 - Gérer et améliorer le système de management</option>
                            </optgroup>
                            <optgroup label="Réalisation">
                                <option value="R1">R1 - Préparer les objets d'essai</option>
                                <option value="R2">R2 - Réaliser les essais</option>
                                <option value="R3">R3 - Rédiger les rapports d'essai</option>
                            </optgroup>
                            <optgroup label="Support">
                                <option value="S1">S1 - Gérer les incertitudes et la qualité des résultats</option>
                                <option value="S2">S2 - Gérer le parc des instruments de mesure</option>
                                <option value="S3">S3 - Gérer les ressources humaines</option>
                                <option value="S4">S4 - Gérer les achats et les approvisionnements</option>
                                <option value="S5">S5 - Gérer la maintenance</option>
                                <option value="S6">S6 - Gérer le système d'information</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1">Titre du Document *</label>
                    <input type="text" name="title" required placeholder="Intitulé exact de la procédure ou mode opératoire" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Type *</label>
                        <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="procedure">Procédure</option>
                            <option value="mode_operatoire">Mode Opératoire</option>
                            <option value="formulaire">Formulaire</option>
                            <option value="manuel">Manuel</option>
                            <option value="politique">Politique</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Version</label>
                        <input type="text" name="version" value="01" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Statut Initial</label>
                        <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="brouillon">Brouillon</option>
                            <option value="en_vigueur">En Vigueur</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Pilote / Rédacteur *</label>
                        <input type="text" name="process_owner" required placeholder="Nom du responsable" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Approbateur</label>
                        <input type="text" name="approver" placeholder="Responsable Qualité / Dir." class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Date d'effet</label>
                        <input type="date" name="effective_date" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Date de révision</label>
                        <input type="date" name="review_date" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1">Fichier PDF rattaché</label>
                    <input type="file" name="document_file" accept=".pdf" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3 py-1.5 text-slate-400 file:mr-3 file:py-1 file:px-2.5 file:rounded file:border-0 file:text-xs file:bg-blue-600/20 file:text-blue-400 hover:file:bg-blue-600/30">
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                    <button type="button" id="btn-cancel-modal" class="px-4 py-2 rounded-lg text-slate-400 hover:bg-slate-800 transition">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-medium transition shadow-lg shadow-blue-600/20">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tiroir Latéral (Drawer) : Consultation Métadonnées & PDF -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden"></div>
    <div id="detail-drawer" class="fixed top-0 right-0 bottom-0 w-96 bg-slate-900 border-l border-slate-800 z-50 transform translate-x-full transition-transform duration-300 ease-in-out p-6 flex flex-col justify-between">
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <span id="drawer-code" class="font-mono text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded border border-blue-500/20">--</span>
                    <h2 id="drawer-title" class="text-base font-bold text-slate-100 mt-2 leading-snug">--</h2>
                </div>
                <button id="close-drawer" class="text-slate-400 hover:text-slate-200 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-slate-500 block mb-1">Statut Actuel</span>
                    <div id="drawer-status">--</div>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-b border-slate-800/60 py-3">
                    <div>
                        <span class="text-slate-500 block">Version</span>
                        <span id="drawer-version" class="font-mono font-bold text-slate-200">--</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Rédacteur / Pilote</span>
                        <span id="drawer-author" class="text-slate-200">--</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <div>
                        <span class="text-slate-500 block">Approbateur</span>
                        <span id="drawer-approver" class="text-slate-200">--</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Date d'Application (Effet)</span>
                        <span id="drawer-effective" class="font-mono text-slate-200">--</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Prochaine Échéance de Révision</span>
                        <span id="drawer-review" class="font-mono text-slate-200">--</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-4">
            <a id="drawer-download" href="#" target="_blank" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-lg text-xs flex items-center justify-center space-x-2 transition shadow-lg shadow-blue-600/20">
                <i class="fa-solid fa-file-pdf text-sm"></i>
                <span>Consulter le Document (PDF)</span>
            </a>
        </div>
    </div>

    <!-- Script Inline pour le Toggle Fonctionnel de la Sidebar -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-nav');
            if (sidebar) {
                sidebar.classList.toggle('hidden');
            }
        }
    </script>

    <!-- Fichier JavaScript principal -->
    <script src="assets/js/app.js"></script>
</body>
</html>
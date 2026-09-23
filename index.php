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
<body class="bg-slate-950 text-slate-100 h-screen flex flex-col font-sans antialiased overflow-hidden">

    <!-- En-tête Principal (Hauteur fixe 4rem / h-16) -->
    <header class="h-16 border-b border-slate-800 bg-slate-900/80 backdrop-blur sticky top-0 z-30 w-full shrink-0">
        <div class="w-full px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
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

    <!-- Zone principale : Hauteur exacte du viewport restant (100vh - 4rem) -->
    <div class="flex-1 w-full flex h-[calc(100vh-4rem)] overflow-hidden">

        <!-- Barre Latérale : Épinglée à 100% de la hauteur -->
        <aside id="sidebar-nav" class="w-72 shrink-0 border-r border-slate-800/80 bg-slate-900/30 p-4 space-y-4 overflow-y-auto h-full transition-all duration-200">
            <div class="space-y-3">
                <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center justify-between px-1">
                    <span>Cartographie des Processus</span>
                    <i class="fa-solid fa-diagram-project text-slate-600"></i>
                </h2>
                
                <nav class="space-y-3 text-xs">
                    <a href="#" class="nav-item flex items-center justify-between px-2.5 py-1.5 rounded-lg text-slate-300 hover:bg-slate-800 transition bg-slate-800/60 font-medium" data-nav-filter="">
                        <span>Tous les processus</span>
                        <i class="fa-solid fa-layer-group text-[10px] text-slate-500"></i>
                    </a>

                    <!-- Pilotage -->
                    <div>
                        <span class="text-[10px] font-semibold text-blue-400 uppercase tracking-wider px-2 block mb-1">Processus de Pilotage</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P1" title="P1 - Planifier, organiser et communiquer">
                                <span class="truncate pr-2">P1 - Planifier, organiser et communiquer</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P2" title="P2 - Maîtriser les documents, enregistrements et docs ext.">
                                <span class="truncate pr-2">P2 - Maîtriser les documents, enregistrements et docs ext.</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P3" title="P3 - Écouter les clients">
                                <span class="truncate pr-2">P3 - Écouter les clients</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P3</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="P4" title="P4 - Gérer et améliorer le système de management">
                                <span class="truncate pr-2">P4 - Gérer et améliorer le système de management</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">P4</span>
                            </a>
                        </div>
                    </div>

                    <!-- Réalisation -->
                    <div>
                        <span class="text-[10px] font-semibold text-emerald-400 uppercase tracking-wider px-2 block mb-1">Processus de Réalisation</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R1" title="R1 - Préparer les objets d'essai">
                                <span class="truncate pr-2">R1 - Préparer les objets d'essai</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R2" title="R2 - Réaliser les essais">
                                <span class="truncate pr-2">R2 - Réaliser les essais</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="R3" title="R3 - Rédiger les rapports d'essai">
                                <span class="truncate pr-2">R3 - Rédiger les rapports d'essai</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">R3</span>
                            </a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div>
                        <span class="text-[10px] font-semibold text-amber-400 uppercase tracking-wider px-2 block mb-1">Processus de Support</span>
                        <div class="space-y-0.5">
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S1" title="S1 - Gérer les incertitudes et la qualité des résultats">
                                <span class="truncate pr-2">S1 - Gérer les incertitudes et la qualité des résultats</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S1</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S2" title="S2 - Gérer le parc des instruments de mesure">
                                <span class="truncate pr-2">S2 - Gérer le parc des instruments de mesure</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S2</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S3" title="S3 - Gérer les ressources humaines">
                                <span class="truncate pr-2">S3 - Gérer les ressources humaines</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S3</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S4" title="S4 - Gérer les achats et les approvisionnements">
                                <span class="truncate pr-2">S4 - Gérer les achats et les approvisionnements</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S4</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S5" title="S5 - Gérer la maintenance">
                                <span class="truncate pr-2">S5 - Gérer la maintenance</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S5</span>
                            </a>
                            <a href="#" class="nav-item flex items-center justify-between px-2 py-1 rounded text-slate-400 hover:text-slate-100 hover:bg-slate-800/60 transition" data-nav-filter="S6" title="S6 - Gérer le système d'information">
                                <span class="truncate pr-2">S6 - Gérer le système d'information</span>
                                <span class="font-mono text-[9px] bg-slate-800 px-1 py-0.5 rounded text-slate-400 shrink-0">S6</span>
                            </a>
                        </div>
                    </div>
                </nav>

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

        <!-- Zone de Contenu Principal -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6 h-full min-w-0">

            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                <div id="card-vigueur" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-emerald-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">En Vigueur</p>
                        <h3 id="stat-vigueur" class="text-2xl font-bold text-emerald-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                </div>

                <div id="card-revision" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-amber-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">En Révision</p>
                        <h3 id="stat-revision" class="text-2xl font-bold text-amber-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                        <i class="fa-solid fa-arrows-rotate text-sm"></i>
                    </div>
                </div>

                <div id="card-brouillon" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-slate-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Brouillons</p>
                        <h3 id="stat-brouillon" class="text-2xl font-bold text-slate-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-slate-500/10 border border-slate-500/20 flex items-center justify-center text-slate-400 shrink-0">
                        <i class="fa-solid fa-pen-ruler text-sm"></i>
                    </div>
                </div>

                <div id="card-perime" class="bg-slate-950 border border-slate-800 p-3.5 rounded-xl flex items-center justify-between transition hover:border-rose-500/40 cursor-pointer">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Périmés</p>
                        <h3 id="stat-perime" class="text-2xl font-bold text-rose-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                        <i class="fa-solid fa-box-archive text-sm"></i>
                    </div>
                </div>

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

            <!-- Barre de filtres -->
            <div class="bg-slate-900/40 border border-slate-800/80 rounded-xl p-4 flex flex-wrap gap-4 items-center justify-between">
                <div class="flex items-center space-x-3 text-xs">
                    <span class="text-slate-400 font-medium">Filtrer par :</span>
                    <select id="filter-type" class="bg-slate-950 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition">
                        <option value="">Tous les types</option>
                        <option value="procedure">Procédure</option>
                        <option value="mode_operatoire">Mode Opératoire</option>
                        <option value="formulaire">Formulaire</option>
                        <option value="manuel">Manuel</option>
                        <option value="politique">Politique</option>
                        <option value="externe">Doc. Externe</option>
                    </select>

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

            <!-- Tableau Fixe avec gestion Strict du Troncage -->
            <div class="bg-slate-900/40 border border-slate-800/80 rounded-xl overflow-hidden shadow-xl flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-300 table-fixed">
                        <thead class="bg-slate-950/80 text-slate-400 border-b border-slate-800 uppercase text-[10px] tracking-wider font-semibold">
                            <tr>
                                <th class="p-3 w-32 whitespace-nowrap">Code</th>
                                <th class="p-3 w-auto">Titre du Document</th>
                                <th class="p-3 w-36 whitespace-nowrap">Type</th>
                                <th class="p-3 w-16 text-center whitespace-nowrap">Ver.</th>
                                <th class="p-3 w-28 whitespace-nowrap">Statut</th>
                                <th class="p-3 w-36 whitespace-nowrap">Date d'application</th>
                                <th class="p-3 w-32 whitespace-nowrap">Prochaine Révision</th>
                                <th class="p-3 w-24 text-center whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="document-table-body" class="divide-y divide-slate-800/50">
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-500">
                                    <i class="fa-solid fa-spinner fa-spin mr-2"></i> Chargement du registre...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer du Tableau : Pagination Dynamique -->
                <div class="bg-slate-950/60 border-t border-slate-800/80 px-4 py-3 flex items-center justify-between text-xs text-slate-400">
                    <div>
                        Page <span id="page-current-num" class="font-bold text-slate-200">1</span> sur <span id="page-total-num" class="font-bold text-slate-200">1</span>
                    </div>
                    <div id="pagination-controls" class="flex items-center space-x-1">
                        <!-- Généré dynamiquement en JS -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODALE : CRÉATION DE DOCUMENT -->
    <div id="modal-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            
            <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-file-circle-plus text-blue-400"></i>
                    <h3 class="font-semibold text-slate-100 text-sm">Ajouter un nouveau document ISO 17025</h3>
                </div>
                <button id="close-modal" class="text-slate-400 hover:text-slate-200 text-lg p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="add-document-form" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Code Document *</label>
                        <input type="text" name="code" required placeholder="ex: PROC-TECH-001" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500 font-mono">
                    </div>

                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Processus Qualité *</label>
                        <select name="process_code" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                            <option value="P1">P1 - Planifier, organiser et communiquer</option>
                            <option value="P2">P2 - Maîtriser les documents</option>
                            <option value="P3">P3 - Écouter les clients</option>
                            <option value="P4">P4 - Gérer et améliorer le système</option>
                            <option value="R1">R1 - Préparer les objets d'essai</option>
                            <option value="R2">R2 - Réaliser les essais</option>
                            <option value="R3">R3 - Rédiger les rapports</option>
                            <option value="S1">S1 - Incertitudes et qualité</option>
                            <option value="S2">S2 - Instruments de mesure</option>
                            <option value="S3">S3 - Ressources humaines</option>
                            <option value="S4">S4 - Achats et approvisionnements</option>
                            <option value="S5">S5 - Maintenance</option>
                            <option value="S6">S6 - Système d'information</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Titre du Document *</label>
                    <input type="text" name="title" required placeholder="ex: Procédure d'étalonnage des balances" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Type *</label>
                        <select name="type" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                            <option value="procedure">Procédure</option>
                            <option value="mode_operatoire">Mode Opératoire</option>
                            <option value="formulaire">Formulaire</option>
                            <option value="manuel">Manuel</option>
                            <option value="politique">Politique</option>
                            <option value="externe">Doc. Externe</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Version *</label>
                        <input type="text" name="version" value="01" required placeholder="01" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 font-mono focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Statut *</label>
                        <select name="status" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                            <option value="brouillon">Brouillon</option>
                            <option value="en_vigueur">En Vigueur</option>
                            <option value="en_revision">En Révision</option>
                            <option value="perime">Périmé</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Pilote / Process Owner</label>
                        <input type="text" name="process_owner" placeholder="ex: Dr. Benali" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Approbateur</label>
                        <input type="text" name="approver" placeholder="ex: Responsable Qualité" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Date d'application</label>
                        <input type="date" name="effective_date" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500 font-mono">
                    </div>

                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Date de révision prévisionnelle</label>
                        <input type="date" name="review_date" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Origine</label>
                    <select name="origin" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                        <option value="interne">Interne</option>
                        <option value="externe">Externe</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Fichier PDF associé</label>
                    <input type="file" name="file" accept=".pdf" class="w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer">
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                    <button type="button" id="btn-cancel-modal" class="px-4 py-2 rounded-lg font-medium text-slate-400 hover:bg-slate-800 transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-lg font-medium bg-blue-600 hover:bg-blue-500 text-white transition flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODALE : RÉVISION / NOUVELLE VERSION DE DOCUMENT -->
    <div id="revise-modal-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            
            <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-code-pull-request text-amber-400"></i>
                    <h3 class="font-semibold text-slate-100 text-sm">Réviser le document (Nouvelle Version)</h3>
                </div>
                <button id="close-revise-modal" class="text-slate-400 hover:text-slate-200 text-lg p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="revise-document-form" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
                <input type="hidden" name="document_id" id="revise-doc-id">

                <div class="grid grid-cols-2 gap-4 bg-slate-950 p-3 rounded-xl border border-slate-800">
                    <div>
                        <span class="text-[10px] text-slate-400 block uppercase">Code Document</span>
                        <span id="revise-display-code" class="font-mono text-blue-400 font-semibold">--</span>
                        <input type="hidden" name="code" id="revise-input-code">
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 block uppercase">Version Actuelle -> Nouvelle</span>
                        <span id="revise-display-version" class="font-mono text-amber-400 font-semibold">--</span>
                        <input type="hidden" name="version" id="revise-input-version">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Titre du Document *</label>
                    <input type="text" name="title" id="revise-title" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Pilote / Process Owner</label>
                        <input type="text" name="process_owner" id="revise-owner" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Approbateur</label>
                        <input type="text" name="approver" id="revise-approver" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Nouvelle date d'application</label>
                        <input type="date" name="effective_date" id="revise-effective" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-300 mb-1">Nouvelle révision prévisionnelle</label>
                        <input type="date" name="review_date" id="revise-review" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-lg text-slate-100 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1 text-amber-400 font-semibold">Motif de la modification / Révision * (ISO 17025)</label>
                    <textarea name="change_reason" required rows="2" placeholder="Expliquez les raisons de cette mise à jour (ex: Évolution de la méthode d'essai...)" class="w-full px-3 py-2 bg-slate-950 border border-amber-500/40 rounded-lg text-slate-100 focus:outline-none focus:border-amber-500"></textarea>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Nouveau fichier PDF révisé</label>
                    <input type="file" name="file" accept=".pdf" class="w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer">
                </div>

                <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
                    <button type="button" id="btn-cancel-revise" class="px-4 py-2 rounded-lg font-medium text-slate-400 hover:bg-slate-800 transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-lg font-medium bg-amber-600 hover:bg-amber-500 text-white transition flex items-center gap-2">
                        <i class="fa-solid fa-arrows-rotate"></i> Valider la révision
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TIROIR LATÉRAL (DRAWER) DE CONSULTATION -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden"></div>
    
    <div id="detail-drawer" class="fixed top-0 right-0 bottom-0 w-96 bg-slate-900 border-l border-slate-800 z-50 transform translate-x-full transition-transform duration-300 ease-in-out p-6 flex flex-col justify-between shadow-2xl">
        <div class="space-y-6 overflow-y-auto flex-1 pr-1">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-circle-info text-blue-400"></i>
                    <h3 class="font-semibold text-slate-100 text-sm">Fiche Documentaire</h3>
                </div>
                <button id="close-drawer" class="text-slate-400 hover:text-slate-200 text-lg p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div>
                <span id="drawer-code" class="font-mono text-xs text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded">--</span>
                <h2 id="drawer-title" class="text-base font-bold text-slate-100 mt-2">--</h2>
            </div>

            <div class="grid grid-cols-2 gap-3 bg-slate-950 p-3.5 rounded-xl border border-slate-800/80 text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block uppercase">Statut Actuel</span>
                    <div id="drawer-status" class="mt-1">--</div>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block uppercase">Version</span>
                    <span id="drawer-version" class="font-mono text-slate-200 mt-1 block font-semibold">--</span>
                </div>
            </div>

            <div class="space-y-3 text-xs bg-slate-950/40 p-3.5 rounded-xl border border-slate-800/60">
                <div class="flex justify-between border-b border-slate-800/60 pb-2">
                    <span class="text-slate-400">Pilote du Processus :</span>
                    <span id="drawer-owner" class="text-slate-200 font-medium">--</span>
                </div>
                <div class="flex justify-between border-b border-slate-800/60 pb-2">
                    <span class="text-slate-400">Approbateur :</span>
                    <span id="drawer-approver" class="text-slate-200 font-medium">--</span>
                </div>
                <div class="flex justify-between border-b border-slate-800/60 pb-2">
                    <span class="text-slate-400">Date d'application :</span>
                    <span id="drawer-effective" class="font-mono text-slate-300">--</span>
                </div>
                <div class="flex justify-between pb-1">
                    <span class="text-slate-400">Prochaine révision :</span>
                    <span id="drawer-review" class="font-mono text-slate-300">--</span>
                </div>
            </div>

            <!-- Bouton de Révision ISO 17025 -->
            <div>
                <button id="btn-open-revise" class="w-full py-2 bg-amber-600/10 hover:bg-amber-600/20 text-amber-400 border border-amber-500/30 rounded-xl font-medium text-xs transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-code-pull-request"></i> Réviser ce document (Nouvelle version)
                </button>
            </div>

            <!-- Bouton de Mise au rebut / Périmer (Ajout Étape 2 - Géré dynamiquement en JS si "en_vigueur") -->
            <div id="container-btn-expire" class="hidden">
                <button id="btn-open-expire" class="w-full py-2 bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-500/30 rounded-xl font-medium text-xs transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-box-archive"></i> Mettre au rebut / Périmer ce document
                </button>
            </div>

            <!-- Section Historique & Traçabilité ISO 17025 -->
            <div class="border-t border-slate-800 pt-4">
                <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 flex items-center">
                    <i class="fa-solid fa-clock-rotate-left mr-1.5 text-blue-400"></i> Historique des versions
                </h4>
                <div id="drawer-history-list" class="space-y-2 text-xs">
                    <!-- Rempli dynamiquement par app.js -->
                    <span class="text-slate-500 italic">Sélectionnez un document...</span>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-800">
            <a id="drawer-pdf-link" href="#" target="_blank" class="w-full py-2.5 bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-500/30 rounded-xl font-medium text-xs transition flex items-center justify-center gap-2 hidden">
                <i class="fa-solid fa-file-pdf"></i> Ouvrir le document PDF
            </a>
        </div>
    </div>

    <!-- MODALE : MISE AU REBUT / PÉREMPTION DE DOCUMENT (Ajout Étape 2) -->
    <div id="expire-modal-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl flex flex-col">
            <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400"></i>
                    <h3 class="font-semibold text-slate-100 text-sm">Mettre au rebut / Périmer le document</h3>
                </div>
                <button id="close-expire-modal" class="text-slate-400 hover:text-slate-200 text-lg p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="expire-document-form" class="p-6 space-y-4 text-xs">
                <input type="hidden" name="document_id" id="expire-doc-id">

                <div class="bg-rose-500/10 border border-rose-500/20 p-3 rounded-xl text-rose-300">
                    <p class="font-medium">Attention :</p>
                    <p class="mt-1 text-slate-300">Vous êtes sur le point de périmer le document <span id="expire-display-code" class="font-mono font-bold text-rose-400">--</span>. Cette action arrêtera sa validité dans le système qualité.</p>
                </div>

                <div>
                    <label class="block font-medium text-slate-300 mb-1">Motif obligatoire de la mise au rebut * (ISO 17025)</label>
                    <textarea name="expiry_reason" required rows="3" placeholder="Expliquez pourquoi ce document est périmé (ex: Remplacé par une nouvelle version...)" class="w-full px-3 py-2 bg-slate-950 border border-rose-500/40 rounded-lg text-slate-100 focus:outline-none focus:border-rose-500"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-3">
                    <button type="button" id="btn-cancel-expire" class="px-4 py-2 rounded-lg font-medium text-slate-400 hover:bg-slate-800 transition">Annuler</button>
                    <button type="submit" class="px-5 py-2 rounded-lg font-medium bg-rose-600 hover:bg-rose-500 text-white transition flex items-center gap-2">
                        <i class="fa-solid fa-box-archive"></i> Confirmer la péremption
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script de bascule de la barre latérale -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-nav');
            if (sidebar) sidebar.classList.toggle('hidden');
        }
    </script>
    <!-- Script principal de l'application -->
    <script src="assets/js/app.js"></script>
</body>
</html>
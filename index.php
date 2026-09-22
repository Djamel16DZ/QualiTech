<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QualiTech 17025 — Gestion Documentaire Qualité</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="h-full flex overflow-hidden font-sans antialiased text-sm">

    <!-- COLLAPSIBLE SIDEBAR (Masquage total w-0) -->
    <aside id="sidebar" class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col transition-all duration-300 z-20 shrink-0 overflow-hidden">
        <!-- Logo & Header -->
        <div class="h-14 flex items-center justify-between px-4 border-b border-slate-800 shrink-0 w-64">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="p-2 bg-blue-600 rounded-lg text-white font-bold text-xs shrink-0">
                    <i class="fa-solid fa-award text-base"></i>
                </div>
                <span id="brand-title" class="font-bold text-slate-100 truncate text-base">QualiTech <span class="text-blue-500">17025</span></span>
            </div>
            <button id="toggle-sidebar" class="text-slate-400 hover:text-white p-1 rounded focus:outline-none transition" title="Masquer la barre (Ctrl+B)">
                <i class="fa-solid fa-angles-left text-sm"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1 w-64">
            
            <!-- Global Option -->
            <a href="#" data-nav-filter="" class="nav-item flex items-center px-3 py-2 text-slate-200 bg-blue-600/20 text-blue-400 rounded-md group font-medium transition mb-3" title="Tous les documents">
                <i class="fa-solid fa-folder-tree w-5 text-center shrink-0"></i>
                <span class="truncate ml-3">Tous les documents</span>
            </a>

            <!-- PROCESSUS DE PILOTAGE -->
            <div class="pt-2 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider truncate">
                Processus de Pilotage
            </div>
            <a href="#" data-nav-filter="P1" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="P1 - Planifier, organiser et communiquer">
                <i class="fa-solid fa-compass w-5 text-center shrink-0 text-slate-500 group-hover:text-blue-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">P1.</strong> Planifier, organiser & comm.</span>
            </a>
            <a href="#" data-nav-filter="P2" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="P2 - Maîtriser les documents, enregistrements et documents externes">
                <i class="fa-solid fa-file-signature w-5 text-center shrink-0 text-slate-500 group-hover:text-blue-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">P2.</strong> Maîtriser les documents</span>
            </a>
            <a href="#" data-nav-filter="P3" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="P3 - Écouter les clients">
                <i class="fa-solid fa-user-group w-5 text-center shrink-0 text-slate-500 group-hover:text-blue-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">P3.</strong> Écouter les clients</span>
            </a>
            <a href="#" data-nav-filter="P4" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="P4 - Gérer et améliorer le système de management">
                <i class="fa-solid fa-chart-line w-5 text-center shrink-0 text-slate-500 group-hover:text-blue-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">P4.</strong> Gérer & améliorer le SMQ</span>
            </a>

            <!-- PROCESSUS DE RÉALISATION -->
            <div class="pt-3 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider truncate">
                Processus de Réalisation
            </div>
            <a href="#" data-nav-filter="R1" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="R1 - Préparer les objets d'essai">
                <i class="fa-solid fa-boxes-packing w-5 text-center shrink-0 text-slate-500 group-hover:text-emerald-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">R1.</strong> Préparer les objets d'essai</span>
            </a>
            <a href="#" data-nav-filter="R2" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="R2 - Réaliser les essais">
                <i class="fa-solid fa-flask-vial w-5 text-center shrink-0 text-slate-500 group-hover:text-emerald-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">R2.</strong> Réaliser les essais</span>
            </a>
            <a href="#" data-nav-filter="R3" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="R3 - Rédiger les rapports d'essai">
                <i class="fa-solid fa-file-lines w-5 text-center shrink-0 text-slate-500 group-hover:text-emerald-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">R3.</strong> Rédiger les rapports d'essai</span>
            </a>

            <!-- PROCESSUS DE SUPPORT -->
            <div class="pt-3 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider truncate">
                Processus de Support
            </div>
            <a href="#" data-nav-filter="S1" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S1 - Gérer les incertitudes et la qualité des résultats">
                <i class="fa-solid fa-calculator w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S1.</strong> Incertitudes & Qualité</span>
            </a>
            <a href="#" data-nav-filter="S2" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S2 - Gérer le parc des instruments de mesure">
                <i class="fa-solid fa-microscope w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S2.</strong> Instruments de mesure</span>
            </a>
            <a href="#" data-nav-filter="S3" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S3 - Gérer les ressources humaines">
                <i class="fa-solid fa-users-gear w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S3.</strong> Ressources Humaines</span>
            </a>
            <a href="#" data-nav-filter="S4" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S4 - Gérer les achats et les approvisionnements">
                <i class="fa-solid fa-cart-shopping w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S4.</strong> Achats & Approvisionnements</span>
            </a>
            <a href="#" data-nav-filter="S5" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S5 - Gérer la maintenance">
                <i class="fa-solid fa-wrench w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S5.</strong> Gérer la maintenance</span>
            </a>
            <a href="#" data-nav-filter="S6" class="nav-item flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="S6 - Gérer le système d'information">
                <i class="fa-solid fa-server w-5 text-center shrink-0 text-slate-500 group-hover:text-amber-400"></i>
                <span class="truncate ml-3"><strong class="text-slate-300">S6.</strong> Système d'Information</span>
            </a>

            <!-- ORIGINE DOCUMENTAIRE -->
            <div class="pt-3 px-3 pb-1 text-[10px] font-bold text-slate-500 uppercase tracking-wider truncate">
                Origine Documentaire
            </div>
            <a href="#" data-nav-type="interne" class="nav-type flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="Documents Internes">
                <i class="fa-solid fa-file-contract w-5 text-center shrink-0"></i>
                <span class="truncate ml-3">Documents Internes</span>
            </a>
            <a href="#" data-nav-type="externe" class="nav-type flex items-center px-3 py-1.5 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group transition text-xs" title="Documents Externes">
                <i class="fa-solid fa-book-bookmark w-5 text-center shrink-0"></i>
                <span class="truncate ml-3">Documents Externes</span>
            </a>
        </nav>

        <!-- User Footer -->
        <div class="p-3 border-t border-slate-800 flex items-center space-x-3 shrink-0 w-64">
            <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-slate-300 shrink-0">
                RQ
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-medium text-slate-200 truncate">Responsable Qualité</p>
                <p class="text-[10px] text-slate-500 truncate">labo-17025@domain.com</p>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- HEADER / NAVBAR -->
        <header class="h-14 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-4 z-10 shrink-0">
            <!-- Bouton pour afficher la barre quand elle est masquée -->
            <div class="flex items-center space-x-3">
                <button id="btn-reveal-sidebar" class="hidden text-slate-400 hover:text-white p-2 rounded bg-slate-950 border border-slate-800 focus:outline-none transition" title="Afficher la barre (Ctrl+B)">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                <!-- Global Search Bar -->
                <div class="w-96 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" id="global-search" placeholder="Rechercher par code, titre, pilote... (Appuyez sur '/' pour cibler)"
                        class="w-full pl-9 pr-12 py-1.5 bg-slate-950 border border-slate-800 rounded-md text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <kbd class="px-1.5 py-0.5 text-[10px] bg-slate-800 text-slate-400 border border-slate-700 rounded font-mono">/</kbd>
                    </div>
                </div>
            </div>

            <!-- Top Actions -->
            <div class="flex items-center space-x-3 ml-4">
                <button id="btn-open-modal" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-medium text-xs flex items-center transition shadow-lg shadow-blue-600/20">
                    <i class="fa-solid fa-plus mr-1.5"></i> Nouveau Document
                </button>
            </div>
        </header>

        <!-- CONTENT BODY -->
        <main class="flex-1 overflow-y-auto flex flex-col p-4 bg-slate-900">
            
            <!-- BLOC STATISTIQUES ISO 17025 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Statut : En Vigueur -->
                <div class="bg-slate-950 border border-slate-800 p-3.5 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">En Vigueur</p>
                        <h3 id="stat-vigueur" class="text-2xl font-bold text-emerald-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <i class="fa-solid fa-circle-check text-base"></i>
                    </div>
                </div>

                <!-- Statut : En Révision -->
                <div class="bg-slate-950 border border-slate-800 p-3.5 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">En Révision</p>
                        <h3 id="stat-revision" class="text-2xl font-bold text-amber-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                    </div>
                </div>

                <!-- Statut : Brouillons -->
                <div class="bg-slate-950 border border-slate-800 p-3.5 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Brouillons</p>
                        <h3 id="stat-brouillon" class="text-2xl font-bold text-slate-300 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-slate-500/10 border border-slate-500/20 flex items-center justify-center text-slate-400">
                        <i class="fa-solid fa-file-pen text-base"></i>
                    </div>
                </div>

                <!-- Statut : Périmés -->
                <div class="bg-slate-950 border border-slate-800 p-3.5 rounded-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Périmés</p>
                        <h3 id="stat-perime" class="text-2xl font-bold text-rose-400 mt-0.5">0</h3>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                        <i class="fa-solid fa-triangle-exclamation text-base"></i>
                    </div>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="mb-3 flex flex-wrap gap-2 items-center justify-between">
                <div class="flex items-center gap-2">
                    <select id="filter-type" class="bg-slate-950 border border-slate-800 text-slate-300 text-xs rounded-md px-2.5 py-1.5 focus:outline-none focus:border-blue-500">
                        <option value="">Tous les Types</option>
                        <option value="politique">Politiques</option>
                        <option value="manuel">Manuel Qualité</option>
                        <option value="procedure">Procédures</option>
                        <option value="mode_operatoire">Modes Opératoires</option>
                        <option value="formulaire">Formulaires</option>
                        <option value="externe">Documents Externes</option>
                    </select>

                    <select id="filter-status" class="bg-slate-950 border border-slate-800 text-slate-300 text-xs rounded-md px-2.5 py-1.5 focus:outline-none focus:border-blue-500">
                        <option value="">Tous les Statuts</option>
                        <option value="en_vigueur">En Vigueur</option>
                        <option value="en_revision">En Révision</option>
                        <option value="brouillon">Brouillon</option>
                        <option value="perime">Périmé</option>
                    </select>
                </div>

                <div class="text-xs text-slate-400">
                    Affichage de <span id="current-count" class="font-semibold text-slate-200">0</span> sur <span id="total-count" class="font-semibold text-slate-200">0</span> documents
                </div>
            </div>

            <!-- MASTER CATALOG GRID TABLE -->
            <div class="flex-1 bg-slate-950 rounded-lg border border-slate-800 overflow-hidden flex flex-col min-h-[350px]">
                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-left text-xs text-slate-300 border-collapse">
                        <thead class="bg-slate-900/90 text-slate-400 font-semibold border-b border-slate-800 sticky top-0 backdrop-blur-sm z-10">
                            <tr>
                                <th class="p-3 w-32">Code / Réf.</th>
                                <th class="p-3">Intitulé du Document</th>
                                <th class="p-3 w-32">Type</th>
                                <th class="p-3 w-20 text-center">Indice</th>
                                <th class="p-3 w-28">Statut</th>
                                <th class="p-3 w-36">Pilote / Rédacteur</th>
                                <th class="p-3 w-28">Date d'effet</th>
                                <th class="p-3 w-16 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60" id="document-table-body">
                            <tr>
                                <td colspan="8" class="p-6 text-center text-slate-500">
                                    <i class="fa-solid fa-spinner fa-spin mr-2"></i> Chargement des documents qualité...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="h-10 bg-slate-900 border-t border-slate-800 flex items-center justify-between px-4 text-xs text-slate-400 shrink-0">
                    <div id="pagination-info">Page 1 sur 1</div>
                    <div class="flex items-center space-x-1">
                        <button id="btn-prev" class="px-2 py-1 bg-slate-800 rounded border border-slate-700 hover:bg-slate-700 text-slate-300 disabled:opacity-50" disabled>Précédent</button>
                        <button id="btn-next" class="px-2 py-1 bg-slate-800 rounded border border-slate-700 hover:bg-slate-700 text-slate-300 disabled:opacity-50" disabled>Suivant</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- SLIDE-OVER DETAIL DRAWER -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-30 hidden transition-opacity"></div>
    <aside id="detail-drawer" class="fixed top-0 right-0 h-full w-96 bg-slate-900 border-l border-slate-800 z-40 transform translate-x-full transition-transform duration-300 flex flex-col shadow-2xl">
        <div class="h-14 px-4 border-b border-slate-800 flex items-center justify-between bg-slate-950">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-file-shield text-blue-500"></i>
                <span class="font-bold text-slate-200">Fiche Métadonnées ISO</span>
            </div>
            <button id="close-drawer" class="text-slate-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-6 text-xs">
            <div class="border-b border-slate-800 pb-3">
                <span id="drawer-code" class="font-mono text-blue-400 font-bold text-sm">--</span>
                <h3 id="drawer-title" class="font-semibold text-slate-100 text-base mt-1">Sélectionnez un document</h3>
            </div>

            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-950 p-2.5 rounded border border-slate-800">
                        <span class="text-slate-500 block text-[10px] uppercase font-semibold">Indice Révision</span>
                        <span id="drawer-version" class="text-slate-200 font-bold font-mono">--</span>
                    </div>
                    <div class="bg-slate-950 p-2.5 rounded border border-slate-800">
                        <span class="text-slate-500 block text-[10px] uppercase font-semibold">Statut</span>
                        <span id="drawer-status" class="text-slate-400 font-semibold">--</span>
                    </div>
                </div>

                <div class="bg-slate-950 p-3 rounded border border-slate-800 space-y-2">
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase font-semibold">Rédacteur / Pilote</span>
                        <span id="drawer-author" class="text-slate-200">--</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase font-semibold">Approbateur</span>
                        <span id="drawer-approver" class="text-slate-200">--</span>
                    </div>
                </div>

                <div class="bg-slate-950 p-3 rounded border border-slate-800 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Date d'application:</span>
                        <span id="drawer-effective" class="text-slate-300 font-mono">--</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Prochaine révision:</span>
                        <span id="drawer-review" class="text-slate-300 font-mono">--</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <a href="#" id="drawer-download" target="_blank" class="w-full py-2 bg-blue-600 hover:bg-blue-500 text-white rounded font-medium flex items-center justify-center space-x-2 transition opacity-50 cursor-not-allowed">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Consulter le Document (PDF)</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- MODAL NEW DOCUMENT -->
    <div id="modal-overlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-lg w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="h-12 px-4 border-b border-slate-800 flex items-center justify-between bg-slate-950">
                <span class="font-bold text-slate-200 text-sm"><i class="fa-solid fa-file-circle-plus text-blue-500 mr-2"></i>Nouveau Document Qualité</span>
                <button id="close-modal" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-document" class="p-4 space-y-3 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Code / Référence *</label>
                        <input type="text" name="code" required placeholder="ex: PR-QUAL-009" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Type *</label>
                        <select name="type" required class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="procedure">Procédure</option>
                            <option value="mode_operatoire">Mode Opératoire</option>
                            <option value="formulaire">Formulaire</option>
                            <option value="manuel">Manuel</option>
                            <option value="politique">Politique</option>
                            <option value="externe">Document Externe</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1">Intitulé du Document *</label>
                    <input type="text" name="title" required placeholder="Titre complet..." class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Version / Indice</label>
                        <input type="text" name="version" value="01" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Statut</label>
                        <select name="status" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                            <option value="en_vigueur">En Vigueur</option>
                            <option value="en_revision">En Révision</option>
                            <option value="brouillon">Brouillon</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Rédacteur / Pilote</label>
                        <input type="text" name="process_owner" placeholder="Nom du responsable" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Approbateur</label>
                        <input type="text" name="approver" placeholder="Responsable Qualité" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-400 mb-1">Date d'effet</label>
                        <input type="date" name="effective_date" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1">Prochaine révision</label>
                        <input type="date" name="review_date" class="w-full p-2 bg-slate-950 border border-slate-800 rounded text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1">Fichier PDF</label>
                    <input type="file" name="doc_file" accept=".pdf" class="w-full p-1.5 bg-slate-950 border border-slate-800 rounded text-slate-400 focus:outline-none">
                </div>

                <div class="pt-3 flex justify-end space-x-2">
                    <button type="button" id="btn-cancel-modal" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded font-medium">Annuler</button>
                    <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded font-medium">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT DE GESTION DU MASQUAGE TOTAL DE LA BARRE LATÉRALE -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const revealBtn = document.getElementById('btn-reveal-sidebar');

            function toggleSidebar() {
                const isHidden = sidebar.classList.contains('w-0');

                if (isHidden) {
                    // Afficher la barre
                    sidebar.classList.remove('w-0', 'border-none');
                    sidebar.classList.add('w-64');
                    revealBtn.classList.add('hidden');
                } else {
                    // Masquer complètement la barre
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-0', 'border-none');
                    revealBtn.classList.remove('hidden');
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (revealBtn) revealBtn.addEventListener('click', toggleSidebar);

            // Raccourci clavier Ctrl + B pour basculer la barre latérale
            window.addEventListener('keydown', (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        });
    </script>
    <script src="assets/js/app.js"></script>
</body>
</html>
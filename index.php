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

    <!-- COLLAPSIBLE SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col transition-all duration-300 z-20 shrink-0">
        <!-- Logo & Header -->
        <div class="h-14 flex items-center justify-between px-4 border-b border-slate-800">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="p-2 bg-blue-600 rounded-lg text-white font-bold text-xs shrink-0">
                    <i class="fa-solid fa-award text-base"></i>
                </div>
                <span id="brand-title" class="font-bold text-slate-100 truncate text-base">QualiTech <span class="text-blue-500">17025</span></span>
            </div>
            <button id="toggle-sidebar" class="text-slate-400 hover:text-white focus:outline-none" title="Réduire la barre (Ctrl+B)">
                <i class="fa-solid fa-angles-left"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
            <div class="px-3 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider sidebar-label">
                Processus ISO 17025
            </div>
            <a href="#" data-nav-filter="" class="nav-item flex items-center px-3 py-2 text-slate-200 bg-blue-600/20 text-blue-400 rounded-md group font-medium">
                <i class="fa-solid fa-folder-tree w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">Tous les documents</span>
            </a>
            <a href="#" data-nav-filter="exigences_generales" class="nav-item flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-user-shield w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">§4. Exigences Générales</span>
            </a>
            <a href="#" data-nav-filter="structure" class="nav-item flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-sitemap w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">§5. Structure Organisationnelle</span>
            </a>
            <a href="#" data-nav-filter="ressources" class="nav-item flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-microscope w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">§6. Ressources (Équipements)</span>
            </a>
            <a href="#" data-nav-filter="processus" class="nav-item flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-flask-vial w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">§7. Exigences de Processus</span>
            </a>
            <a href="#" data-nav-filter="management" class="nav-item flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-gears w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">§8. Système de Management</span>
            </a>

            <div class="pt-4 px-3 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider sidebar-label">
                Origine Documentaire
            </div>
            <a href="#" data-nav-type="interne" class="nav-type flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-file-contract w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">Documents Internes</span>
            </a>
            <a href="#" data-nav-type="externe" class="nav-type flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 rounded-md group">
                <i class="fa-solid fa-book-bookmark w-5 text-center mr-3"></i>
                <span class="sidebar-text truncate">Documents Externes</span>
            </a>
        </nav>

        <!-- User Footer -->
        <div class="p-3 border-t border-slate-800 flex items-center space-x-3">
            <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-slate-300 shrink-0">
                RQ
            </div>
            <div class="overflow-hidden sidebar-text">
                <p class="text-xs font-medium text-slate-200 truncate">Responsable Qualité</p>
                <p class="text-[10px] text-slate-500 truncate">labo-17025@domain.com</p>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- HEADER / NAVBAR -->
        <header class="h-14 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-4 z-10">
            <!-- Global Search Bar -->
            <div class="flex-1 max-w-2xl relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="global-search" placeholder="Rechercher par code (ex: PR-QUAL-001), titre, rédacteur... (Appuyez sur '/' pour cibler)"
                    class="w-full pl-9 pr-12 py-1.5 bg-slate-950 border border-slate-800 rounded-md text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <kbd class="px-1.5 py-0.5 text-[10px] bg-slate-800 text-slate-400 border border-slate-700 rounded font-mono">/</kbd>
                </div>
            </div>

            <!-- Top Actions -->
            <div class="flex items-center space-x-3 ml-4">
                <button id="btn-open-modal" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-md font-medium text-xs flex items-center transition">
                    <i class="fa-solid fa-plus mr-1.5"></i> Nouveau Document
                </button>
            </div>
        </header>

        <!-- CONTENT BODY -->
        <main class="flex-1 overflow-hidden flex flex-col p-4 bg-slate-900">
            
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
            <div class="flex-1 bg-slate-950 rounded-lg border border-slate-800 overflow-hidden flex flex-col">
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
                            <!-- Injected dynamically via assets/js/app.js -->
                            <tr>
                                <td colspan="8" class="p-6 text-center text-slate-500">
                                    <i class="fa-solid fa-spinner fa-spin mr-2"></i> Chargement des documents qualité...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                <div class="h-10 bg-slate-900 border-t border-slate-800 flex items-center justify-between px-4 text-xs text-slate-400">
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
        <!-- Drawer Header -->
        <div class="h-14 px-4 border-b border-slate-800 flex items-center justify-between bg-slate-950">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-file-shield text-blue-500"></i>
                <span class="font-bold text-slate-200">Fiche Métadonnées ISO</span>
            </div>
            <button id="close-drawer" class="text-slate-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <!-- Drawer Content -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6 text-xs">
            <!-- Document Header Title -->
            <div class="border-b border-slate-800 pb-3">
                <span id="drawer-code" class="font-mono text-blue-400 font-bold text-sm">--</span>
                <h3 id="drawer-title" class="font-semibold text-slate-100 text-base mt-1">Sélectionnez un document</h3>
            </div>

            <!-- Metadata List -->
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

            <!-- Download / Action Button -->
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

    <script src="assets/js/app.js"></script>
</body>
</html>
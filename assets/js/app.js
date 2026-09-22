/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * app.js - Gestion de l'affichage, pagination, filtres et interactions
 */

/* ==========================================================================
   0. INITIALISATION SÉCURISÉE
   ========================================================================== */

function startApp() {
    // Variable d'état global
    window.AppState = {
        documents: [],
        filteredDocuments: [],
        currentPage: 1,
        itemsPerPage: 10,
        filters: {
            search: '',
            type: '',
            status: '',
            process: '',
            origin: ''
        }
    };

    // Initialisation des événements et chargement
    initEvents();
    loadDocuments();
}

// Sécurité : s'exécute que le DOM soit en cours de chargement ou déjà prêt
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startApp);
} else {
    startApp();
}

/* ==========================================================================
   1. DONNÉES & CHARGEMENT
   ========================================================================== */

/**
 * Charge les documents depuis le backend PHP/API ou utilise un Mock Data ISO 17025
 */
async function loadDocuments() {
    try {
        // Décommentez pour connecter votre API PHP réelle :
        // const response = await fetch('api/get_documents.php');
        // window.AppState.documents = await response.json();

        // Données de démonstration (Mock Data) conformes ISO 17025
        window.AppState.documents = [
            { id: 1, code: 'PR-PIL-001', title: 'Procédure de maîtrise de la documentation et des enregistrements qualité', type: 'procedure', process_code: 'P2', version: '03', status: 'en_vigueur', process_owner: 'Dr. Karim Benali', approver: 'Directeur Qualité', effective_date: '2025-01-15', review_date: '2027-01-15', origin: 'interne' },
            { id: 2, code: 'MO-ESS-012', title: 'Mode opératoire d\'essai de compression sur bétons hydrauliques (NF EN 12390-3)', type: 'mode_operatoire', process_code: 'R2', version: '02', status: 'en_vigueur', process_owner: 'Ing. Amina Khelil', approver: 'Resp. Laboratoire', effective_date: '2024-06-10', review_date: '2026-10-15', origin: 'interne' },
            { id: 3, code: 'FOR-MET-004', title: 'Fiche d\'étalonnage et vérification métrologique des dynamomètres et capteurs de force', type: 'formulaire', process_code: 'S2', version: '01', status: 'en_revision', process_owner: 'Technicien Métrologie', approver: 'Resp. Métrologie', effective_date: '2023-11-01', review_date: '2026-09-30', origin: 'interne' },
            { id: 4, code: 'POL-QUAL-001', title: 'Politique d\'impartialité, d\'indépendance et de confidentialité du laboratoire', type: 'politique', process_code: 'P1', version: '04', status: 'en_vigueur', process_owner: 'Direction Générale', approver: 'Comité de Direction', effective_date: '2026-01-05', review_date: '2028-01-05', origin: 'interne' },
            { id: 5, code: 'MAN-QUAL-17025', title: 'Manuel de Management de la Qualité ISO/IEC 17025:2017', type: 'manuel', process_code: 'P4', version: '05', status: 'en_vigueur', process_owner: 'Resp. Qualité', approver: 'Directeur Général', effective_date: '2025-03-20', review_date: '2027-03-20', origin: 'interne' },
            { id: 6, code: 'PR-SUP-008', title: 'Procédure d\'évaluation des incertitudes de mesure selon le GUM', type: 'procedure', process_code: 'S1', version: '01', status: 'brouillon', process_owner: 'Ing. Yassine Mourad', approver: 'Resp. Qualité', effective_date: '', review_date: '2026-11-30', origin: 'interne' },
            { id: 7, code: 'EXT-ISO-17025', title: 'Norme ISO/IEC 17025:2017 - Exigences générales concernant la compétence des laboratoires d\'étalonnages et d\'essais', type: 'externe', process_code: 'P2', version: '2017', status: 'en_vigueur', process_owner: 'Veille Normative', approver: 'ISO/CEI', effective_date: '2017-11-01', review_date: '2027-12-31', origin: 'externe' },
            { id: 8, code: 'MO-ESS-015', title: 'Analyse granulométrique des granulats par tamisage (NF EN 933-1)', type: 'mode_operatoire', process_code: 'R2', version: '01', status: 'perime', process_owner: 'Ing. Amina Khelil', approver: 'Resp. Laboratoire', effective_date: '2020-02-10', review_date: '2024-02-10', origin: 'interne' },
            { id: 9, code: 'FOR-ACH-002', title: 'Grille d\'évaluation et d\'habilitation des fournisseurs de prestations d\'étalonnage externe (COFRAC/ALGERAC)', type: 'formulaire', process_code: 'S4', version: '02', status: 'en_vigueur', process_owner: 'Resp. Achats', approver: 'Resp. Qualité', effective_date: '2025-05-12', review_date: '2026-10-01', origin: 'interne' },
            { id: 10, code: 'PR-PIL-003', title: 'Procédure de traitement des réclamations clients, travaux non conformes et actions correctives', type: 'procedure', process_code: 'P3', version: '03', status: 'en_vigueur', process_owner: 'Resp. Clientèle', approver: 'Directeur Qualité', effective_date: '2024-09-01', review_date: '2026-12-01', origin: 'interne' },
            { id: 11, code: 'MO-SUP-020', title: 'Sauvegarde, sécurisation des données et gestion du système d\'information LIMS', type: 'mode_operatoire', process_code: 'S6', version: '02', status: 'en_vigueur', process_owner: 'Administrateur IT', approver: 'Resp. Système Info', effective_date: '2025-08-14', review_date: '2027-08-14', origin: 'interne' },
            { id: 12, code: 'FOR-RH-005', title: 'Matrice de compétences et fiche d\'autorisation d\'exécution des essais du personnel', type: 'formulaire', process_code: 'S3', version: '03', status: 'en_vigueur', process_owner: 'Resp. RH', approver: 'Resp. Technique', effective_date: '2025-02-01', review_date: '2026-10-20', origin: 'interne' }
        ];

        applyFilters();
    } catch (error) {
        console.error('Erreur lors du chargement des documents :', error);
    }
}

/* ==========================================================================
   2. FILTRAGE & RECHERCHE
   ========================================================================== */

/**
 * Applique l'ensemble des filtres actifs sur le jeu de données
 */
function applyFilters() {
    const { search, type, status, process, origin } = window.AppState.filters;

    window.AppState.filteredDocuments = window.AppState.documents.filter(doc => {
        // Recherche textuelle (Code, Titre, Pilote)
        const matchesSearch = !search || 
            doc.code.toLowerCase().includes(search.toLowerCase()) ||
            doc.title.toLowerCase().includes(search.toLowerCase()) ||
            doc.process_owner.toLowerCase().includes(search.toLowerCase());

        // Filtre par Type
        const matchesType = !type || doc.type === type;

        // Filtre par Statut
        const matchesStatus = !status || doc.status === status;

        // Filtre par Processus ISO
        const matchesProcess = !process || doc.process_code === process;

        // Filtre par Origine
        const matchesOrigin = !origin || doc.origin === origin;

        return matchesSearch && matchesType && matchesStatus && matchesProcess && matchesOrigin;
    });

    // Réinitialiser à la première page à chaque changement de filtre
    window.AppState.currentPage = 1;

    // Mise à jour des compteurs et du tableau
    updateStatistics();
    renderTable();
}

/* ==========================================================================
   3. RENDU DU TABLEAU & PAGINATION
   ========================================================================== */

/**
 * Rendu dynamique du tableau avec troncage du texte et gestion de pagination
 */
function renderTable() {
    const tbody = document.getElementById('document-table-body');
    if (!tbody) return;

    tbody.innerHTML = '';
    const docs = window.AppState.filteredDocuments;

    if (docs.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="p-8 text-center text-slate-500">
                    <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                    Aucun document ne correspond à vos critères de recherche.
                </td>
            </tr>`;
        renderPagination(0);
        return;
    }

    // Calculs de pagination (10 éléments max par page)
    const itemsPerPage = window.AppState.itemsPerPage;
    const totalPages = Math.ceil(docs.length / itemsPerPage);

    if (window.AppState.currentPage > totalPages) {
        window.AppState.currentPage = totalPages || 1;
    }

    const startIndex = (window.AppState.currentPage - 1) * itemsPerPage;
    const paginatedDocs = docs.slice(startIndex, startIndex + itemsPerPage);

    // Génération des lignes du tableau
    paginatedDocs.forEach(doc => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-800/30 transition group border-b border-slate-800/40';

        tr.innerHTML = `
            <!-- Code avec points de suspension (truncate) et tooltip au survol -->
            <td class="p-3 font-mono text-blue-400 font-semibold truncate" title="${escapeHtml(doc.code)}">
                ${escapeHtml(doc.code)}
            </td>

            <!-- Titre complet au survol (title) -->
            <td class="p-3 font-medium text-slate-100">
                <div class="truncate cursor-help" title="${escapeHtml(doc.title)}">
                    ${escapeHtml(doc.title)}
                </div>
            </td>

            <td class="p-3 capitalize truncate text-slate-300" title="${escapeHtml(formatTypeLabel(doc.type))}">
                ${escapeHtml(formatTypeLabel(doc.type))}
            </td>

            <td class="p-3 text-center font-mono text-slate-400">
                v${escapeHtml(doc.version)}
            </td>

            <td class="p-3 whitespace-nowrap">
                ${getStatusBadge(doc.status)}
            </td>

            <!-- Pilote / Rédacteur avec survol -->
            <td class="p-3 truncate text-slate-300" title="${escapeHtml(doc.process_owner)}">
                ${escapeHtml(doc.process_owner)}
            </td>

            <td class="p-3 font-mono text-xs ${isDeadlineAlert(doc.review_date) ? 'text-amber-400 font-bold' : 'text-slate-400'}">
                ${doc.review_date || '--'}
            </td>

            <td class="p-3 text-center whitespace-nowrap">
                <button onclick="openDrawer(${doc.id})" class="text-slate-400 hover:text-blue-400 p-1.5 rounded-lg hover:bg-slate-800 transition" title="Consulter la fiche détaillée">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Mettre à jour les indicateurs de quantité
    const currentCountEl = document.getElementById('current-count');
    const totalCountEl = document.getElementById('total-count');
    if (currentCountEl) currentCountEl.textContent = paginatedDocs.length;
    if (totalCountEl) totalCountEl.textContent = docs.length;

    renderPagination(totalPages);
}

/**
 * Génère les boutons de pagination
 */
function renderPagination(totalPages) {
    const controls = document.getElementById('pagination-controls');
    const currentPageNum = document.getElementById('page-current-num');
    const totalPageNum = document.getElementById('page-total-num');

    if (currentPageNum) currentPageNum.textContent = totalPages === 0 ? 0 : window.AppState.currentPage;
    if (totalPageNum) totalPageNum.textContent = totalPages;

    if (!controls) return;
    controls.innerHTML = '';

    if (totalPages <= 1) return;

    // Bouton PRÉCÉDENT
    const prevBtn = document.createElement('button');
    prevBtn.className = `px-2.5 py-1 rounded border border-slate-800 text-xs transition ${
        window.AppState.currentPage === 1 
        ? 'opacity-40 cursor-not-allowed text-slate-600' 
        : 'hover:bg-slate-800 text-slate-300'
    }`;
    prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
    prevBtn.disabled = window.AppState.currentPage === 1;
    prevBtn.onclick = () => {
        if (window.AppState.currentPage > 1) {
            window.AppState.currentPage--;
            renderTable();
        }
    };
    controls.appendChild(prevBtn);

    // Boutons de numéros de pages [1], [2], [3]...
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('button');
        const isActive = i === window.AppState.currentPage;
        pageBtn.className = `px-2.5 py-1 rounded text-xs font-medium transition ${
            isActive 
            ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' 
            : 'border border-slate-800 text-slate-400 hover:bg-slate-800 hover:text-slate-200'
        }`;
        pageBtn.textContent = i;
        pageBtn.onclick = () => {
            window.AppState.currentPage = i;
            renderTable();
        };
        controls.appendChild(pageBtn);
    }

    // Bouton SUIVANT
    const nextBtn = document.createElement('button');
    nextBtn.className = `px-2.5 py-1 rounded border border-slate-800 text-xs transition ${
        window.AppState.currentPage === totalPages 
        ? 'opacity-40 cursor-not-allowed text-slate-600' 
        : 'hover:bg-slate-800 text-slate-300'
    }`;
    nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
    nextBtn.disabled = window.AppState.currentPage === totalPages;
    nextBtn.onclick = () => {
        if (window.AppState.currentPage < totalPages) {
            window.AppState.currentPage++;
            renderTable();
        }
    };
    controls.appendChild(nextBtn);
}

/* ==========================================================================
   4. COMPTEURS ET STATISTIQUES ISO 17025
   ========================================================================== */

function updateStatistics() {
    const docs = window.AppState.documents;

    const countVigueur = docs.filter(d => d.status === 'en_vigueur').length;
    const countRevision = docs.filter(d => d.status === 'en_revision').length;
    const countBrouillon = docs.filter(d => d.status === 'brouillon').length;
    const countPerime = docs.filter(d => d.status === 'perime').length;
    const countAlertes = docs.filter(d => isDeadlineAlert(d.review_date)).length;

    setStatText('stat-vigueur', countVigueur);
    setStatText('stat-revision', countRevision);
    setStatText('stat-brouillon', countBrouillon);
    setStatText('stat-perime', countPerime);
    setStatText('stat-alertes', countAlertes);
}

function setStatText(id, value) {
    const el = document.getElementById(id);
    if (el) el.textContent = value;
}

/* ==========================================================================
   5. ÉVÉNEMENTS & ÉCOUTEURS
   ========================================================================== */

function initEvents() {
    // 1. Recherche globale avec raccourci clavier '/'
    const searchInput = document.getElementById('global-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            window.AppState.filters.search = e.target.value.trim();
            applyFilters();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement !== searchInput) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }

    // 2. Filtres déroulants (Type et Statut)
    const filterType = document.getElementById('filter-type');
    if (filterType) {
        filterType.addEventListener('change', (e) => {
            window.AppState.filters.type = e.target.value;
            applyFilters();
        });
    }

    const filterStatus = document.getElementById('filter-status');
    if (filterStatus) {
        filterStatus.addEventListener('change', (e) => {
            window.AppState.filters.status = e.target.value;
            applyFilters();
        });
    }

    // 3. Navigation dans la Sidebar (Processus ISO)
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('bg-slate-800/60', 'font-medium', 'text-slate-100'));
            item.classList.add('bg-slate-800/60', 'font-medium', 'text-slate-100');

            window.AppState.filters.process = item.getAttribute('data-nav-filter') || '';
            applyFilters();
        });
    });

    // 4. Navigation Origine (Interne / Externe)
    document.querySelectorAll('.nav-type').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-type').forEach(i => i.classList.remove('bg-slate-800/60', 'font-medium', 'text-slate-100'));
            item.classList.add('bg-slate-800/60', 'font-medium', 'text-slate-100');

            window.AppState.filters.origin = item.getAttribute('data-nav-type') || '';
            applyFilters();
        });
    });

    // 5. Clics sur les cartes de statistiques pour filtrage rapide
    bindCardFilter('card-vigueur', 'en_vigueur');
    bindCardFilter('card-revision', 'en_revision');
    bindCardFilter('card-brouillon', 'brouillon');
    bindCardFilter('card-perime', 'perime');

    // 6. Gestion de la Modale de Création
    const btnOpenModal = document.getElementById('btn-open-modal');
    const btnCloseModal = document.getElementById('close-modal');
    const btnCancelModal = document.getElementById('btn-cancel-modal');
    const modalOverlay = document.getElementById('modal-overlay');

    if (btnOpenModal) btnOpenModal.addEventListener('click', () => modalOverlay?.classList.remove('hidden'));
    if (btnCloseModal) btnCloseModal.addEventListener('click', () => modalOverlay?.classList.add('hidden'));
    if (btnCancelModal) btnCancelModal.addEventListener('click', () => modalOverlay?.classList.add('hidden'));

    // Soumission du formulaire
    const formDoc = document.getElementById('form-document');
    if (formDoc) {
        formDoc.addEventListener('submit', handleFormSubmit);
    }

    // 7. Fermeture du Drawer
    const closeDrawerBtn = document.getElementById('close-drawer');
    const drawerOverlay = document.getElementById('drawer-overlay');

    if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeDrawer);
    if (drawerOverlay) drawerOverlay.addEventListener('click', closeDrawer);
}

function bindCardFilter(cardId, statusValue) {
    const card = document.getElementById(cardId);
    if (card) {
        card.addEventListener('click', () => {
            const filterStatus = document.getElementById('filter-status');
            if (filterStatus) {
                filterStatus.value = statusValue;
                window.AppState.filters.status = statusValue;
                applyFilters();
            }
        });
    }
}

/* ==========================================================================
   6. DRAWER (TIROIR DE CONSULTATION)
   ========================================================================== */

function openDrawer(docId) {
    const doc = window.AppState.documents.find(d => d.id === docId || d.id === parseInt(docId));
    if (!doc) return;

    const setElText = (id, txt) => {
        const el = document.getElementById(id);
        if (el) el.textContent = txt;
    };

    setElText('drawer-code', doc.code);
    setElText('drawer-title', doc.title);
    
    const statusEl = document.getElementById('drawer-status');
    if (statusEl) statusEl.innerHTML = getStatusBadge(doc.status);

    setElText('drawer-version', 'v' + doc.version);
    setElText('drawer-author', doc.process_owner);
    setElText('drawer-approver', doc.approver || '--');
    setElText('drawer-effective', doc.effective_date || '--');
    setElText('drawer-review', doc.review_date || '--');

    const drawer = document.getElementById('detail-drawer');
    const overlay = document.getElementById('drawer-overlay');

    if (overlay) overlay.classList.remove('hidden');
    if (drawer) drawer.classList.remove('translate-x-full');
}

function closeDrawer() {
    const drawer = document.getElementById('detail-drawer');
    const overlay = document.getElementById('drawer-overlay');

    if (drawer) drawer.classList.add('translate-x-full');
    if (overlay) overlay.classList.add('hidden');
}

/* ==========================================================================
   7. CRÉATION D'UN DOCUMENT (SOUMISSION FORMULAIRE)
   ========================================================================== */

function handleFormSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);

    const newDoc = {
        id: Date.now(),
        code: formData.get('code'),
        title: formData.get('title'),
        type: formData.get('type'),
        process_code: formData.get('process_code'),
        version: formData.get('version') || '01',
        status: formData.get('status') || 'brouillon',
        process_owner: formData.get('process_owner'),
        approver: formData.get('approver') || '',
        effective_date: formData.get('effective_date') || '',
        review_date: formData.get('review_date') || '',
        origin: 'interne'
    };

    // Ajouter au tableau local
    window.AppState.documents.unshift(newDoc);
    applyFilters();

    // Réinitialiser et fermer
    e.target.reset();
    document.getElementById('modal-overlay')?.classList.add('hidden');
}

/* ==========================================================================
   8. UTILITAIRES DE FORMATAGE & SÉCURITÉ
   ========================================================================== */

function getStatusBadge(status) {
    switch (status) {
        case 'en_vigueur':
            return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20"><i class="fa-solid fa-circle-check text-[9px]"></i> En Vigueur</span>`;
        case 'en_revision':
            return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20"><i class="fa-solid fa-arrows-rotate text-[9px]"></i> En Révision</span>`;
        case 'brouillon':
            return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20"><i class="fa-solid fa-pen-ruler text-[9px]"></i> Brouillon</span>`;
        case 'perime':
            return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20"><i class="fa-solid fa-box-archive text-[9px]"></i> Périmé</span>`;
        default:
            return `<span class="px-2 py-0.5 rounded text-[11px] bg-slate-800 text-slate-400">${status}</span>`;
    }
}

function formatTypeLabel(type) {
    const labels = {
        procedure: 'Procédure',
        mode_operatoire: 'Mode Opératoire',
        formulaire: 'Formulaire',
        manuel: 'Manuel',
        politique: 'Politique',
        externe: 'Doc. Externe'
    };
    return labels[type] || type;
}

function isDeadlineAlert(dateString) {
    if (!dateString) return false;
    const reviewDate = new Date(dateString);
    const today = new Date();
    const diffDays = Math.ceil((reviewDate - today) / (1000 * 60 * 60 * 24));
    return diffDays <= 30; // Alerte si l'échéance est dans moins de 30 jours ou dépassée
}

function escapeHtml(str) {
    return String(str || '')
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
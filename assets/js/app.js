/**
 * QualiTech - Système de Gestion Documentaire ISO 17025
 * assets/js/app.js - Logique Front-End, Interface Riche & API PHP/MariaDB
 */

/* ==========================================================================
   0. INITIALISATION SÉCURISÉE
   ========================================================================== */

function startApp() {
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
        },
        currentSelectedDoc: null // Stocke le document actif dans le drawer
    };

    initEvents();
    loadDocuments();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startApp);
} else {
    startApp();
}

/* ==========================================================================
   1. CHARGEMENT DEPUIS L'API
   ========================================================================== */

async function loadDocuments() {
    const tbody = document.getElementById('document-table-body');
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="p-8 text-center text-slate-400">
                    <i class="fa-solid fa-spinner fa-spin text-2xl mb-2 block"></i>
                    Chargement du registre documentaire...
                </td>
            </tr>`;
    }

    try {
        const response = await fetch('api/documents.php');
        if (!response.ok) {
            const errData = await response.json();
            throw new Error(errData.error || `Erreur serveur (${response.status})`);
        }

        window.AppState.documents = await response.json();
        applyFilters();

    } catch (error) {
        console.error('Erreur lors du chargement des documents :', error);
        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-8 text-center text-rose-400">
                        <i class="fa-solid fa-triangle-exclamation text-2xl mb-2 block"></i>
                        Impossible de charger les données depuis la base MariaDB.<br>
                        <span class="text-xs text-rose-300">${escapeHtml(error.message)}</span>
                    </td>
                </tr>`;
        }
    }
}

/* ==========================================================================
   2. FILTRAGE & RECHERCHE
   ========================================================================== */

function applyFilters() {
    const { search, type, status, process, origin } = window.AppState.filters;

    window.AppState.filteredDocuments = window.AppState.documents.filter(doc => {
        const matchesSearch = !search || 
            (doc.code && doc.code.toLowerCase().includes(search.toLowerCase())) ||
            (doc.title && doc.title.toLowerCase().includes(search.toLowerCase())) ||
            (doc.process_owner && doc.process_owner.toLowerCase().includes(search.toLowerCase()));

        const matchesType = !type || doc.type === type;
        const matchesStatus = !status || doc.status === status;
        const matchesProcess = !process || doc.process_code === process;
        const matchesOrigin = !origin || doc.origin === origin;

        return matchesSearch && matchesType && matchesStatus && matchesProcess && matchesOrigin;
    });

    window.AppState.currentPage = 1;

    updateStatistics();
    renderTable();
}

/* ==========================================================================
   3. RENDU DU TABLEAU, PAGINATION & BADGES
   ========================================================================== */

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

    const itemsPerPage = window.AppState.itemsPerPage;
    const totalPages = Math.ceil(docs.length / itemsPerPage);

    if (window.AppState.currentPage > totalPages) {
        window.AppState.currentPage = totalPages || 1;
    }

    const startIndex = (window.AppState.currentPage - 1) * itemsPerPage;
    const paginatedDocs = docs.slice(startIndex, startIndex + itemsPerPage);

    paginatedDocs.forEach(doc => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-800/30 transition group border-b border-slate-800/40 text-sm';

        tr.innerHTML = `
            <!-- Code document avec survol -->
            <td class="p-3 font-mono text-blue-400 font-semibold truncate" title="${escapeHtml(doc.code)}">
                ${escapeHtml(doc.code)}
            </td>

            <!-- Titre complet + Icône PDF si présent -->
            <td class="p-3 font-medium text-slate-100">
                <div class="flex items-center gap-2 truncate cursor-help" title="${escapeHtml(doc.title)}">
                    <span class="truncate">${escapeHtml(doc.title)}</span>
                    ${doc.file_path ? `<a href="${escapeHtml(doc.file_path)}" target="_blank" title="Consulter le PDF" class="text-rose-400 hover:text-rose-300 text-xs shrink-0"><i class="fa-solid fa-file-pdf"></i></a>` : ''}
                </div>
            </td>

            <!-- Type formaté -->
            <td class="p-3 capitalize truncate text-slate-300" title="${escapeHtml(formatTypeLabel(doc.type))}">
                ${escapeHtml(formatTypeLabel(doc.type))}
            </td>

            <!-- Version -->
            <td class="p-3 text-center font-mono text-slate-400 text-xs">
                v${escapeHtml(doc.version || '01')}
            </td>

            <!-- Statut avec badge coloré et icône -->
            <td class="p-3 whitespace-nowrap">
                ${getStatusBadge(doc.status)}
            </td>

            <!-- Date d'application -->
            <td class="p-3 font-mono text-xs text-slate-300 whitespace-nowrap">
                ${escapeHtml(doc.effective_date || '--')}
            </td>

            <!-- Date de révision avec alerte colorée si échéance < 30j -->
            <td class="p-3 font-mono text-xs ${isDeadlineAlert(doc.review_date) ? 'text-amber-400 font-bold animate-pulse' : 'text-slate-400'}">
                ${doc.review_date || '--'}
            </td>

            <!-- Action : Ouverture du Drawer -->
            <td class="p-3 text-center whitespace-nowrap">
                <button onclick="openDrawer(${doc.id})" class="text-slate-400 hover:text-blue-400 p-1.5 rounded-lg hover:bg-slate-800 transition" title="Consulter la fiche détaillée">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const currentCountEl = document.getElementById('current-count');
    const totalCountEl = document.getElementById('total-count');
    if (currentCountEl) currentCountEl.textContent = paginatedDocs.length;
    if (totalCountEl) totalCountEl.textContent = docs.length;

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const controls = document.getElementById('pagination-controls');
    const currentPageNum = document.getElementById('page-current-num');
    const totalPageNum = document.getElementById('page-total-num');

    if (currentPageNum) currentPageNum.textContent = totalPages === 0 ? 0 : window.AppState.currentPage;
    if (totalPageNum) totalPageNum.textContent = totalPages;

    if (!controls) return;
    controls.innerHTML = '';

    if (totalPages <= 1) return;

    // Bouton Précédent
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

    // Numéros de pages
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

    // Bouton Suivant
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
   4. STATISTIQUES ISO 17025
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
    const searchInput = document.getElementById('global-search') || document.getElementById('search-input');
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

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('bg-slate-800/60', 'font-medium', 'text-slate-100'));
            item.classList.add('bg-slate-800/60', 'font-medium', 'text-slate-100');

            window.AppState.filters.process = item.getAttribute('data-nav-filter') || '';
            applyFilters();
        });
    });

    document.querySelectorAll('.nav-type').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-type').forEach(i => i.classList.remove('bg-slate-800/60', 'font-medium', 'text-slate-100'));
            item.classList.add('bg-slate-800/60', 'font-medium', 'text-slate-100');

            window.AppState.filters.origin = item.getAttribute('data-nav-type') || '';
            applyFilters();
        });
    });

    bindCardFilter('card-vigueur', 'en_vigueur');
    bindCardFilter('card-revision', 'en_revision');
    bindCardFilter('card-brouillon', 'brouillon');
    bindCardFilter('card-perime', 'perime');

    // Modale de création
    const btnOpenModal = document.getElementById('btn-open-modal') || document.getElementById('btn-new-document');
    const btnCloseModal = document.getElementById('close-modal') || document.getElementById('close-modal-btn');
    const btnCancelModal = document.getElementById('btn-cancel-modal') || document.getElementById('cancel-modal-btn');
    const modalOverlay = document.getElementById('modal-overlay') || document.getElementById('add-document-modal');

    if (btnOpenModal) btnOpenModal.addEventListener('click', () => modalOverlay?.classList.remove('hidden'));
    if (btnCloseModal) btnCloseModal.addEventListener('click', () => modalOverlay?.classList.add('hidden'));
    if (btnCancelModal) btnCancelModal.addEventListener('click', () => modalOverlay?.classList.add('hidden'));

    const formDoc = document.getElementById('form-document') || document.getElementById('add-document-form');
    if (formDoc) {
        formDoc.addEventListener('submit', handleFormSubmit);
    }

    // Modale de révision
    const btnOpenRevise = document.getElementById('btn-open-revise');
    const btnCloseRevise = document.getElementById('close-revise-modal');
    const btnCancelRevise = document.getElementById('btn-cancel-revise');
    const reviseModalOverlay = document.getElementById('revise-modal-overlay');

    if (btnOpenRevise) btnOpenRevise.addEventListener('click', openReviseModal);
    if (btnCloseRevise) btnCloseRevise.addEventListener('click', () => reviseModalOverlay?.classList.add('hidden'));
    if (btnCancelRevise) btnCancelRevise.addEventListener('click', () => reviseModalOverlay?.classList.add('hidden'));

    const formRevise = document.getElementById('revise-document-form');
    if (formRevise) {
        formRevise.addEventListener('submit', handleReviseSubmit);
    }

    // Modale de mise au rebut / péremption (Ajout Étape 2)
    const btnOpenExpire = document.getElementById('btn-open-expire');
    const btnCloseExpire = document.getElementById('close-expire-modal');
    const btnCancelExpire = document.getElementById('btn-cancel-expire');
    const expireModalOverlay = document.getElementById('expire-modal-overlay');

    if (btnOpenExpire) btnOpenExpire.addEventListener('click', openExpireModal);
    if (btnCloseExpire) btnCloseExpire.addEventListener('click', () => expireModalOverlay?.classList.add('hidden'));
    if (btnCancelExpire) btnCancelExpire.addEventListener('click', () => expireModalOverlay?.classList.add('hidden'));

    const formExpire = document.getElementById('expire-document-form');
    if (formExpire) {
        formExpire.addEventListener('submit', handleExpireSubmit);
    }

    // Drawer de consultation
    const closeDrawerBtn = document.getElementById('close-drawer') || document.getElementById('close-drawer-btn');
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

async function openDrawer(docId) {
    const doc = window.AppState.documents.find(d => d.id === docId || d.id === parseInt(docId));
    if (!doc) return;

    // Stockage dans l'état global pour accès facile lors de la révision ou de la péremption
    window.AppState.currentSelectedDoc = doc;

    setElText('drawer-code', doc.code);
    setElText('drawer-title', doc.title);
    
    const statusEl = document.getElementById('drawer-status') || document.getElementById('drawer-status-badge');
    if (statusEl) statusEl.innerHTML = getStatusBadge(doc.status);

    setElText('drawer-version', 'v' + (doc.version || '01'));
    setElText('drawer-author', doc.process_owner || '--');
    setElText('drawer-owner', doc.process_owner || '--');
    setElText('drawer-approver', doc.approver || '--');
    setElText('drawer-effective', doc.effective_date || '--');
    setElText('drawer-review', doc.review_date || '--');

    // Gestion de l'affichage du bouton de mise au rebut (visible uniquement si "en_vigueur")
    const containerExpire = document.getElementById('container-btn-expire');
    if (containerExpire) {
        if (doc.status === 'en_vigueur') {
            containerExpire.classList.remove('hidden');
        } else {
            containerExpire.classList.add('hidden');
        }
    }

    const pdfLinkEl = document.getElementById('drawer-pdf-link');
    if (pdfLinkEl) {
        if (doc.file_path) {
            pdfLinkEl.href = doc.file_path;
            pdfLinkEl.classList.remove('hidden');
        } else {
            pdfLinkEl.classList.add('hidden');
        }
    }

    // Chargement dynamique de l'historique des versions ISO 17025 avec liens PDF
    const historyListEl = document.getElementById('drawer-history-list');
    if (historyListEl) {
        historyListEl.innerHTML = '<span class="text-slate-500 italic"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Chargement de l\'historique...</span>';
        
        try {
            const res = await fetch(`api/get_history.php?document_id=${doc.id}`);
            if (!res.ok) throw new Error('Erreur serveur lors de la récupération de l\'historique');
            
            const historyItems = await res.json();
            
            if (!historyItems || historyItems.length === 0) {
                historyListEl.innerHTML = '<span class="text-slate-500 italic">Aucun historique de version disponible.</span>';
            } else {
                historyListEl.innerHTML = historyItems.map(h => `
                    <div class="bg-slate-950 p-3 rounded-lg border border-slate-800/80 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-blue-400 font-semibold">v${escapeHtml(h.version)}</span>
                            <span class="text-[10px] text-slate-400 font-mono">${escapeHtml(h.created_at || '--')}</span>
                        </div>
                        <p class="text-slate-300 text-xs">${escapeHtml(h.change_reason || 'Mise à jour du document')}</p>
                        <div class="flex items-center justify-between text-[10px] text-slate-500 pt-1 border-t border-slate-800/60">
                            <span>Pilote : ${escapeHtml(h.author || 'Système')}</span>
                            ${h.file_path ? `<a href="${escapeHtml(h.file_path)}" target="_blank" class="text-rose-400 hover:text-rose-300 flex items-center gap-1"><i class="fa-solid fa-file-pdf"></i> Consulter PDF</a>` : '<span class="italic text-slate-600">Pas de fichier</span>'}
                        </div>
                    </div>
                `).join('');
            }
        } catch (err) {
            console.error(err);
            historyListEl.innerHTML = '<span class="text-rose-400 italic">Impossible de charger l\'historique.</span>';
        }
    }

    const drawer = document.getElementById('detail-drawer') || document.getElementById('document-drawer');
    const overlay = document.getElementById('drawer-overlay');

    if (overlay) overlay.classList.remove('hidden');
    if (drawer) drawer.classList.remove('translate-x-full');
}

function closeDrawer() {
    const drawer = document.getElementById('detail-drawer') || document.getElementById('document-drawer');
    const overlay = document.getElementById('drawer-overlay');

    if (drawer) drawer.classList.add('translate-x-full');
    if (overlay) overlay.classList.add('hidden');
}

function setElText(id, txt) {
    const el = document.getElementById(id);
    if (el) el.textContent = txt || '--';
}

/* ==========================================================================
   7. CRÉATION, RÉVISION ET MISE AU REBUT DE DOCUMENTS (POST API)
   ========================================================================== */

async function handleFormSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Enregistrer';

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Enregistrement...';
    }

    try {
        const response = await fetch('api/create_document.php', {
            method: 'POST',
            body: formData
        });

        const rawText = await response.text();
        let result;

        try {
            result = JSON.parse(rawText);
        } catch (err) {
            throw new Error(`Le serveur PHP a renvoyé du texte brut / HTML au lieu de JSON :\n${rawText.substring(0, 300)}`);
        }

        if (response.ok && result.success) {
            await loadDocuments();
            form.reset();
            
            const modalOverlay = document.getElementById('modal-overlay') || document.getElementById('add-document-modal');
            if (modalOverlay) modalOverlay.classList.add('hidden');

            alert('Document enregistré avec succès !');
        } else {
            const errorMsg = result.error || 'Erreur BDD inconnue';
            const detailsMsg = result.details ? `\nDétails MariaDB : ${result.details}` : '';
            alert(`Erreur d'enregistrement :\n${errorMsg}${detailsMsg}`);
        }
    } catch (error) {
        console.error('Erreur lors de la soumission :', error);
        alert(`Erreur critique :\n${error.message}`);
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
}

// --- OUVERTURE DE LA MODALE DE RÉVISION ---
function openReviseModal() {
    const doc = window.AppState.currentSelectedDoc;
    
    if (!doc) {
        alert("Erreur : Aucun document sélectionné. Veuillez réouvrir le tiroir du document.");
        return;
    }

    // Calcul automatique de la version suivante
    let currentVerNum = parseInt(doc.version, 10);
    let nextVersion = isNaN(currentVerNum) ? '02' : String(currentVerNum + 1).padStart(2, '0');

    // Remplissage des champs de la modale de révision
    document.getElementById('revise-doc-id').value = doc.id;
    document.getElementById('revise-display-code').textContent = doc.code;
    document.getElementById('revise-input-code').value = doc.code;
    document.getElementById('revise-display-version').textContent = `v${doc.version || '01'} -> v${nextVersion}`;
    document.getElementById('revise-input-version').value = nextVersion;

    document.getElementById('revise-title').value = doc.title || '';
    document.getElementById('revise-owner').value = doc.process_owner || '';
    document.getElementById('revise-approver').value = doc.approver || '';
    document.getElementById('revise-effective').value = doc.effective_date || '';
    document.getElementById('revise-review').value = doc.review_date || '';

    // Fermeture du tiroir et ouverture de la modale de révision
    closeDrawer();
    const reviseModal = document.getElementById('revise-modal-overlay');
    if (reviseModal) {
        reviseModal.classList.remove('hidden');
    } else {
        console.error("L'élément #revise-modal-overlay est introuvable dans le DOM.");
    }
}

// --- SOUMISSION DE LA RÉVISION ---
async function handleReviseSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Valider la révision';

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Révision en cours...';
    }

    try {
        const response = await fetch('api/revise_document.php', {
            method: 'POST',
            body: formData
        });

        const rawText = await response.text();
        let result;

        try {
            result = JSON.parse(rawText);
        } catch (err) {
            throw new Error(`Le serveur PHP a renvoyé du texte brut :\n${rawText.substring(0, 300)}`);
        }

        if (response.ok && result.success) {
            await loadDocuments();
            form.reset();

            const reviseModal = document.getElementById('revise-modal-overlay');
            if (reviseModal) reviseModal.classList.add('hidden');

            alert('Révision enregistrée avec succès ! L\'ancienne version a été archivée.');
        } else {
            const errorMsg = result.error || 'Erreur BDD inconnue';
            const detailsMsg = result.details ? `\nDétails : ${result.details}` : '';
            alert(`Erreur lors de la révision :\n${errorMsg}${detailsMsg}`);
        }
    } catch (error) {
        console.error('Erreur lors de la révision :', error);
        alert(`Erreur critique :\n${error.message}`);
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
}

// --- OUVERTURE DE LA MODALE DE MISE AU REBUT (Ajout Étape 2) ---
function openExpireModal() {
    const doc = window.AppState.currentSelectedDoc;
    
    if (!doc) {
        alert("Erreur : Aucun document sélectionné.");
        return;
    }

    document.getElementById('expire-doc-id').value = doc.id;
    document.getElementById('expire-display-code').textContent = doc.code;

    closeDrawer();
    const expireModal = document.getElementById('expire-modal-overlay');
    if (expireModal) {
        expireModal.classList.remove('hidden');
    }
}

// --- SOUMISSION DE LA MISE AU REBUT (Ajout Étape 2) ---
async function handleExpireSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.innerHTML : 'Confirmer la péremption';

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Traitement...';
    }

    try {
        const response = await fetch('api/expire_document.php', {
            method: 'POST',
            body: formData
        });

        const rawText = await response.text();
        let result;

        try {
            result = JSON.parse(rawText);
        } catch (err) {
            throw new Error(`Le serveur PHP a renvoyé du texte brut :\n${rawText.substring(0, 300)}`);
        }

        if (response.ok && result.success) {
            await loadDocuments();
            form.reset();

            const expireModal = document.getElementById('expire-modal-overlay');
            if (expireModal) expireModal.classList.add('hidden');

            alert('Document mis au rebut / périmé avec succès !');
        } else {
            const errorMsg = result.error || 'Erreur BDD inconnue';
            alert(`Erreur lors de la péremption :\n${errorMsg}`);
        }
    } catch (error) {
        console.error('Erreur lors de la péremption :', error);
        alert(`Erreur critique :\n${error.message}`);
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
}

/* ==========================================================================
   8. UTILITAIRES DE FORMATAGE ET BADGES ISO 17025
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
            return `<span class="px-2 py-0.5 rounded text-[11px] bg-slate-800 text-slate-400">${escapeHtml(status || 'brouillon')}</span>`;
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
    return diffDays <= 30;
}

function escapeHtml(str) {
    return String(str || '')
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
document.addEventListener('DOMContentLoaded', () => {
    // Éléments du DOM - Tableau & Compteurs
    const tableBody = document.getElementById('document-table-body');
    const currentCount = document.getElementById('current-count');
    const totalCount = document.getElementById('total-count');

    // Éléments du DOM - Statistiques ISO 17025
    const statVigueur = document.getElementById('stat-vigueur');
    const statRevision = document.getElementById('stat-revision');
    const statBrouillon = document.getElementById('stat-brouillon');
    const statPerime = document.getElementById('stat-perime');

    // Conteneurs parent des cartes pour les rendre cliquables
    const cardVigueur = statVigueur ? statVigueur.closest('.bg-slate-950') : null;
    const cardRevision = statRevision ? statRevision.closest('.bg-slate-950') : null;
    const cardBrouillon = statBrouillon ? statBrouillon.closest('.bg-slate-950') : null;
    const cardPerime = statPerime ? statPerime.closest('.bg-slate-950') : null;

    // Éléments du DOM - Filtres & Recherche
    const globalSearch = document.getElementById('global-search');
    const filterType = document.getElementById('filter-type');
    const filterStatus = document.getElementById('filter-status');

    // Navigation Barre Latérale (Processus & Origine)
    const navItems = document.querySelectorAll('.nav-item');
    const navTypes = document.querySelectorAll('.nav-type');

    // Modale Nouveau Document
    const btnOpenModal = document.getElementById('btn-open-modal');
    const btnCloseModal = document.getElementById('close-modal');
    const btnCancelModal = document.getElementById('btn-cancel-modal');
    const modalOverlay = document.getElementById('modal-overlay');
    const formDocument = document.getElementById('form-document');

    // Drawer de Détail
    const drawerOverlay = document.getElementById('drawer-overlay');
    const detailDrawer = document.getElementById('detail-drawer');
    const closeDrawer = document.getElementById('close-drawer');

    // Variables d'état
    let allDocuments = [];
    let selectedProcess = '';
    let selectedOrigin = '';

    // ==========================================
    // 1. Normalisation Robuste des Statuts
    // ==========================================
    function normalizeStatus(statusRaw) {
        if (!statusRaw) return 'perime';
        
        // Nettoyage de la chaîne : minuscules, retrait espaces, tirets -> underscores
        const s = String(statusRaw).trim().toLowerCase().replace(/-/g, '_');
        
        if (['en_vigueur', 'vigueur', 'valide', 'actif', 'approuve'].includes(s)) return 'en_vigueur';
        if (['en_revision', 'revision', 'en_cours'].includes(s)) return 'en_revision';
        if (['brouillon', 'draft'].includes(s)) return 'brouillon';
        if (['perime', 'obsolete', 'annule', 'archive'].includes(s)) return 'perime';
        
        return 'perime';
    }

    // ==========================================
    // 2. Chargement des Documents via l'API PHP
    // ==========================================
    async function fetchDocuments() {
        try {
            const response = await fetch('api/documents.php');
            if (!response.ok) throw new Error(`HTTP: ${response.status}`);
            const result = await response.json();
            
            // Correction clé : Extraire 'data' de l'objet JSON retourné par api/documents.php
            if (result && Array.isArray(result.data)) {
                allDocuments = result.data;
            } else if (Array.isArray(result)) {
                allDocuments = result;
            } else {
                allDocuments = [];
            }
            
            console.log("Documents chargés avec succès (", allDocuments.length, ") :", allDocuments);

            // Mise à jour des cartes et affichage du tableau
            updateStatistics();
            applyFilters();
        } catch (error) {
            console.error('Erreur de chargement des documents :', error);
            if (tableBody) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="p-6 text-center text-red-400">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                            Impossible de charger les documents depuis le serveur.
                        </td>
                    </tr>
                `;
            }
            resetStatistics();
        }
    }

    // ==========================================
    // 3. Calcul & Mise à jour des Statistiques
    // ==========================================
    function updateStatistics() {
        const counts = {
            en_vigueur: 0,
            en_revision: 0,
            brouillon: 0,
            perime: 0
        };

        allDocuments.forEach(doc => {
            // Lecture flexible des clés possibles : status, statut, STATUS
            const rawStatus = doc.status || doc.statut || doc.STATUS;
            const mappedStatus = normalizeStatus(rawStatus);
            
            if (counts.hasOwnProperty(mappedStatus)) {
                counts[mappedStatus]++;
            }
        });

        if (statVigueur) statVigueur.textContent = counts.en_vigueur;
        if (statRevision) statRevision.textContent = counts.en_revision;
        if (statBrouillon) statBrouillon.textContent = counts.brouillon;
        if (statPerime) statPerime.textContent = counts.perime;
    }

    function resetStatistics() {
        if (statVigueur) statVigueur.textContent = '0';
        if (statRevision) statRevision.textContent = '0';
        if (statBrouillon) statBrouillon.textContent = '0';
        if (statPerime) statPerime.textContent = '0';
    }

    // ==========================================
    // 4. Rendu du Tableau
    // ==========================================
    function renderTable(documents) {
        if (!tableBody) return;

        if (!documents || documents.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-6 text-center text-slate-500">
                        Aucun document ne correspond aux critères sélectionnés.
                    </td>
                </tr>
            `;
            if (currentCount) currentCount.textContent = '0';
            if (totalCount) totalCount.textContent = allDocuments.length;
            return;
        }

        tableBody.innerHTML = documents.map(doc => `
            <tr class="hover:bg-slate-900/50 transition border-b border-slate-800/50">
                <td class="p-3 font-mono font-medium text-blue-400">${escapeHtml(doc.code || '--')}</td>
                <td class="p-3 font-medium text-slate-200">${escapeHtml(doc.title || '--')}</td>
                <td class="p-3 capitalize">${formatType(doc.type)}</td>
                <td class="p-3 text-center font-mono">${escapeHtml(doc.version || '01')}</td>
                <td class="p-3">${getStatusBadge(doc.status || doc.statut)}</td>
                <td class="p-3 text-slate-400">${escapeHtml(doc.process_owner || doc.pilote || '--')}</td>
                <td class="p-3 font-mono text-slate-400">${escapeHtml(doc.effective_date || doc.date_effet || '--')}</td>
                <td class="p-3 text-center">
                    <button class="text-slate-400 hover:text-blue-400 transition btn-view-doc" data-id="${doc.id}">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        if (currentCount) currentCount.textContent = documents.length;
        if (totalCount) totalCount.textContent = allDocuments.length;

        // Attacher les écouteurs pour la consultation
        document.querySelectorAll('.btn-view-doc').forEach(btn => {
            btn.addEventListener('click', () => {
                const docId = btn.getAttribute('data-id');
                const doc = allDocuments.find(d => d.id == docId);
                if (doc) openDetailDrawer(doc);
            });
        });
    }

    // Formatters
    function formatType(type) {
        const types = {
            'procedure': 'Procédure',
            'mode_operatoire': 'Mode Opératoire',
            'formulaire': 'Formulaire',
            'manuel': 'Manuel',
            'politique': 'Politique',
            'externe': 'Doc. Externe'
        };
        return types[type] || type || '--';
    }

    function getStatusBadge(statusRaw) {
        const status = normalizeStatus(statusRaw);
        switch (status) {
            case 'en_vigueur':
                return `<span class="px-2 py-0.5 text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded font-medium">En Vigueur</span>`;
            case 'en_revision':
                return `<span class="px-2 py-0.5 text-[10px] bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded font-medium">En Révision</span>`;
            case 'brouillon':
                return `<span class="px-2 py-0.5 text-[10px] bg-slate-500/10 text-slate-400 border border-slate-500/20 rounded font-medium">Brouillon</span>`;
            default:
                return `<span class="px-2 py-0.5 text-[10px] bg-red-500/10 text-red-400 border border-red-500/20 rounded font-medium">Périmé</span>`;
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;");
    }

    // ==========================================
    // 5. Filtrage Dynamique
    // ==========================================
    function applyFilters() {
        const searchVal = globalSearch ? globalSearch.value.toLowerCase().trim() : '';
        const typeVal = filterType ? filterType.value : '';
        const statusVal = filterStatus ? filterStatus.value : '';

        const filtered = allDocuments.filter(doc => {
            const matchesProcess = !selectedProcess || doc.process_code === selectedProcess;
            const matchesOrigin = !selectedOrigin || doc.origin === selectedOrigin;

            const matchesSearch = !searchVal || 
                (doc.code && doc.code.toLowerCase().includes(searchVal)) ||
                (doc.title && doc.title.toLowerCase().includes(searchVal)) ||
                (doc.process_owner && doc.process_owner.toLowerCase().includes(searchVal));

            const matchesType = !typeVal || doc.type === typeVal;

            const docNormalizedStatus = normalizeStatus(doc.status || doc.statut);
            const matchesStatus = !statusVal || docNormalizedStatus === normalizeStatus(statusVal);

            return matchesProcess && matchesOrigin && matchesSearch && matchesType && matchesStatus;
        });

        renderTable(filtered);
    }

    // ==========================================
    // 6. Écouteurs & Cartes Cliquables
    // ==========================================
    function setStatusFilter(targetStatus) {
        if (!filterStatus) return;
        if (filterStatus.value === targetStatus) {
            filterStatus.value = '';
        } else {
            filterStatus.value = targetStatus;
        }
        applyFilters();
    }

    if (cardVigueur) {
        cardVigueur.classList.add('cursor-pointer', 'hover:border-emerald-500/40', 'transition');
        cardVigueur.addEventListener('click', () => setStatusFilter('en_vigueur'));
    }
    if (cardRevision) {
        cardRevision.classList.add('cursor-pointer', 'hover:border-amber-500/40', 'transition');
        cardRevision.addEventListener('click', () => setStatusFilter('en_revision'));
    }
    if (cardBrouillon) {
        cardBrouillon.classList.add('cursor-pointer', 'hover:border-slate-500/40', 'transition');
        cardBrouillon.addEventListener('click', () => setStatusFilter('brouillon'));
    }
    if (cardPerime) {
        cardPerime.classList.add('cursor-pointer', 'hover:border-rose-500/40', 'transition');
        cardPerime.addEventListener('click', () => setStatusFilter('perime'));
    }

    // Menu latéral
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            navItems.forEach(el => {
                el.classList.remove('bg-blue-600/20', 'text-blue-400', 'font-medium');
                el.classList.add('text-slate-400');
            });

            const filterValue = item.getAttribute('data-nav-filter') || '';
            if (selectedProcess === filterValue) {
                selectedProcess = '';
            } else {
                selectedProcess = filterValue;
                item.classList.remove('text-slate-400');
                item.classList.add('bg-blue-600/20', 'text-blue-400', 'font-medium');
            }
            applyFilters();
        });
    });

    navTypes.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            navTypes.forEach(el => el.classList.remove('bg-blue-600/20', 'text-blue-400'));
            
            const typeValue = item.getAttribute('data-nav-type') || '';
            if (selectedOrigin === typeValue) {
                selectedOrigin = '';
            } else {
                selectedOrigin = typeValue;
                item.classList.add('bg-blue-600/20', 'text-blue-400');
            }
            applyFilters();
        });
    });

    if (globalSearch) globalSearch.addEventListener('input', applyFilters);
    if (filterType) filterType.addEventListener('change', applyFilters);
    if (filterStatus) filterStatus.addEventListener('change', applyFilters);

    // Modale Nouveau Document
    function openModal() {
        if (modalOverlay) modalOverlay.classList.remove('hidden');
    }
    function closeModal() {
        if (modalOverlay) modalOverlay.classList.add('hidden');
        if (formDocument) formDocument.reset();
    }

    if (btnOpenModal) btnOpenModal.addEventListener('click', openModal);
    if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
    if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

    if (formDocument) {
        formDocument.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(formDocument);

            try {
                const response = await fetch('api/create_document.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (response.ok && (result.status === 'success' || result.success)) {
                    closeModal();
                    fetchDocuments();
                } else {
                    alert('Erreur : ' + (result.message || 'Impossible d\'enregistrer le document.'));
                }
            } catch (err) {
                console.error('Erreur de soumission :', err);
                alert('Une erreur serveur est survenue.');
            }
        });
    }

    // Drawer de Détail
    function openDetailDrawer(doc) {
        const setField = (id, value) => {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '--';
        };

        setField('drawer-code', doc.code);
        setField('drawer-title', doc.title);
        setField('drawer-version', doc.version || '01');
        setField('drawer-author', doc.process_owner || doc.pilote);
        setField('drawer-approver', doc.approver);
        setField('drawer-effective', doc.effective_date || doc.date_effet);
        setField('drawer-review', doc.review_date);

        const drawerStatus = document.getElementById('drawer-status');
        if (drawerStatus) {
            drawerStatus.innerHTML = getStatusBadge(doc.status || doc.statut);
        }

        const btnDownload = document.getElementById('drawer-download');
        if (btnDownload) {
            if (doc.file_path) {
                btnDownload.href = doc.file_path;
                btnDownload.classList.remove('opacity-50', 'cursor-not-allowed');
                btnDownload.classList.add('hover:bg-blue-500');
            } else {
                btnDownload.removeAttribute('href');
                btnDownload.classList.add('opacity-50', 'cursor-not-allowed');
                btnDownload.classList.remove('hover:bg-blue-500');
            }
        }

        if (drawerOverlay) drawerOverlay.classList.remove('hidden');
        if (detailDrawer) detailDrawer.classList.remove('translate-x-full');
    }

    function closeDetailDrawer() {
        if (detailDrawer) detailDrawer.classList.add('translate-x-full');
        if (drawerOverlay) drawerOverlay.classList.add('hidden');
    }

    if (closeDrawer) closeDrawer.addEventListener('click', closeDetailDrawer);
    if (drawerOverlay) drawerOverlay.addEventListener('click', closeDetailDrawer);

    // Focus rapide sur la barre de recherche via '/'
    window.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement !== globalSearch) {
            e.preventDefault();
            if (globalSearch) globalSearch.focus();
        }
    });

    // Initialisation
    fetchDocuments();
});
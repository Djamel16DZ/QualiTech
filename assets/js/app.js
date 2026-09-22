/**
 * QualiTech - ISO 17025 Document Management System
 * assets/js/app.js
 */

document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Données Initiales Mockées (Registre ISO 17025) ---
    let documents = [
        {
            id: 1,
            code: 'PR-QUAL-001',
            title: 'Procédure de maîtrise des documents et des enregistrements',
            type: 'procedure',
            version: '03',
            status: 'en_vigueur',
            process_code: 'P1',
            process_owner: 'Dr. A. Benali',
            approver: 'Dir. Qualité',
            effective_date: '2025-01-15',
            review_date: '2026-10-15',
            origin: 'interne',
            file_path: 'uploads/PR-QUAL-001.pdf'
        },
        {
            id: 2,
            code: 'MO-MET-012',
            title: 'Étalonnage des balances analytiques et calcul d\'incertitude',
            type: 'mode_operatoire',
            version: '02',
            status: 'en_vigueur',
            process_code: 'P3',
            process_owner: 'M. K. Saidi',
            approver: 'Resp. Métrologie',
            effective_date: '2024-06-10',
            review_date: '2026-09-01', // Échéance dépassée
            origin: 'interne',
            file_path: 'uploads/MO-MET-012.pdf'
        },
        {
            id: 3,
            code: 'FO-ESS-045',
            title: 'Fiche d\'enregistrement des essais d\'écrasement béton',
            type: 'formulaire',
            version: '01',
            status: 'en_vigueur',
            process_code: 'P2',
            process_owner: 'Ing. S. Brahimi',
            approver: 'Chef Labo',
            effective_date: '2025-11-20',
            review_date: '2026-10-05', // Dans moins de 30 jours
            origin: 'interne',
            file_path: null
        },
        {
            id: 4,
            code: 'PR-ACH-003',
            title: 'Évaluation des fournisseurs et prestataires de services critiques',
            type: 'procedure',
            version: '02',
            status: 'en_revision',
            process_code: 'P4',
            process_owner: 'L. Mansouri',
            approver: 'Dir. Achats',
            effective_date: '2023-04-01',
            review_date: '2026-04-01',
            origin: 'interne',
            file_path: 'uploads/PR-ACH-003.pdf'
        },
        {
            id: 5,
            code: 'ISO-17025-2017',
            title: 'Exigences générales concernant la compétence des laboratoires d\'étalonnages et d\'essais',
            type: 'externe',
            version: '2017',
            status: 'en_vigueur',
            process_code: 'P1',
            process_owner: 'Resp. Qualité',
            approver: 'ISO/IEC',
            effective_date: '2018-01-01',
            review_date: '2028-01-01',
            origin: 'externe',
            file_path: 'uploads/ISO-17025.pdf'
        },
        {
            id: 6,
            code: 'MO-ESS-088',
            title: 'Essai de perméabilité à l\'eau sur mortier durci',
            type: 'mode_operatoire',
            version: '00',
            status: 'brouillon',
            process_code: 'P2',
            process_owner: 'Ing. S. Brahimi',
            approver: 'En attente',
            effective_date: '',
            review_date: '',
            origin: 'interne',
            file_path: null
        },
        {
            id: 7,
            code: 'PR-QUAL-000',
            title: 'Manuel Qualité ISO 17025 v2005 (Ancienne Version)',
            type: 'manuel',
            version: '01',
            status: 'perime',
            process_code: 'P1',
            process_owner: 'Dr. A. Benali',
            approver: 'Direction',
            effective_date: '2015-01-01',
            review_date: '2018-01-01',
            origin: 'interne',
            file_path: null
        }
    ];

    // --- 2. Filtres Actifs ---
    const filters = {
        search: '',
        process: '',
        type: '',
        status: '',
        origin: '',
        alertsOnly: false
    };

    // --- 3. Sélecteurs DOM ---
    const tableBody = document.getElementById('document-table-body');
    const globalSearchInput = document.getElementById('global-search');
    const filterTypeSelect = document.getElementById('filter-type');
    const filterStatusSelect = document.getElementById('filter-status');
    const currentCountEl = document.getElementById('current-count');
    const totalCountEl = document.getElementById('total-count');

    // Cartes de statistiques
    const statVigueur = document.getElementById('stat-vigueur');
    const statRevision = document.getElementById('stat-revision');
    const statBrouillon = document.getElementById('stat-brouillon');
    const statPerime = document.getElementById('stat-perime');
    const statAlertes = document.getElementById('stat-alertes');

    const cardVigueur = document.getElementById('card-vigueur');
    const cardRevision = document.getElementById('card-revision');
    const cardBrouillon = document.getElementById('card-brouillon');
    const cardPerime = document.getElementById('card-perime');
    const cardAlertes = document.getElementById('card-alertes');

    // Modale & Drawer
    const btnOpenModal = document.getElementById('btn-open-modal');
    const modalOverlay = document.getElementById('modal-overlay');
    const closeModalBtn = document.getElementById('close-modal');
    const btnCancelModal = document.getElementById('btn-cancel-modal');
    const formDocument = document.getElementById('form-document');

    const drawerOverlay = document.getElementById('drawer-overlay');
    const detailDrawer = document.getElementById('detail-drawer');
    const closeDrawerBtn = document.getElementById('close-drawer');

    // Éléments du Drawer
    const drawerCode = document.getElementById('drawer-code');
    const drawerTitle = document.getElementById('drawer-title');
    const drawerStatus = document.getElementById('drawer-status');
    const drawerVersion = document.getElementById('drawer-version');
    const drawerAuthor = document.getElementById('drawer-author');
    const drawerApprover = document.getElementById('drawer-approver');
    const drawerEffective = document.getElementById('drawer-effective');
    const drawerReview = document.getElementById('drawer-review');
    const drawerDownload = document.getElementById('drawer-download');

    // --- 4. Utilitaires de Dates et Badge Statuts ---
    function isReviewAlert(dateString, status) {
        if (!dateString || status === 'perime' || status === 'brouillon') return false;
        const reviewDate = new Date(dateString);
        const today = new Date();
        const diffDays = (reviewDate - today) / (1000 * 60 * 60 * 24);
        return diffDays <= 30; // Alerte si dépassé ou échéance dans moins de 30 jours
    }

    function getStatusBadge(status) {
        const badges = {
            'en_vigueur': '<span class="inline-flex items-center gap-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-medium"><i class="fa-solid fa-circle-check text-[8px]"></i> En Vigueur</span>',
            'en_revision': '<span class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-medium"><i class="fa-solid fa-arrows-rotate text-[8px]"></i> En Révision</span>',
            'brouillon': '<span class="inline-flex items-center gap-1 bg-slate-500/10 text-slate-400 border border-slate-500/20 px-2 py-0.5 rounded text-[10px] font-medium"><i class="fa-solid fa-pen-ruler text-[8px]"></i> Brouillon</span>',
            'perime': '<span class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded text-[10px] font-medium"><i class="fa-solid fa-box-archive text-[8px]"></i> Périmé</span>'
        };
        return badges[status] || status;
    }

    function getTypeLabel(type) {
        const types = {
            'procedure': 'Procédure',
            'mode_operatoire': 'Mode Opératoire',
            'formulaire': 'Formulaire',
            'manuel': 'Manuel',
            'politique': 'Politique',
            'externe': 'Doc. Externe'
        };
        return types[type] || type;
    }

    // --- 5. Mise à jour des Statistiques (Cartes) ---
    function updateStats() {
        const countVigueur = documents.filter(d => d.status === 'en_vigueur').length;
        const countRevision = documents.filter(d => d.status === 'en_revision').length;
        const countBrouillon = documents.filter(d => d.status === 'brouillon').length;
        const countPerime = documents.filter(d => d.status === 'perime').length;
        const countAlertes = documents.filter(d => isReviewAlert(d.review_date, d.status)).length;

        statVigueur.textContent = countVigueur;
        statRevision.textContent = countRevision;
        statBrouillon.textContent = countBrouillon;
        statPerime.textContent = countPerime;
        statAlertes.textContent = countAlertes;

        totalCountEl.textContent = documents.length;
    }

    // --- 6. Rendu du Tableau avec Filtrage ---
    function renderTable() {
        let filtered = documents.filter(doc => {
            // Filtre Recherche
            const matchesSearch = !filters.search || 
                doc.code.toLowerCase().includes(filters.search.toLowerCase()) ||
                doc.title.toLowerCase().includes(filters.search.toLowerCase()) ||
                doc.process_owner.toLowerCase().includes(filters.search.toLowerCase());

            // Filtre Processus
            const matchesProcess = !filters.process || doc.process_code === filters.process;

            // Filtre Type
            const matchesType = !filters.type || doc.type === filters.type;

            // Filtre Statut
            const matchesStatus = !filters.status || doc.status === filters.status;

            // Filtre Origine
            const matchesOrigin = !filters.origin || doc.origin === filters.origin;

            // Filtre Alertes uniquement
            const matchesAlerts = !filters.alertsOnly || isReviewAlert(doc.review_date, doc.status);

            return matchesSearch && matchesProcess && matchesType && matchesStatus && matchesOrigin && matchesAlerts;
        });

        currentCountEl.textContent = filtered.length;

        if (filtered.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-8 text-center text-slate-500">
                        <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                        Aucun document trouvé correspondant aux critères.
                    </td>
                </tr>`;
            return;
        }

        tableBody.innerHTML = filtered.map(doc => {
            const hasAlert = isReviewAlert(doc.review_date, doc.status);
            const reviewDisplay = doc.review_date 
                ? `<span class="${hasAlert ? 'text-amber-400 font-bold flex items-center gap-1' : 'text-slate-400'}">
                    ${hasAlert ? '<i class="fa-solid fa-triangle-exclamation text-[10px]"></i>' : ''} ${doc.review_date}
                   </span>` 
                : '<span class="text-slate-600">N/A</span>';

            return `
                <tr class="hover:bg-slate-800/40 transition border-b border-slate-800/40 cursor-pointer" onclick="openDrawer(${doc.id})">
                    <td class="p-3 font-mono font-bold text-blue-400">${doc.code}</td>
                    <td class="p-3 font-medium text-slate-100">${doc.title}</td>
                    <td class="p-3 text-slate-400">${getTypeLabel(doc.type)}</td>
                    <td class="p-3 text-center font-mono text-slate-300">v${doc.version}</td>
                    <td class="p-3">${getStatusBadge(doc.status)}</td>
                    <td class="p-3 text-slate-400">${doc.process_owner}</td>
                    <td class="p-3">${reviewDisplay}</td>
                    <td class="p-3 text-center" onclick="event.stopPropagation()">
                        <button onclick="openDrawer(${doc.id})" class="p-1.5 hover:bg-slate-700 text-slate-400 hover:text-slate-200 rounded transition" title="Consulter">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // --- 7. Gestion de la Modale (Nouveau Document) ---
    function openModal() { modalOverlay.classList.remove('hidden'); }
    function closeModal() { 
        modalOverlay.classList.add('hidden'); 
        formDocument.reset();
    }

    btnOpenModal.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    btnCancelModal.addEventListener('click', closeModal);

    formDocument.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(formDocument);
        
        const newDoc = {
            id: Date.now(),
            code: formData.get('code'),
            title: formData.get('title'),
            type: formData.get('type'),
            version: formData.get('version') || '01',
            status: formData.get('status') || 'brouillon',
            process_code: formData.get('process_code'),
            process_owner: formData.get('process_owner'),
            approver: formData.get('approver') || 'Non assigné',
            effective_date: formData.get('effective_date') || '',
            review_date: formData.get('review_date') || '',
            origin: 'interne',
            file_path: null
        };

        documents.unshift(newDoc);
        updateStats();
        renderTable();
        closeModal();
    });

    // --- 8. Gestion du Tiroir Latéral (Drawer) ---
    window.openDrawer = function(id) {
        const doc = documents.find(d => d.id === id);
        if (!doc) return;

        drawerCode.textContent = doc.code;
        drawerTitle.textContent = doc.title;
        drawerStatus.innerHTML = getStatusBadge(doc.status);
        drawerVersion.textContent = `v${doc.version}`;
        drawerAuthor.textContent = doc.process_owner;
        drawerApprover.textContent = doc.approver || 'N/A';
        drawerEffective.textContent = doc.effective_date || 'N/A';
        drawerReview.textContent = doc.review_date || 'N/A';

        if (doc.file_path) {
            drawerDownload.href = doc.file_path;
            drawerDownload.classList.remove('pointer-events-none', 'opacity-50');
            drawerDownload.querySelector('span').textContent = 'Consulter le Document (PDF)';
        } else {
            drawerDownload.href = '#';
            drawerDownload.classList.add('pointer-events-none', 'opacity-50');
            drawerDownload.querySelector('span').textContent = 'Aucun fichier rattaché';
        }

        drawerOverlay.classList.remove('hidden');
        detailDrawer.classList.remove('translate-x-full');
    };

    function closeDrawer() {
        detailDrawer.classList.add('translate-x-full');
        drawerOverlay.classList.add('hidden');
    }

    closeDrawerBtn.addEventListener('click', closeDrawer);
    drawerOverlay.addEventListener('click', closeDrawer);

    // --- 9. Événements des Filtres ---
    globalSearchInput.addEventListener('input', (e) => {
        filters.search = e.target.value;
        renderTable();
    });

    // Raccourci clavier "/" pour la recherche rapide
    document.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement !== globalSearchInput && !modalOverlay.classList.contains('hidden') === false) {
            e.preventDefault();
            globalSearchInput.focus();
        }
    });

    filterTypeSelect.addEventListener('change', (e) => {
        filters.type = e.target.value;
        renderTable();
    });

    filterStatusSelect.addEventListener('change', (e) => {
        filters.status = e.target.value;
        filters.alertsOnly = false;
        renderTable();
    });

    // Filtres Navigation Latérale (Processus & Origine)
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('bg-slate-800', 'text-slate-100'));
            item.classList.add('bg-slate-800', 'text-slate-100');
            filters.process = item.getAttribute('data-nav-filter');
            renderTable();
        });
    });

    document.querySelectorAll('.nav-type').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.nav-type').forEach(el => el.classList.remove('bg-slate-800', 'text-slate-100'));
            item.classList.add('bg-slate-800', 'text-slate-100');
            filters.origin = item.getAttribute('data-nav-type');
            renderTable();
        });
    });

    // Clics sur les 5 Cartes de Statistiques pour Filtrage Rapide
    cardVigueur.addEventListener('click', () => {
        filters.status = 'en_vigueur';
        filters.alertsOnly = false;
        filterStatusSelect.value = 'en_vigueur';
        renderTable();
    });

    cardRevision.addEventListener('click', () => {
        filters.status = 'en_revision';
        filters.alertsOnly = false;
        filterStatusSelect.value = 'en_revision';
        renderTable();
    });

    cardBrouillon.addEventListener('click', () => {
        filters.status = 'brouillon';
        filters.alertsOnly = false;
        filterStatusSelect.value = 'brouillon';
        renderTable();
    });

    cardPerime.addEventListener('click', () => {
        filters.status = 'perime';
        filters.alertsOnly = false;
        filterStatusSelect.value = 'perime';
        renderTable();
    });

    cardAlertes.addEventListener('click', () => {
        filters.status = '';
        filters.alertsOnly = true;
        filterStatusSelect.value = '';
        renderTable();
    });

    // --- 10. Initialisation ---
    updateStats();
    renderTable();
});
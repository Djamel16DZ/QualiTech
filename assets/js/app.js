document.addEventListener('DOMContentLoaded', () => {
    // Éléments du DOM
    const tableBody = document.getElementById('document-table-body');
    const currentCount = document.getElementById('current-count');
    const totalCount = document.getElementById('total-count');
    const globalSearch = document.getElementById('global-search');
    const filterType = document.getElementById('filter-type');
    const filterStatus = document.getElementById('filter-status');

    // Modale Elements
    const btnOpenModal = document.getElementById('btn-open-modal');
    const btnCloseModal = document.getElementById('close-modal');
    const btnCancelModal = document.getElementById('btn-cancel-modal');
    const modalOverlay = document.getElementById('modal-overlay');
    const formDocument = document.getElementById('form-document');

    // Drawer Elements
    const drawerOverlay = document.getElementById('drawer-overlay');
    const detailDrawer = document.getElementById('detail-drawer');
    const closeDrawer = document.getElementById('close-drawer');

    let allDocuments = [];

    // 1. Charger la liste des documents
    async function fetchDocuments() {
        try {
            const response = await fetch('api/documents.php');
            if (!response.ok) throw new Error(`HTTP: ${response.status}`);
            const result = await response.json();
            
            allDocuments = Array.isArray(result) ? result : (result.data || []);
            renderTable(allDocuments);
        } catch (error) {
            console.error('Erreur de chargement:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-6 text-center text-red-400">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        Impossible de charger les documents (erreur API/SQL).
                    </td>
                </tr>
            `;
        }
    }

    // 2. Afficher les lignes du tableau
    function renderTable(documents) {
        if (!documents || documents.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-6 text-center text-slate-500">
                        Aucun document trouvé dans le système ISO 17025.
                    </td>
                </tr>
            `;
            if (currentCount) currentCount.textContent = '0';
            if (totalCount) totalCount.textContent = '0';
            return;
        }

        tableBody.innerHTML = documents.map(doc => `
            <tr class="hover:bg-slate-900/50 transition">
                <td class="p-3 font-mono font-medium text-blue-400">${escapeHtml(doc.code || '--')}</td>
                <td class="p-3 font-medium text-slate-200">${escapeHtml(doc.title || '--')}</td>
                <td class="p-3 capitalize">${formatType(doc.type)}</td>
                <td class="p-3 text-center font-mono">${escapeHtml(doc.version || '01')}</td>
                <td class="p-3">${getStatusBadge(doc.status)}</td>
                <td class="p-3 text-slate-400">${escapeHtml(doc.process_owner || '--')}</td>
                <td class="p-3 font-mono text-slate-400">${escapeHtml(doc.effective_date || '--')}</td>
                <td class="p-3 text-center">
                    <button class="text-slate-400 hover:text-blue-400 transition btn-view-doc" data-id="${doc.id}">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        if (currentCount) currentCount.textContent = documents.length;
        if (totalCount) totalCount.textContent = allDocuments.length;

        // Attacher les évènements de clic pour le volet de détail (Drawer)
        document.querySelectorAll('.btn-view-doc').forEach(btn => {
            btn.addEventListener('click', () => {
                const docId = btn.getAttribute('data-id');
                const doc = allDocuments.find(d => d.id == docId);
                if (doc) openDetailDrawer(doc);
            });
        });
    }

    // Formateurs et Utilitaires
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

    function getStatusBadge(status) {
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

    // 3. Filtrage en temps réel
    function applyFilters() {
        const searchVal = globalSearch ? globalSearch.value.toLowerCase() : '';
        const typeVal = filterType ? filterType.value : '';
        const statusVal = filterStatus ? filterStatus.value : '';

        const filtered = allDocuments.filter(doc => {
            const matchesSearch = !searchVal || 
                (doc.code && doc.code.toLowerCase().includes(searchVal)) ||
                (doc.title && doc.title.toLowerCase().includes(searchVal)) ||
                (doc.process_owner && doc.process_owner.toLowerCase().includes(searchVal));

            const matchesType = !typeVal || doc.type === typeVal;
            const matchesStatus = !statusVal || doc.status === statusVal;

            return matchesSearch && matchesType && matchesStatus;
        });

        renderTable(filtered);
    }

    if (globalSearch) globalSearch.addEventListener('input', applyFilters);
    if (filterType) filterType.addEventListener('change', applyFilters);
    if (filterStatus) filterStatus.addEventListener('change', applyFilters);

    // 4. Modal Nouveau Document
    function openModal() {
        modalOverlay.classList.remove('hidden');
    }

    function closeModal() {
        modalOverlay.classList.add('hidden');
        formDocument.reset();
    }

    if (btnOpenModal) btnOpenModal.addEventListener('click', openModal);
    if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
    if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

    // Soumission du formulaire Nouveau Document (AJAX Multi-part / FormData)
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

                if (response.ok && result.status === 'success') {
                    closeModal();
                    fetchDocuments(); // Rechargement dynamique de la liste
                } else {
                    alert('Erreur : ' + (result.message || 'Impossible d\'enregistrer le document.'));
                }
            } catch (err) {
                console.error('Erreur lors de la création :', err);
                alert('Une erreur réseau ou serveur est survenue.');
            }
        });
    }

    // 5. Drawer de détail
    function openDetailDrawer(doc) {
        document.getElementById('drawer-code').textContent = doc.code || '--';
        document.getElementById('drawer-title').textContent = doc.title || '--';
        document.getElementById('drawer-version').textContent = doc.version || '01';
        document.getElementById('drawer-status').innerHTML = getStatusBadge(doc.status);
        document.getElementById('drawer-author').textContent = doc.process_owner || '--';
        document.getElementById('drawer-approver').textContent = doc.approver || '--';
        document.getElementById('drawer-effective').textContent = doc.effective_date || '--';
        document.getElementById('drawer-review').textContent = doc.review_date || '--';

        const btnDownload = document.getElementById('drawer-download');
        if (doc.file_path) {
            btnDownload.href = doc.file_path;
            btnDownload.classList.remove('opacity-50', 'cursor-not-allowed');
            btnDownload.classList.add('hover:bg-blue-500');
        } else {
            btnDownload.removeAttribute('href');
            btnDownload.classList.add('opacity-50', 'cursor-not-allowed');
            btnDownload.classList.remove('hover:bg-blue-500');
        }

        drawerOverlay.classList.remove('hidden');
        detailDrawer.classList.remove('translate-x-full');
    }

    function closeDetailDrawer() {
        detailDrawer.classList.add('translate-x-full');
        drawerOverlay.classList.add('hidden');
    }

    if (closeDrawer) closeDrawer.addEventListener('click', closeDetailDrawer);
    if (drawerOverlay) drawerOverlay.addEventListener('click', closeDetailDrawer);

    // Raccourci clavier '/' pour la recherche
    window.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement !== globalSearch) {
            e.preventDefault();
            if (globalSearch) globalSearch.focus();
        }
    });

    // Chargement initial
    fetchDocuments();
});
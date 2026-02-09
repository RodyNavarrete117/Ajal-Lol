document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const pageName = this.closest('.page-item').querySelector('.page-name').textContent;
            console.log(`Editando: ${pageName}`);
        });
    });

    const viewButtons = document.querySelectorAll('.btn-view');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const pageName = this.closest('.page-item').querySelector('.page-name').textContent;
            console.log(`Visualizando: ${pageName}`);
        });
    });

    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const pageName = this.closest('.page-item').querySelector('.page-name').textContent;
            if(confirm(`¿Estás seguro de eliminar la página "${pageName}"?`)) {
                console.log(`Eliminando: ${pageName}`);
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {

    const navItems   = document.querySelectorAll('.quick-nav-item[data-target]');
    const sections   = document.querySelectorAll('.manual-section');
    const emptyState = document.getElementById('manualEmptyState');

    let currentTarget = null;

    function showSection(targetId) {
        // If same section clicked again — deselect (toggle off)
        if (currentTarget === targetId) {
            hideAll();
            currentTarget = null;
            return;
        }

        currentTarget = targetId;

        // Hide empty state
        if (emptyState) emptyState.style.display = 'none';

        // Hide all sections, then show target
        sections.forEach(s => s.classList.remove('visible'));

        const target = document.getElementById(targetId);
        if (target) {
            // Small delay so the animation re-triggers if switching sections
            requestAnimationFrame(() => {
                target.classList.add('visible');
            });
        }

        // Update nav active state
        navItems.forEach(n => {
            n.classList.toggle('nav-active', n.dataset.target === targetId);
        });
    }

    function hideAll() {
        sections.forEach(s => s.classList.remove('visible'));
        navItems.forEach(n => n.classList.remove('nav-active'));
        if (emptyState) emptyState.style.display = '';
        currentTarget = null;
    }

    // Bind nav clicks
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            showSection(this.dataset.target);
        });
    });

});
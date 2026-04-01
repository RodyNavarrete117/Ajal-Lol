/* ==================== faq_edit.js ==================== */
(function () {
    'use strict';

    let faqCount = document.querySelectorAll('.faq-card').length;
    let dragSrc  = null;

    /* ── Toast ─────────────────────────────────────────── */
    function showToast(message, type = 'success') {
        const existing = document.querySelector('.edit-toast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                ${type === 'success'
                    ? '<i class="fa fa-circle-check"></i>'
                    : '<i class="fa fa-circle-exclamation"></i>'}
            </span>
            <span class="edit-toast__msg">${message}</span>
        `;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3200);
    }

    /* ── Renumerar ──────────────────────────────────────── */
    function renumber() {
        document.querySelectorAll('.faq-card').forEach((card, i) => {
            const n = i + 1;
            card.id = `faq-${n}`;

            const badge = card.querySelector('.faq-card__num');
            if (badge) badge.textContent = n;

            card.querySelectorAll('input, textarea').forEach(el => {
                const base = el.name.replace(/_\d+$/, '');
                const newName = `${base}_${n}`;
                const oldId   = el.id;
                el.name = newName;
                el.id   = newName;
                const lbl = card.querySelector(`label[for="${oldId}"]`);
                if (lbl) lbl.setAttribute('for', newName);
            });

            const btnRemove = card.querySelector('.faq-card__remove');
            if (btnRemove) btnRemove.dataset.faq = n;
        });
    }

    /* ── Eliminar card ──────────────────────────────────── */
    function removeCard(card) {
        if (document.querySelectorAll('.faq-card').length <= 1) {
            showToast('Debe haber al menos una pregunta.', 'error');
            return;
        }
        card.style.transition = 'opacity .2s ease, transform .2s ease';
        card.style.opacity    = '0';
        card.style.transform  = 'translateY(-8px)';
        setTimeout(() => { card.remove(); renumber(); }, 220);
    }

    /* ── Drag & Drop para reordenar ─────────────────────── */
    function initDrag(card) {
        const grip = card.querySelector('.faq-card__drag');

        card.addEventListener('dragstart', (e) => {
            dragSrc = card;
            card.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('dragging');
            document.querySelectorAll('.faq-card').forEach(c => c.classList.remove('drag-over'));
            dragSrc = null;
            renumber();
        });

        card.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            if (dragSrc && dragSrc !== card) {
                card.classList.add('drag-over');
            }
        });

        card.addEventListener('dragleave', () => {
            card.classList.remove('drag-over');
        });

        card.addEventListener('drop', (e) => {
            e.preventDefault();
            card.classList.remove('drag-over');
            if (!dragSrc || dragSrc === card) return;

            const list = document.getElementById('faqList');
            const cards = [...list.querySelectorAll('.faq-card')];
            const srcIdx  = cards.indexOf(dragSrc);
            const destIdx = cards.indexOf(card);

            if (srcIdx < destIdx) {
                card.after(dragSrc);
            } else {
                card.before(dragSrc);
            }
        });

        // Solo el grip activa el arrastre
        if (grip) {
            grip.addEventListener('mousedown', () => { card.draggable = true; });
            grip.addEventListener('mouseup',   () => { card.draggable = false; });
        }
        card.draggable = false;
    }

    /* ── Inicializar un card ────────────────────────────── */
    function initCard(card) {
        initDrag(card);

        const btnRemove = card.querySelector('.faq-card__remove');
        if (btnRemove) {
            btnRemove.addEventListener('click', () => removeCard(card));
        }
    }

    /* ── Construir nuevo card ───────────────────────────── */
    function buildCard(n) {
        const card = document.createElement('div');
        card.className = 'faq-card';
        card.id = `faq-${n}`;
        card.style.cssText = 'opacity:0;transform:translateY(10px);';
        card.innerHTML = `
            <div class="faq-card__drag" title="Arrastrar para reordenar">
                <i class="fa fa-grip-vertical"></i>
            </div>
            <div class="faq-card__num">${n}</div>
            <div class="faq-card__fields">
                <div class="form-group">
                    <label for="pregunta_${n}">Pregunta</label>
                    <input
                        type="text"
                        id="pregunta_${n}"
                        name="pregunta_${n}"
                        placeholder="Escribe la pregunta frecuente..."
                    >
                </div>
                <div class="form-group">
                    <label for="respuesta_${n}">Respuesta</label>
                    <textarea
                        id="respuesta_${n}"
                        name="respuesta_${n}"
                        rows="3"
                        placeholder="Escribe la respuesta detallada..."
                    ></textarea>
                </div>
            </div>
            <button type="button" class="faq-card__remove" data-faq="${n}" title="Eliminar pregunta">
                <i class="fa fa-xmark"></i>
            </button>
        `;
        return card;
    }

    /* ── Agregar pregunta ───────────────────────────────── */
    document.getElementById('btnAddFaq')?.addEventListener('click', () => {
        faqCount++;
        const card = buildCard(faqCount);
        document.getElementById('faqList').appendChild(card);

        requestAnimationFrame(() => {
            card.style.transition = 'opacity .3s ease, transform .3s ease';
            card.style.opacity    = '1';
            card.style.transform  = 'translateY(0)';
            card.querySelector('input')?.focus();
        });

        initCard(card);
    });

    /* ── Validación ──────────────────────────────────────── */
    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('input[required]').forEach(field => {
            field.classList.remove('field--error');
            field.parentElement.querySelector('.field-error-msg')?.remove();

            if (!field.value.trim()) {
                field.classList.add('field--error');
                const msg = document.createElement('span');
                msg.className = 'field-error-msg';
                msg.textContent = 'Este campo es obligatorio.';
                field.insertAdjacentElement('afterend', msg);
                field.addEventListener('input', () => {
                    field.classList.remove('field--error');
                    field.parentElement.querySelector('.field-error-msg')?.remove();
                }, { once: true });
                valid = false;
            }
        });
        return valid;
    }

    /* ── Submit ──────────────────────────────────────────── */
    const form = document.querySelector('.edit-container form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateForm(form)) {
                showToast('Por favor completa los campos obligatorios.', 'error');
                return;
            }
            showToast('Cambios guardados correctamente.', 'success');
            /* TODO: reemplazar con fetch/axios o form.submit() */
        });
    }

    /* ── Init cards existentes ───────────────────────────── */
    document.querySelectorAll('.faq-card').forEach(card => initCard(card));

})();
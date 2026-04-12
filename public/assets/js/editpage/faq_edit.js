/* ==================== faq_edit.js ==================== */
(function () {
    'use strict';

    let faqCount = document.querySelectorAll('.faq-card').length;
    let dragSrc  = null;

    /* ════ TOAST ════ */
    function showToast(message, type = 'success') {
        document.querySelector('.edit-toast')?.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                <i class="fa ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
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

    /* ════ ACORDEÓN ════ */
    function toggleFaq(card) {
        const collapsed = card.getAttribute('data-collapsed') === 'true';
        card.setAttribute('data-collapsed', collapsed ? 'false' : 'true');
    }

    function expandFaq(card) {
        card.setAttribute('data-collapsed', 'false');
    }

    /* ════ SYNC RESUMEN ════ */
    function initSummarySync(card) {
        const input = card.querySelector('.faq-pregunta-input');
        const summaryId = input?.dataset.summary;
        if (!input || !summaryId) return;

        input.addEventListener('input', function () {
            const el = document.getElementById(summaryId);
            if (!el) return;
            if (this.value.trim()) {
                el.textContent = this.value;
                el.classList.remove('is-empty');
            } else {
                el.textContent = 'Sin pregunta';
                el.classList.add('is-empty');
            }
        });
    }

    /* ════ RENUMERAR ════ */
    function renumber() {
        document.querySelectorAll('.faq-card').forEach((card, i) => {
            const n = i + 1;
            card.id = `faq-${n}`;

            // Header data-card
            const hdr = card.querySelector('.faq-card__header');
            if (hdr) hdr.dataset.card = `faq-${n}`;

            // Número
            const badge = card.querySelector('.faq-card__num');
            if (badge) badge.textContent = n;

            // Resumen
            const sum = card.querySelector('[id^="summary-"]');
            if (sum) sum.id = `summary-${n}`;

            // Inputs: pregunta
            const pInp = card.querySelector('.faq-pregunta-input');
            if (pInp) {
                const oldId = pInp.id;
                pInp.id   = `pregunta_${n}`;
                pInp.name = `pregunta_${n}`;
                pInp.dataset.summary = `summary-${n}`;
                const lbl = card.querySelector(`label[for="${oldId}"]`);
                if (lbl) lbl.setAttribute('for', `pregunta_${n}`);
            }

            // Textarea: respuesta
            const rInp = card.querySelector('textarea');
            if (rInp) {
                const oldId = rInp.id;
                rInp.id   = `respuesta_${n}`;
                rInp.name = `respuesta_${n}`;
                const lbl = card.querySelector(`label[for="${oldId}"]`);
                if (lbl) lbl.setAttribute('for', `respuesta_${n}`);
            }

            // Botón eliminar
            const btnRemove = card.querySelector('.faq-card__remove');
            if (btnRemove) btnRemove.dataset.faq = n;
        });
    }

    /* ════ ELIMINAR ════ */
    function removeCard(card) {
        if (document.querySelectorAll('.faq-card').length <= 1) {
            showToast('Debe haber al menos una pregunta.', 'error');
            return;
        }
        card.style.cssText = 'transition:opacity .2s ease,transform .2s ease;opacity:0;transform:translateY(-6px);';
        setTimeout(() => { card.remove(); renumber(); }, 220);
    }

    /* ════ DRAG & DROP ════ */
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
            if (dragSrc && dragSrc !== card) card.classList.add('drag-over');
        });

        card.addEventListener('dragleave', () => card.classList.remove('drag-over'));

        card.addEventListener('drop', (e) => {
            e.preventDefault();
            card.classList.remove('drag-over');
            if (!dragSrc || dragSrc === card) return;
            const cards   = [...document.querySelectorAll('.faq-card')];
            const srcIdx  = cards.indexOf(dragSrc);
            const destIdx = cards.indexOf(card);
            srcIdx < destIdx ? card.after(dragSrc) : card.before(dragSrc);
        });

        // Solo el grip activa draggable
        if (grip) {
            grip.addEventListener('mousedown', () => { card.draggable = true; });
            grip.addEventListener('mouseup',   () => { card.draggable = false; });
        }
        card.draggable = false;
    }

    /* ════ INIT CARD ════ */
    function initCard(card) {
        // Acordeón
        const hdr = card.querySelector('.faq-card__header');
        if (hdr) {
            hdr.addEventListener('click', () => toggleFaq(card));
        }

        // Sync resumen
        initSummarySync(card);

        // Eliminar (stopPropagation para no disparar el toggle)
        const btnRemove = card.querySelector('.faq-card__remove');
        if (btnRemove) {
            btnRemove.addEventListener('click', (e) => {
                e.stopPropagation();
                removeCard(card);
            });
        }

        // Drag & drop
        initDrag(card);
    }

    /* ════ BUILD CARD ════ */
    function buildCard(n) {
        const card = document.createElement('div');
        card.className = 'faq-card';
        card.id = `faq-${n}`;
        card.setAttribute('data-collapsed', 'false'); // nueva: abierta
        card.style.cssText = 'opacity:0;transform:translateY(8px);';
        card.innerHTML = `
            <div class="faq-card__header" data-card="faq-${n}">
                <span class="faq-card__drag" title="Arrastrar para reordenar">
                    <i class="fa fa-grip-vertical"></i>
                </span>
                <span class="faq-card__num">${n}</span>
                <span class="faq-card__summary is-empty" id="summary-${n}">Sin pregunta</span>
                <span class="faq-card__header-right">
                    <span class="faq-card__chevron"><i class="fa fa-chevron-down"></i></span>
                    <button type="button" class="faq-card__remove" data-faq="${n}"
                        title="Eliminar pregunta">
                        <i class="fa fa-xmark"></i>
                    </button>
                </span>
            </div>
            <div class="faq-card__divider"></div>
            <div class="faq-card__body">
                <div class="form-group">
                    <label for="pregunta_${n}">Pregunta</label>
                    <input type="text" id="pregunta_${n}" name="pregunta_${n}"
                        placeholder="Escribe la pregunta frecuente..."
                        class="faq-pregunta-input" data-summary="summary-${n}">
                </div>
                <div class="form-group">
                    <label for="respuesta_${n}">Respuesta</label>
                    <textarea id="respuesta_${n}" name="respuesta_${n}" rows="3"
                        placeholder="Escribe la respuesta detallada..."></textarea>
                </div>
            </div>
        `;
        return card;
    }

    /* ════ AGREGAR ════ */
    document.getElementById('btnAddFaq')?.addEventListener('click', () => {
        faqCount++;
        const card = buildCard(faqCount);
        document.getElementById('faqList').appendChild(card);
        requestAnimationFrame(() => {
            card.style.cssText = 'transition:opacity .3s ease,transform .3s ease;opacity:1;transform:translateY(0);';
            card.querySelector('.faq-pregunta-input')?.focus();
        });
        initCard(card);
    });

    /* ════ VALIDACIÓN ════ */
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
                // Expandir el card si está colapsado
                const faqCard = field.closest('.faq-card');
                if (faqCard && faqCard.getAttribute('data-collapsed') === 'true') {
                    expandFaq(faqCard);
                }
                field.addEventListener('input', () => {
                    field.classList.remove('field--error');
                    field.parentElement.querySelector('.field-error-msg')?.remove();
                }, { once: true });
                valid = false;
            }
        });
        return valid;
    }

    /* ════ SUBMIT ════ */
    const form = document.querySelector('.edit-container form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateForm(form)) {
                showToast('Por favor completa los campos obligatorios.', 'error');
                const errorField = form.querySelector('.field--error');
                if (errorField) {
                    setTimeout(() => errorField.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
                }
                return;
            }
            showToast('Cambios guardados correctamente.', 'success');
            /* TODO: reemplazar con fetch/axios real o form.submit() */
        });
    }

    /* ════ INIT ════ */
    document.querySelectorAll('.faq-card').forEach(card => initCard(card));

})();
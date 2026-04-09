/* ==================== board_edit.js ==================== */
(function () {
    'use strict';

    let memberCount = document.querySelectorAll('.member-card').length;

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

    /* ── Colapsar / expandir ────────────────────────────── */
    function toggleCard(card) { card.classList.toggle('is-collapsed'); }
    function expandCard(card) { card.classList.remove('is-collapsed'); }
    function collapseAll()    { document.querySelectorAll('.member-card').forEach(c => c.classList.add('is-collapsed')); }

    /* ── Actualizar head ────────────────────────────────── */
    function updateHead(memberNum) {
        const nombre = document.getElementById(`miembro_nombre_${memberNum}`)?.value.trim();
        const cargo  = document.getElementById(`miembro_cargo_${memberNum}`)?.value.trim();

        const headName  = document.getElementById(`head-name-${memberNum}`);
        const headCargo = document.getElementById(`head-cargo-${memberNum}`);

        if (headName) {
            headName.innerHTML = nombre
                ? `<span>${nombre}</span>`
                : `<span class="member-card__head-empty">Sin nombre</span>`;
        }
        if (headCargo) {
            headCargo.innerHTML = cargo
                ? `<span>${cargo}</span>`
                : `<span style="color:var(--text-placeholder);font-style:italic">Sin cargo</span>`;
        }
    }

    /* ── Aplicar imagen seleccionada ────────────────────── */
    function applyPhotoResult(memberNum, dataURL) {
        const preview = document.getElementById(`photo-preview-${memberNum}`);
        const thumb   = document.getElementById(`thumb-${memberNum}`);

        if (preview) {
            preview.innerHTML = `<img src="${dataURL}" alt="Foto miembro ${memberNum}">`;
            preview.classList.add('has-image');
        }
        if (thumb) {
            thumb.innerHTML = `<img src="${dataURL}" alt="">`;
        }
    }

    /* ── Quitar foto ────────────────────────────────────── */
    function clearPhoto(memberNum) {
        const preview   = document.getElementById(`photo-preview-${memberNum}`);
        const thumb     = document.getElementById(`thumb-${memberNum}`);
        const fileInput = document.getElementById(`foto_${memberNum}`);

        if (preview) {
            preview.innerHTML = `<div class="member-photo__empty"><i class="fa fa-user"></i><span>Subir foto</span></div>`;
            preview.classList.remove('has-image');
        }
        if (thumb)     thumb.innerHTML = `<i class="fa fa-user"></i>`;
        if (fileInput) fileInput.value = '';
    }

    /* ── Inicializar listeners de un card ───────────────── */
    function initCard(card) {
        const memberNum = card.id.replace('member-', '');

        /* Toggle colapsar */
        const head = card.querySelector('.member-card__head');
        if (head) {
            head.addEventListener('click', (e) => {
                if (e.target.closest('.btn-remove-member') ||
                    e.target.closest('.member-card__chevron')) return;
                toggleCard(card);
            });
        }

        const chevron = card.querySelector('.member-card__chevron');
        if (chevron) {
            chevron.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleCard(card);
            });
        }

        /* Click en área de foto → abre file input */
        const photoEl = card.querySelector('.member-photo');
        const inputEl = card.querySelector('.photo-input');
        if (photoEl && inputEl) {
            photoEl.addEventListener('click', () => {
                if (!photoEl.classList.contains('has-image')) {
                    inputEl.click();
                }
            });
        }

        /* Cambio de archivo → previsualizar directamente */
        if (inputEl) {
            inputEl.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (file.size > 8 * 1024 * 1024) {
                    showToast('La imagen supera el límite de 8MB.', 'error');
                    this.value = '';
                    return;
                }

                const allowed = ['image/png', 'image/jpeg', 'image/webp'];
                if (!allowed.includes(file.type)) {
                    showToast('Formato no permitido. Usa PNG, JPG o WEBP.', 'error');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => applyPhotoResult(memberNum, e.target.result);
                reader.readAsDataURL(file);
            });
        }

        /* Botón subir foto → abre file input aunque ya haya imagen */
        const uploadLabel = card.querySelector('.btn-photo-upload');
        if (uploadLabel && inputEl) {
            uploadLabel.addEventListener('click', (e) => {
                e.preventDefault();
                inputEl.click();
            });
        }

        /* Quitar foto */
        const btnClear = card.querySelector('.btn-photo-clear');
        if (btnClear) {
            btnClear.addEventListener('click', () => clearPhoto(memberNum));
        }

        /* Actualizar head al escribir */
        const nombreInput = card.querySelector('.nombre-input');
        const cargoInput  = card.querySelector('.cargo-input');
        if (nombreInput) nombreInput.addEventListener('input', () => updateHead(memberNum));
        if (cargoInput)  cargoInput.addEventListener('input',  () => updateHead(memberNum));

        /* Quitar miembro */
        const btnRemove = card.querySelector('.btn-remove-member');
        if (btnRemove) {
            btnRemove.addEventListener('click', (e) => {
                e.stopPropagation();
                removeMember(card);
            });
        }
    }

    /* ── Quitar miembro ─────────────────────────────────── */
    function removeMember(card) {
        if (document.querySelectorAll('.member-card').length <= 1) {
            showToast('Debe haber al menos un miembro.', 'error');
            return;
        }
        card.style.transition = 'opacity .2s ease, transform .2s ease';
        card.style.opacity    = '0';
        card.style.transform  = 'translateY(-8px)';
        setTimeout(() => { card.remove(); renumberMembers(); }, 220);
    }

    /* ── Renumerar ──────────────────────────────────────── */
    function renumberMembers() {
        document.querySelectorAll('.member-card').forEach((card, i) => {
            const n = i + 1;
            card.id = `member-${n}`;

            const numBadge = card.querySelector('.member-card__num');
            if (numBadge) numBadge.textContent = n;

            const thumb = card.querySelector('.member-card__thumb');
            if (thumb) thumb.id = `thumb-${n}`;

            const headName = card.querySelector('[id^="head-name-"]');
            if (headName) headName.id = `head-name-${n}`;

            const headCargo = card.querySelector('[id^="head-cargo-"]');
            if (headCargo) headCargo.id = `head-cargo-${n}`;

            const photoPreview = card.querySelector('[id^="photo-preview-"]');
            if (photoPreview) photoPreview.id = `photo-preview-${n}`;

            const fileInput = card.querySelector('.photo-input');
            if (fileInput) {
                fileInput.id   = `foto_${n}`;
                fileInput.name = `foto_${n}`;
                fileInput.dataset.member = n;
            }

            const uploadLabel = card.querySelector('.btn-photo-upload');
            if (uploadLabel) uploadLabel.setAttribute('for', `foto_${n}`);

            const clearBtn = card.querySelector('.btn-photo-clear');
            if (clearBtn) clearBtn.dataset.member = n;

            const nombreInput = card.querySelector('.nombre-input');
            if (nombreInput) {
                nombreInput.id   = `miembro_nombre_${n}`;
                nombreInput.name = `miembro_nombre_${n}`;
                nombreInput.dataset.member = n;
                card.querySelector(`label[for^="miembro_nombre_"]`)
                    ?.setAttribute('for', `miembro_nombre_${n}`);
            }

            const cargoInput = card.querySelector('.cargo-input');
            if (cargoInput) {
                cargoInput.id   = `miembro_cargo_${n}`;
                cargoInput.name = `miembro_cargo_${n}`;
                cargoInput.dataset.member = n;
                card.querySelector(`label[for^="miembro_cargo_"]`)
                    ?.setAttribute('for', `miembro_cargo_${n}`);
            }

            const removeBtn = card.querySelector('.btn-remove-member');
            if (removeBtn) removeBtn.dataset.member = n;
        });
    }

    /* ── Construir card nuevo ────────────────────────────── */
    function buildMemberCard(n) {
        const card = document.createElement('div');
        card.className = 'member-card';
        card.id = `member-${n}`;
        card.style.cssText = 'opacity:0;transform:translateY(12px);';
        card.innerHTML = `
            <div class="member-card__head" data-member="${n}">
                <div class="member-card__num">${n}</div>
                <div class="member-card__thumb" id="thumb-${n}">
                    <i class="fa fa-user"></i>
                </div>
                <div class="member-card__head-info">
                    <div class="member-card__head-name" id="head-name-${n}">
                        <span class="member-card__head-empty">Sin nombre</span>
                    </div>
                    <div class="member-card__head-cargo" id="head-cargo-${n}">
                        <span style="color:var(--text-placeholder);font-style:italic">Sin cargo</span>
                    </div>
                </div>
                <div class="member-card__head-actions">
                    <button type="button" class="member-card__chevron" title="Expandir / contraer">
                        <i class="fa fa-chevron-down"></i>
                    </button>
                    <button type="button" class="btn-remove-member" data-member="${n}" title="Quitar miembro">
                        <i class="fa fa-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="member-card__body">
                <div class="member-photo-col">
                    <div class="member-photo" id="photo-preview-${n}">
                        <div class="member-photo__empty">
                            <i class="fa fa-user"></i>
                            <span>Subir foto</span>
                        </div>
                    </div>
                    <div class="member-photo-actions">
                        <label class="btn-photo-upload" for="foto_${n}">
                            <i class="fa fa-camera"></i>
                            Subir foto
                        </label>
                        <button type="button" class="btn-photo-clear" data-member="${n}">
                            <i class="fa fa-xmark"></i>
                            Quitar
                        </button>
                        <input type="file" id="foto_${n}" name="foto_${n}"
                               accept="image/png,image/jpeg,image/webp"
                               class="photo-input" data-member="${n}" style="display:none;">
                    </div>
                </div>

                <div class="member-fields-col">
                    <div class="member-fields">
                        <div class="form-group">
                            <label for="miembro_nombre_${n}">Nombre completo</label>
                            <input type="text" id="miembro_nombre_${n}"
                                   name="miembro_nombre_${n}"
                                   placeholder="Ej: Ing. Paula Guadalupe Pech Puc"
                                   class="nombre-input" data-member="${n}">
                        </div>
                        <div class="form-group">
                            <label for="miembro_cargo_${n}">Cargo</label>
                            <input type="text" id="miembro_cargo_${n}"
                                   name="miembro_cargo_${n}"
                                   placeholder="Ej: Presidenta, Secretaria..."
                                   class="cargo-input" data-member="${n}">
                        </div>
                    </div>
                </div>
            </div>
        `;
        return card;
    }

    /* ── Agregar miembro ─────────────────────────────────── */
    document.getElementById('btnAddMember')?.addEventListener('click', () => {
        collapseAll();
        memberCount++;
        const card = buildMemberCard(memberCount);
        document.getElementById('membersGrid').appendChild(card);

        requestAnimationFrame(() => {
            card.style.transition = 'opacity .3s ease, transform .3s ease';
            card.style.opacity    = '1';
            card.style.transform  = 'translateY(0)';
            card.querySelector('.nombre-input')?.focus();
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
                const msg       = document.createElement('span');
                msg.className   = 'field-error-msg';
                msg.textContent = 'Este campo es obligatorio.';
                field.insertAdjacentElement('afterend', msg);

                const cardErr = field.closest('.member-card');
                if (cardErr) expandCard(cardErr);

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
            /* TODO: reemplazar con fetch real */
        });
    }

    /* ── Init cards existentes ───────────────────────────── */
    document.querySelectorAll('.member-card').forEach(card => initCard(card));

})();
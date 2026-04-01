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

    /* ── Preview de foto ────────────────────────────────── */
    function setPhotoPreview(memberNum, file) {
        const preview = document.getElementById(`photo-preview-${memberNum}`);
        if (!preview) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" alt="Foto miembro ${memberNum}">`;
            preview.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }

    function clearPhotoPreview(memberNum) {
        const preview = document.getElementById(`photo-preview-${memberNum}`);
        if (!preview) return;
        preview.innerHTML = `<div class="member-photo__empty"><i class="fa fa-user"></i></div>`;
        preview.classList.remove('has-image');
    }

    /* ── Inicializar listeners de un card ───────────────── */
    function initCard(card) {
        const memberNum = card.id.replace('member-', '');

        // Click en foto → abre file input
        const photoEl = card.querySelector('.member-photo');
        const inputEl = card.querySelector('.photo-input');
        if (photoEl && inputEl) {
            photoEl.addEventListener('click', () => inputEl.click());
        }

        // Cambio de archivo
        if (inputEl) {
            inputEl.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                if (file.size > 3 * 1024 * 1024) {
                    showToast('La imagen supera el límite de 3MB.', 'error');
                    this.value = '';
                    return;
                }

                const allowed = ['image/png', 'image/jpeg', 'image/webp'];
                if (!allowed.includes(file.type)) {
                    showToast('Formato no permitido. Usa PNG, JPG o WEBP.', 'error');
                    this.value = '';
                    return;
                }

                setPhotoPreview(memberNum, file);
            });
        }

        // Botón quitar miembro
        const btnRemove = card.querySelector('.btn-remove-member');
        if (btnRemove) {
            btnRemove.addEventListener('click', () => removeMember(card));
        }
    }

    /* ── Quitar miembro ─────────────────────────────────── */
    function removeMember(card) {
        const cards = document.querySelectorAll('.member-card');
        if (cards.length <= 1) {
            showToast('Debe haber al menos un miembro.', 'error');
            return;
        }
        card.style.transition = 'opacity .2s ease, transform .2s ease';
        card.style.opacity = '0';
        card.style.transform = 'translateY(-8px)';
        setTimeout(() => {
            card.remove();
            renumberMembers();
        }, 220);
    }

    /* ── Renumerar ──────────────────────────────────────── */
    function renumberMembers() {
        document.querySelectorAll('.member-card').forEach((card, i) => {
            const n = i + 1;

            // ID del card
            card.id = `member-${n}`;

            // Número visible
            const numBadge = card.querySelector('.member-card__num');
            if (numBadge) numBadge.textContent = n;

            // Preview foto
            const photoPreview = card.querySelector('.member-photo');
            if (photoPreview) photoPreview.id = `photo-preview-${n}`;

            // Label de subir foto
            const uploadLabel = card.querySelector('.btn-photo-upload');
            if (uploadLabel) uploadLabel.setAttribute('for', `foto_${n}`);

            // Input file
            const fileInput = card.querySelector('.photo-input');
            if (fileInput) {
                fileInput.id   = `foto_${n}`;
                fileInput.name = `foto_${n}`;
                fileInput.dataset.member = n;
            }

            // Inputs de texto
            card.querySelectorAll('input[type="text"]').forEach(inp => {
                inp.id   = inp.id.replace(/_\d+$/, `_${n}`);
                inp.name = inp.name.replace(/_\d+$/, `_${n}`);
                const lbl = card.querySelector(`label[for="${inp.id}"]`);
                if (lbl) lbl.setAttribute('for', inp.id);
            });

            // Botón quitar
            const btnRemove = card.querySelector('.btn-remove-member');
            if (btnRemove) btnRemove.dataset.member = n;
        });
    }

    /* ── Agregar miembro ─────────────────────────────────── */
    function buildMemberCard(n) {
        const card = document.createElement('div');
        card.className = 'member-card';
        card.id = `member-${n}`;
        card.style.cssText = 'opacity:0;transform:translateY(12px);';
        card.innerHTML = `
            <div class="member-card__num">${n}</div>

            <div class="member-photo-wrap">
                <div class="member-photo" id="photo-preview-${n}">
                    <div class="member-photo__empty">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
                <label class="btn-photo-upload" for="foto_${n}">
                    <i class="fa fa-camera"></i>
                    Subir foto
                </label>
                <input
                    type="file"
                    id="foto_${n}"
                    name="foto_${n}"
                    accept="image/png,image/jpeg,image/webp"
                    class="photo-input"
                    data-member="${n}"
                    style="display:none;"
                >
            </div>

            <div class="member-fields">
                <div class="form-group">
                    <label for="miembro_nombre_${n}">Nombre completo</label>
                    <input
                        type="text"
                        id="miembro_nombre_${n}"
                        name="miembro_nombre_${n}"
                        placeholder="Ej: Ing. Paula Guadalupe Pech Puc"
                    >
                </div>
                <div class="form-group">
                    <label for="miembro_cargo_${n}">Cargo</label>
                    <input
                        type="text"
                        id="miembro_cargo_${n}"
                        name="miembro_cargo_${n}"
                        placeholder="Ej: Presidenta, Secretaria..."
                    >
                </div>
            </div>

            <button type="button" class="btn-remove-member" data-member="${n}" title="Quitar miembro">
                <i class="fa fa-xmark"></i>
            </button>
        `;
        return card;
    }

    document.getElementById('btnAddMember')?.addEventListener('click', () => {
        memberCount++;
        const card = buildMemberCard(memberCount);
        document.getElementById('membersGrid').appendChild(card);

        requestAnimationFrame(() => {
            card.style.transition = 'opacity .3s ease, transform .3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
            card.querySelector('input[type="text"]')?.focus();
        });

        initCard(card);
    });

    /* ── Validación ──────────────────────────────────────── */
    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('input[required]').forEach(field => {
            field.classList.remove('field--error');
            const prev = field.parentElement.querySelector('.field-error-msg');
            if (prev) prev.remove();

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
    document.querySelectorAll('.member-card').forEach(card => initCard(card));

})();
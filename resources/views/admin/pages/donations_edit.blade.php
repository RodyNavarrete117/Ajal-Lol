@extends('admin.dashboard')

@section('title', 'Editar Página - Donaciones')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/editpagescss/donations_edit.css') }}">
@endpush

@section('content')
<div class="edit-page-wrapper">
    <div class="edit-container">

        {{-- HEADER --}}
        <div class="edit-header">
            <div class="edit-header__bg">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <i class="fa-solid fa-heart"></i>
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <i class="fa-solid fa-circle-dollar-to-slot"></i>
                <i class="fa-solid fa-hand-holding-heart"></i>
                <i class="fa-solid fa-heart"></i>
            </div>
            <div class="edit-header-top">
                <a href="{{ url('/admin/page') }}" class="edit-back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="edit-icon">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div class="edit-header-text">
                    <h2>Editor de Donaciones</h2>
                    <p class="subtitle">Configura cómo los usuarios pueden apoyar a la organización</p>
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="edit-form-body">
        <form method="POST" action="#">
            @csrf

            <div class="accordion">

                {{-- ===== INFORMACIÓN GENERAL ===== --}}
                <div class="accordion-item active">
                    <div class="accordion-header">
                        <div class="accordion-header__left">
                            <div class="accordion-header__icon">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <span class="accordion-title">Información general</span>
                        </div>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="form-group">
                            <label for="title">Título principal</label>
                            <input type="text" id="title" name="title"
                                placeholder="Ej: Apoya nuestra causa">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea id="description" name="description" rows="3"
                                placeholder="Explica cómo ayudan las donaciones..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- ===== DATOS BANCARIOS ===== --}}
                <div class="accordion-item">
                    <div class="accordion-header">
                        <div class="accordion-header__left">
                            <div class="accordion-header__icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <span class="accordion-title">Datos bancarios</span>
                        </div>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="bank-card">
                            <div class="bank-card__header">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Cuenta bancaria</span>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="beneficiary">Nombre del beneficiario</label>
                                    <input type="text" id="beneficiary" name="beneficiary"
                                        placeholder="Ej: Ajal Lol A.C.">
                                </div>
                                <div class="form-group">
                                    <label for="bank">Banco</label>
                                    <input type="text" id="bank" name="bank"
                                        placeholder="Ej: BBVA">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="account">Cuenta / CLABE</label>
                                <div class="input-copy-wrapper">
                                    <input type="text" id="account" name="account"
                                        placeholder="012345678901234567" class="input-copy">
                                    <button type="button" class="btn-copy" id="btnCopyAccount" title="Copiar">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </div>
                                <span class="field-hint">18 dígitos para CLABE interbancaria.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== PAYPAL ===== --}}
                <div class="accordion-item donation">
                    <div class="accordion-header">
                        <div class="accordion-header__left">
                            <div class="accordion-header__icon accordion-header__icon--paypal">
                                <i class="fa-brands fa-paypal"></i>
                            </div>
                            <span class="accordion-title">Donación vía PayPal</span>
                        </div>
                        <i class="fa-solid fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">

                        <div class="paypal-highlight">
                            <div class="paypal-highlight__left">
                                <i class="fa-brands fa-paypal paypal-highlight__icon"></i>
                                <div class="paypal-highlight__text">
                                    <strong>Enlace de donación PayPal</strong>
                                    <span>Los visitantes serán redirigidos a PayPal para donar de forma segura</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paypal_url">URL de PayPal.me</label>
                            <div class="input-paypal-wrapper">
                                <span class="input-paypal-prefix">
                                    <i class="fa-brands fa-paypal"></i>
                                    paypal.me/
                                </span>
                                <input type="text" id="paypal_url" name="paypal_url"
                                    placeholder="AjalLolAC"
                                    class="input-paypal">
                            </div>
                            <span class="field-hint">
                                Solo escribe el nombre de usuario. Ej: si tu link es
                                <strong>paypal.me/AjalLolAC</strong> escribe solo <strong>AjalLolAC</strong>.
                            </span>
                        </div>

                        <div class="paypal-preview" id="paypalPreview" style="display:none;">
                            <span class="paypal-preview__label">Vista previa del enlace:</span>
                            <a class="paypal-preview__link" id="paypalPreviewLink" href="#" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-paypal"></i>
                                <span id="paypalPreviewText">paypal.me/</span>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="form-actions">
                <button type="button" class="btn-save" id="btnSaveDonations">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar cambios
                </button>
                <button type="button" class="btn-cancel" onclick="window.history.back()">
                    Cancelar
                </button>
            </div>

        </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
/* ── Acordeón ── */
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        header.closest('.accordion-item').classList.toggle('active');
    });
});

/* ── Preview PayPal ── */
const paypalInput   = document.getElementById('paypal_url');
const paypalPreview = document.getElementById('paypalPreview');
const paypalLink    = document.getElementById('paypalPreviewLink');
const paypalText    = document.getElementById('paypalPreviewText');

paypalInput?.addEventListener('input', function () {
    const val = this.value.trim();
    if (val) {
        paypalPreview.style.display = 'flex';
        paypalText.textContent = 'paypal.me/' + val;
        paypalLink.href = 'https://paypal.me/' + val;
    } else {
        paypalPreview.style.display = 'none';
    }
});

/* ── Copiar CLABE ── */
document.getElementById('btnCopyAccount')?.addEventListener('click', () => {
    const val = document.getElementById('account')?.value.trim();
    if (!val) return;
    navigator.clipboard.writeText(val).then(() => {
        const btn = document.getElementById('btnCopyAccount');
        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
        setTimeout(() => { btn.innerHTML = '<i class="fa-solid fa-copy"></i>'; }, 1800);
    });
});

/* ── Toast ── */
function showToast(msg, type = 'success') {
    const t = document.createElement('div');
    t.className = `edit-toast edit-toast--${type}`;
    t.innerHTML = `<i class="fa-solid fa-circle-${type === 'success' ? 'check' : 'exclamation'} edit-toast__icon"></i><span>${msg}</span>`;
    document.body.appendChild(t);
    requestAnimationFrame(() => t.classList.add('edit-toast--show'));
    setTimeout(() => { t.classList.remove('edit-toast--show'); t.addEventListener('transitionend', () => t.remove(), { once: true }); }, 3200);
}

/* ── Guardar ── */
document.getElementById('btnSaveDonations')?.addEventListener('click', () => {
    showToast('Cambios guardados correctamente.');
});
</script>
@endpush
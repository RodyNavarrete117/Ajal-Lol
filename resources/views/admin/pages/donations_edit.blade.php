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
        <div class="edit-form">

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
                                value="{{ old('title', $donacion_info->titulo ?? '') }}"
                                placeholder="Ej: ¡Tu apoyo transforma vidas!">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea id="description" name="description" rows="3"
                                placeholder="Explica cómo ayudan las donaciones...">{{ old('description', $donacion_info->descripcion ?? '') }}</textarea>
                        </div>
                        <div class="form-actions-inline">
                            <button type="button" class="btn-save" id="btnSaveInfo">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
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
                                        value="{{ old('beneficiary', $donacion_bancario->beneficiario ?? '') }}"
                                        placeholder="Ej: Ajal Lol A.C.">
                                </div>
                                <div class="form-group">
                                    <label for="bank">Banco</label>
                                    <input type="text" id="bank" name="bank"
                                        value="{{ old('bank', $donacion_bancario->banco ?? '') }}"
                                        placeholder="Ej: BBVA">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="account">Cuenta / CLABE</label>
                                <div class="input-copy-wrapper">
                                    <input type="text" id="account" name="account"
                                        value="{{ old('account', $donacion_bancario->clabe ?? '') }}"
                                        placeholder="012345678901234567"
                                        class="input-copy"
                                        maxlength="18"
                                        inputmode="numeric"
                                        pattern="\d{18}">
                                    <button type="button" class="btn-copy" id="btnCopyAccount" title="Copiar">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </div>
                                <span class="field-hint">18 dígitos para CLABE interbancaria.</span>
                            </div>
                        </div>
                        <div class="form-actions-inline">
                            <button type="button" class="btn-save" id="btnSaveBancario">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
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
                                    value="{{ old('paypal_url', $donacion_paypal->paypal_usuario ?? '') }}"
                                    placeholder="AjalLolAC"
                                    class="input-paypal"
                                    maxlength="20"
                                    pattern="[a-zA-Z0-9\-\.]{1,20}">
                            </div>
                            <span class="field-hint">
                                Solo escribe el nombre de usuario. Ej: si tu link es
                                <strong>paypal.me/AjalLolAC</strong> escribe solo <strong>AjalLolAC</strong>.
                            </span>
                        </div>

                        <div class="paypal-preview" id="paypalPreview"
                            style="{{ !empty($donacion_paypal->paypal_usuario) ? 'display:flex' : 'display:none' }}">
                            <span class="paypal-preview__label">Vista previa del enlace:</span>
                            <a class="paypal-preview__link" id="paypalPreviewLink"
                                href="{{ !empty($donacion_paypal->paypal_usuario) ? 'https://paypal.me/'.$donacion_paypal->paypal_usuario : '#' }}"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-paypal"></i>
                                <span id="paypalPreviewText">paypal.me/{{ $donacion_paypal->paypal_usuario ?? '' }}</span>
                            </a>
                        </div>

                        <div class="form-actions-inline">
                            <button type="button" class="btn-save" id="btnSavePaypal">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    window.DONATIONS_ROUTES = {
        info     : '{{ route("admin.pages.donations.info") }}',
        bancario : '{{ route("admin.pages.donations.bancario") }}',
        paypal   : '{{ route("admin.pages.donations.paypal") }}',
        csrfToken: '{{ csrf_token() }}',
    };
</script>
<script>
const CSRF = window.DONATIONS_ROUTES.csrfToken;

function setButtonLoading(btn, loading) {
    if (loading) {
        btn.disabled = true;
        btn.dataset.originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';
    } else {
        btn.disabled = false;
        btn.innerHTML = btn.dataset.originalHtml ?? '<i class="fa-solid fa-floppy-disk"></i> Guardar';
    }
}

async function apiFetch(url, body) {
    let res;
    try {
        res = await fetch(url, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN' : CSRF,
                'Accept'       : 'application/json',
                'Content-Type' : 'application/json',
            },
            body: JSON.stringify(body),
        });
    } catch {
        // Error de red: sin conexión, servidor caído, CORS, timeout, etc.
        throw new Error('Sin conexión. Verifica tu red e intenta de nuevo.');
    }

    const data = await res.json();

    if (!res.ok) {
        // Error HTTP: el servidor respondió con 4xx / 5xx
        throw new Error(data.message ?? `Error del servidor (${res.status}). Intenta de nuevo.`);
    }

    return data;
}

function showToast(msg, type = 'success') {
    document.querySelector('.edit-toast')?.remove();
    const t = document.createElement('div');
    t.className = `edit-toast edit-toast--${type}`;
    t.innerHTML = `<i class="fa-solid fa-circle-${type === 'success' ? 'check' : 'exclamation'} edit-toast__icon"></i><span>${msg}</span>`;
    document.body.appendChild(t);
    requestAnimationFrame(() => t.classList.add('edit-toast--show'));
    setTimeout(() => {
        t.classList.remove('edit-toast--show');
        t.addEventListener('transitionend', () => t.remove(), { once: true });
    }, 3200);
}

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

/* ── Contador / validación CLABE en tiempo real ── */
document.getElementById('account')?.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 18);
    const len = this.value.length;
    const hint = this.closest('.form-group')?.querySelector('.field-hint');
    if (hint) {
        // Si ya tiene 18 dígitos, el hint desaparece — no hace falta confirmarlo,
        // el usuario ya ve que el campo está completo.
        if (len === 18) {
            hint.textContent = '';
        } else if (len > 0) {
            hint.textContent = `${len}/18 dígitos`;
            hint.style.color = '';
        } else {
            hint.textContent = '18 dígitos para CLABE interbancaria.';
            hint.style.color = '';
        }
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

/* ── Guardar Info ── */
document.getElementById('btnSaveInfo')?.addEventListener('click', async function () {
    setButtonLoading(this, true);
    try {
        const data = await apiFetch(window.DONATIONS_ROUTES.info, {
            titulo      : document.getElementById('title')?.value.trim(),
            descripcion : document.getElementById('description')?.value.trim(),
        });
        showToast(data.message ?? 'Información guardada.');
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        setButtonLoading(this, false);
    }
});

/* ── Guardar Bancario ── */
document.getElementById('btnSaveBancario')?.addEventListener('click', async function () {
    const clabe = document.getElementById('account')?.value.trim();

    if (!/^\d{18}$/.test(clabe)) {
        showToast('La CLABE debe tener exactamente 18 dígitos numéricos.', 'error');
        return;
    }

    setButtonLoading(this, true);
    try {
        const data = await apiFetch(window.DONATIONS_ROUTES.bancario, {
            beneficiario : document.getElementById('beneficiary')?.value.trim(),
            banco        : document.getElementById('bank')?.value.trim(),
            clabe,
        });
        showToast(data.message ?? 'Datos bancarios guardados.');
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        setButtonLoading(this, false);
    }
});

/* ── Guardar PayPal ── */
document.getElementById('btnSavePaypal')?.addEventListener('click', async function () {
    const usuario = document.getElementById('paypal_url')?.value.trim();

    if (usuario && !/^[a-zA-Z0-9\-\.]{1,20}$/.test(usuario)) {
        showToast('Usuario de PayPal inválido. Solo letras, números, guiones y puntos (máx. 20).', 'error');
        return;
    }

    setButtonLoading(this, true);
    try {
        const data = await apiFetch(window.DONATIONS_ROUTES.paypal, {
            paypal_usuario: usuario,
        });
        showToast(data.message ?? 'PayPal guardado.');
    } catch (err) {
        showToast(err.message, 'error');
    } finally {
        setButtonLoading(this, false);
    }
});
</script>
@endpush
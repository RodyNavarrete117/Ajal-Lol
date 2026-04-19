/* ==================== HOME EDIT — JS ====================
   Ruta: assets/js/editpage/home_edit.js
   ========================================================= */
(function () {
    'use strict';

    const MAX_VIDEOS = 10;

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

    /* ── Tabs ─────────────────────────────────────────── */
    const tabs   = document.querySelectorAll('.edit-tab');
    const panels = document.querySelectorAll('.edit-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.target;
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + target);
            if (panel) panel.classList.add('active');
        });
    });

    /* ── Extraer ID de YouTube desde URL o ID directo ── */
    function extractYouTubeId(input) {
        input = input.trim();
        if (/^[a-zA-Z0-9_-]{11}$/.test(input)) return input;
        try {
            const url = new URL(input);
            if (url.searchParams.get('v')) return url.searchParams.get('v');
            if (url.hostname === 'youtu.be') return url.pathname.slice(1).split('?')[0];
            const embedMatch = url.pathname.match(/\/embed\/([a-zA-Z0-9_-]{11})/);
            if (embedMatch) return embedMatch[1];
        } catch {}
        return null;
    }

    /* ── Actualizar miniatura de un video ── */
    function updateThumb(thumbEl, videoId) {
        if (!thumbEl) return;
        const img = thumbEl.querySelector('img');
        if (!img) return;
        if (videoId) {
            img.src = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;
            img.style.opacity = '1';
        } else {
            img.src = '';
            img.style.opacity = '0';
        }
    }

    /* ── Inicializar eventos de una fila de video ── */
    function initVideoRow(row) {
        const idInput   = row.querySelector('.vid-id-input');
        const thumbId   = idInput?.dataset.thumb;
        const thumbEl   = thumbId ? document.getElementById(thumbId) : null;
        const btnRemove = row.querySelector('.btn-remove-video');

        let debounce;
        idInput?.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                const ytId = extractYouTubeId(idInput.value);
                if (ytId) idInput.dataset.ytid = ytId;
                updateThumb(thumbEl, ytId);
            }, 500);
        });

        btnRemove?.addEventListener('click', () => {
            if (document.querySelectorAll('.video-row').length <= 1) {
                showToast('Debe haber al menos un video.', 'error');
                return;
            }
            row.style.transition = 'opacity .2s ease, transform .2s ease';
            row.style.opacity    = '0';
            row.style.transform  = 'translateY(-6px)';
            setTimeout(() => {
                row.remove();
                renumberVideos();
                updateVideoAddBar();
            }, 220);
        });
    }

    /* ── Renumerar filas de video ── */
    function renumberVideos() {
        document.querySelectorAll('.video-row').forEach((row, i) => {
            const n = i + 1;
            row.id = `video-row-${n}`;
            const numEl = row.querySelector('.video-row__num');
            if (numEl) numEl.textContent = n;

            row.querySelectorAll('input').forEach(inp => {
                if (inp.name?.startsWith('vid_titulo_')) { inp.name = `vid_titulo_${n}`; inp.id = `vid_titulo_${n}`; }
                if (inp.name?.startsWith('vid_id_'))     { inp.name = `vid_id_${n}`;     inp.id = `vid_id_${n}`;     }
            });

            const thumbEl = row.querySelector('.video-row__thumb');
            if (thumbEl) thumbEl.id = `vthumb-${n}`;
            const idInput = row.querySelector('.vid-id-input');
            if (idInput) idInput.dataset.thumb = `vthumb-${n}`;

            const btnRemove = row.querySelector('.btn-remove-video');
            if (btnRemove) btnRemove.dataset.row = n;
        });
    }

    /* ── Actualizar estado del botón agregar ── */
    function updateVideoAddBar() {
        const count = document.querySelectorAll('.video-row').length;
        const bar   = document.getElementById('videoAddBar');
        const btn   = document.getElementById('btnAddVideo');
        if (!bar || !btn) return;
        const isMax = count >= MAX_VIDEOS;
        bar.classList.toggle('is-max', isMax);
        btn.disabled = isMax;
    }

    /* ── Construir fila de video nueva ── */
    function buildVideoRow(n) {
        const row = document.createElement('div');
        row.className = 'video-row';
        row.id        = `video-row-${n}`;
        row.innerHTML = `
            <div class="video-row__num">${n}</div>
            <div class="video-row__thumb" id="vthumb-${n}">
                <img src="" alt="Miniatura" loading="lazy" style="opacity:0">
                <span class="video-row__play"><i class="fa fa-play"></i></span>
            </div>
            <div class="video-row__fields">
                <div class="form-group">
                    <label for="vid_titulo_${n}">Título del video</label>
                    <input type="text" id="vid_titulo_${n}" name="vid_titulo_${n}"
                        placeholder="Ej: Nuestra historia" class="vid-title-input">
                </div>
                <div class="form-group">
                    <label for="vid_id_${n}">ID o URL de YouTube</label>
                    <input type="text" id="vid_id_${n}" name="vid_id_${n}"
                        placeholder="Ej: lRM7kJdDUM4 o https://youtube.com/..."
                        class="vid-id-input" data-thumb="vthumb-${n}">
                    <span class="field-hint">Pega el ID del video o la URL completa de YouTube.</span>
                </div>
            </div>
            <button type="button" class="btn-remove-video" data-row="${n}" title="Eliminar video">
                <i class="fa fa-xmark"></i>
            </button>
        `;
        return row;
    }

    /* ── Botón agregar video ── */
    document.getElementById('btnAddVideo')?.addEventListener('click', () => {
        const count = document.querySelectorAll('.video-row').length;
        if (count >= MAX_VIDEOS) {
            showToast(`Máximo de ${MAX_VIDEOS} videos alcanzado.`, 'error');
            return;
        }
        const n   = count + 1;
        const row = buildVideoRow(n);
        document.getElementById('videosList').appendChild(row);
        requestAnimationFrame(() => { row.style.opacity = '1'; row.style.transform = 'translateY(0)'; });
        initVideoRow(row);
        updateVideoAddBar();
        setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);
    });

    /* ── Validación ── */
    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('input[required], textarea[required]').forEach(field => {
            clearError(field);
            if (!field.value.trim()) { markError(field, 'Este campo es obligatorio.'); valid = false; }
        });
        return valid;
    }
    function markError(field, msg) {
        field.classList.add('field--error');
        const err = document.createElement('span');
        err.className = 'field-error-msg'; err.textContent = msg;
        field.insertAdjacentElement('afterend', err);
        field.addEventListener('input', () => clearError(field), { once: true });
    }
    function clearError(field) {
        field.classList.remove('field--error');
        field.parentElement?.querySelector('.field-error-msg')?.remove();
    }

    /* ── Submit general (AJAX) ── */
    const form = document.querySelector('.edit-container form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Serializar statsData
            const hidden = document.getElementById('statsDataInput');
            if (hidden && typeof statsData !== 'undefined') {
                hidden.value = JSON.stringify(statsData);
            }

            if (!validateForm(form)) {
                showToast('Por favor completa los campos obligatorios.', 'error');
                const errorField = form.querySelector('.field--error');
                if (errorField) {
                    const panel = errorField.closest('.edit-panel');
                    if (panel && !panel.classList.contains('active')) {
                        const panelId = panel.id.replace('panel-', '');
                        const tab = document.querySelector(`.edit-tab[data-target="${panelId}"]`);
                        if (tab) tab.click();
                    }
                    setTimeout(() => errorField.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
                }
                return;
            }

            // Estado de carga en todos los botones guardar
            const btnsSave = form.querySelectorAll('.btn-save');
            const originales = [];
            btnsSave.forEach(btn => {
                originales.push(btn.innerHTML);
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';
            });

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(res => {
                if (res.ok) return res.json();
                throw new Error('Error ' + res.status);
            })
            .then(data => {
                if (data.success) {
                    showToast('Cambios guardados correctamente.');
                } else {
                    showToast('Error al guardar.', 'error');
                }
            })
            .catch(err => {
                console.error('Error al guardar:', err);
                showToast('Error al guardar los cambios.', 'error');
            })
            .finally(() => {
                btnsSave.forEach((btn, i) => {
                    btn.disabled = false;
                    btn.innerHTML = originales[i];
                });
            });
        });
    }

    /* ── Init videos ── */
    document.querySelectorAll('.video-row').forEach(row => initVideoRow(row));
    updateVideoAddBar();


    /* ══════════════════════════════════════════════════════
       ESTADÍSTICAS POR AÑO
       ══════════════════════════════════════════════════════ */

    const STAT_FIELDS = [
        { key: 'ben',  label: 'Beneficiarios',    placeholder: 'Ej: 500'  },
        { key: 'proy', label: 'Proyectos activos', placeholder: 'Ej: 5'    },
        { key: 'hrs',  label: 'Horas de apoyo',    placeholder: 'Ej: 1200' },
        { key: 'vol',  label: 'Voluntarios',       placeholder: 'Ej: 35'   },
    ];

    const statsPanel = document.getElementById('panel-stats');
    var statsData = {};

    if (statsPanel) {

        try {
            const raw = JSON.parse(statsPanel.dataset.stats || '{}');
            Object.entries(raw).forEach(([k, v]) => { statsData[Number(k)] = v; });
        } catch (e) { console.error('Error al parsear data-stats:', e); }

        let statsCurrentIdx = 0;

        function statsSortedYears() {
            return Object.keys(statsData).map(Number).sort((a, b) => b - a);
        }
        function statsFmt(n) { return Number(n || 0).toLocaleString('es-MX'); }

        /* ── Totales ── */
        function statsUpdateTotals() {
            const t = { ben: 0, proy: 0, hrs: 0, vol: 0 };
            Object.values(statsData).forEach(yr =>
                STAT_FIELDS.forEach(f => t[f.key] += Number(yr[f.key] || 0))
            );
            const el = id => document.getElementById(id);
            if (el('statTotBen'))  el('statTotBen').textContent  = statsFmt(t.ben);
            if (el('statTotProy')) el('statTotProy').textContent = statsFmt(t.proy);
            if (el('statTotHrs'))  el('statTotHrs').textContent  = statsFmt(t.hrs);
            if (el('statTotVol'))  el('statTotVol').textContent  = statsFmt(t.vol);
        }

        /* ── Dropdown ── */
        const statsDd = document.getElementById('statsYrDd');
        if (statsDd && statsDd.parentElement !== document.body) {
            document.body.appendChild(statsDd);
        }
        let statsDropBtn = null;

        function statsBuildDropdown() {
            if (!statsDd) return;
            statsDd.innerHTML = '';
            statsSortedYears().forEach((yr, i) => {
                const item = document.createElement('div');
                item.className = 'stats-yr-dd-item' + (i === statsCurrentIdx ? ' active' : '');
                item.textContent = yr;
                item.addEventListener('click', e => {
                    e.stopPropagation();
                    statsCurrentIdx = i;
                    statsRenderAll();
                    statsCloseDropdown();
                });
                statsDd.appendChild(item);
            });
        }

        function statsPositionDropdown(btn) {
            if (!statsDd || !btn) return;
            const r = btn.getBoundingClientRect();
            statsDd.style.top   = (r.bottom + 6) + 'px';
            statsDd.style.left  = r.left + 'px';
            statsDd.style.width = '';
        }

        function statsOpenDropdown(btn) {
            statsDropBtn = btn;
            statsBuildDropdown();
            statsDd.style.visibility = 'hidden';
            statsDd.style.display    = 'block';
            statsPositionDropdown(btn);
            statsDd.style.visibility = '';
            btn.classList.add('open');
        }

        function statsCloseDropdown() {
            if (statsDd) statsDd.style.display = 'none';
            statsDropBtn?.classList.remove('open');
            statsDropBtn = null;
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('.stats-yr-active-wrap') &&
                !e.target.closest('#statsYrDd')) {
                statsCloseDropdown();
            }
        });
        window.addEventListener('scroll', () => {
            if (statsDd && statsDd.style.display !== 'none' && statsDropBtn)
                statsPositionDropdown(statsDropBtn);
        }, { passive: true });
        window.addEventListener('resize', () => {
            if (statsDd && statsDd.style.display !== 'none' && statsDropBtn)
                statsPositionDropdown(statsDropBtn);
        }, { passive: true });

        /* ── Poblar select de años disponibles ── */
        function statsPopulateAddForm() {
            const addForm = document.getElementById('statsAddYrForm');
            const plusBtnReset = document.querySelector('.stats-btn-plus');
            if (plusBtnReset) {
                plusBtnReset.disabled = false;
                plusBtnReset.style.opacity       = '';
                plusBtnReset.style.cursor        = '';
                plusBtnReset.style.pointerEvents = '';
            }
            if (!addForm) return;

            const currentYear = new Date().getFullYear();
            const existing    = statsSortedYears();

            // Años disponibles: año actual+1 hacia atrás hasta 2023, excluyendo los ya registrados
            const available = [];
            for (let y = currentYear; y >= 2023; y--) {
                if (!existing.includes(y)) available.push(y);
            }

            // Reemplazar el input por un select (solo la primera vez)
            const oldInp = document.getElementById('statsAyiInp');
            let sel = addForm.querySelector('.stats-ayi-select');

            if (!sel) {
                sel = document.createElement('select');
                sel.className = 'stats-ayi stats-ayi-select';
                sel.id = 'statsAyiSel';
                if (oldInp) oldInp.replaceWith(sel);
                else addForm.prepend(sel);
            }

            sel.innerHTML = '';
            const btnOk = document.getElementById('statsBtnOk');

                if (available.length === 0) {
                    // Cerrar el form si estaba abierto
                    addForm.classList.remove('show');
                    // Deshabilitar visualmente el botón +
                    const plusBtn = document.querySelector('.stats-btn-plus');
                    if (plusBtn) {
                        plusBtn.disabled = true;
                        plusBtn.style.opacity      = '0.35';
                        plusBtn.style.cursor       = 'not-allowed';
                        plusBtn.style.pointerEvents = 'none';
                    }
                    return;
                }else {
                if (btnOk) btnOk.disabled = false;
                available.forEach(y => {
                    const opt = document.createElement('option');
                    opt.value       = y;
                    opt.textContent = y;
                    sel.appendChild(opt);
                });
            }
        }

        // NUEVA función — agregar después de statsPopulateAddForm
        function statsUpdatePlusBtn() {
            const currentYear = new Date().getFullYear();
            const existing    = statsSortedYears();
            const available   = [];
            for (let y = currentYear; y >= 2023; y--) {
                if (!existing.includes(y)) available.push(y);
            }

            const plusBtn = document.querySelector('.stats-btn-plus');
            if (!plusBtn) return;

            if (available.length === 0) {
                plusBtn.disabled            = true;
                plusBtn.style.opacity       = '0.35';
                plusBtn.style.cursor        = 'not-allowed';
                plusBtn.style.pointerEvents = 'none';
            } else {
                plusBtn.disabled            = false;
                plusBtn.style.opacity       = '';
                plusBtn.style.cursor        = '';
                plusBtn.style.pointerEvents = '';
            }
        }

        /* ── Carrusel ── */
        function statsBuildCarousel() {
            const row = document.getElementById('statsYrRow');
            if (!row) return;
            row.innerHTML = '';

            const all    = statsSortedYears();   // ordenados desc: [2025, 2024, 2023…]
            if (!all.length) {
                // Sin años: solo mostrar botón +
                const plusBtn = buildPlusBtn();
                row.appendChild(plusBtn);
                return;
            }

            const activeYr = all[statsCurrentIdx];

            // Año anterior (el que va ANTES en el tiempo = índice mayor en array desc)
            const prevYr = all[statsCurrentIdx + 1] ?? null;
            // Año siguiente (el que va DESPUÉS en el tiempo = índice menor en array desc)
            const nextYr = all[statsCurrentIdx - 1] ?? null;

            // Cápsula año anterior
            if (prevYr !== null) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'stats-yr-adj';
                btn.textContent = prevYr;
                btn.addEventListener('click', () => {
                    statsCurrentIdx = statsCurrentIdx + 1;
                    statsRenderAll();
                });
                row.appendChild(btn);
            }

            // Cápsula activa (con dropdown)
            const wrap   = document.createElement('div');
            wrap.className = 'stats-yr-active-wrap';
            const actBtn = document.createElement('button');
            actBtn.type      = 'button';
            actBtn.className = 'stats-yr-act';
            actBtn.innerHTML = `${activeYr} <span class="stats-yr-chv">&#9660;</span>`;
            actBtn.addEventListener('click', e => {
                e.stopPropagation();
                statsDd.style.display === 'none'
                    ? statsOpenDropdown(actBtn)
                    : statsCloseDropdown();
            });
            wrap.appendChild(actBtn);
            row.appendChild(wrap);

            // Cápsula año siguiente
            if (nextYr !== null) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'stats-yr-adj';
                btn.textContent = nextYr;
                btn.addEventListener('click', () => {
                    statsCurrentIdx = statsCurrentIdx - 1;
                    statsRenderAll();
                });
                row.appendChild(btn);
            }

            // Botón +
            row.appendChild(buildPlusBtn());
        }

        function buildPlusBtn() {
            const plusBtn = document.createElement('button');
            plusBtn.type        = 'button';
            plusBtn.className   = 'stats-btn-plus';
            plusBtn.title       = 'Agregar año';
            plusBtn.textContent = '+';
            plusBtn.addEventListener('click', e => {
                e.stopPropagation();
                const addForm = document.getElementById('statsAddYrForm');
                const open    = addForm.classList.contains('show');
                addForm.classList.toggle('show', !open);
                if (!open) statsPopulateAddForm();
                statsCloseDropdown();
            });
            return plusBtn;
        }

        /* ── Panel del año ── */
        function statsRenderPanel() {
            const wrap = document.getElementById('statsYrPanel');
            if (!wrap) return;

            const all = statsSortedYears();
            if (!all.length) {
                wrap.innerHTML = '<div class="stats-no-yr">Sin años registrados. Usa el botón + para añadir uno.</div>';
                return;
            }

            const yr = all[statsCurrentIdx];
            const d  = statsData[yr] || {};
            wrap.innerHTML = '';

            const p = document.createElement('div');
            p.className = 'stats-yr-panel';

            const hdr = document.createElement('div');
            hdr.className = 'stats-yr-panel-hdr';
            hdr.innerHTML = `
                <span class="stats-yr-badge">${yr}</span>
                <span class="stats-yr-psub">Datos registrados </span>`;
            p.appendChild(hdr);

            const grid = document.createElement('div');
            grid.className = 'stats-fields-grid';

            STAT_FIELDS.forEach(f => {
                const sf = document.createElement('div');
                sf.className = 'stats-field';
                sf.innerHTML = `
                    <label>${f.label}</label>
                    <input type="number" min="0"
                           data-key="${f.key}"
                           value="${d[f.key] || ''}"
                           placeholder="${f.placeholder}">`;
                grid.appendChild(sf);
            });

            p.appendChild(grid);
            wrap.appendChild(p);

            p.addEventListener('input', e => {
                const inp = e.target;
                if (inp.tagName !== 'INPUT' || !inp.dataset.key) return;
                if (!statsData[yr]) statsData[yr] = {};
                statsData[yr][inp.dataset.key] = Number(inp.value) || 0;
                statsUpdateTotals();
            });
        }

        /* ── Render completo ── */
        function statsRenderAll() {
            statsBuildCarousel();
            statsRenderPanel();
            statsUpdateTotals();
            statsUpdatePlusBtn();
        }

        /* ── Confirmar agregar año ── */
        function statsConfirmAddYear() {
            const sel = document.querySelector('.stats-ayi-select');
            const val = parseInt(sel?.value);
            if (!val) {
                showToast('No hay años disponibles para agregar.', 'error');
                return;
            }
            if (statsData[val] !== undefined) {
                showToast(`El año ${val} ya existe.`, 'error');
                return;
            }
            statsData[val] = { ben: 0, proy: 0, hrs: 0, vol: 0 };
            statsCurrentIdx = statsSortedYears().indexOf(val);
            document.getElementById('statsAddYrForm')?.classList.remove('show');
            statsRenderAll();
            showToast(`Año ${val} agregado.`);
        }

        document.getElementById('statsBtnOk')?.addEventListener('click', statsConfirmAddYear);
        document.getElementById('statsBtnCx')?.addEventListener('click', () => {
            document.getElementById('statsAddYrForm')?.classList.remove('show');
        });

        /* ── Init ── */
        statsCurrentIdx = 0;
        statsRenderAll();
    }

})();
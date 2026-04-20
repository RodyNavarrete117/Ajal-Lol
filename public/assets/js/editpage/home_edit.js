/* ==================== HOME EDIT — JS ====================
   Ruta: assets/js/editpage/home_edit.js
   ========================================================= */
(function () {
    'use strict';

    const MAX_VIDEOS = 10;
    const CSRF = window.HOME_ROUTES?.csrfToken
        ?? document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ── helpers fetch ── */
    async function apiFetch(url, body) {
        const isFormData = body instanceof FormData;
        const res = await fetch(url, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept'      : 'application/json',
                ...(!isFormData ? { 'Content-Type': 'application/json' } : {}),
            },
            body: isFormData ? body : JSON.stringify(body),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Error en la solicitud.');
        return data;
    }

    /* ── Toast ── */
    function showToast(message, type = 'success') {
        document.querySelector('.edit-toast')?.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                <i class="fa ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            </span>
            <span class="edit-toast__msg">${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3200);
    }

    /* ── Tabs ── */
    document.querySelectorAll('.edit-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.edit-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.edit-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + tab.dataset.target);
            if (panel) panel.classList.add('active');
        });
    });

    /* ── Extraer ID de YouTube ── */
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

    /* ── Actualizar miniatura ── */
    function updateThumb(thumbEl, videoId) {
        if (!thumbEl) return;
        const img = thumbEl.querySelector('img');
        if (!img) return;
        if (videoId) {
            img.src           = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;
            img.style.opacity = '1';
        } else {
            img.src           = '';
            img.style.opacity = '0';
        }
    }

    /* ── Init fila de video ── */
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

    /* ── Renumerar filas ── */
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
        });
    }

    /* ── Estado botón agregar ── */
    function updateVideoAddBar() {
        const count = document.querySelectorAll('.video-row').length;
        const btn   = document.getElementById('btnAddVideo');
        if (!btn) return;
        btn.disabled = count >= MAX_VIDEOS;
        document.getElementById('videoAddBar')?.classList.toggle('is-max', count >= MAX_VIDEOS);
    }

    /* ── Construir fila nueva ── */
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
                    <label for="vid_id_${n}">URL de YouTube</label>
                    <input type="text" id="vid_id_${n}" name="vid_id_${n}"
                        placeholder="Ej: https://www.youtube.com/watch?v=..."
                        class="vid-id-input" data-thumb="vthumb-${n}">
                    <span class="field-hint">URL completa de YouTube.</span>
                </div>
            </div>
            <button type="button" class="btn-remove-video" data-row="${n}" title="Eliminar video">
                <i class="fa fa-xmark"></i>
            </button>`;
        return row;
    }

    /* ── Botón agregar video ── */
    document.getElementById('btnAddVideo')?.addEventListener('click', () => {
        const count = document.querySelectorAll('.video-row').length;
        if (count >= MAX_VIDEOS) {
            showToast(`Máximo de ${MAX_VIDEOS} videos alcanzado.`, 'error');
            return;
        }
        const row = buildVideoRow(count + 1);
        document.getElementById('videosList').appendChild(row);
        initVideoRow(row);
        updateVideoAddBar();
        setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 80);
    });

    /* ── Guardar Hero ── */
    document.getElementById('btnSaveHero')?.addEventListener('click', async () => {
        const payload = {
            eyebrow          : document.getElementById('eyebrow')?.value.trim(),
            titulo_principal : document.getElementById('titulo_principal')?.value.trim(),
            titulo_em        : document.getElementById('titulo_em')?.value.trim(),
            descripcion      : document.getElementById('descripcion')?.value.trim(),
        };

        if (!payload.titulo_principal || !payload.descripcion) {
            showToast('Completa los campos obligatorios.', 'error');
            return;
        }

        try {
            const data = await apiFetch(window.HOME_ROUTES.hero, payload);
            showToast(data.message ?? 'Hero guardado.');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ── Guardar Videos ── */
    document.getElementById('btnSaveVideos')?.addEventListener('click', async () => {
        const rows  = document.querySelectorAll('.video-row');
        const videos = [];

        rows.forEach(row => {
            const urlInput   = row.querySelector('.vid-id-input');
            const titleInput = row.querySelector('.vid-title-input');
            const url        = urlInput?.value.trim();
            if (url) {
                videos.push({
                    titulo: titleInput?.value.trim() ?? '',
                    url,
                });
            }
        });

        if (!videos.length) {
            showToast('Agrega al menos un video con URL.', 'error');
            return;
        }

        try {
            const data = await apiFetch(window.HOME_ROUTES.videos, { videos });
            showToast(data.message ?? 'Videos guardados.');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ── Guardar Estadísticas ── */
    document.getElementById('btnSaveStats')?.addEventListener('click', async () => {
        const hidden = document.getElementById('statsDataInput');
        if (hidden && typeof statsData !== 'undefined') {
            hidden.value = JSON.stringify(statsData);
        }

        const formData = new FormData();
        formData.append('stats_data', hidden?.value ?? '{}');
        formData.append('_token', CSRF);

        try {
            const res  = await fetch(window.HOME_ROUTES.stats, {
                method : 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                    'X-CSRF-TOKEN'    : CSRF,
                },
                body: formData,
            });
            const data = await res.json();
            if (data.success) {
                showToast('Estadísticas guardadas correctamente.');
            } else {
                showToast('Error al guardar.', 'error');
            }
        } catch (err) {
            showToast('Error al guardar las estadísticas.', 'error');
        }
    });

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
    var bdStatsData = {};

    if (statsPanel) {

        try {
            const raw = JSON.parse(statsPanel.dataset.stats || '{}');
            Object.entries(raw).forEach(([k, v]) => { statsData[Number(k)] = v; });
        } catch (e) { console.error('Error al parsear data-stats:', e); }

        try {
            const rawBd = JSON.parse(statsPanel.dataset.bdStats || '{}');
            Object.entries(rawBd).forEach(([k, v]) => { bdStatsData[Number(k)] = v; });
        } catch (e) { console.error('Error al parsear data-bd-stats:', e); }

        let statsCurrentIdx = 0;

        function statsSortedYears() {
            return Object.keys(statsData).map(Number).sort((a, b) => b - a);
        }
        function statsFmt(n) { return Number(n || 0).toLocaleString('es-MX'); }

        function statsUpdateTotals() {
            const t = { ben: 0, proy: 0, hrs: 0, vol: 0 };
            Object.entries(statsData).forEach(([yrKey, yr]) => {
                STAT_FIELDS.forEach(f => { t[f.key] += Number(yr[f.key] || 0); });
                if (yr._bdInclude) {
                    const bd = bdStatsData[Number(yrKey)];
                    if (bd) {
                        t.ben  += Number(bd.beneficiarios || 0);
                        t.proy += Number(bd.proyectos     || 0);
                    }
                }
            });
            const el = id => document.getElementById(id);
            if (el('statTotBen'))  el('statTotBen').textContent  = statsFmt(t.ben);
            if (el('statTotProy')) el('statTotProy').textContent = statsFmt(t.proy);
            if (el('statTotHrs'))  el('statTotHrs').textContent  = statsFmt(t.hrs);
            if (el('statTotVol'))  el('statTotVol').textContent  = statsFmt(t.vol);
        }

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
            statsDd.style.top  = (r.bottom + 6) + 'px';
            statsDd.style.left = r.left + 'px';
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
            if (!e.target.closest('.stats-yr-active-wrap') && !e.target.closest('#statsYrDd'))
                statsCloseDropdown();
        });
        window.addEventListener('scroll', () => {
            if (statsDd?.style.display !== 'none' && statsDropBtn)
                statsPositionDropdown(statsDropBtn);
        }, { passive: true });
        window.addEventListener('resize', () => {
            if (statsDd?.style.display !== 'none' && statsDropBtn)
                statsPositionDropdown(statsDropBtn);
        }, { passive: true });

        function statsPopulateAddForm() {
            const addForm     = document.getElementById('statsAddYrForm');
            const currentYear = new Date().getFullYear();
            const existing    = statsSortedYears();
            const available   = [];
            for (let y = currentYear; y >= 2023; y--) {
                if (!existing.includes(y)) available.push(y);
            }

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
                addForm.classList.remove('show');
                const plusBtn = document.querySelector('.stats-btn-plus');
                if (plusBtn) {
                    plusBtn.disabled            = true;
                    plusBtn.style.opacity       = '0.35';
                    plusBtn.style.cursor        = 'not-allowed';
                    plusBtn.style.pointerEvents = 'none';
                }
                return;
            } else {
                if (btnOk) btnOk.disabled = false;
                available.forEach(y => {
                    const opt = document.createElement('option');
                    opt.value = y; opt.textContent = y;
                    sel.appendChild(opt);
                });
            }
        }

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
                plusBtn.disabled = true; plusBtn.style.opacity = '0.35';
                plusBtn.style.cursor = 'not-allowed'; plusBtn.style.pointerEvents = 'none';
            } else {
                plusBtn.disabled = false; plusBtn.style.opacity = '';
                plusBtn.style.cursor = ''; plusBtn.style.pointerEvents = '';
            }
        }

        function statsBuildCarousel() {
            const row = document.getElementById('statsYrRow');
            if (!row) return;
            row.innerHTML = '';

            const all = statsSortedYears();
            if (!all.length) { row.appendChild(buildPlusBtn()); return; }

            const prevYr = all[statsCurrentIdx + 1] ?? null;
            const nextYr = all[statsCurrentIdx - 1] ?? null;

            if (prevYr !== null) {
                const btn = document.createElement('button');
                btn.type = 'button'; btn.className = 'stats-yr-adj'; btn.textContent = prevYr;
                btn.addEventListener('click', () => { statsCurrentIdx++; statsRenderAll(); });
                row.appendChild(btn);
            }

            const wrap   = document.createElement('div');
            wrap.className = 'stats-yr-active-wrap';
            const actBtn = document.createElement('button');
            actBtn.type = 'button'; actBtn.className = 'stats-yr-act';
            actBtn.innerHTML = `${all[statsCurrentIdx]} <span class="stats-yr-chv">&#9660;</span>`;
            actBtn.addEventListener('click', e => {
                e.stopPropagation();
                statsDd.style.display === 'none'
                    ? statsOpenDropdown(actBtn)
                    : statsCloseDropdown();
            });
            wrap.appendChild(actBtn);
            row.appendChild(wrap);

            if (nextYr !== null) {
                const btn = document.createElement('button');
                btn.type = 'button'; btn.className = 'stats-yr-adj'; btn.textContent = nextYr;
                btn.addEventListener('click', () => { statsCurrentIdx--; statsRenderAll(); });
                row.appendChild(btn);
            }

            row.appendChild(buildPlusBtn());
        }

        function buildPlusBtn() {
            const plusBtn = document.createElement('button');
            plusBtn.type = 'button'; plusBtn.className = 'stats-btn-plus';
            plusBtn.title = 'Agregar año'; plusBtn.textContent = '+';
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
            const bd = bdStatsData[yr] || null;
            wrap.innerHTML = '';

            const p = document.createElement('div');
            p.className = 'stats-yr-panel';

            const hdr = document.createElement('div');
            hdr.className = 'stats-yr-panel-hdr';
            hdr.innerHTML = `<span class="stats-yr-badge">${yr}</span><span class="stats-yr-psub">Datos registrados</span>`;
            p.appendChild(hdr);

            const grid = document.createElement('div');
            grid.className = 'stats-fields-grid';

            STAT_FIELDS.forEach(f => {
                const bdVal    = bd ? (f.key === 'ben' ? bd.beneficiarios : f.key === 'proy' ? bd.proyectos : null) : null;
                const manualVal = d[f.key] || '';
                const sf = document.createElement('div');
                sf.className = 'stats-field'; sf.dataset.fieldKey = f.key;
                sf.innerHTML = `
                    <label>${f.label}</label>
                    <input type="number" min="0" data-key="${f.key}"
                        value="${manualVal}" placeholder="${f.placeholder}">
                    ${bdVal !== null ? `<span class="stats-field-bd-hint">+ ${Number(bdVal).toLocaleString('es-MX')} de la BD</span>` : ''}`;
                grid.appendChild(sf);
            });
            p.appendChild(grid);

            if (bd && (bd.beneficiarios > 0 || bd.proyectos > 0)) {
                const bdSection = document.createElement('div');
                bdSection.className = 'stats-bd-toggle-row';
                const isChecked = d._bdInclude === true || d._bdInclude === 1;
                bdSection.innerHTML = `
                    <div class="stats-bd-toggle-info">
                        <i class="fa fa-database"></i>
                        <span>Sumar datos existentes de la BD para <strong>${yr}</strong>:</span>
                        <span class="stats-bd-pill">
                            ${bd.beneficiarios > 0 ? `<span>${Number(bd.beneficiarios).toLocaleString('es-MX')} beneficiarios</span>` : ''}
                            ${bd.proyectos > 0 ? `<span>${Number(bd.proyectos).toLocaleString('es-MX')} proyectos</span>` : ''}
                        </span>
                    </div>
                    <label class="stats-bd-switch">
                        <input type="checkbox" class="stats-bd-chk" data-ano="${yr}" ${isChecked ? 'checked' : ''}>
                        <span class="stats-bd-switch-track"><span class="stats-bd-switch-thumb"></span></span>
                    </label>`;
                p.appendChild(bdSection);
                bdSection.querySelector('.stats-bd-chk').addEventListener('change', function () {
                    const ano = Number(this.dataset.ano);
                    if (!statsData[ano]) statsData[ano] = { ben: 0, proy: 0, hrs: 0, vol: 0 };
                    Object.assign(statsData[ano], { _bdInclude: this.checked });
                    statsUpdateTotals();
                });
            }

            wrap.appendChild(p);
            p.addEventListener('input', e => {
                const inp = e.target;
                if (inp.tagName !== 'INPUT' || inp.type === 'checkbox' || !inp.dataset.key) return;
                if (!statsData[yr]) statsData[yr] = {};
                statsData[yr][inp.dataset.key] = Number(inp.value) || 0;
                statsUpdateTotals();
            });
        }

        function statsRenderAll() {
            statsBuildCarousel();
            statsRenderPanel();
            statsUpdateTotals();
            statsUpdatePlusBtn();
        }

        function statsConfirmAddYear() {
            const sel = document.querySelector('.stats-ayi-select');
            const val = parseInt(sel?.value);
            if (!val) { showToast('No hay años disponibles.', 'error'); return; }
            if (statsData[val] !== undefined) { showToast(`El año ${val} ya existe.`, 'error'); return; }
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

        statsCurrentIdx = 0;
        statsRenderAll();
    }

})();
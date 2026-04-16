/* ==================== activities_edit.js ==================== */
(function () {
    'use strict';

    /* ════ RUTAS (inyectadas desde blade) ════ */
    const ROUTES = window.ACTIVITIES_ROUTES ?? {};
    const CSRF   = ROUTES.csrfToken ?? document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ════ HELPERS FETCH ════ */
    async function apiFetch(url, method = 'GET', body = null) {
        const opts = {
            method,
            headers: {
                'Content-Type'  : 'application/json',
                'X-CSRF-TOKEN'  : CSRF,
                'Accept'        : 'application/json',
            },
        };
        if (body) opts.body = JSON.stringify(body);
        const res  = await fetch(url, opts);
        const data = await res.json();
        if (!res.ok) throw new Error(data.message ?? 'Error en la solicitud.');
        return data;
    }

    /* ════ CATÁLOGO DE ÍCONOS ════ */
    const ICON_CATALOG = {
        'Salud': [
            { cls: 'fa-heart-pulse',    label: 'Pulso cardíaco'   },
            { cls: 'fa-stethoscope',    label: 'Estetoscopio'     },
            { cls: 'fa-syringe',        label: 'Jeringa'          },
            { cls: 'fa-pills',          label: 'Pastillas'        },
            { cls: 'fa-tooth',          label: 'Diente'           },
            { cls: 'fa-eye',            label: 'Ojo / Visión'     },
            { cls: 'fa-brain',          label: 'Cerebro'          },
            { cls: 'fa-lungs',          label: 'Pulmones'         },
            { cls: 'fa-hospital',       label: 'Hospital'         },
            { cls: 'fa-kit-medical',    label: 'Kit médico'       },
            { cls: 'fa-weight-scale',   label: 'Báscula'          },
            { cls: 'fa-person-walking', label: 'Ejercicio'        },
        ],
        'Educación': [
            { cls: 'fa-chalkboard',     label: 'Pizarrón'        },
            { cls: 'fa-book-open',      label: 'Libro abierto'   },
            { cls: 'fa-graduation-cap', label: 'Graduación'      },
            { cls: 'fa-pencil',         label: 'Lápiz'           },
            { cls: 'fa-school',         label: 'Escuela'         },
            { cls: 'fa-laptop',         label: 'Computadora'     },
            { cls: 'fa-microscope',     label: 'Microscopio'     },
            { cls: 'fa-lightbulb',      label: 'Idea'            },
            { cls: 'fa-certificate',    label: 'Certificado'     },
        ],
        'Naturaleza': [
            { cls: 'fa-tree',           label: 'Árbol'           },
            { cls: 'fa-leaf',           label: 'Hoja'            },
            { cls: 'fa-seedling',       label: 'Planta'          },
            { cls: 'fa-droplet',        label: 'Agua / Tinaco'   },
            { cls: 'fa-sun',            label: 'Sol'             },
            { cls: 'fa-wind',           label: 'Viento'          },
            { cls: 'fa-mountain',       label: 'Montaña'         },
            { cls: 'fa-globe',          label: 'Tierra'          },
            { cls: 'fa-recycle',        label: 'Reciclaje'       },
            { cls: 'fa-paw',            label: 'Animal / Mascota'},
            { cls: 'fa-feather',        label: 'Pluma / Ave'     },
            { cls: 'fa-fish',           label: 'Pez'             },
        ],
        'Comunidad': [
            { cls: 'fa-people-group',   label: 'Grupo de personas'},
            { cls: 'fa-heart',          label: 'Apoyo'            },
            { cls: 'fa-house',          label: 'Casa'             },
            { cls: 'fa-utensils',       label: 'Alimentación'     },
            { cls: 'fa-shirt',          label: 'Ropa'             },
            { cls: 'fa-gift',           label: 'Donación'         },
            { cls: 'fa-handshake',      label: 'Solidaridad'      },
            { cls: 'fa-church',         label: 'Iglesia'          },
            { cls: 'fa-store',          label: 'Comercio local'   },
            { cls: 'fa-user-group',     label: 'Familias'         },
            { cls: 'fa-wheelchair',     label: 'Adulto mayor'     },
            { cls: 'fa-baby-carriage',  label: 'Bebé'             },
        ],
        'Trabajo': [
            { cls: 'fa-briefcase',       label: 'Maletín'         },
            { cls: 'fa-hammer',          label: 'Martillo'        },
            { cls: 'fa-wrench',          label: 'Herramientas'    },
            { cls: 'fa-tractor',         label: 'Tractor'         },
            { cls: 'fa-industry',        label: 'Industria'       },
            { cls: 'fa-money-bill-wave', label: 'Dinero'          },
            { cls: 'fa-chart-line',      label: 'Crecimiento'     },
            { cls: 'fa-handshake',       label: 'Acuerdo'         },
            { cls: 'fa-bullhorn',        label: 'Anuncio'         },
            { cls: 'fa-calendar-check',  label: 'Evento'          },
        ],
        'General': [
            { cls: 'fa-star',           label: 'Estrella'        },
            { cls: 'fa-trophy',         label: 'Trofeo'          },
            { cls: 'fa-flag',           label: 'Bandera'         },
            { cls: 'fa-circle-check',   label: 'Completado'      },
            { cls: 'fa-calendar-days',  label: 'Calendario'      },
            { cls: 'fa-location-dot',   label: 'Ubicación'       },
            { cls: 'fa-camera',         label: 'Fotografía'      },
            { cls: 'fa-music',          label: 'Música / Arte'   },
            { cls: 'fa-palette',        label: 'Pintura'         },
            { cls: 'fa-fire',           label: 'Urgente'         },
            { cls: 'fa-shield-halved',  label: 'Protección'      },
        ],
        'Animales': [
            { cls: 'fa-kiwi-bird',       label: 'Ave de corral'    },
            { cls: 'fa-crow',            label: 'Gallo / Gallina'  },
            { cls: 'fa-egg',             label: 'Huevo'            },
            { cls: 'fa-drumstick-bite',  label: 'Pollo'            },
            { cls: 'fa-paw',             label: 'Animal de granja' },
            { cls: 'fa-horse',           label: 'Caballo'          },
            { cls: 'fa-cow',             label: 'Vaca'             },
            { cls: 'fa-dog',             label: 'Animal doméstico' },
            { cls: 'fa-wheat-awn',       label: 'Alimento animal'  },
            { cls: 'fa-tractor',         label: 'Campo'            },
        ],
        'Campo': [
            { cls: 'fa-tractor',          label: 'Agricultura'        },
            { cls: 'fa-seedling',         label: 'Siembra'            },
            { cls: 'fa-leaf',             label: 'Cultivo'            },
            { cls: 'fa-wheat-awn',        label: 'Cosecha'            },
            { cls: 'fa-water',            label: 'Riego'              },
            { cls: 'fa-sun',              label: 'Jornada agrícola'   },
            { cls: 'fa-cloud-sun',        label: 'Clima'              },
            { cls: 'fa-bucket',           label: 'Recolección'        },
            { cls: 'fa-hammer',           label: 'Herramientas'       },
            { cls: 'fa-people-carry-box', label: 'Apoyo comunitario'  },
            { cls: 'fa-truck',            label: 'Transporte rural'   },
        ],
    };

    const ALL_ICONS = Object.entries(ICON_CATALOG).flatMap(([cat, icons]) =>
        icons.map(ic => ({ ...ic, cat }))
    );

    /* ════ TABS ════ */
    document.querySelectorAll('.edit-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.edit-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.edit-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            const panel = document.getElementById('panel-' + tab.dataset.target);
            if (panel) panel.classList.add('active');
        });
    });

    /* ════ YEAR PICKER — Encabezado ════ */
    const yearDisplay = document.getElementById('yearDisplay');
    const yearInput   = document.getElementById('anio_activo');
    const MIN_YEAR = 2000, MAX_YEAR = 2099;

    function animateEl(el, dir) {
        el.style.cssText = 'transition:none;transform:' + (dir === 'up' ? 'translateY(10px)' : 'translateY(-10px)') + ';opacity:0';
        requestAnimationFrame(() => {
            el.style.cssText = 'transition:transform .18s ease,opacity .18s ease;transform:translateY(0);opacity:1';
        });
    }

    function updateYear(delta) {
        let val = parseInt(yearInput.value) + delta;
        val = Math.max(MIN_YEAR, Math.min(MAX_YEAR, val));
        yearInput.value = val;
        yearDisplay.textContent = val;
        animateEl(yearDisplay, delta > 0 ? 'up' : 'down');
    }

    document.getElementById('yearDown')?.addEventListener('click', () => updateYear(-1));
    document.getElementById('yearUp')?.addEventListener('click',   () => updateYear(1));

    /* ════ GUARDAR ENCABEZADO ════ */
    document.getElementById('btnSaveEncabezado')?.addEventListener('click', async () => {
        const titulo     = document.getElementById('titulo_seccion')?.value.trim();
        const subtitulo  = document.getElementById('subtitulo_seccion')?.value.trim();
        const anoVisible = parseInt(yearInput?.value);

        if (!titulo) {
            showToast('El título principal es obligatorio.', 'error');
            document.getElementById('titulo_seccion')?.focus();
            return;
        }

        try {
            const data = await apiFetch(ROUTES.encabezado, 'POST', {
                titulo_actividad    : titulo,
                subtitulo_actividad : subtitulo,
                ano_visible         : anoVisible,
            });
            showToast(data.message ?? 'Encabezado guardado.', 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ════ FILTRO DE AÑO — Pestaña Actividades ════ */
    const filterYearDisplay = document.getElementById('filterYearDisplay');
    const filterYearInput   = document.getElementById('filter_anio');

    function updateFilterYear(delta) {
        let val = parseInt(filterYearInput.value) + delta;
        val = Math.max(MIN_YEAR, Math.min(MAX_YEAR, val));
        filterYearInput.value = val;
        filterYearDisplay.textContent = val;
        animateEl(filterYearDisplay, delta > 0 ? 'up' : 'down');
        loadActivitiesForYear(val);
    }

    document.getElementById('filterYearDown')?.addEventListener('click', () => updateFilterYear(-1));
    document.getElementById('filterYearUp')?.addEventListener('click',   () => updateFilterYear(1));

    /* ════ CARGAR ACTIVIDADES POR AÑO (AJAX) ════ */
    async function loadActivitiesForYear(ano) {
        const list = document.getElementById('activitiesList');
        if (!list) return;

        list.style.cssText = 'opacity:0;transition:opacity .2s;';

        try {
            const url  = ROUTES.byAno.replace(':ano', ano);
            const data = await apiFetch(url);
            const acts = data.actividades ?? [];

            list.innerHTML = '';

            if (acts.length === 0) {
                list.innerHTML = `
                <div class="act-empty-state">
                    <i class="fa fa-calendar-xmark"></i>
                    <p>No hay actividades para <strong>${ano}</strong>.</p>
                    <span>Agrega la primera actividad con el botón de abajo.</span>
                </div>`;
            } else {
                acts.forEach((act, i) => {
                    const card = buildCard(i + 1, act);
                    list.appendChild(card);
                    initCard(card);
                });
                actCount = acts.length;
            }
        } catch (err) {
            showToast('Error al cargar actividades.', 'error');
        } finally {
            requestAnimationFrame(() => {
                list.style.cssText = 'opacity:1;transition:opacity .3s;';
            });
        }
    }

    /* ════ GUARDAR ACTIVIDADES ════ */
    document.getElementById('btnSaveActividades')?.addEventListener('click', async () => {
        const ano   = parseInt(filterYearInput?.value);
        const cards = document.querySelectorAll('#activitiesList .activity-card');

        if (cards.length === 0) {
            showToast('Agrega al menos una actividad.', 'error');
            return;
        }

        const actividades = [];
        let valid = true;

        cards.forEach((card, i) => {
            const titulo = card.querySelector(`[name^="act_titulo_"]`)?.value.trim();
            const icono  = card.querySelector('.icon-hidden-input')?.value.trim();
            const desc   = card.querySelector(`[name^="act_desc_"]`)?.value.trim();

            if (!titulo) {
                valid = false;
                card.setAttribute('data-collapsed', 'false');
                showToast(`La tarjeta ${i + 1} necesita un título.`, 'error');
                return;
            }

            actividades.push({ titulo, icono: icono || 'fa-star', descripcion: desc });
        });

        if (!valid) return;

        try {
            const data = await apiFetch(ROUTES.actividades, 'POST', { ano, actividades });
            showToast(data.message ?? 'Actividades guardadas.', 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al guardar.', 'error');
        }
    });

    /* ════ ACORDEÓN ════ */
    function initAccordion(card) {
        const toggleDiv = card.querySelector('.activity-card__toggle');
        if (!toggleDiv) return;
        toggleDiv.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-act')) return;
            const collapsed = card.getAttribute('data-collapsed') === 'true';
            card.setAttribute('data-collapsed', collapsed ? 'false' : 'true');
        });
    }

    function initTitleSync(card) {
        const input = card.querySelector('.act-title-input');
        if (!input) return;
        input.addEventListener('input', function () {
            const summaryEl = document.getElementById(this.dataset.summary);
            if (summaryEl) summaryEl.textContent = this.value || 'Sin título';
        });
    }

    /* ════ ICON PICKER ════ */
    let activeTarget   = null;
    let activeCategory = 'Todos';

    const picker      = document.getElementById('iconPicker');
    const backdrop    = document.getElementById('iconPickerBackdrop');
    const closeBtn    = document.getElementById('iconPickerClose');
    const searchInput = document.getElementById('iconSearch');
    const categoriesEl = document.getElementById('iconCategories');
    const gridEl      = document.getElementById('iconGrid');
    const emptyEl     = document.getElementById('iconEmpty');

    function renderCategories() {
        const cats = ['Todos', ...Object.keys(ICON_CATALOG)];
        categoriesEl.innerHTML = '';
        cats.forEach(cat => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'icon-cat-btn' + (cat === activeCategory ? ' active' : '');
            btn.textContent = cat;
            btn.addEventListener('click', () => {
                activeCategory = cat;
                document.querySelectorAll('.icon-cat-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                searchInput.value = '';
                renderGrid();
            });
            categoriesEl.appendChild(btn);
        });
    }

    function renderGrid(query = '') {
        const q = query.toLowerCase().trim();
        const currentValue = activeTarget?.hiddenInput.value || '';

        let icons = activeCategory === 'Todos'
            ? ALL_ICONS
            : ALL_ICONS.filter(ic => ic.cat === activeCategory);

        if (q) icons = ALL_ICONS.filter(ic =>
            ic.label.toLowerCase().includes(q) || ic.cls.toLowerCase().includes(q)
        );

        gridEl.innerHTML = '';

        if (!icons.length) {
            gridEl.style.display = 'none';
            emptyEl.style.display = 'flex';
            return;
        }

        gridEl.style.display = 'grid';
        emptyEl.style.display = 'none';

        icons.forEach(ic => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'icon-item' + (ic.cls === currentValue ? ' selected' : '');
            item.dataset.cls = ic.cls;
            item.innerHTML = `<i class="fa ${ic.cls}"></i><span>${ic.label}</span>`;
            item.addEventListener('click', () => selectIcon(ic));
            gridEl.appendChild(item);
        });
    }

    function selectIcon(ic) {
        if (!activeTarget) return;
        const { hiddenInput, previewEl, triggerEl, triggerNameEl, triggerClassEl, summaryIconEl } = activeTarget;

        hiddenInput.value = ic.cls;
        if (previewEl) previewEl.innerHTML = `<i class="fa ${ic.cls}"></i>`;
        if (summaryIconEl) summaryIconEl.textContent = ic.cls;
        if (triggerEl) {
            const tp = triggerEl.querySelector('.icon-selector-trigger__preview');
            if (tp) tp.innerHTML = `<i class="fa ${ic.cls}"></i>`;
        }
        if (triggerNameEl)  triggerNameEl.textContent  = ic.label;
        if (triggerClassEl) triggerClassEl.textContent = ic.cls;

        document.querySelectorAll('.icon-item').forEach(el =>
            el.classList.toggle('selected', el.dataset.cls === ic.cls)
        );
        setTimeout(closePicker, 220);
    }

    function openPicker(target) {
        activeTarget   = target;
        activeCategory = 'Todos';
        searchInput.value = '';
        renderCategories();
        renderGrid();
        picker.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => searchInput.focus(), 100);
    }

    function closePicker() {
        picker.classList.remove('open');
        document.body.style.overflow = '';
        if (activeTarget?.triggerEl) activeTarget.triggerEl.classList.remove('open');
        activeTarget = null;
    }

    backdrop.addEventListener('click', closePicker);
    closeBtn.addEventListener('click', closePicker);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && picker.classList.contains('open')) closePicker();
    });

    let searchTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            if (searchInput.value.trim()) activeCategory = 'Todos';
            renderCategories();
            renderGrid(searchInput.value);
        }, 220);
    });

    function initTrigger(trigger) {
        const targetId      = trigger.dataset.target;
        const previewId     = trigger.dataset.preview;
        const summaryIconId = trigger.dataset.summaryIcon;
        const hiddenInput   = document.getElementById(targetId);
        const previewEl     = document.getElementById(previewId);
        const summaryIconEl = summaryIconId ? document.getElementById(summaryIconId) : null;
        const triggerNameEl  = trigger.querySelector('.icon-selector-trigger__name');
        const triggerClassEl = trigger.querySelector('.icon-selector-trigger__class');
        if (!hiddenInput) return;
        trigger.addEventListener('click', () => {
            trigger.classList.add('open');
            openPicker({ hiddenInput, previewEl, triggerEl: trigger, triggerNameEl, triggerClassEl, summaryIconEl });
        });
    }

    /* ════ CARDS — AGREGAR / QUITAR ════ */
    let actCount = document.querySelectorAll('.activity-card').length;

    function renumber() {
        document.querySelectorAll('.activity-card').forEach((card, i) => {
            const n = i + 1;
            card.id = `act-${n}`;
            const numEl = card.querySelector('.act-card-num');
            if (numEl) numEl.textContent = n;
            const toggle = card.querySelector('.activity-card__toggle');
            if (toggle) toggle.dataset.card = `act-${n}`;
            ['icon-preview-', 'trigger-preview-', 'trigger-name-', 'trigger-class-',
             'summary-title-', 'summary-icon-'].forEach(prefix => {
                const el = card.querySelector(`[id^="${prefix}"]`);
                if (el) el.id = prefix + n;
            });
            const hidden = card.querySelector('.icon-hidden-input');
            if (hidden) { hidden.id = `act_icono_${n}`; hidden.name = `act_icono_${n}`; }
            const trigger = card.querySelector('.icon-selector-trigger');
            if (trigger) {
                trigger.dataset.target      = `act_icono_${n}`;
                trigger.dataset.preview     = `icon-preview-${n}`;
                trigger.dataset.summaryIcon = `summary-icon-${n}`;
            }
            card.querySelectorAll('input[name^="act_titulo_"], textarea[name^="act_desc_"]').forEach(el => {
                const base = el.name.replace(/_\d+$/, '');
                el.name = `${base}_${n}`; el.id = `${base}_${n}`;
            });
            const titleInput = card.querySelector('.act-title-input');
            if (titleInput) titleInput.dataset.summary = `summary-title-${n}`;
            const btnRemove = card.querySelector('.btn-remove-act');
            if (btnRemove) btnRemove.dataset.act = n;
        });
    }

    function removeCard(card) {
        if (document.querySelectorAll('.activity-card').length <= 1) {
            showToast('Debe haber al menos una actividad.', 'error');
            return;
        }
        card.style.cssText = 'transition:opacity .2s,transform .2s;opacity:0;transform:translateY(-6px);';
        setTimeout(() => { card.remove(); renumber(); }, 220);
    }

    function initCard(card) {
        initAccordion(card);
        initTitleSync(card);
        const trigger = card.querySelector('.icon-selector-trigger');
        if (trigger) initTrigger(trigger);
        const btnRemove = card.querySelector('.btn-remove-act');
        if (btnRemove) btnRemove.addEventListener('click', () => removeCard(card));
    }

    function buildCard(n, act = null) {
        const icono  = act?.icono_actividad  ?? '';
        const titulo = act?.titulo_actividad ?? '';
        const desc   = act?.texto_actividad  ?? '';
        const iconLabel = icono ? icono.replace('fa-', '') : 'Seleccionar ícono';

        const card = document.createElement('div');
        card.className = 'activity-card';
        card.id = `act-${n}`;
        card.setAttribute('data-collapsed', act ? 'true' : 'false');
        if (act?.id_actividad) card.dataset.id = act.id_actividad;
        card.style.cssText = 'opacity:0;transform:translateY(8px);';
        card.innerHTML = `
            <div class="activity-card__toggle" data-card="act-${n}">
                <span class="act-card-num">${n}</span>
                <span class="act-card-icon" id="icon-preview-${n}">
                    <i class="fa ${icono || 'fa-image'}"></i>
                </span>
                <span class="act-card-summary">
                    <span class="act-card-summary__title" id="summary-title-${n}">${titulo || 'Nueva actividad'}</span>
                    <span class="act-card-summary__sub" id="summary-icon-${n}">${icono || '—'}</span>
                </span>
                <span class="act-card-actions">
                    <span class="act-card-chevron"><i class="fa fa-chevron-down"></i></span>
                    <button type="button" class="btn-remove-act" data-act="${n}" title="Eliminar actividad">
                        <i class="fa fa-xmark"></i>
                    </button>
                </span>
            </div>
            <div class="act-card-divider"></div>
            <div class="act-card-body">
                <div class="act-fields-row">
                    <div class="form-group">
                        <label>Ícono</label>
                        <div class="icon-selector-wrap">
                            <div class="icon-selector-trigger"
                                 data-target="act_icono_${n}"
                                 data-preview="icon-preview-${n}"
                                 data-summary-icon="summary-icon-${n}">
                                <div class="icon-selector-trigger__preview" id="trigger-preview-${n}">
                                    <i class="fa ${icono || 'fa-image'}"></i>
                                </div>
                                <div class="icon-selector-trigger__info">
                                    <span class="icon-selector-trigger__name" id="trigger-name-${n}">${iconLabel}</span>
                                    <span class="icon-selector-trigger__class" id="trigger-class-${n}">${icono || '—'}</span>
                                </div>
                                <span class="icon-selector-trigger__arrow"><i class="fa fa-chevron-down"></i></span>
                            </div>
                            <input type="hidden" id="act_icono_${n}" name="act_icono_${n}" value="${icono}" class="icon-hidden-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="act_titulo_${n}">Título</label>
                        <input type="text" id="act_titulo_${n}" name="act_titulo_${n}"
                            value="${titulo}"
                            placeholder="Nombre de la actividad..."
                            class="act-title-input" data-summary="summary-title-${n}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="act_desc_${n}">Descripción</label>
                    <textarea id="act_desc_${n}" name="act_desc_${n}" rows="3"
                        placeholder="Describe la actividad, beneficiarios, alcance...">${desc}</textarea>
                </div>
            </div>`;
        return card;
    }

    document.getElementById('btnAddAct')?.addEventListener('click', () => {
        // Quitar estado vacío si existe
        document.getElementById('actEmptyState')?.remove();
        actCount++;
        const card = buildCard(actCount);
        document.getElementById('activitiesList').appendChild(card);
        requestAnimationFrame(() => {
            card.style.cssText = 'transition:opacity .3s,transform .3s;opacity:1;transform:translateY(0);';
        });
        initCard(card);
    });

    /* ════ TOAST ════ */
    function showToast(message, type = 'success') {
        document.querySelector('.edit-toast')?.remove();
        const toast = document.createElement('div');
        toast.className = `edit-toast edit-toast--${type}`;
        toast.innerHTML = `
            <span class="edit-toast__icon">
                <i class="fa ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
            </span>
            <span>${message}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('edit-toast--show'));
        setTimeout(() => {
            toast.classList.remove('edit-toast--show');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }, 3200);
    }

    /* ════ PANEL AÑOS — Toggle y Eliminar con fetch ════ */
    const confirmOverlay = document.getElementById('yrConfirmOverlay');
    const confirmYear    = document.getElementById('yrConfirmYear');
    const confirmDesc    = document.getElementById('yrConfirmDesc');
    const confirmCancel  = document.getElementById('yrConfirmCancel');
    const confirmDelete  = document.getElementById('yrConfirmDelete');

    let pendingDeleteId   = null;
    let pendingDeleteYear = null;
    let pendingDeleteRow  = null;

    function openDeleteConfirm(id, year, acts, row) {
        pendingDeleteId   = id;
        pendingDeleteYear = year;
        pendingDeleteRow  = row;
        confirmYear.textContent = year;
        confirmDesc.textContent = acts > 0
            ? `Se eliminarán también las ${acts} actividades de este año. Esta acción no se puede deshacer.`
            : 'Este año no tiene actividades. Esta acción no se puede deshacer.';
        confirmOverlay.classList.add('open');
        confirmOverlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteConfirm() {
        confirmOverlay.classList.remove('open');
        confirmOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        pendingDeleteId   = null;
        pendingDeleteYear = null;
        pendingDeleteRow  = null;
    }

    confirmCancel?.addEventListener('click', closeDeleteConfirm);
    confirmOverlay?.addEventListener('click', e => {
        if (e.target === confirmOverlay) closeDeleteConfirm();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && confirmOverlay?.classList.contains('open')) closeDeleteConfirm();
    });

    /* ── Confirmar eliminación con fetch ── */
    confirmDelete?.addEventListener('click', async () => {
        if (!pendingDeleteRow || !pendingDeleteId) return;

        const row  = pendingDeleteRow;
        const year = pendingDeleteYear;
        const id   = pendingDeleteId;
        closeDeleteConfirm();

        try {
            const url  = ROUTES.destroyAno.replace(':id', id);
            const data = await apiFetch(url, 'DELETE');

            row.style.cssText = 'transition:opacity .22s,transform .22s;opacity:0;transform:translateX(-8px);';
            setTimeout(() => {
                row.remove();
                showToast(data.message ?? `Año ${year} eliminado.`, 'success');
                const tbody = document.getElementById('yearsTableBody');
                if (tbody && tbody.querySelectorAll('.year-row').length === 0) {
                    tbody.innerHTML = `
                    <tr><td colspan="4" class="yt-empty">
                        <i class="fa fa-calendar-xmark"></i>
                        <span>No hay años registrados.</span>
                    </td></tr>`;
                }
            }, 240);
        } catch (err) {
            showToast(err.message ?? 'Error al eliminar.', 'error');
        }
    });

    /* ── Toggle visible/oculto con fetch ── */
    async function handleToggle(btn, row) {
        const id      = btn.dataset.id;
        const year    = row.dataset.year;
        const wasVisible = row.dataset.visible === 'true';

        try {
            const url  = ROUTES.toggleAno.replace(':id', id);
            const data = await apiFetch(url, 'PATCH');
            const newVisible = data.visible === 1;

            row.dataset.visible = newVisible ? 'true' : 'false';
            row.classList.toggle('year-row--hidden', !newVisible);

            const statusCell = row.querySelector('.yt-status');
            if (statusCell) {
                statusCell.className = `yt-status yt-status--${newVisible ? 'visible' : 'hidden'}`;
                statusCell.innerHTML = newVisible
                    ? '<i class="fa fa-eye"></i> Visible'
                    : '<i class="fa fa-eye-slash"></i> Oculto';
            }

            btn.dataset.visible = newVisible ? 'true' : 'false';
            btn.title = newVisible ? 'Ocultar año' : 'Mostrar año';
            btn.innerHTML = newVisible
                ? '<i class="fa fa-eye-slash"></i><span>Ocultar</span>'
                : '<i class="fa fa-eye"></i><span>Mostrar</span>';

            showToast(data.message ?? `Año ${year} actualizado.`, 'success');
        } catch (err) {
            showToast(err.message ?? 'Error al actualizar.', 'error');
        }
    }

    /* ── Delegación de eventos en tabla de años ── */
    document.getElementById('yearsTableBody')?.addEventListener('click', e => {
        const toggleBtn = e.target.closest('.yt-btn--toggle');
        const deleteBtn = e.target.closest('.yt-btn--delete');

        if (toggleBtn) {
            const row = toggleBtn.closest('.year-row');
            if (row) handleToggle(toggleBtn, row);
        }

        if (deleteBtn) {
            const row  = deleteBtn.closest('.year-row');
            const id   = deleteBtn.dataset.id;
            const year = deleteBtn.dataset.year;
            const acts = parseInt(deleteBtn.dataset.acts) || 0;
            if (row) openDeleteConfirm(id, year, acts, row);
        }
    });

    /* ════ INIT ════ */
    document.querySelectorAll('.activity-card').forEach(card => initCard(card));
    renderCategories();

})();
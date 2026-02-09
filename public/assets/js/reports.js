// ============================================
// NAVEGACIÓN ENTRE VISTAS
// ============================================
function showCalendarView() {
    document.getElementById('calendar-view').classList.add('active');
    document.getElementById('create-view').classList.remove('active');
    document.getElementById('history-view').classList.remove('active');
}

function showCreateView() {
    document.getElementById('calendar-view').classList.remove('active');
    document.getElementById('create-view').classList.add('active');
    document.getElementById('history-view').classList.remove('active');
}

function showHistoryView() {
    document.getElementById('calendar-view').classList.remove('active');
    document.getElementById('create-view').classList.remove('active');
    document.getElementById('history-view').classList.add('active');
}

// ============================================
// MODAL DE EVENTO
// ============================================
function openEventModal(eventTitle, eventDate, eventDescription) {
    const modal = document.getElementById('event-modal');
    const overlay = document.getElementById('event-overlay');
    
    document.getElementById('event-modal-title').textContent = eventTitle;
    document.getElementById('event-modal-subtitle').textContent = '2026';
    document.getElementById('event-modal-description').textContent = eventDescription || 'Detalles del evento próximamente.';
    
    modal.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeEventModal() {
    const modal = document.getElementById('event-modal');
    const overlay = document.getElementById('event-overlay');
    
    modal.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// ============================================
// DATOS DE EVENTOS (Simulados)
// ============================================
const events = {
    '2026-01-08': {
        title: 'Campaña de prevención de caries',
        description: 'Campaña de prevención de caries 2026 en las comunidades locales.'
    },
    '2026-01-09': {
        title: 'Campaña de prevención de caries',
        description: 'Continuación de la campaña de prevención de caries 2026.'
    },
    '2026-01-15': {
        title: 'Día de reyes atrasado',
        description: 'Celebración del día de reyes con actividades para niños.'
    },
    '2026-01-16': {
        title: 'Actividad recreativa de año nuevo',
        description: 'Actividad recreativa y de integración para celebrar el año nuevo.'
    },
    '2026-01-17': {
        title: 'Recreación de actividades',
        description: 'Jornada de recreación y actividades comunitarias.'
    }
};

// ============================================
// GENERACIÓN DE CALENDARIO
// ============================================
let currentMonth = 0; // Enero 2026
let currentYear = 2026;

const monthNames = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

function generateCalendar() {
    const calendarDates = document.getElementById('calendar-dates');
    const monthTitle = document.getElementById('calendar-month');
    
    if (!calendarDates || !monthTitle) return;
    
    calendarDates.innerHTML = '';
    monthTitle.textContent = `${monthNames[currentMonth]} ${currentYear}`;
    
    const firstDay = new Date(currentYear, currentMonth, 1);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const prevLastDay = new Date(currentYear, currentMonth, 0);
    
    const firstDayIndex = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1;
    const lastDayDate = lastDay.getDate();
    const prevLastDayDate = prevLastDay.getDate();
    
    // Días del mes anterior
    for (let i = firstDayIndex; i > 0; i--) {
        const dateDiv = createDateElement(prevLastDayDate - i + 1, true);
        calendarDates.appendChild(dateDiv);
    }
    
    // Días del mes actual
    for (let i = 1; i <= lastDayDate; i++) {
        const dateDiv = createDateElement(i, false);
        calendarDates.appendChild(dateDiv);
    }
    
    // Días del siguiente mes
    const remainingDays = 42 - (firstDayIndex + lastDayDate);
    for (let i = 1; i <= remainingDays; i++) {
        const dateDiv = createDateElement(i, true);
        calendarDates.appendChild(dateDiv);
    }
}

function createDateElement(day, isOtherMonth) {
    const dateDiv = document.createElement('div');
    dateDiv.className = 'calendar-date';
    dateDiv.textContent = day;
    
    if (isOtherMonth) {
        dateDiv.classList.add('other-month');
    } else {
        const dateKey = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        
        if (events[dateKey]) {
            dateDiv.classList.add('has-event');
            dateDiv.addEventListener('click', function() {
                openEventModal(
                    events[dateKey].title,
                    dateKey,
                    events[dateKey].description
                );
            });
        }
    }
    
    return dateDiv;
}

function previousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar();
}

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    generateCalendar();
    
    // Filtros de historial
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEventModal();
        }
    });
});
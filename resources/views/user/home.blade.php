@extends('user.dashboard')

@section('title', 'Inicio')

@section('content')
    <h2>Inicio</h2>
    <p>Bienvenido al panel de usuario.</p>

    <!-- FILTROS -->
    <div class="filters">
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Buscar módulo..."
        >

        <select id="statusFilter">
            <option value="">Todos los estados</option>
            <option value="Activo">Activo</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Inactivo">Inactivo</option>
        </select>
    </div>

    <!-- TABLA -->
    <div class="table-container">
        <h3>Resumen general</h3>

        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Módulo</th>
                    <th>Estado</th>
                    <th>Última actualización</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Formularios</td>
                    <td data-status="Activo">
                        <span class="badge success">Activo</span>
                    </td>
                    <td>Hoy</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Usuarios</td>
                    <td data-status="Pendiente">
                        <span class="badge warning">Pendiente</span>
                    </td>
                    <td>Ayer</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Informes</td>
                    <td data-status="Inactivo">
                        <span class="badge danger">Inactivo</span>
                    </td>
                    <td>Hace 3 días</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- JS FILTROS -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const tableRows = document.querySelectorAll('#dataTable tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            tableRows.forEach(row => {
                const moduleText = row.cells[1].textContent.toLowerCase();
                const statusText = row.cells[2].dataset.status;

                const matchesSearch = moduleText.includes(searchText);
                const matchesStatus = statusValue === '' || statusText === statusValue;

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    </script>
@endsection

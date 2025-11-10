<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Ciudades - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Ciudades</a></li>
                </ul>
            </nav>
            
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title">Gestionar Ciudades</h1>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="{{ route('admin.cities.create') }}" class="button is-success">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>Nueva Ciudad</span>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Mensajes de éxito/error --}}
            @if(session('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="notification is-danger is-light">
                <button class="delete"></button>
                {{ session('error') }}
            </div>
            @endif
            
            <div class="box">
                <div class="table-container">
                    <table class="table is-fullwidth is-striped is-hoverable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cities as $city)
                            <tr>
                                <td>{{ $city->id }}</td>
                                <td>{{ $city->name }}</td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="{{ route('admin.cities.edit', $city->id) }}" class="button is-warning is-small">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                        </a>
                                        
                                        <button class="button is-danger is-small" onclick="confirmDelete({{ $city->id }}, '{{ $city->name }}')">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="has-text-centered">No hay ciudades registradas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $cities->links() }}
            </div>
        </div>
    </section>
    
    {{-- Modal de confirmación --}}
    <div class="modal" id="deleteModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Confirmar eliminación</p>
                <button class="delete" aria-label="close" onclick="closeModal()"></button>
            </header>
            <section class="modal-card-body">
                <p>¿Estás seguro de que deseas eliminar la ciudad <strong id="cityName"></strong>?</p>
                <p class="mt-3 has-text-danger">Esta acción no se puede deshacer y puede afectar los viajes registrados.</p>
            </section>
            <footer class="modal-card-foot">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button is-danger">Eliminar</button>
                    <button type="button" class="button" onclick="closeModal()">Cancelar</button>
                </form>
            </footer>
        </div>
    </div>
    
    @include('footer')
    
    <script>
        // Función para abrir el modal de confirmación
        function confirmDelete(cityId, cityName) {
            document.getElementById('cityName').textContent = cityName;
            document.getElementById('deleteForm').action = '/admin/cities/' + cityId;
            document.getElementById('deleteModal').classList.add('is-active');
        }
        
        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('is-active');
        }
        
        // Cerrar notificaciones
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
</body>
</html>
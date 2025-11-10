<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Admin</title>
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
                    <li class="is-active"><a href="#" aria-current="page">Usuarios</a></li>
                </ul>
            </nav>
            
            <h1 class="title">Gestionar Usuarios</h1>
            
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
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="tag is-danger">Admin</span>
                                    @else
                                        <span class="tag is-light">Usuario</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="buttons are-small">
                                        <button class="button is-info is-small">
                                            <span class="icon"><i class="fas fa-eye"></i></span>
                                        </button>
                                        <button class="button is-warning is-small">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                        </button>
                                        
                                        {{-- Botón de eliminar --}}
                                        @if($user->id !== auth()->id())
                                        <button class="button is-danger is-small" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $users->links() }}
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
                <p>¿Estás seguro de que deseas eliminar al usuario <strong id="userName"></strong>?</p>
                <p class="mt-3 has-text-danger">Esta acción no se puede deshacer.</p>
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
        function confirmDelete(userId, userName) {
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = '/admin/users/' + userId;
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
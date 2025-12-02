<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Admin Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            background-color: #f5f7fb;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }
        
        .content-box {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .table-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 1rem 0.75rem;
        }
        
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .action-button {
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-state .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <!-- Encabezado mejorado -->
            <div class="admin-header">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <h1 class="title is-2 has-text-white">Gestionar Usuarios</h1>
                            <p class="subtitle has-text-white">Administra todos los usuarios del sistema</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="tags has-addons">
                            <span class="tag is-dark">Total</span>
                            <span class="tag is-success">{{ $users->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Mensajes de éxito/error --}}
            @if(session('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                <span class="icon"><i class="fas fa-check-circle"></i></span>
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="notification is-danger is-light">
                <button class="delete"></button>
                <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
                {{ session('error') }}
            </div>
            @endif
            
            <div class="content-box">
                <div class="level mb-4">
                    <div class="level-left">
                        <h2 class="title is-4 has-text-grey-dark">
                            <span class="icon has-text-primary">
                                <i class="fas fa-users"></i>
                            </span>
                            <span>Lista de Usuarios</span>
                        </h2>
                    </div>
                    <div class="level-right">
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="text" placeholder="Buscar usuarios...">
                            </div>
                            <div class="control">
                                <button class="button is-primary">
                                    <span class="icon"><i class="fas fa-search"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="table is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="has-text-weight-semibold">#{{ $user->id }}</td>
                                <td>
                                    <div class="is-flex is-align-items-center">
                                        <figure class="image is-32x32 mr-2">
                                            <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Avatar">
                                        </figure>
                                        <div>
                                            <p class="has-text-weight-semibold">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="tag is-danger is-medium">
                                            <span class="icon is-small">
                                                <i class="fas fa-shield-alt"></i>
                                            </span>
                                            <span>Administrador</span>
                                        </span>
                                    @else
                                        <span class="tag is-info is-medium">
                                            <span class="icon is-small">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <span>Usuario</span>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('d/m/Y') }}</small>
                                    <br>
                                    <small class="has-text-grey">{{ $user->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="buttons are-small">
                                        <button class="button is-info is-small action-button">
                                            <span class="icon"><i class="fas fa-eye"></i></span>
                                        </button>
                                        <button class="button is-warning is-small action-button">
                                            <span class="icon"><i class="fas fa-edit"></i></span>
                                        </button>
                                        
                                        {{-- Botón de eliminar --}}
                                        @if($user->id !== auth()->id())
                                        <button class="button is-danger is-small action-button" onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
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
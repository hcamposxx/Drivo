<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Rutas - Admin Drivo</title>
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
                            <h1 class="title is-2 has-text-white">Gestión de Rutas entre Ciudades</h1>
                            <p class="subtitle has-text-white">Administra las conexiones entre ciudades</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <a href="{{ route('admin.cities.index') }}" class="button is-light">
                                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                                <span>Volver a Ciudades</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

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
                                <i class="fas fa-route"></i>
                            </span>
                            <span>Configuración de Rutas</span>
                        </h2>
                    </div>
                    <div class="level-right">
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="text" placeholder="Buscar ciudades...">
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
                                <th>Ciudad Origen</th>
                                <th>Código</th>
                                <th>Ciudades Destino</th>
                                <th class="has-text-centered">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cities as $city)
                            <tr>
                                <td>
                                    <div class="is-flex is-align-items-center">
                                        <span class="icon has-text-primary mr-2">
                                            <i class="fas fa-city"></i>
                                        </span>
                                        <strong>{{ $city->name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="tag is-info is-medium">{{ $city->short_name }}</span>
                                </td>
                                <td>
                                    @if($city->originRoutes->count() > 0)
                                        <div class="tags are-medium">
                                            @foreach($city->originRoutes as $route)
                                                <span class="tag is-primary is-light">
                                                    {{ $route->destinationCity->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="tag is-warning is-light">Sin destinos asignados</span>
                                    @endif
                                </td>
                                <td class="has-text-centered">
                                    <div class="buttons is-centered">
                                        <a href="{{ route('admin.city-routes.edit', $city->id) }}" 
                                           class="button is-small is-info action-button"
                                           title="Configurar destinos">
                                            <span class="icon"><i class="fas fa-route"></i></span>
                                            <span>Configurar Rutas</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <span class="icon">
                                            <i class="fas fa-route"></i>
                                        </span>
                                        <p class="is-size-5">No hay ciudades registradas</p>
                                        <p class="has-text-grey">Las ciudades aparecerán aquí una vez que se creen</p>
                                        <a href="{{ route('admin.cities.index') }}" class="button is-primary mt-3">
                                            <span class="icon"><i class="fas fa-arrow-left"></i></span>
                                            <span>Gestionar Ciudades</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    @include('footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Cerrar notificaciones
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });

        function removeRoute(routeId) {
            if (confirm('¿Estás seguro de que deseas eliminar esta ruta?')) {
                // Aquí se podría hacer una petición AJAX para eliminar la ruta
                // Por ahora, recargamos la página
                window.location.href = `/admin/city-routes/${routeId}`;
            }
        }
    </script>
</body>
</html>
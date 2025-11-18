<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Rutas - Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <div>
                            <h1 class="title">Gestión de Rutas entre Ciudades</h1>
                            <hr>
                            <p class="subtitle">Administra las conexiones entre ciudades</p>
                        </div>
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
                                    <strong>{{ $city->name }}</strong>
                                </td>
                                <td>
                                    <span class="tag is-info">{{ $city->short_name }}</span>
                                </td>
                                <td>
                                    @if($city->originRoutes->count() > 0)
                                        <div class="tags">
                                            @foreach($city->originRoutes as $route)
                                                <span class="tag is-primary is-light">
                                                    {{ $route->destinationCity->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="tag is-warning">Sin destinos asignados</span>
                                    @endif
                                </td>
                                <td class="has-text-centered">
                                    <div class="buttons is-centered">
                                        <a href="{{ route('admin.city-routes.edit', $city->id) }}" 
                                           class="button is-small is-info"
                                           title="Configurar destinos">
                                            <span class="icon"><i class="fas fa-route"></i></span>
                                            <span>Configurar Rutas</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="has-text-centered">
                                    <p class="has-text-grey">No hay ciudades registradas</p>
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
    </script>
</body>
</html>
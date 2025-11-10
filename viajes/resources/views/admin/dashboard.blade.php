<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <h1 class="title">Panel de Administrador</h1>
            <h2 class="subtitle">Bienvenido, {{ Auth::user()->name }}</h2>
            
            {{-- Estadísticas --}}
            <div class="columns">
                <div class="column">
                    <div class="box has-background-info-light">
                        <div class="level">
                            <div class="level-left">
                                <div>
                                    <p class="heading">Total Usuarios</p>
                                    <p class="title">{{ $totalUsers }}</p>
                                </div>
                            </div>
                            <div class="level-right">
                                <span class="icon is-large has-text-info">
                                    <i class="fas fa-users fa-2x"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="box has-background-success-light">
                        <div class="level">
                            <div class="level-left">
                                <div>
                                    <p class="heading">Total Viajes</p>
                                    <p class="title">{{ $totalTrips }}</p>
                                </div>
                            </div>
                            <div class="level-right">
                                <span class="icon is-large has-text-success">
                                    <i class="fas fa-car fa-2x"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Acciones rápidas --}}
            <div class="box">
                <h3 class="title is-4">Acciones Rápidas</h3>
                <div class="buttons">
                    <a href="{{ route('admin.users') }}" class="button is-primary">
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <span>Gestionar Usuarios</span>
                    </a>
                    <a href="{{ route('admin.trips') }}" class="button is-info">
                        <span class="icon"><i class="fas fa-car"></i></span>
                        <span>Gestionar Viajes</span>
                    </a>
                     <a href="{{ route('admin.cities.index') }}" class="button is_secondary">
                     <span class="icon"><i class="fas fa-city"></i></span>
                     <span>Gestionar Ciudades</span>
                        </a>
                </div>
            </div>
            {{-- Viajes recientes --}}
            <div class="box">
                <h3 class="title is-4">Viajes Recientes</h3>
                <div class="table-container">
                    <table class="table is-fullwidth is-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Conductor</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTrips as $trip)
                            <tr>
            <td>{{ $trip->id }}</td>
            <td>{{ $trip->departureCity->name ?? 'N/A' }}</td>
            <td>{{ $trip->arrivalCity->name ?? 'N/A' }}</td>
            <td>{{ $trip->driver->name ?? 'N/A' }}</td>
            <td>{{ $trip->departure_date ? \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') : 'N/A' }}</td>
            <td>
                @if($trip->status == 'active' || $trip->status == 'activo')
                    <span class="badge bg-success">Activo</span>
                @elseif($trip->status == 'completed' || $trip->status == 'completado')
                    <span class="badge bg-secondary">Completado</span>
                @elseif($trip->status == 'cancelled' || $trip->status == 'cancelado')
                    <span class="badge bg-danger">Cancelado</span>
                @else
                    <span class="badge bg-warning">{{ $trip->status ?? 'N/A' }}</span>
                @endif
            </td>
        </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="has-text-centered">No hay viajes registrados</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
    @include('footer')
</body>
</html>
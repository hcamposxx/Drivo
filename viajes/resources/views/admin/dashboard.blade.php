<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Drivo</title>
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
            --scheduled: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            background-color: #f5f7fb;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }
        
        .stat-card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            border: none;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card .icon-container {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .stat-card.users .icon-container {
            background: rgba(67, 97, 238, 0.15);
            color: var(--primary);
        }
        
        .stat-card.trips .icon-container {
            background: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }
        
        .stat-card.tickets .icon-container {
            background: rgba(247, 37, 133, 0.15);
            color: var(--warning);
        }
        
        .quick-actions {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .action-button {
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100%;
            text-align: center;
            background: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        
        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .action-button .icon {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }
        
        .recent-trips {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success);
        }
        
        .status-completed {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }
        
        .status-cancelled {
            background-color: rgba(230, 57, 70, 0.15);
            color: var(--danger);
        }
        
        .status-expired {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--warning);
        }
        
        .status-scheduled {
            background-color: rgba(114, 9, 183, 0.15);
            color: var(--scheduled);
        }
        
        .status-other {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
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
            .dashboard-header {
                padding: 1.5rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .action-button {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <!-- Encabezado mejorado -->
            <div class="dashboard-header">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <h1 class="title is-2 has-text-white">Panel de Administrador</h1>
                            <p class="subtitle has-text-white">Bienvenido, {{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="tags has-addons">
                            <span class="tag is-dark">Rol</span>
                            <span class="tag is-success">Administrador</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas mejoradas -->
            <div class="columns is-multiline">
                <div class="column is-4">
                    <div class="stat-card users box">
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="icon-container">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                            <div class="level-right has-text-right">
                                <p class="heading">Total Usuarios</p>
                                <p class="title is-3">{{ $totalUsers }}</p>
                            </div>
                        </div>
                        <div class="content mt-3">
                            <progress class="progress is-primary is-small" value="80" max="100">80%</progress>
                            <p class="help"></p>
                        </div>
                    </div>
                </div>
                
                <div class="column is-4">
                    <div class="stat-card trips box">
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="icon-container">
                                    <i class="fas fa-car fa-2x"></i>
                                </div>
                            </div>
                            <div class="level-right has-text-right">
                                <p class="heading">Total Viajes</p>
                                <p class="title is-3">{{ $totalTrips }}</p>
                            </div>
                        </div>
                        <div class="content mt-3">
                            <progress class="progress is-info is-small" value="65" max="100">65%</progress>
                            <p class="help">Completados: {{ $totalTrips - ($recentTrips->whereIn('status', ['active', 'activo'])->count() ?? 0) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="column is-4">
                    <div class="stat-card tickets box">
                        <div class="level is-mobile">
                            <div class="level-left">
                                <div class="icon-container">
                                    <i class="fas fa-ticket-alt fa-2x"></i>
                                </div>
                            </div>
                            <div class="level-right has-text-right">
                                <p class="heading">Tickets Abiertos</p>
                                <p class="title is-3">{{ \App\Models\Ticket::whereIn('status', ['abierto', 'en_proceso'])->count() }}</p>
                            </div>
                        </div>
                        <div class="content mt-3">
                            <progress class="progress is-warning is-small" value="30" max="100">30%</progress>
                            <p class="help"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Acciones rápidas mejoradas -->
            <div class="quick-actions">
                <h3 class="title is-4 has-text-grey-dark mb-4">
                    <span class="icon has-text-primary">
                        <i class="fas fa-bolt"></i>
                    </span>
                    <span>Acciones Rápidas</span>
                </h3>
                <div class="columns is-multiline">
                    <div class="column is-2">
                        <a href="{{ route('admin.users') }}" class="action-button">
                            <span class="icon has-text-primary">
                                <i class="fas fa-users"></i>
                            </span>
                            <span class="has-text-weight-semibold">Gestionar Usuarios</span>
                        </a>
                    </div>
                    <div class="column is-2">
                        <a href="{{ route('admin.trips') }}" class="action-button">
                            <span class="icon has-text-info">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="has-text-weight-semibold">Gestionar Viajes</span>
                        </a>
                    </div>
                    <div class="column is-2">
                        <a href="{{ route('admin.cities.index') }}" class="action-button">
                            <span class="icon has-text-success">
                                <i class="fas fa-city"></i>
                            </span>
                            <span class="has-text-weight-semibold">Gestionar Ciudades</span>
                        </a>
                    </div>
                    <div class="column is-2">
                        <a href="{{ route('admin.city-routes.index') }}" class="action-button">
                            <span class="icon has-text-warning">
                                <i class="fas fa-route"></i>
                            </span>
                            <span class="has-text-weight-semibold">Gestionar Rutas</span>
                        </a>
                    </div>
                    <div class="column is-2">
                        <a href="{{ route('admin.tickets.index') }}" class="action-button">
                            <span class="icon has-text-danger">
                                <i class="fas fa-ticket-alt"></i>
                            </span>
                            <span class="has-text-weight-semibold">Gestionar Tickets</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Viajes recientes mejorados -->
            <div class="recent-trips">
                <div class="level">
                    <div class="level-left">
                        <h3 class="title is-4 has-text-grey-dark">
                            <span class="icon has-text-primary">
                                <i class="fas fa-history"></i>
                            </span>
                            <span>Viajes Recientes</span>
                        </h3>
                    </div>
                    <div class="level-right">
                        <a href="{{ route('admin.trips') }}" class="button is-primary is-outlined is-small">
                            <span class="icon">
                                <i class="fas fa-eye"></i>
                            </span>
                            <span>Ver todos</span>
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="table is-fullwidth is-hoverable">
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
                                <td class="has-text-weight-semibold">#{{ $trip->id }}</td>
                                <td>{{ $trip->departureCity->name ?? 'Programado' }}</td>
                                <td>{{ $trip->arrivalCity->name ?? 'Programado' }}</td>
                                <td>
                                    <div class="is-flex is-align-items-center">
                                        <figure class="image is-24x24 mr-2">
                                            <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($trip->driver->name ?? 'Programado') }}&background=random" alt="Avatar">
                                        </figure>
                                        <span>{{ $trip->driver->name ?? 'Programado' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($trip->departure_date)
                                        {{ \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') }}

                                    @else
                                        Programado
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $departureDate = $trip->departure_date ? \Carbon\Carbon::parse($trip->departure_date) : null;
                                        
                                        // Determinar si el viaje está vencido
                                        $isExpired = $departureDate && $departureDate->lt($today) && 
                                                   (($trip->status == 'active' || $trip->status == 'activo') || 
                                                    !in_array($trip->status, ['completed', 'completado', 'cancelled', 'cancelado']));
                                        
                                        // Determinar si el viaje está programado (fecha futura)
                                        $isScheduled = $departureDate && $departureDate->gt($today);
                                    @endphp
                                    
                                    @if($isExpired)
                                        <span class="status-badge status-expired">
                                            <span class="icon is-small">
                                                <i class="fas fa-clock"></i>
                                            </span>
                                            <span>Vencido</span>
                                        </span>
                                    @elseif($isScheduled && ($trip->status == 'active' || $trip->status == 'activo' || !$trip->status))
                                        <span class="status-badge status-scheduled">
                                            <span class="icon is-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </span>
                                            <span>Programado</span>
                                        </span>
                                    @elseif($trip->status == 'active' || $trip->status == 'activo')
                                        <span class="status-badge status-active">
                                            <span class="icon is-small">
                                                <i class="fas fa-play-circle"></i>
                                            </span>
                                            <span>Activo</span>
                                        </span>
                                    @elseif($trip->status == 'completed' || $trip->status == 'completado')
                                        <span class="status-badge status-completed">
                                            <span class="icon is-small">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                            <span>Completado</span>
                                        </span>
                                    @elseif($trip->status == 'cancelled' || $trip->status == 'cancelado')
                                        <span class="status-badge status-cancelled">
                                            <span class="icon is-small">
                                                <i class="fas fa-times-circle"></i>
                                            </span>
                                            <span>Cancelado</span>
                                        </span>
                                    @else
                                        <span class="status-badge status-scheduled">
                                            <span class="icon is-small">
                                                <i class="fas fa-calendar-check"></i>
                                            </span>
                                            <span>Programado</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <span class="icon">
                                            <i class="fas fa-car"></i>
                                        </span>
                                        <p class="is-size-5">No hay viajes registrados</p>
                                        <p class="has-text-grey">Los viajes aparecerán aquí una vez que se creen</p>
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
</body>
</html>
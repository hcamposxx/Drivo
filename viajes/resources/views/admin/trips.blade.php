<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Viajes - Admin Drivo</title>
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
            color: #7209b7;
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

        /* Estilos para el modal de detalles del viaje */
        .trip-details-modal .modal-card-body {
            padding: 2rem;
        }
        
        .trip-info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .trip-info-item:last-child {
            border-bottom: none;
        }
        
        .trip-info-label {
            font-weight: 600;
            color: #495057;
            min-width: 140px;
        }
        
        .trip-info-value {
            color: #6c757d;
            text-align: right;
            flex: 1;
        }
        
        .route-display {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1.5rem 0;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            position: relative;
        }
        
        .route-point {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }
        
        .route-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        
        .route-start {
            background-color: var(--success);
            color: white;
        }
        
        .route-end {
            background-color: var(--primary);
            color: white;
        }
        
        .route-line {
            flex: 2;
            height: 3px;
            background: linear-gradient(90deg, var(--success) 0%, var(--primary) 100%);
            margin: 0 1rem;
            position: relative;
            top: -10px;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 1.5rem;
            }
            
            .route-display {
                flex-direction: column;
                text-align: center;
            }
            
            .route-line {
                width: 3px;
                height: 40px;
                margin: 0.5rem 0;
            }
            
            .trip-info-item {
                flex-direction: column;
            }
            
            .trip-info-value {
                text-align: left;
                margin-top: 0.25rem;
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
                            <h1 class="title is-2 has-text-white">Gestionar Viajes</h1>
                            <p class="subtitle has-text-white">Administra todos los viajes del sistema</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="tags has-addons">
                            <span class="tag is-dark">Total</span>
                            <span class="tag is-success">{{ $trips->count() }}</span>
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
                                <i class="fas fa-list"></i>
                            </span>
                            <span>Lista de Viajes</span>
                        </h2>
                    </div>
                    <div class="level-right">
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="text" placeholder="Buscar viajes...">
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
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Conductor</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Asientos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                            @php
                                $today = \Carbon\Carbon::today();
                                $departureDate = $trip->departure_date ? \Carbon\Carbon::parse($trip->departure_date) : null;
                                
                                // Determinar si el viaje está vencido
                                $isExpired = $departureDate && $departureDate->lt($today) && 
                                           (($trip->status == 'active' || $trip->status == 'activo') || 
                                            !in_array($trip->status, ['completed', 'completado', 'cancelled', 'cancelado']));
                                
                                // Determinar si el viaje está programado (fecha futura)
                                $isScheduled = $departureDate && $departureDate->gt($today);
                                
                                // Determinar el estado para el modal
                                if($isExpired) {
                                    $modalStatus = 'Vencido';
                                    $modalStatusClass = 'status-expired';
                                } elseif($isScheduled && ($trip->status == 'active' || $trip->status == 'activo' || !$trip->status)) {
                                    $modalStatus = 'Programado';
                                    $modalStatusClass = 'status-scheduled';
                                } elseif($trip->status == 'active' || $trip->status == 'activo') {
                                    $modalStatus = 'Activo';
                                    $modalStatusClass = 'status-active';
                                } elseif($trip->status == 'completed' || $trip->status == 'completado') {
                                    $modalStatus = 'Completado';
                                    $modalStatusClass = 'status-completed';
                                } elseif($trip->status == 'cancelled' || $trip->status == 'cancelado') {
                                    $modalStatus = 'Cancelado';
                                    $modalStatusClass = 'status-cancelled';
                                } else {
                                    $modalStatus = 'Programado';
                                    $modalStatusClass = 'status-scheduled';
                                }
                            @endphp
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
                                    {{ $trip->departure_date ? \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') : 'Programado' }}
                                </td>
                                <td>{{ $trip->departure_time ?? 'Programado' }}</td>
                                <td>
                                    <span class="tag is-info is-light">{{ $trip->available_seats ?? '0' }}</span>
                                </td>
                                <td>
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
                                <td>
                                    <div class="buttons are-small">
                                        <!-- Botón azul para ver detalles del viaje -->
                                        <button class="button is-info is-small action-button" onclick="showTripDetails(
                                            {{ $trip->id }}, 
                                            '{{ $trip->departureCity->name ?? 'Origen' }}', 
                                            '{{ $trip->arrivalCity->name ?? 'Destino' }}', 
                                            '{{ $trip->driver->name ?? 'Programado' }}', 
                                            '{{ $trip->departure_date ? \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') : 'Programado' }}', 
                                            '{{ $trip->departure_time ?? 'Programado' }}', 
                                            '{{ $trip->available_seats ?? '0' }}', 
                                            '{{ $modalStatus }}',
                                            '{{ $modalStatusClass }}',
                                            '{{ $trip->price_per_seat ?? '0' }}', 
                                            '{{ $trip->details ?? '' }}'
                                        )">
                                            <span class="icon"><i class="fas fa-eye"></i></span>
                                        </button>
                                        
                                        {{-- Botón de eliminar --}}
                                        <button class="button is-danger is-small action-button" onclick="confirmDelete({{ $trip->id }}, '{{ $trip->departureCity->name ?? 'Origen' }} - {{ $trip->arrivalCity->name ?? 'Destino' }}')">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{ $trips->links() }}
            </div>
        </div>
    </section>
    
    {{-- Modal de confirmación para eliminar --}}
    <div class="modal" id="deleteModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Confirmar eliminación</p>
                <button class="delete" aria-label="close" onclick="closeModal()"></button>
            </header>
            <section class="modal-card-body">
                <p>¿Estás seguro de que deseas eliminar el viaje <strong id="tripName"></strong>?</p>
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
    
    {{-- Modal para mostrar detalles del viaje --}}
    <div class="modal trip-details-modal" id="tripDetailsModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Detalles del Viaje</p>
                <button class="delete" aria-label="close" onclick="closeTripModal()"></button>
            </header>
            <section class="modal-card-body">
                <div class="has-text-centered mb-4">
                    <span class="icon is-large has-text-primary">
                        <i class="fas fa-route fa-3x"></i>
                    </span>
                    <h2 class="title is-3 mt-2" id="modalTripRoute">Ruta del Viaje</h2>
                    <p class="subtitle is-6">Información detallada del viaje</p>
                </div>
                
                <!-- Visualización de la ruta -->
                <div class="route-display">
                    <div class="route-point">
                        <div class="route-icon route-start">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="has-text-weight-bold" id="modalTripOrigin">Origen</p>
                            <p class="is-size-7">Salida</p>
                        </div>
                    </div>
                    <div class="route-line"></div>
                    <div class="route-point">
                        <div class="route-icon route-end">
                            <i class="fas fa-flag-checkered"></i>
                        </div>
                        <div>
                            <p class="has-text-weight-bold" id="modalTripDestination">Destino</p>
                            <p class="is-size-7">Llegada</p>
                        </div>
                    </div>
                </div>
                
                <!-- Información detallada -->
                <div class="trip-info">
                    <div class="trip-info-item">
                        <span class="trip-info-label">ID del Viaje:</span>
                        <span class="trip-info-value" id="modalTripId">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Conductor:</span>
                        <span class="trip-info-value" id="modalTripDriver">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Fecha:</span>
                        <span class="trip-info-value" id="modalTripDate">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Hora:</span>
                        <span class="trip-info-value" id="modalTripTime">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Asientos disponibles:</span>
                        <span class="trip-info-value" id="modalTripSeats">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Estado:</span>
                        <span class="trip-info-value" id="modalTripStatus">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Precio por asiento:</span>
                        <span class="trip-info-value" id="modalTripPrice">-</span>
                    </div>
                    <div class="trip-info-item">
                        <span class="trip-info-label">Detalles:</span>
                        <span class="trip-info-value" id="modalTripDetails">-</span>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary" onclick="closeTripModal()">Aceptar</button>
            </footer>
        </div>
    </div>
    
    @include('footer')
    
    <script>
        // Función para abrir el modal de confirmación de eliminación
        function confirmDelete(tripId, tripName) {
            document.getElementById('tripName').textContent = tripName;
            document.getElementById('deleteForm').action = '/admin/trips/' + tripId;
            document.getElementById('deleteModal').classList.add('is-active');
        }
        
        // Función para cerrar el modal de eliminación
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('is-active');
        }
        
        // Función para mostrar detalles del viaje
        function showTripDetails(tripId, origin, destination, driver, date, time, seats, status, statusClass, price, details) {
            // Establecer los valores en el modal
            document.getElementById('modalTripId').textContent = '#' + tripId;
            document.getElementById('modalTripRoute').textContent = origin + ' → ' + destination;
            document.getElementById('modalTripOrigin').textContent = origin;
            document.getElementById('modalTripDestination').textContent = destination;
            document.getElementById('modalTripDriver').textContent = driver;
            document.getElementById('modalTripDate').textContent = date;
            document.getElementById('modalTripTime').textContent = time;
            document.getElementById('modalTripSeats').textContent = seats;
            document.getElementById('modalTripPrice').textContent = '$' + price + ' por asiento';
            document.getElementById('modalTripDetails').textContent = details || 'Sin detalles';
            
            // Establecer el estado con el formato correcto
            document.getElementById('modalTripStatus').textContent = status;
            document.getElementById('modalTripStatus').className = 'trip-info-value ' + statusClass;
            
            // Abrir el modal
            document.getElementById('tripDetailsModal').classList.add('is-active');
        }
        
        // Función para cerrar el modal de detalles del viaje
        function closeTripModal() {
            document.getElementById('tripDetailsModal').classList.remove('is-active');
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
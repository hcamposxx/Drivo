<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets - Admin Drivo</title>
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
        
        .stats-box {
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stats-box:hover {
            transform: translateY(-5px);
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
        
        .modal-card-scrollable {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        .modal-card-body-scrollable {
            overflow-y: auto;
            max-height: calc(90vh - 160px);
        }
        .modal-card-foot{
            flex-shrink: 0;
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
                            <h1 class="title is-2 has-text-white">
                                <span class="icon-text">
                                    <span class="icon"><i class="fas fa-headset"></i></span>
                                    <span>Gestión de Tickets de Soporte</span>
                                </span>
                            </h1>
                            <p class="subtitle has-text-white">Administra los reportes de los usuarios</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="tags has-addons">
                            <span class="tag is-dark">Total</span>
                            <span class="tag is-success">{{ $tickets->count() }}</span>
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

            <div class="columns">
                <div class="column">
                    <div class="stats-box has-background-white">
                        <p class="heading">Total</p>
                        <p class="title has-text-dark">{{ $tickets->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="stats-box has-background-danger-light">
                        <p class="heading">Abiertos</p>
                        <p class="title has-text-dark">{{ $tickets->where('status', 'abierto')->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="stats-box has-background-warning-light">
                        <p class="heading">En Proceso</p>
                        <p class="title has-text-dark">{{ $tickets->where('status', 'en_proceso')->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="stats-box has-background-success-light">
                        <p class="heading">Resueltos</p>
                        <p class="title has-text-dark">{{ $tickets->where('status', 'resuelto')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="content-box">
                <div class="tabs">
                    <ul>
                        <li class="is-active"><a onclick="filterTickets('all', event)">Todos</a></li>
                        <li><a onclick="filterTickets('abierto', event)">Abiertos</a></li>
                        <li><a onclick="filterTickets('en_proceso', event)">En Proceso</a></li>
                        <li><a onclick="filterTickets('resuelto', event)">Resueltos</a></li>
                    </ul>
                </div>
            </div>

            <div class="content-box">
                <div class="level mb-4">
                    <div class="level-left">
                        <h2 class="title is-4 has-text-grey-dark">
                            <span class="icon has-text-primary">
                                <i class="fas fa-ticket-alt"></i>
                            </span>
                            <span>Lista de Tickets</span>
                        </h2>
                    </div>
                    <div class="level-right">
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="text" placeholder="Buscar tickets...">
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
                                <th>Usuario</th>
                                <th>Asunto</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTableBody">
                            @forelse($tickets as $ticket)
                            <tr data-status="{{ $ticket->status }}">
                                <td><strong>#{{ $ticket->id }}</strong></td>
                                <td>
                                    <div class="is-flex is-align-items-center">
                                        <figure class="image is-32x32 mr-2">
                                            <img class="is-rounded" src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&background=random" alt="Avatar">
                                        </figure>
                                        <div>
                                            <strong>{{ $ticket->user->name }}</strong><br>
                                            <small class="has-text-grey">{{ $ticket->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $ticket->subject }}</strong><br>
                                    <small class="has-text-grey">{{ Str::limit($ticket->description, 60) }}</small>
                                </td>
                                <td>
                                    @if($ticket->priority)
                                    <span class="tag {{ $ticket->priorityBadge }} is-medium">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                    @else
                                    <span class="tag is-light is-medium">
                                        <i class="fas fa-exclamation-triangle"></i> Sin asignar
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="tag {{ $ticket->statusBadge }} is-medium">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <button class="button is-small is-info action-button" 
                                            onclick="openResponseModal(
                                                {{ $ticket->id }}, 
                                                '{{ addslashes($ticket->subject) }}', 
                                                '{{ addslashes($ticket->description) }}', 
                                                '{{ $ticket->status }}', 
                                                '{{ $ticket->priority ?? '' }}', 
                                                '{{ addslashes($ticket->admin_response ?? '') }}', 
                                                '{{ $ticket->image ? asset('storage/' . $ticket->image) : '' }}'
                                            )">
                                        <span class="icon"><i class="fas fa-reply"></i></span>
                                        <span>Responder</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <span class="icon">
                                            <i class="fas fa-inbox"></i>
                                        </span>
                                        <p class="is-size-5">No hay tickets registrados</p>
                                        <p class="has-text-grey">Los tickets aparecerán aquí una vez que los usuarios los creen</p>
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

    <!-- Modal para responder -->
    <div id="responseModal" class="modal">
        <div class="modal-background" onclick="closeResponseModal()"></div>
        <div class="modal-card modal-card-scrollable" style="width: 700px;">
            <header class="modal-card-head">
                <p class="modal-card-title" id="modalTitle">Responder Ticket</p>
                <button class="delete" aria-label="close" onclick="closeResponseModal()"></button>
            </header>
            <form id="responseForm" method="POST">
                @csrf
                @method('PUT')
                <section class="modal-card-body modal-card-body-scrollable">
                    <!-- Descripción del problema -->
                    <div class="content">
                        <p><strong>📋 Descripción del problema:</strong></p>
                        <div class="notification is-light" id="ticketDescription"></div>
                    </div>

                    <!-- Imagen adjunta -->
                    <div id="ticketImageContainer" style="display: none;" class="mb-4">
                        <p class="has-text-weight-bold mb-2">📷 Imagen adjunta:</p>
                        <figure class="image" style="max-width: 100%;">
                            <img id="ticketImage" src="" alt="Imagen del ticket"
                                style="border-radius: 8px; max-height:300px; width: auto; cursor: pointer; border: 2px solid #dbdbdb;" 
                                onclick="window.open(this.src, '_blank')">
                        </figure>
                        <p class="help has-text-info">💡 Click en la imagen para verla en tamaño completo</p>
                    </div>

                    <!-- Campo de Prioridad -->
                    <div class="field">
                        <label class="label">
                            <span class="icon-text">
                                <span class="icon has-text-warning">
                                    <i class="fas fa-flag"></i>
                                </span>
                                <span>Asignar Prioridad *</span>
                            </span>
                        </label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="priority" id="prioritySelect" required>
                                    <option value="">-- Seleccionar prioridad --</option>
                                    <option value="baja">🟢 Baja - No urgente</option>
                                    <option value="media">🟡 Media - Atención normal</option>
                                    <option value="alta">🔴 Alta - Requiere atención urgente</option>
                                </select>
                            </div>
                        </div>
                        <p class="help">Evalúa la urgencia del problema según la imagen y descripción</p>
                    </div>

                    <!-- Campo de Estado -->
                    <div class="field">
                        <label class="label">
                            <span class="icon-text">
                                <span class="icon has-text-info">
                                    <i class="fas fa-tasks"></i>
                                </span>
                                <span>Estado del Ticket *</span>
                            </span>
                        </label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="status" id="statusSelect" required>
                                    <option value="abierto">🔴 Abierto</option>
                                    <option value="en_proceso">🟡 En Proceso</option>
                                    <option value="resuelto">🟢 Resuelto</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Respuesta al usuario -->
                    <div class="field">
                        <label class="label">
                            <span class="icon-text">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-comment-dots"></i>
                                </span>
                                <span>Respuesta al Usuario</span>
                            </span>
                        </label>
                        <div class="control">
                            <textarea class="textarea" 
                                    name="admin_response" 
                                    id="adminResponseText"
                                    rows="5" 
                                    placeholder="Escribe una respuesta clara y profesional para el usuario..."></textarea>
                        </div>
                        <p class="help">Esta respuesta será visible para el usuario</p>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Guardar Respuesta</span>
                    </button>
                    <button type="button" class="button" onclick="closeResponseModal()">
                        <span class="icon"><i class="fas fa-times"></i></span>
                        <span>Cancelar</span>
                    </button>
                </footer>
            </form>
        </div>
    </div>

    @include('footer')

    <script>
        function openResponseModal(ticketId, subject, description, status, priority, adminResponse, imageUrl) {
            console.log('Opening modal with:', {ticketId, subject, status, priority, imageUrl});
            
            // Establecer título
            document.getElementById('modalTitle').textContent = `Ticket #${ticketId}: ${subject}`;
            
            // Establecer descripción
            document.getElementById('ticketDescription').textContent = description;
            
            // Establecer prioridad
            const prioritySelect = document.getElementById('prioritySelect');
            if (priority && priority !== '') {
                prioritySelect.value = priority;
                console.log('Priority set to:', priority);
            } else {
                prioritySelect.value = '';
                console.log('No priority assigned');
            }
            
            // Establecer estado
            const statusSelect = document.getElementById('statusSelect');
            statusSelect.value = status;
            
            // Establecer respuesta del admin
            document.getElementById('adminResponseText').value = adminResponse || '';
            
            // Establecer action del formulario
            document.getElementById('responseForm').action = `/admin/tickets/${ticketId}`;

            // Mostrar/ocultar imagen
            const imageContainer = document.getElementById('ticketImageContainer');
            if (imageUrl && imageUrl !== '') {
                document.getElementById('ticketImage').src = imageUrl;
                imageContainer.style.display = 'block';
            } else {
                imageContainer.style.display = 'none';
            }

            // Abrir modal
            document.getElementById('responseModal').classList.add('is-active');
        }

        function closeResponseModal() {
            document.getElementById('responseModal').classList.remove('is-active');
        }

        function filterTickets(status, event) {
            const rows = document.querySelectorAll('#ticketsTableBody tr[data-status]');
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Actualizar tabs activos
            document.querySelectorAll('.tabs li').forEach(tab => {
                tab.classList.remove('is-active');
            });
            if (event) {
                event.target.closest('li').classList.add('is-active');
            }
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeResponseModal();
            }
        });

        // Auto-cerrar notificaciones
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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets - Admin Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos adicionales para el modal desplazable */
        .modal-card-scrollable {
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }
        .modal-card-body-scrollable {
            overflow-y: auto;
            max-height: calc(85vh - 120px); /* Restamos la altura del header y footer */
        }
    </style>
</head>
<body>
    @include('menu')

    <section class="section">
        <div class="container">
            <h1 class="title">
                <span class="icon-text">
                    <span class="icon"><i class="fas fa-headset"></i></span>
                    <span>Gestión de Tickets de Soporte</span>
                </span>
            </h1>
            <h2 class="subtitle">Administra los reportes de los usuarios</h2>

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

            <div class="columns">
                <div class="column">
                    <div class="box has-text-centered">
                        <p class="heading">Total</p>
                        <p class="title">{{ $tickets->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-text-centered has-background-danger-light">
                        <p class="heading">Abiertos</p>
                        <p class="title">{{ $tickets->where('status', 'abierto')->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-text-centered has-background-warning-light">
                        <p class="heading">En Proceso</p>
                        <p class="title">{{ $tickets->where('status', 'en_proceso')->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-text-centered has-background-success-light">
                        <p class="heading">Resueltos</p>
                        <p class="title">{{ $tickets->where('status', 'resuelto')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="tabs">
                    <ul>
                        <li class="is-active"><a onclick="filterTickets('all', event)">Todos</a></li>
                        <li><a onclick="filterTickets('abierto', event)">Abiertos</a></li>
                        <li><a onclick="filterTickets('en_proceso', event)">En Proceso</a></li>
                        <li><a onclick="filterTickets('resuelto', event)">Resueltos</a></li>
                    </ul>
                </div>
            </div>

            <div class="box">
                <div class="table-container">
                    <table class="table is-fullwidth is-striped is-hoverable">
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
                                        <span class="icon mr-2">
                                            <i class="fas fa-user-circle"></i>
                                        </span>
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
                                    <span class="tag {{ $ticket->priorityBadge }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                    @else
                                    <span class="tag is-light">
                                        <i class="fas fa-exclamation-triangle"></i> Sin asignar
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="tag {{ $ticket->statusBadge }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <button class="button is-small is-info" 
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
                                <td colspan="7" class="has-text-centered py-5">
                                    <span class="icon is-large has-text-grey-light">
                                        <i class="fas fa-inbox fa-3x"></i>
                                    </span>
                                    <p class="mt-3">No hay tickets registrados</p>
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
                                    <option value="cerrado">⚫ Cerrado</option>
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
            console.log('Opening modal with:', {ticketId, subject, status, priority, imageUrl}); // Debug
            
            // Establecer título
            document.getElementById('modalTitle').textContent = `Ticket #${ticketId}: ${subject}`;
            
            // Establecer descripción
            document.getElementById('ticketDescription').textContent = description;
            
            // Establecer prioridad
            const prioritySelect = document.getElementById('prioritySelect');
            if (priority && priority !== '') {
                prioritySelect.value = priority;
                console.log('Priority set to:', priority); // Debug
            } else {
                prioritySelect.value = '';
                console.log('No priority assigned'); // Debug
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
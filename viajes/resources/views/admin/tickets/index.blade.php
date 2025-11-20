<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets - Admin Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

            <!-- Estadísticas -->
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

            <!-- Filtros -->
            <div class="box">
                <div class="tabs">
                    <ul>
                        <li class="is-active"><a>Todos</a></li>
                        <li><a onclick="filterTickets('abierto')">Abiertos</a></li>
                        <li><a onclick="filterTickets('en_proceso')">En Proceso</a></li>
                        <li><a onclick="filterTickets('resuelto')">Resueltos</a></li>
                    </ul>
                </div>
            </div>

            <!-- Lista de tickets -->
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
                                    <span class="tag {{ $ticket->priorityBadge }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
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
                                    <button class="button is-small is-info" onclick="openResponseModal({{ $ticket->id }}, '{{ addslashes($ticket->subject) }}', '{{ addslashes($ticket->description) }}', '{{ $ticket->status }}', '{{ addslashes($ticket->admin_response ?? '') }}')">
                                        <span class="icon"><i class="fas fa-reply"></i></span>
                                        <span>Responder</span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="has-text-centered">No hay tickets registrados</td>
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
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title" id="modalTitle">Responder Ticket</p>
                <button class="delete" onclick="closeResponseModal()"></button>
            </header>
            <form id="responseForm" method="POST">
                @csrf
                @method('PUT')
                <section class="modal-card-body">
                    <div class="content">
                        <p><strong>Descripción del problema:</strong></p>
                        <div class="notification is-light" id="ticketDescription"></div>
                    </div>

                    <div class="field">
                        <label class="label">Estado del Ticket</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select name="status" required>
                                    <option value="abierto">Abierto</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="resuelto">Resuelto</option>
                                    <option value="cerrado">Cerrado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Respuesta al Usuario</label>
                        <div class="control">
                            <textarea class="textarea" name="admin_response" rows="5" placeholder="Escribe tu respuesta aquí..."></textarea>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button type="submit" class="button is-primary">
                        <span class="icon"><i class="fas fa-save"></i></span>
                        <span>Guardar Respuesta</span>
                    </button>
                    <button type="button" class="button" onclick="closeResponseModal()">Cancelar</button>
                </footer>
            </form>
        </div>
    </div>

    @include('footer')

    <script>
        // Abrir modal de respuesta
        function openResponseModal(ticketId, subject, description, status, adminResponse) {
            document.getElementById('modalTitle').textContent = `Ticket #${ticketId}: ${subject}`;
            document.getElementById('ticketDescription').textContent = description;
            document.querySelector('select[name="status"]').value = status;
            document.querySelector('textarea[name="admin_response"]').value = adminResponse;
            document.getElementById('responseForm').action = `/admin/tickets/${ticketId}`;
            document.getElementById('responseModal').classList.add('is-active');
        }

        // Cerrar modal
        function closeResponseModal() {
            document.getElementById('responseModal').classList.remove('is-active');
        }

        // Filtrar tickets
        function filterTickets(status) {
            const rows = document.querySelectorAll('#ticketsTableBody tr[data-status]');
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

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
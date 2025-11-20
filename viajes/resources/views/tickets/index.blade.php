<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets - Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <div class="level">
                <div class="level-left">
                    <div>
                        <h1 class="title">
                            <span class="icon-text">
                                <span class="icon"><i class="fas fa-ticket-alt"></i></span>
                                <span>Mis Tickets de Soporte</span>
                            </span>
                        </h1>
                        <p class="subtitle">Historial de tus reportes y problemas</p>
                    </div>
                </div>
            </div>

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
                        <p class="heading">Total de Tickets</p>
                        <p class="title">{{ $tickets->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-text-centered has-background-warning-light">
                        <p class="heading">En Proceso</p>
                        <p class="title">{{ $tickets->whereIn('status', ['abierto', 'en_proceso'])->count() }}</p>
                    </div>
                </div>
                <div class="column">
                    <div class="box has-text-centered has-background-success-light">
                        <p class="heading">Resueltos</p>
                        <p class="title">{{ $tickets->where('status', 'resuelto')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Lista de tickets -->
            <div class="box">
                @forelse($tickets as $ticket)
                <article class="message {{ $ticket->statusBadge }}">
                    <div class="message-header">
                        <div>
                            <strong>{{ $ticket->subject }}</strong>
                        </div>
                        <div>
                            <span class="tag {{ $ticket->statusBadge }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="message-body">
                        <div class="content">
                            <p>{{ Str::limit($ticket->description, 150) }}</p>
                            
                            @if($ticket->admin_response)
                            <div class="notification is-info is-light mt-3">
                                <strong><i class="fas fa-reply"></i> Respuesta del equipo:</strong>
                                <p class="mt-2">{{ $ticket->admin_response }}</p>
                                @if($ticket->admin)
                                <p class="is-size-7 has-text-grey mt-2">
                                    Por: {{ $ticket->admin->name }}
                                </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        <div class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <small class="has-text-grey">
                                        <i class="far fa-clock"></i> 
                                        Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                @if($ticket->resolved_at)
                                <div class="level-item">
                                    <small class="has-text-success">
                                        <i class="fas fa-check-circle"></i> 
                                        Resuelto: {{ $ticket->resolved_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                @endif
                            </div>
                            <div class="level-right">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="button is-small is-light">
                                    <span class="icon"><i class="fas fa-eye"></i></span>
                                    <span>Ver detalles</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="has-text-centered py-6">
                    <span class="icon is-large has-text-grey-light">
                        <i class="fas fa-inbox fa-3x"></i>
                    </span>
                    <p class="title is-4 mt-4">No tienes tickets aún</p>
                    <p class="subtitle">Si experimentas algún problema, créa un ticket y te ayudaremos.</p>
                    <button class="button is-primary" onclick="document.getElementById('btn-ticket').click()">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Crear mi primer ticket</span>
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('footer')

    <script>
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
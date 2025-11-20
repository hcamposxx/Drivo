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
                <div class="level-right">
                    <button class="button is-primary" onclick="document.getElementById('btn-ticket').click()">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Nuevo Ticket</span>
                    </button>
                </div>
            </div>

            @if(session('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ session('success') }}
            </div>
            @endif

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

            <div class="box">
                @forelse($tickets as $ticket)
                <article class="message {{ $ticket->statusBadge }}">
                    <div class="message-header">
                        <div>
                            <span class="tag {{ $ticket->priorityBadge }} mr-2">
                                {{ ucfirst($ticket->priority) }}
                            </span>
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
                            
                            @php $imgPath = $ticket->attachment ?? $ticket->image ?? null; @endphp
                            @if($imgPath)
                            <div class="mt-3">
                                <p class="has-text-weight-bold mb-2">📷 Imagen adjunta:</p>
                                <figure class="image" style="max-width: 400px;">
                                    <img src="{{ asset('storage/' . $imgPath) }}" alt="Imagen del ticket" style="border-radius: 8px; cursor: pointer;" onclick="window.open('{{ asset('storage/' . $imgPath) }}', '_blank')">
                                </figure>
                                <p class="help">Click para ver en tamaño completo</p>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $imgPath) }}" download class="button is-small is-link">
                                        <span class="icon"><i class="fas fa-download"></i></span>
                                        <span>Descargar imagen</span>
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($ticket->priority)
                            <div class="mt-3">
                                <span class="tag {{ $ticket->priorityBadge }}">
                                    Prioridad: {{ ucfirst($ticket->priority) }}
                                </span>
                            </div>
                            @endif
                            
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
                        </div>
                    </div>
                </article>
                @empty
                <div class="has-text-centered py-6">
                    <span class="icon is-large has-text-grey-light">
                        <i class="fas fa-inbox fa-3x"></i>
                    </span>
                    <p class="title is-4 mt-4">No tienes tickets aún</p>
                    <p class="subtitle">Si experimentas algún problema, crea un ticket y te ayudaremos.</p>
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

    <!-- Sidebar de Subir/Bajar -->
    @php
        $attachments = $tickets->filter(function($t) { return ($t->attachment ?? $t->image) != null; });
    @endphp
    <aside id="attachmentSidebar" class="attachment-sidebar">
        <button id="toggleSidebar" class="button is-primary is-small sidebar-toggle" aria-label="Abrir panel"> 
            <span class="icon"><i class="fas fa-chevron-left"></i></span>
        </button>
        <div class="sidebar-content">
            <h3 class="title is-6">Archivos adjuntos</h3>
            <p class="subtitle is-7">Subir / Descargar imágenes de tickets</p>

            <div class="buttons mb-3">
                <button class="button is-success is-fullwidth" onclick="document.getElementById('btn-ticket').click()">
                    <span class="icon"><i class="fas fa-upload"></i></span>
                    <span>Subir imagen (Nuevo ticket)</span>
                </button>
            </div>

            @if($attachments->isEmpty())
                <div class="content has-text-grey">
                    <p>No hay archivos adjuntos todavía.</p>
                </div>
            @else
                <div class="content">
                    <ul>
                        @foreach($attachments as $att)
                            @php $p = $att->attachment ?? $att->image; @endphp
                            <li class="mb-2">
                                <div class="is-flex is-justify-content-space-between is-align-items-center">
                                    <div>
                                        <strong class="is-size-7">{{ Str::limit($att->subject, 30) }}</strong>
                                        <div class="is-size-7 has-text-grey">{{ $att->created_at->format('d/m/Y') }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ asset('storage/' . $p) }}" class="button is-small is-link" download>
                                            <span class="icon"><i class="fas fa-download"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </aside>

    <script>
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
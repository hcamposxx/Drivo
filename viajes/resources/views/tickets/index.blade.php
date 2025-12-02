<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Tickets - Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #eef2ff;
            --secondary-color: #3a0ca3;
            --success-color: #06d6a0;
            --success-light: #e8faf5;
            --warning-color: #ff9e00;
            --warning-light: #fff9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .section {
            padding: 2rem 1.5rem;
        }
        
        .hero-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 16px;
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .stats-card.en-proceso {
            border-left-color: var(--warning-color);
        }
        
        .stats-card.resueltos {
            border-left-color: var(--success-color);
        }
        
        .ticket-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border-left: 4px solid #e9ecef;
        }
        
        .ticket-card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }
        
        .ticket-card.abierto {
            border-left-color: var(--primary-color);
        }
        
        .ticket-card.en_proceso {
            border-left-color: var(--warning-color);
        }
        
        .ticket-card.resuelto {
            border-left-color: var(--success-color);
        }
        
        .priority-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }
        
        .priority-alta {
            background-color: #ff6b6b;
            color: white;
        }
        
        .priority-media {
            background-color: #ffd166;
            color: #333;
        }
        
        .priority-baja {
            background-color: #06d6a0;
            color: white;
        }
        
        .status-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }
        
        .status-abierto {
            background-color: var(--primary-light);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .status-en_proceso {
            background-color: var(--warning-light);
            color: #b36b00;
            border: 1px solid var(--warning-color);
        }
        
        .status-resuelto {
            background-color: var(--success-light);
            color: #0a7a5a;
            border: 1px solid var(--success-color);
        }
        
        /* Botones mejorados */
        .btn-primary {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-success {
            background: white;
            color: var(--success-color);
            border: 2px solid var(--success-color);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background: var(--success-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 214, 160, 0.3);
        }
        
        .btn-warning {
            background: white;
            color: var(--warning-color);
            border: 2px solid var(--warning-color);
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: var(--warning-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 158, 0, 0.3);
        }
        
        .btn-link {
            background: white;
            color: #4361ee;
            border: 2px solid #4361ee;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-link:hover {
            background: #4361ee;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            color: #6c757d;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            background: #f8f9fa;
            color: #495057;
            border-color: #adb5bd;
            transform: translateY(-2px);
        }
        
        .attachment-sidebar {
            background: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            height: 100vh;
            position: fixed;
            top: 0;
            right: -300px;
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 1.5rem;
            overflow-y: auto;
        }
        
        .attachment-sidebar.open {
            right: 0;
        }
        
        .sidebar-toggle {
            position: absolute;
            left: -40px;
            top: 20px;
            border-radius: 8px 0 0 8px;
            padding: 0.75rem 0.5rem;
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .sidebar-toggle:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 1.5rem;
        }
        
        .image-preview {
            border-radius: 8px;
            overflow: hidden;
            margin: 1rem 0;
            max-width: 400px;
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .image-preview:hover {
            transform: scale(1.02);
            border-color: var(--primary-color);
        }
        
        .admin-response {
            background: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .ticket-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #6c757d;
        }
        
        .ticket-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .ticket-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        
        .ticket-description {
            color: #495057;
            line-height: 1.6;
        }
        
        .notification {
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        @media (max-width: 768px) {
            .section {
                padding: 1.5rem 1rem;
            }
            
            .hero-card {
                padding: 1.5rem;
            }
            
            .attachment-sidebar {
                width: 280px;
            }
        }
    </style>
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <div class="hero-card">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <h1 class="title is-3 has-text-white">
                                <span class="icon-text">
                                    <span class="icon"><i class="fas fa-ticket-alt"></i></span>
                                    <span>Mis Tickets de Soporte</span>
                                </span>
                            </h1>
                            <p class="subtitle has-text-light">Historial de tus reportes y problemas</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <button class="button btn-primary is-medium" onclick="document.getElementById('btn-ticket').click()">
                            <span class="icon"><i class="fas fa-plus"></i></span>
                            <span>Nuevo Ticket</span>
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="notification is-success is-light">
                <button class="delete"></button>
                {{ session('success') }}
            </div>
            @endif

            <div class="columns is-multiline">
                <div class="column is-one-third">
                    <div class="stats-card">
                        <p class="heading">Total de Tickets</p>
                        <p class="title is-3">{{ $tickets->count() }}</p>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="stats-card en-proceso">
                        <p class="heading">En Proceso</p>
                        <p class="title is-3">{{ $tickets->whereIn('status', ['abierto', 'en_proceso'])->count() }}</p>
                    </div>
                </div>
                <div class="column is-one-third">
                    <div class="stats-card resueltos">
                        <p class="heading">Resueltos</p>
                        <p class="title is-3">{{ $tickets->where('status', 'resuelto')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="box" style="background: transparent; box-shadow: none; padding: 0;">
                @forelse($tickets as $ticket)
                <div class="ticket-card {{ $ticket->status }}">
                    <div class="ticket-header">
                        <div style="flex-grow: 1;">
                            <h3 class="ticket-title">{{ $ticket->subject }}</h3>
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                <span class="priority-badge priority-{{ $ticket->priority }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                                <span class="status-badge status-{{ $ticket->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ticket-description">
                        <p>{{ Str::limit($ticket->description, 150) }}</p>
                        
                        @php $imgPath = $ticket->attachment ?? $ticket->image ?? null; @endphp
                        @if($imgPath)
                        <div class="mt-3">
                            <p class="has-text-weight-bold mb-2">📷 Imagen adjunta:</p>
                            <div class="image-preview">
                                <img src="{{ asset('storage/' . $imgPath) }}" alt="Imagen del ticket" style="width: 100%;">
                            </div>
                            <p class="help">Click para ver en tamaño completo</p>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $imgPath) }}" download class="button btn-link is-small">
                                    <span class="icon"><i class="fas fa-download"></i></span>
                                    <span>Descargar imagen</span>
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($ticket->admin_response)
                        <div class="admin-response">
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
                    
                    <div class="ticket-meta">
                        <div>
                            <small>
                                <i class="far fa-clock"></i> 
                                Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        @if($ticket->resolved_at)
                        <div>
                            <small class="has-text-success">
                                <i class="fas fa-check-circle"></i> 
                                Resuelto: {{ $ticket->resolved_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="title is-4">No tienes tickets aún</p>
                    <p class="subtitle">Si experimentas algún problema, crea un ticket y te ayudaremos.</p>
                    <button class="button btn-primary is-medium mt-4" onclick="document.getElementById('btn-ticket').click()">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span>Crear mi primer ticket</span>
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('footer')

    <!-- Sidebar de Archivos Adjuntos -->
    @php
        $attachments = $tickets->filter(function($t) { return ($t->attachment ?? $t->image) != null; });
    @endphp
    <aside id="attachmentSidebar" class="attachment-sidebar">
        <button id="toggleSidebar" class="button sidebar-toggle" aria-label="Abrir panel"> 
            <span class="icon"><i class="fas fa-chevron-left"></i></span>
        </button>
        <div class="sidebar-content">
            <h3 class="title is-5">Archivos adjuntos</h3>
            <p class="subtitle is-6">Subir / Descargar imágenes de tickets</p>

            <div class="buttons mb-4">
                <button class="button btn-success is-fullwidth" onclick="document.getElementById('btn-ticket').click()">
                    <span class="icon"><i class="fas fa-upload"></i></span>
                    <span>Subir imagen (Nuevo ticket)</span>
                </button>
            </div>

            @if($attachments->isEmpty())
                <div class="content has-text-grey has-text-centered py-4">
                    <span class="icon is-large mb-3">
                        <i class="fas fa-paperclip fa-2x"></i>
                    </span>
                    <p>No hay archivos adjuntos todavía.</p>
                </div>
            @else
                <div class="content">
                    <ul>
                        @foreach($attachments as $att)
                            @php $p = $att->attachment ?? $att->image; @endphp
                            <li class="mb-3">
                                <div class="is-flex is-justify-content-space-between is-align-items-center p-2" style="border: 1px solid #f0f0f0; border-radius: 8px;">
                                    <div style="max-width: 70%;">
                                        <strong class="is-size-6">{{ Str::limit($att->subject, 25) }}</strong>
                                        <div class="is-size-7 has-text-grey">{{ $att->created_at->format('d/m/Y') }}</div>
                                    </div>
                                    <div>
                                        <a href="{{ asset('storage/' . $p) }}" class="button btn-link is-small" download>
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
            // Eliminar notificaciones
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
            
            // Toggle sidebar
            const toggleSidebar = document.getElementById('toggleSidebar');
            const attachmentSidebar = document.getElementById('attachmentSidebar');
            
            if (toggleSidebar && attachmentSidebar) {
                toggleSidebar.addEventListener('click', () => {
                    attachmentSidebar.classList.toggle('open');
                    
                    // Cambiar icono según estado
                    const icon = toggleSidebar.querySelector('.icon i');
                    if (attachmentSidebar.classList.contains('open')) {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    } else {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                    }
                });
            }
            
            // Hacer clic en imágenes para abrirlas
            document.querySelectorAll('.image-preview').forEach(img => {
                img.addEventListener('click', function() {
                    const imgSrc = this.querySelector('img').src;
                    window.open(imgSrc, '_blank');
                });
            });
        });
    </script>
</body>
</html>
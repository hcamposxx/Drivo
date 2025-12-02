@include('header')

<div class="container my-6">
    <div class="columns is-centered">
        <!-- Tarjeta de perfil mejorada -->
        <div class="column is-4">
            <div class="card profile-card">
                <div class="card-image">
                    <figure class="image is-square">
                        @if($user->photo)
                            <img src="{{ asset($user->photo) }}" alt="Foto de perfil" class="profile-image">
                        @else
                            <div class="default-profile-image">
                                <span class="initials">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media is-align-items-center">
                        <div class="media-content has-text-centered">
                            <p class="title is-4 mb-2">{{ $user->name }}</p>
                            <div class="tags is-justify-content-center">
                                @if($user->is_admin)
                                    <span class="tag is-danger is-rounded">
                                        <span class="icon is-small mr-1">
                                            <i class="fas fa-shield-alt"></i>
                                        </span>
                                        <span>Administrador</span>
                                    </span>
                                @endif
                                @if($user->verified)
                                    <span class="tag is-success is-rounded">
                                        <span class="icon is-small mr-1">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <span>Verificado</span>
                                    </span>
                                @else
                                    <span class="tag is-warning is-rounded">
                                        <span class="icon is-small mr-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span>
                                        <span>No verificado</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="content mt-4">
                        <div class="profile-info-item">
                            <span class="icon has-text-grey">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <div class="info-text">
                                <span class="label">Email</span>
                                <span class="value">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="icon has-text-grey">
                                <i class="fas fa-phone"></i>
                            </span>
                            <div class="info-text">
                                <span class="label">Teléfono</span>
                                <span class="value">{{ $user->phone ?? 'No registrado' }}</span>
                            </div>
                        </div>
                        <div class="profile-info-item">
                            <span class="icon has-text-grey">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <div class="info-text">
                                <span class="label">Miembro desde</span>
                                <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="{{ route('profile.edit') }}" class="card-footer-item has-text-primary">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Editar Perfil</span>
                    </a>
                </footer>
            </div>
        </div>

        <!-- Información detallada mejorada -->
        <div class="column is-8">
            <div class="box profile-details-box">
                <h2 class="title is-4 has-text-primary">
                    <span class="icon"><i class="fas fa-user-circle"></i></span>
                    <span>Información de Perfil</span>
                </h2>

                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-user"></i>
                                </span>
                                <span class="has-text-weight-semibold">Nombre</span>
                            </div>
                            <div class="info-card-content">
                                <p class="is-size-5">{{ $user->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="has-text-weight-semibold">Email</span>
                            </div>
                            <div class="info-card-content">
                                <p class="is-size-5 is-truncated">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <span class="has-text-weight-semibold">Teléfono</span>
                            </div>
                            <div class="info-card-content">
                                <p class="is-size-5">{{ $user->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="info-card">
                            <div class="info-card-header">
                                <span class="icon has-text-primary">
                                    <i class="fas fa-badge-check"></i>
                                </span>
                                <span class="has-text-weight-semibold">Estado</span>
                            </div>
                            <div class="info-card-content">
                                @if($user->verified)
                                    <span class="tag is-success is-medium">
                                        <span class="icon is-small mr-1">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span>Verificado</span>
                                    </span>
                                @else
                                    <span class="tag is-warning is-medium">
                                        <span class="icon is-small mr-1">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <span>No verificado</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->is_admin)
                <div class="notification is-info is-light admin-notification">
                    <div class="media">
                        <div class="media-left">
                            <span class="icon is-large has-text-info">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </span>
                        </div>
                        <div class="media-content">
                            <h3 class="title is-5 has-text-info">Acceso de Administrador</h3>
                            <p>Tienes permisos de administrador. Puedes acceder al <a href="{{ route('admin.dashboard') }}" class="has-text-link has-text-weight-semibold">panel de control</a> para gestionar el sistema.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Estilos personalizados para mejorar el diseño */
    .profile-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    /* Imagen de perfil más pequeña y centrada */
    .card-image {
        padding: 1.5rem 1.5rem 0;
    }
    
    .image.is-square {
        padding-top: 100%; /* Esto crea un contenedor cuadrado */
        position: relative;
    }
    
    .profile-image, .default-profile-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #f0f0f0;
    }
    
    .default-profile-image {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    }
    
    .initials {
        font-size: 3rem;
        font-weight: bold;
        color: white;
    }
    
    /* Estilos para separar textos de los : */
    .profile-info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    
    .profile-info-item .icon {
        margin-right: 12px;
        width: 20px;
        margin-top: 2px;
    }
    
    .info-text {
        display: flex;
        flex-direction: column;
    }
    
    .label { /* el color */
        font-weight: 600;
        color: #f5ededff;
        margin-bottom: 4px;
    }
    
    .value {
        color: #f5ededff;
    }
    
    .profile-details-box {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #3273dc;
    }
    
    .info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 16px;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .info-card:hover {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .info-card-header {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: #4a4a4a;
    }
    
    .info-card-header .icon {
        margin-right: 8px;
    }
    
    .info-card-content {
        color: #363636;
    }
    
    .admin-notification {
        border-radius: 8px;
        border-left: 4px solid #3273dc;
    }
    
    .card-footer-item {
        transition: background-color 0.2s ease;
    }
    
    .card-footer-item:hover {
        background-color: #f5f5f5;
    }
    
    /* Mejoras de responsive */
    @media screen and (max-width: 768px) {
        .columns:not(.is-desktop) {
            flex-direction: column;
        }
        
        .column.is-4, .column.is-8 {
            width: 100%;
        }
        
        .profile-card {
            margin-bottom: 1.5rem;
        }
        
        .image.is-square {
            max-width: 200px;
            margin: 0 auto;
        }
    }
    
    @media screen and (max-width: 480px) {
        .image.is-square {
            max-width: 150px;
        }
        
        .initials {
            font-size: 2.5rem;
        }
    }
</style>

@include('footer-content')
@include('footer')
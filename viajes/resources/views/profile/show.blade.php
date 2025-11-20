@include('header')

<div class="container my-6">
    <div class="columns">
        <!-- Tarjeta de perfil -->
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        @if($user->photo)
                            <img src="{{ asset($user->photo) }}" alt="Foto de perfil">
                        @else
                            <img src="https://via.placeholder.com/400x300?text={{ urlencode($user->name) }}" alt="Foto por defecto">
                        @endif
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4">{{ $user->name }}</p>
                            <p class="subtitle is-6">
                                @if($user->is_admin)
                                    <span class="tag is-danger">Administrador</span>
                                @endif
                                @if($user->verified)
                                    <span class="tag is-success">Verificado</span>
                                @else
                                    <span class="tag is-warning">No verificado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="content">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Teléfono:</strong> {{ $user->phone ?? 'No registrado' }}</p>
                        <p><strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="{{ route('profile.edit') }}" class="card-footer-item">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Editar</span>
                    </a>
                </footer>
            </div>
        </div>

        <!-- Información detallada -->
        <div class="column is-8">
            <div class="box">
                <h2 class="title is-4">
                    <span class="icon"><i class="fas fa-info-circle"></i></span>
                    <span>Información de Perfil</span>
                </h2>

                <div class="columns">
                    <div class="column is-6">
                        <div class="box has-background-light">
                            <p class="has-text-grey-dark" style="font-weight: 600;">Nombre</p>
                            <p class="title is-5" style="color: #333;">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="box has-background-light">
                            <p class="has-text-grey-dark" style="font-weight: 600;">Email</p>
                            <p class="title is-5 is-truncated" style="color: #333;">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-6">
                        <div class="box has-background-light">
                            <p class="has-text-grey-dark" style="font-weight: 600;">Teléfono</p>
                            <p class="title is-5" style="color: #333;">{{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="box has-background-light">
                            <p class="has-text-grey-dark" style="font-weight: 600;">Estado</p>
                            <p class="title is-5">
                                @if($user->verified)
                                    <span class="tag is-success">Verificado</span>
                                @else
                                    <span class="tag is-warning">No verificado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->is_admin)
                <div class="box has-background-info-light">
                    <h3 class="title is-5 has-text-info">
                        <span class="icon"><i class="fas fa-shield-alt"></i></span>
                        <span>Acceso de Administrador</span>
                    </h3>
                    <p>Tienes permisos de administrador. Puedes acceder al <a href="{{ route('admin.dashboard') }}" class="has-text-link">panel de control</a>.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@include('footer-content')
@include('footer')

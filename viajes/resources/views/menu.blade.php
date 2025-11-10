<nav class="navbar has-shadow">

    <div class="navbar-brand">
        <a href="{{ route('home') }}" class="navbar-item">
            <img style="height:70px;max-height:70px; transform: scale(4.4);" src="{{ asset('img/Drivo.png') }}" alt="Logo" class="py-2 px-6">
        </a>
    </div>

    <nav class="navbar-menu" id="nav-links">
        <div class="navbar-end">
            @auth
                <a href="{{ route('offer-seats') }}" class="navbar-item">
                    <span class="icon"><i class="fa-solid fa-plus"></i></span> Publicar un viaje
                </a>
                <a href="{{ route('home') }}" class="navbar-item">
                    <span class="icon"><i class="fas fa-user"></i></span> {{ Auth::user()->name }}
                </a>
                <a href="{{ route('history') }}" class="navbar-item">
                    <span class="icon"><i class="fas fa-car"></i></span> Mis viajes
                </a>
                <a id="logout-btn" style="color:red" href="{{ route('logout') }}" class="navbar-item">
                    <span class="icon"><i class="fas fa-lock"></i></span> Cerrar sesión
                </a>

            {{-- Enlace al panel de administrador (solo para admins) --}}
            @if(Auth::user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" class="navbar-item"><span class="icon"><i class="fas fa-user-shield"></i></span>Panel Admin</a>
            @endif
            
            @else
                <a href="{{ route('login') }}" class="navbar-item">
                    <span class="icon"><i class="fa-solid fa-plus"></i></span> Publicar un viaje
                </a>
                <a href="{{ route('login') }}" class="navbar-item">
                    <span class="icon"><i class="fas fa-lock"></i></span> Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="navbar-item">
                    <span class="icon"><i class="fas fa-user"></i></span> Crear cuenta
                </a>
            @endauth
        </div>
    </nav>

    <style>
        .navbar {
            background-color: #000000 !important;
            color: #fc7100ff !important;
        }

        .navbar-item,
        .navbar-link {
            color: #fc6f12ff !important;
        }

        .navbar-item:hover,
        .navbar-link:hover {
            background-color: #222222 !important;
            color: #FFD700 !important;
        }

        .navbar-brand img {
            filter: brightness(1.2);
        }
    </style>
</nav>

<!-- Incluir SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('logout-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Prevenir la navegación automática
        Swal.fire({
            title: '¿Cerrar sesión?',
            text: "¿Estás seguro de que quieres salir?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF3B30',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('logout') }}";
            }
        });
    });
</script>

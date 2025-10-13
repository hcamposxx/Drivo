<nav class="navbar has-shadow">

    <div class="navbar-brand">
     
        <a href="{{ route('home') }}" class="navbar-item">
            <img style="height:70px;max-height:70px; transform: scale(4.4);" src="{{ asset('img/Drivo.png') }}" alt="Logo" class="py-2 px-6">
        </a>
    </div>

    <nav class="navbar-menu" id="nav-links">
        <div class="navbar-end">
            @auth
            <a href="{{ route('offer-seats')  }}" class="navbar-item"><span class="icon"><i class="fa-solid fa-plus"></i></span>Publicar un viaje</a>
            <a href="{{ route('home') }}" class="navbar-item"><span class="icon"><i class="fas fa-user"></i></span>{{ Auth::user()->name }}</a>
            <a href="{{ route('history') }}" class="navbar-item"><span class="icon"><i class="fas fa-car"></i></span>Mis viajes</a>
            <a style="color:red" href="{{ route('logout') }}" class="navbar-item"><span class="icon"><i class="fas fa-lock"></i></span>Cerrar sesión</a>

            @else
            <a href="{{ route('login') }}" class="navbar-item"><span class="icon"><i class="fa-solid fa-plus"></i></span>Publicar un viaje</a>
            <a href="{{ route('login') }}" class="navbar-item"><span class="icon"><i class="fas fa-lock"></i></span>Iniciar sesión</a>
            <a href="{{ route('register') }}" class="navbar-item"><span class="icon"><i class="fas fa-user"></i></span>Crear cuenta</a>

            @endauth

        </div>
        
    </nav>
</nav>


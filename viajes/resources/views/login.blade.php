@include('header')

<div class="container login-container">
    <div class="login-box">
        <h1 class="my-2 has-text-centered">¿Cómo quieres acceder?</h1>

        <section class="my-2 has-text-centered">
            <a href="{{ route('login-google') }}" class="button is-danger is-fullwidth mb-3">
                <i class="fab fa-google mr-2"></i> Acceder con Google
            </a>
        </section>

        <hr class="my-4">

        <h2 class="my-2 has-text-centered">O</h2>

        <section class="my-2">
            <form method="POST" action="{{ route('login-account-email') }}">
                @csrf
                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="text" name="email" value="{{ old('email') }}" placeholder="Correo electrónico">
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="password" name="password" placeholder="Contraseña">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success is-fullwidth">
                            Iniciar sesión
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="my-2 has-text-centered">
            ¿No tienes una cuenta? <a href="{{ route('register') }}" class="has-text-weight-bold">Crear cuenta</a>
        </section>
    </div>
</div>

@include('footer-content')
@include('footer')

<style>
/* Centrar el cuadro en la pantalla */
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh; /* Deja espacio para header y footer */
}

/* Caja translucida elegante */
.login-box {
  background: rgba(0, 0, 0, 0.7); /* Fondo oscuro con transparencia */
  padding: 2.5rem;
  border-radius: 15px;
  max-width: 400px;
  width: 100%;
  color: #fff; /* Texto blanco */
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

/* Campos y botones */
.input {
  background: rgba(255, 255, 255, 0.9);
  border: none;
  color: #000;
}

.input:focus {
  border-color: #ffd700;
  box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.4);
}

.button.is-success {
  background: linear-gradient(90deg, #FFD700, #FF43A0);
  border: none;
  font-weight: bold;
  color: #000;
}

.button.is-success:hover {

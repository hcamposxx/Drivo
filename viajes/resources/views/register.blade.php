@include('header')

<div class="container content has-text-centered">
    <div class="register-box"
         style="background: rgba(0, 0, 0, 0.6);
                padding: 2rem;
                border-radius: 15px;
                max-width: 500px;
                margin: 3rem auto;
                box-shadow: 0 4px 15px rgba(0,0,0,0.5);
                color: white;">

        <h1 class="my-2" style="color: white; font-weight: 600;">
            ¿Cómo quieres acceder?
        </h1>

        <section class="my-2">
            <a href="{{ route('login-google') }}"
               class="button is-danger is-fullwidth"
               style="margin-bottom: 1rem;">
               <i class="fab fa-google"></i> Continuar con Google
            </a>
        </section>

        <hr style="background-color: rgba(255,255,255,0.2); height: 1px; border: none;">

        <h1 class="my-3" style="color: white; font-weight: 600;">
            Usar otro correo
        </h1>

        <section class="my-2">
            <form method="POST" action="{{ route('new-account-email') }}">
                @csrf

                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="text" name="name" {{ old('name') }} placeholder="Nombre completo">
                        <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                    </div>
                </div>

                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="text" name="email" {{ old('email') }} placeholder="Correo electrónico">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </div>
                </div>

                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="text" name="phone" {{ old('phone') }} placeholder="Teléfono">
                        <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
                    </div>
                </div>

                <div class="field">
                    <div class="control has-icons-left">
                        <input required class="input" type="password" name="password" placeholder="Contraseña">
                        <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                    </div>
                </div>

                <div class="field">
                    <button class="button is-fullwidth"
                            style="background: linear-gradient(90deg, #FFD700, #FF69B4);
                                   border: none;
                                   color: black; /* 👈 Letras negras */
                                   font-weight: bold;
                                   transition: 0.3s;
                                   box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
                        Continuar
                    </button>
                </div>
            </form>
        </section>

        <section class="my-2">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}"
               style="color: #007BFF; /* 👈 Azul destacado */
                      font-weight: 500;
                      text-decoration: underline;">
               Iniciar sesión
            </a>
        </section>
    </div>
</div>

@include('footer-content')
@include('footer')

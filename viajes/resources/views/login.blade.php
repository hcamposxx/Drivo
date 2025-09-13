@include('header')


<div class="container content">
    <h1 class="my-2 columns is-mobile is-centered">Como quieres acceder?</h1>
    <section class="my-2 columns is-mobile is-centered">
        <a href="{{ route('login-google') }}">Acceder con Google</a>
    </section>

    </hr>
    <h1 class="my-2 columns is-mobile is-centered">O</h1>

    <section class="my-2 columns is-mobile is-centered">
        <form method="POST" action="{{ route('login-account-email') }}">
            @csrf
            <div class="field">                
                <div class="control has-icons-left">
                    <input required class="input" type="text" name="email" {{ old('email') }} placeholder="Correo electrónico"></input>
                    <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                    <input required class="input" type="password" name="password" placeholder="Contraseña"></input>
                    <span class="icon is-small is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="field">                
                <div class="control has-icons-left">
                    <button class="button is-success is-fullwidth">
                        Iniciar sesión
                    </button>
                </div>
            </div>
            
        </form>
    </section>
    <section class="my-2 columns is-mobile is-centered">
        ¿No tienes una cuenta?<a href="{{ route('register') }}">Crear cuenta</a>
    </section>
</hr>
</div>

@include('footer')
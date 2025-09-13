@include('header')


<div class="container content">
    <h1 class="my-2 columns is-mobile is-centered">Publicar nuevo viaje</h1>
    <section class="my-2 columns is-mobile is-centered">
        <a href="{{ route('login-google') }}">Continuar con Google</a>
    </section>
</hr>
    <h1 class="my-2 columns is-mobile is-centered">Usar otro correo</h1>

    <section class="my-2 columns is-mobile is-centered">
        <form method="POST" action="{{ route('new-account-email') }}">
            @csrf
            <div class="field">                
                <div class="control has-icons-left">
                    <input required class="input" type="text" name="name" {{ old('name') }} placeholder="Nombre completo"></input>
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>

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
                    <input required class="input" type="text" name="phone" {{ old('phone') }} placeholder="Teléfono"></input>
                    <span class="icon is-small is-left">
                        <i class="fas fa-phone"></i>
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
                        Continuar
                    </button>
                </div>
            </div>
            
        </form>
    </section>
    <section class="my-2 columns is-mobile is-centered">
       Ya tengo una cuenta<a href="{{ route('login') }}"> Iniciar sesión</a>
    </section>
</hr>
</div>

@include('footer')
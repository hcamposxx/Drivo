@include('header')

<div class="container my-6">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div class="box">
                <h1 class="title is-3">
                    <span class="icon"><i class="fas fa-user-edit"></i></span>
                    <span>Editar Perfil</span>
                </h1>

                @if ($message = Session::get('success'))
                    <div class="notification is-success is-light">
                        <button class="delete"></button>
                        <strong>¡Éxito!</strong> {{ $message }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="notification is-danger is-light">
                        <button class="delete"></button>
                        <strong>Errores encontrados:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario de edición de datos personales -->
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h2 class="title is-5 mt-5 mb-4">Datos Personales</h2>

                    <!-- Foto de perfil -->
                    <div class="field">
                        <label class="label">Foto de Perfil</label>
                        <div class="file is-centered is-boxed">
                            <label class="file-label">
                                <input class="file-input" type="file" name="photo" accept="image/*">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </span>
                                    <span class="file-label">
                                        Selecciona una imagen
                                    </span>
                                </span>
                            </label>
                        </div>
                        @if($user->photo)
                            <figure class="image is-128x128 mt-3">
                                <img src="{{ asset($user->photo) }}" alt="Foto actual">
                            </figure>
                        @endif
                    </div>

                    <!-- Nombre -->
                    <div class="field">
                        <label class="label">Nombre Completo</label>
                        <div class="control has-icons-left">
                            <input class="input @error('name') is-danger @enderror" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        @error('name')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left">
                            <input class="input @error('email') is-danger @enderror" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div class="field">
                        <label class="label">Teléfono</label>
                        <div class="control has-icons-left">
                            <input class="input @error('phone') is-danger @enderror" 
                                   type="tel" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="Ej: +56912345678">
                            <span class="icon is-small is-left">
                                <i class="fas fa-phone"></i>
                            </span>
                        </div>
                        @error('phone')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-success">
                                <span class="icon"><i class="fas fa-save"></i></span>
                                <span>Guardar Cambios</span>
                            </button>
                        </div>
                        <div class="control">
                            <a href="{{ route('profile.show') }}" class="button is-light">
                                <span class="icon"><i class="fas fa-times"></i></span>
                                <span>Cancelar</span>
                            </a>
                        </div>
                    </div>
                </form>

                <hr>

                <!-- Formulario de cambio de contraseña -->
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h2 class="title is-5 mt-5 mb-4">Cambiar Contraseña</h2>

                    <!-- Contraseña actual -->
                    <div class="field">
                        <label class="label">Contraseña Actual</label>
                        <div class="control has-icons-left">
                            <input class="input @error('current_password') is-danger @enderror" 
                                   type="password" 
                                   name="current_password" 
                                   required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        @error('current_password')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nueva contraseña -->
                    <div class="field">
                        <label class="label">Nueva Contraseña</label>
                        <div class="control has-icons-left">
                            <input class="input @error('password') is-danger @enderror" 
                                   type="password" 
                                   name="password" 
                                   required
                                   minlength="8">
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                        @error('password')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                        <p class="help">Mínimo 8 caracteres</p>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div class="field">
                        <label class="label">Confirmar Contraseña</label>
                        <div class="control has-icons-left">
                            <input class="input" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required>
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Botón -->
                    <div class="field is-grouped mt-5">
                        <div class="control">
                            <button type="submit" class="button is-warning">
                                <span class="icon"><i class="fas fa-refresh"></i></span>
                                <span>Cambiar Contraseña</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('footer-content')
@include('footer')

<script>
    // Cerrar notificaciones
    document.querySelectorAll('.notification .delete').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });
</script>

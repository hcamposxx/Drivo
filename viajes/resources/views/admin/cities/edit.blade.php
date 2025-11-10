<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ciudad - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.cities.index') }}">Ciudades</a></li>
                    <li class="is-active"><a href="#" aria-current="page">Editar Ciudad</a></li>
                </ul>
            </nav>
            
            <h1 class="title">Editar Ciudad</h1>
            
            <div class="columns">
                <div class="column is-half">
                    <div class="box">
                        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="field">
                                <label class="label">Nombre de la Ciudad</label>
                                <div class="control has-icons-left">
                                    <input class="input @error('name') is-danger @enderror" 
                                        type="text" 
                                        name="name" 
                                        value="{{ old('name', $city->name) }}"
                                        placeholder="Ej: Santiago, Valparaíso, Concepción..."
                                        required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-city"></i>
                                    </span>
                                </div>
                                @error('name')
                                    <p class="help is-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="field">
                            <label class="label">Nombre Corto</label>
                            <div class="control has-icons-left">
                                <input class="input @error('short_name') is-danger @enderror" 
                                    type="text" 
                                    name="short_name" 
                                    value="{{ old('short_name', $city->short_name) }}"
                                    placeholder="Ej: STG, VPA, CCP..."
                                    required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-tag"></i>
                                </span>
                            </div>
                            @error('short_name')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                            <div class="field is-grouped">
                                <div class="control">
                                    <button type="submit" class="button is-success">
                                        <span class="icon"><i class="fas fa-save"></i></span>
                                        <span>Actualizar</span>
                                    </button>
                                </div>
                                <div class="control">
                                    <a href="{{ route('admin.cities.index') }}" class="button is-light">
                                        <span class="icon"><i class="fas fa-times"></i></span>
                                        <span>Cancelar</span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @include('footer')
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ciudad - Admin Drivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body {
            background-color: #f5f7fb;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }
        
        .form-box {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        
        .field .label {
            font-weight: 600;
        }
        
        .help {
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                padding: 1.5rem;
            }
            
            .form-box {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <!-- Encabezado mejorado -->
            <div class="admin-header">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <h1 class="title is-2 has-text-white">Editar Ciudad</h1>
                            <p class="subtitle has-text-white">Modifica los datos de la ciudad</p>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="tags has-addons">
                            <span class="tag is-dark">ID</span>
                            <span class="tag is-info">{{ $city->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="columns is-centered">
                <div class="column is-half">
                    <div class="form-box">
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
                                        <span>Actualizar Ciudad</span>
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
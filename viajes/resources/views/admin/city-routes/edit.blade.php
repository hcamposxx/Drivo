<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Rutas - {{ $city->name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .city-checkbox-card {
            border: 2px solid #dbdbdb;
            border-radius: 6px;
            padding: 1rem;
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .city-checkbox-card:hover {
            border-color: #3273dc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .city-checkbox-card.selected {
            border-color: #48c774;
            background-color: #f0fdf4;
        }
        .city-checkbox-card input[type="checkbox"] {
            width: 20px;
            height: 20px;
        }
        .selected-count {
            position: sticky;
            top: 20px;
            z-index: 10;
        }
    </style>
</head>
<body>
    @include('menu')
    
    <section class="section">
        <div class="container">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <div>
                            <h1 class="title">Configurar Rutas desde {{ $city->name }}</h1>
                            <hr>
                            <p class="subtitle">Selecciona las ciudades destino disponibles</p>
                        </div>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <a href="{{ route('admin.city-routes.index') }}" class="button is-light">
                            <span class="icon"><i class="fas fa-arrow-left"></i></span>
                            <span>Volver</span>
                        </a>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.city-routes.update', $city->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="columns">
                    <div class="column is-8">
                        <div class="box">
                            <div class="level mb-4">
                                <div class="level-left">
                                    <div class="level-item">
                                        <h2 class="title is-5">
                                            <span class="icon has-text-info">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </span>
                                            Ciudades Disponibles
                                        </h2>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <div class="field has-addons">
                                            <div class="control">
                                                <button type="button" class="button is-small is-info" onclick="selectAll()">
                                                    <span class="icon"><i class="fas fa-check-double"></i></span>
                                                    <span>Seleccionar Todas</span>
                                                </button>
                                            </div>
                                            <div class="control">
                                                <button type="button" class="button is-small" onclick="deselectAll()">
                                                    <span class="icon"><i class="fas fa-times"></i></span>
                                                    <span>Limpiar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($allCities->count() > 0)
                                <div class="columns is-multiline">
                                    @foreach($allCities as $destCity)
                                    <div class="column is-6">
                                        <label class="city-checkbox-card {{ in_array($destCity->id, $assignedDestinations) ? 'selected' : '' }}" 
                                               data-city-id="{{ $destCity->id }}">
                                            <div class="level is-mobile">
                                                <div class="level-left">
                                                    <div class="level-item">
                                                        <input type="checkbox" 
                                                               name="destinations[]" 
                                                               value="{{ $destCity->id }}"
                                                               {{ in_array($destCity->id, $assignedDestinations) ? 'checked' : '' }}
                                                               onchange="updateCardStyle(this)">
                                                    </div>
                                                    <div class="level-item">
                                                        <div>
                                                            <p class="has-text-weight-semibold">{{ $destCity->name }}</p>
                                                            <p class="is-size-7 has-text-grey">Código: {{ $destCity->short_name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="level-right">
                                                    <span class="icon has-text-primary">
                                                        <i class="fas fa-city"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="notification is-warning is-light">
                                    <span class="icon"><i class="fas fa-exclamation-triangle"></i></span>
                                    No hay otras ciudades disponibles para asignar como destino.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="column is-4">
                        <div class="box selected-count">
                            <h3 class="title is-5">
                                <span class="icon has-text-success">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                Resumen
                            </h3>
                            
                            <div class="notification is-info is-light">
                                <p class="has-text-weight-semibold mb-2">Ciudad Origen:</p>
                                <p class="is-size-4">{{ $city->name }}</p>
                                <span class="tag is-info mt-2">{{ $city->short_name }}</span>
                            </div>

                            <div class="notification is-success is-light">
                                <p class="has-text-weight-semibold mb-2">Destinos Seleccionados:</p>
                                <p class="is-size-2 has-text-success" id="selectedCount">{{ count($assignedDestinations) }}</p>
                            </div>

                            <div class="buttons">
                                <button type="submit" class="button is-success is-fullwidth">
                                    <span class="icon"><i class="fas fa-save"></i></span>
                                    <span>Guardar Rutas</span>
                                </button>
                                <a href="{{ route('admin.city-routes.index') }}" class="button is-light is-fullwidth">
                                    <span class="icon"><i class="fas fa-times"></i></span>
                                    <span>Cancelar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    @include('footer')

    <script>
        function updateCardStyle(checkbox) {
            const card = checkbox.closest('.city-checkbox-card');
            if (checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const count = document.querySelectorAll('input[name="destinations[]"]:checked').length;
            document.getElementById('selectedCount').textContent = count;
        }

        function selectAll() {
            document.querySelectorAll('input[name="destinations[]"]').forEach(checkbox => {
                checkbox.checked = true;
                updateCardStyle(checkbox);
            });
        }

        function deselectAll() {
            document.querySelectorAll('input[name="destinations[]"]').forEach(checkbox => {
                checkbox.checked = false;
                updateCardStyle(checkbox);
            });
        }

        // Hacer que toda la tarjeta sea clickeable
        document.querySelectorAll('.city-checkbox-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    updateCardStyle(checkbox);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateSelectedCount();
        });
    </script>
</body>
</html>
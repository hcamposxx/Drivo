<footer class="footer custom-footer">
    <div class="container">
        <div class="columns">
            <!-- Sección 1: Sobre la empresa -->
            <div class="column is-3">
                <h3 class="title is-5">Sobre Nosotros</h3>
                <p>
                    En Drivo conectamos personas para viajar de forma más económica, ecológica y segura. 
                </p>
            </div>

            <!-- Sección 2: Servicio al Cliente -->
            <div class="column is-3">
                <h3 class="title is-5">Servicio al Cliente</h3>
                <ul>
                   <li><a href="{{ route('ayuda') }}">Centro de Ayuda</a></li> 

                    <li><a href="{{ route('preguntas') }}">Preguntas Frecuentes</a></li>
                  
                    <li><a href="{{ route('privacidad') }}">Política de Privacidad</a></li>
                    
                    <li><a href="{{ route('reglas') }}">Términos del servicio</a></li>
                </ul>
            </div>

            <!-- Sección 3: Contacto -->
            <div class="column is-3">
                <h3 class="title is-5">Contacto</h3>
                <ul>
                    <li><i class="fa fa-envelope"></i> contacto@drivo.cl</li>
                    <li><i class="fa fa-phone"></i> +56 9 8765 4321</li>
                    <li><i class="fa fa-map-marker"></i> Temuco, Chile</li>
                </ul>
            </div>

            <!-- Sección 4: Redes Sociales -->
            <div class="column is-3">
                <h3 class="title is-5">Síguenos</h3>
                <p class="icons">
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                </p>
            </div>
        </div>

        <div class="has-text-centered mt-5">
            <p class="is-size-7">
                &copy; {{ date('Y') }} Drivo. Todos los derechos reservados.
                

            </p>
        </div>
    </div>
</footer>

<style>
    .custom-footer {
        background-color: #000000; /* Fondo negro (puedes cambiarlo) */
        color: #fc7506ff; /* Color del texto */
        padding: 2rem 1rem;
    }

    .custom-footer a {
        color: #fc7506ff; /* Color enlaces */
        text-decoration: none;
    }

    .custom-footer a:hover {
        color: #ffae00ff; /* Color al pasar el mouse (fucsia o el que quieras) */
    }

    .custom-footer h3 {
        color: #ff4081; /* Color de los títulos */
        font-weight: 600;
    }

    .custom-footer .icons a {
        margin-right: 10px;
        font-size: 1.5rem;
        transition: color 0.3s ease;
    }

    .custom-footer .icons a:hover {
        color: #ffd700; /* Amarillo dorado al pasar el mouse */
    }
</style>

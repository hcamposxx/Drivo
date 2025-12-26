# 🚗 Drivo - Plataforma de Compartir Viajes
Drivo es una aplicación web de viajes compartidos que conecta conductores con pasajeros que comparten rutas similares.
## ✨ Características Principales
### Para Conductores
- **🚘 Publicar viajes con detalles completos** (origen, destino, fecha, hora, precio)
- **👥 Gestionar pasajeros de sus viajes**
- **🚗 Registrar información del vehículo** (marca, color, placa)
- **❌ Cancelar viajes con notificación automática**
- **📊 Visualizar historial completo de viajes realizados**
### Para Pasajeros
- **🔍 Buscar viajes disponibles por ruta y fecha**
- **💺 Reservar asientos en viajes publicados**
- **📜 Acceder al historial de viajes como pasajero**
- **💬 Ver comentarios y detalles del conductor**
## 🛠️ Tecnologías Utilizadas
- **Backend: Laravel (PHP)**
- **Frontend: Blade Templates, Bulma CSS**
- **JavaScript: jQuery, SweetAlert2**
- **Gestión de Fechas: Carbon (PHP)**
- **Iconos: Font Awesome**
- **Base de Datos: MySQL/MariaDB (implícito en Laravel)**
## 📂 Estructura de Archivos
```
├── resources/
│   └── views/
│       ├── index.blade.php       # Página principal
│       ├── history.blade.php     # Historial de viajes
│       ├── header.blade.php      # Encabezado común
│       ├── footer.blade.php      # Pie de página
│       ├── hero.blade.php        # Sección hero
│       ├── search-trip.blade.php # Búsqueda de viajes
│       └── info.blade.php        # Información adicional
```
## 🚀 Instalación
Requisitos Previos
- **PHP >= 8.0**
- **Composer**
- **Node.js & NPM**
- **MySQL/MariaDB**
- **Servidor web (Apache/Nginx)**
- **Git**

## Pasos de Instalación
## 1.- Clonar el repositorio
```
bashgit clone https://github.com/tu-usuario/drivo.git
cd drivo
```
## 2.- Instalar dependencias de PHP
```
bashcomposer install
```
## 3.- Instalar dependencias de JavaScript
```
bashnpm install
```
## 4.- Configurar variables de entorno
```
bashcp .env.example .env
php artisan key:generate
```
## 5.- Configurar base de datos en .env
```
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=drivo
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
## 6.- Ejecutar migraciones
```
bashphp artisan migrate
```
## 7.- Compilar assets
```
bashnpm run dev
```
## 8.- Iniciar servidor de desarrollo
```
bashphp artisan serve
```
La aplicación estará disponible en http://localhost:8000

## ## 👥 Equipo de Desarrollo

| Nombre | Rol | Responsabilidades |
|--------|-----|-------------------|
| Héctor Campos| Frontend Developer | UI/UX, Blade templates, CSS |
| Sebastián Cisternas | Full Stack Developer | Backend, Base de datos, Blade templates |
| Claudio Rivas | Project Manager | Coordinación, testing, documentación |

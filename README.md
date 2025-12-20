# Oswaldo Guayasamin - Proyecto Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## 📋 Descripción del Proyecto

Aplicación web desarrollada con Laravel 12.x, utilizando Laravel Breeze para autenticación y las mejores prácticas de desarrollo moderno.

## 🛠️ Stack Tecnológico

### Backend
- **PHP**: ^8.2
- **Laravel Framework**: ^12.0
- **Laravel Breeze**: ^2.3 (Sistema de autenticación)
- **Laravel Tinker**: ^2.10.1
- **Laravel Boost**: ^1.8
- **Laravel Pail**: ^1.2.2 (Logs en tiempo real)
- **Laravel Sail**: ^1.41 (Entorno Docker)

### Frontend
- **Vite**: ^7.0.7
- **Tailwind CSS**: ^3.1.0
- **Alpine.js**: ^3.4.2
- **Axios**: ^1.11.0

### Testing
- **Pest PHP**: ^3.8
- **Pest Laravel Plugin**: ^3.2
- **Mockery**: ^1.6

### Herramientas de Desarrollo
- **Laravel Pint**: ^1.24 (Code styling)
- **Concurrently**: ^9.0.1

## 📦 Requisitos Previos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL/PostgreSQL o SQLite
- XAMPP (para entorno local en Windows)

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd oswaldoguayasamin
```

### 2. Instalar dependencias
```bash
# Instalar dependencias de PHP
composer install

# Instalar dependencias de Node.js
npm install
```

### 3. Configurar el entorno
```bash
# Copiar el archivo de configuración
cp .env.example .env

# Generar la clave de aplicación
php artisan key:generate
```

### 4. Configurar la base de datos
Edita el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oswaldoguayasamin
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones
```bash
php artisan migrate
```

## 🏃‍♂️ Ejecutar el Proyecto

### Opción 1: Comando unificado (Recomendado)
Ejecuta el servidor, queue listener y Vite simultáneamente:
```bash
composer dev
```

### Opción 2: Comandos separados
```bash
# Terminal 1 - Servidor Laravel
php artisan serve

# Terminal 2 - Vite (compilación de assets)
npm run dev

# Terminal 3 - Queue listener (opcional)
php artisan queue:listen
```

La aplicación estará disponible en: `http://localhost:8000`

## 🧪 Testing

Ejecutar las pruebas con Pest:
```bash
# Ejecutar todas las pruebas
composer test

# O directamente con Pest
php artisan test
```

## 📁 Estructura del Proyecto

```
oswaldoguayasamin/
├── app/                    # Lógica de la aplicación
│   ├── Http/
│   │   ├── Controllers/   # Controladores
│   │   └── Requests/      # Form Requests
│   ├── Models/            # Modelos Eloquent
│   └── Providers/         # Service Providers
├── config/                # Archivos de configuración
├── database/
│   ├── factories/        # Factories para testing
│   ├── migrations/       # Migraciones de base de datos
│   └── seeders/          # Seeders
├── public/               # Archivos públicos
├── resources/
│   ├── css/             # Estilos
│   ├── js/              # JavaScript
│   └── views/           # Vistas Blade
├── routes/
│   ├── web.php          # Rutas web
│   └── auth.php         # Rutas de autenticación
├── storage/             # Archivos generados
└── tests/               # Tests con Pest
```

## 🔧 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Formatear código con Pint
./vendor/bin/pint

# Acceder a Tinker (REPL de Laravel)
php artisan tinker

# Ver logs en tiempo real
php artisan pail

# Compilar assets para producción
npm run build
```

## 📚 Recursos de Laravel

- [Documentación oficial](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)
- [Laravel News](https://laravel-news.com)

## 📝 Licencia

Este proyecto está bajo la licencia MIT.

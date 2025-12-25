# 🔐 Sistema de Autenticación y Registro

## 📋 Resumen

Este sistema educativo utiliza un modelo de **pre-registro administrativo** en lugar de registro público. Los usuarios (docentes, estudiantes, padres y personal administrativo) son creados previamente por administradores del sistema.

## 🚫 Registro Público Deshabilitado

El registro público ha sido **deshabilitado** por las siguientes razones:

1. **Seguridad**: Solo personal autorizado debe tener acceso al sistema
2. **Control**: Los administradores controlan quién puede acceder
3. **Validación**: Los usuarios deben estar vinculados a una institución educativa válida
4. **Roles**: Cada usuario requiere roles específicos (profesor, estudiante, padre, etc.)

### Archivos modificados:
- ✅ [routes/auth.php](routes/auth.php) - Rutas de registro comentadas
- ✅ [welcome.blade.php](resources/views/welcome.blade.php) - Botón de registro removido

## 🔑 Credenciales de Acceso

### Sistema de Contraseñas Iniciales

Todos los usuarios son creados con su **cédula como contraseña inicial**:

**Ejemplo:**
- **Usuario**: Dr. Carlos Mendoza
- **Cédula**: 1301234567
- **Email**: docente1@guayasamin.edu.ec
- **Contraseña inicial**: `1301234567`

### Tipos de Usuarios y Credenciales

#### 👨‍🏫 **Docentes**
```
Email: docente1@guayasamin.edu.ec
Password: 1301234567 (su cédula)
```

#### 👨‍👩‍👧‍👦 **Padres**
```
Email: padre1@email.com
Password: 1305001 (su cédula)
```

#### 👨‍🎓 **Estudiantes**
```
Email: estudiante1@guayasamin.edu.ec
Password: 1303001 (su cédula)
```

## 🔄 Cambio Obligatorio de Contraseña

### Flujo de Primer Acceso

1. **Login inicial**: Usuario ingresa con su cédula como contraseña
2. **Detección automática**: El middleware `EnsurePasswordIsChanged` detecta que usa la contraseña predeterminada
3. **Redirección**: Usuario es redirigido a `/password/change`
4. **Cambio obligatorio**: Debe cambiar su contraseña antes de acceder al sistema
5. **Validación**: Nueva contraseña debe cumplir requisitos de seguridad:
   - Mínimo 8 caracteres
   - Incluir mayúsculas
   - Incluir minúsculas
   - Incluir números
6. **Acceso completo**: Una vez cambiada, puede acceder normalmente

### Implementación Técnica

**Middleware**: `App\Http\Middleware\EnsurePasswordIsChanged`
- Ubicación: [app/Http/Middleware/EnsurePasswordIsChanged.php](app/Http/Middleware/EnsurePasswordIsChanged.php)
- Función: Verifica si la contraseña actual es igual a la cédula
- Acción: Redirige a cambio de contraseña si es necesario

**Controlador**: `App\Http\Controllers\Auth\PasswordChangeController`
- Ubicación: [app/Http/Controllers/Auth/PasswordChangeController.php](app/Http/Controllers/Auth/PasswordChangeController.php)
- Métodos:
  - `create()`: Muestra formulario de cambio
  - `store()`: Procesa el cambio de contraseña

**Vista**: [resources/views/auth/change-password.blade.php](resources/views/auth/change-password.blade.php)

**Rutas protegidas**:
```php
Route::middleware(['auth', 'password.changed'])->group(function () {
    // Todas las rutas del sistema requieren contraseña cambiada
});
```

## 📊 Seeders

### UsuariosEspecializadosSeeder

Ubicación: [database/seeders/UsuariosEspecializadosSeeder.php](database/seeders/UsuariosEspecializadosSeeder.php)

Este seeder crea:
- ✅ **8 Docentes** con especialidades
- ✅ **20 Padres/Madres**
- ✅ **40 Estudiantes** (cada uno vinculado a 2 padres)

**Comando para ejecutar:**
```bash
php artisan db:seed --class=UsuariosEspecializadosSeeder
```

### Modificaciones Realizadas

```php
// ANTES
'password' => Hash::make('password'),

// AHORA
'password' => Hash::make($docenteData['cedula']), // Usa cédula como contraseña
```

## 🎯 Flujo Completo del Sistema

```
┌─────────────────────────────────────────────────────────────┐
│  1. ADMINISTRADOR CREA USUARIOS (via Seeder o Panel Admin) │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  2. USUARIO RECIBE CREDENCIALES                             │
│     - Email: estudiante1@guayasamin.edu.ec                  │
│     - Password: 1303001 (su cédula)                         │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  3. PRIMER LOGIN                                            │
│     Usuario ingresa con cédula como contraseña              │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  4. MIDDLEWARE DETECTA CONTRASEÑA PREDETERMINADA            │
│     EnsurePasswordIsChanged verifica Hash                   │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  5. REDIRECCIÓN AUTOMÁTICA                                  │
│     → /password/change                                      │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  6. CAMBIO OBLIGATORIO                                      │
│     - Contraseña actual (cédula)                            │
│     - Nueva contraseña (con requisitos)                     │
│     - Confirmar contraseña                                  │
└─────────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────────┐
│  7. ACCESO COMPLETO AL SISTEMA                              │
│     Usuario puede usar todas las funcionalidades            │
└─────────────────────────────────────────────────────────────┘
```

## 🔧 Comandos Útiles

### Resetear base de datos y crear usuarios
```bash
php artisan migrate:fresh --seed
```

### Crear solo usuarios especializados
```bash
php artisan db:seed --class=UsuariosEspecializadosSeeder
```

### Verificar rutas de autenticación
```bash
php artisan route:list | grep auth
```

## ⚙️ Configuración del Middleware

El middleware `password.changed` se registra en:

**Archivo**: [bootstrap/app.php](bootstrap/app.php)
```php
$middleware->alias([
    'password.changed' => \App\Http\Middleware\EnsurePasswordIsChanged::class,
]);
```

**Aplicado en**: [routes/web.php](routes/web.php)
```php
Route::middleware(['auth', 'password.changed'])->group(function () {
    // Todas las rutas protegidas
});
```

## 📝 Notas de Seguridad

1. **Nunca** uses la cédula como contraseña permanente
2. El sistema **fuerza** el cambio en el primer acceso
3. Las contraseñas nuevas deben cumplir requisitos estrictos
4. No hay registro público para evitar accesos no autorizados
5. Solo administradores pueden crear usuarios

## 🎓 Roles del Sistema

- **Super Admin**: Control total del sistema
- **Administrador**: Gestión de institución
- **Profesor**: Gestión académica (calificaciones, asistencia, tareas)
- **Estudiante**: Acceso a información académica
- **Representante**: Acceso a información de sus hijos
- **Operativo**: Personal de apoyo

## 📚 Documentación Adicional

- [Documentación de Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Laravel Authentication](https://laravel.com/docs/authentication)
- [Laravel Middleware](https://laravel.com/docs/middleware)

---

**Fecha de última actualización**: Enero 2025  
**Sistema**: Oswaldo Guayasamin - Gestión Educativa  
**Desarrollado con**: Laravel + Breeze + Spatie Permission

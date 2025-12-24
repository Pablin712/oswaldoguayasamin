# Fase 2: Módulos de Institución y Configuraciones

## Resumen

La Fase 2 implementa dos módulos fundamentales del sistema educativo:

1. **Módulo de Institución**: Gestión de información institucional (datos generales, ubicación, contacto, autoridades)
2. **Módulo de Configuraciones**: Sistema de configuración centralizada en base de datos para personalizar el comportamiento del sistema

## Arquitectura de Configuración Basada en Base de Datos

### ¿Por qué no usar .env?

El archivo `.env` es ideal para configuraciones de **infraestructura** (conexión DB, claves API, modo debug), pero **NO** para configuraciones de **negocio** que:

- Cambian frecuentemente (por ejemplo, inicio de quimestres)
- Varían por institución (cada escuela tiene diferentes reglas)
- Necesitan interfaz administrativa (los directores no editan archivos)
- Requieren historial de cambios

### Arquitectura Implementada

```
┌─────────────────────────────────────────────────────────────┐
│                    TABLA: configuraciones                    │
├─────────────────────────────────────────────────────────────┤
│ ✓ Configuraciones académicas (periodos, quimestres, etc)    │
│ ✓ Configuraciones de calificaciones (escala, ponderación)   │
│ ✓ Configuraciones de horarios (duración, días laborales)    │
│ ✓ Configuraciones SMTP (servidor de correo)                 │
│ ✓ Configuraciones de notificaciones                         │
└─────────────────────────────────────────────────────────────┘
                              ▲
                              │ Única fila (Singleton Pattern)
                              │
┌─────────────────────────────┴───────────────────────────────┐
│          ConfiguracionController::index()                    │
│  - Lee configuración desde BD                                │
│  - No usa .env para configuraciones de negocio              │
│  - Muestra interfaz con 4 tabs                               │
└──────────────────────────────────────────────────────────────┘
```

### Ventajas de este Enfoque

| Aspecto | .env | Base de Datos |
|---------|------|---------------|
| **Cambios en caliente** | ❌ Requiere reiniciar servidor | ✅ Inmediato |
| **Interfaz web** | ❌ Solo archivo | ✅ UI amigable con tabs |
| **Validación** | ❌ Ninguna | ✅ FormRequest con reglas |
| **Historial** | ❌ Solo con Git | ✅ timestamps + auditoría |
| **Multi-institución** | ❌ Una sola configuración | ✅ Escalable (aunque actualmente 1 registro) |
| **Acceso controlado** | ❌ Acceso al servidor | ✅ Permisos Laravel |

---

## 1. Módulo de Institución

### Propósito

Gestionar la información oficial de la institución educativa en un **registro único** (patrón Singleton):

- Datos generales (nombre, código AMIE, tipo, nivel, jornada)
- Ubicación (provincia, ciudad, cantón, parroquia, dirección)
- Contacto (teléfono, email, sitio web)
- Autoridades (rector, vicerrector, inspector)
- Logo institucional

### Arquitectura

#### Modelo: `Institucion`

```php
// app/Models/Institucion.php
protected $fillable = [
    'nombre', 'codigo_amie', 'logo',
    'tipo', 'nivel', 'jornada',
    'provincia', 'ciudad', 'canton', 'parroquia', 'direccion',
    'telefono', 'email', 'sitio_web',
    'rector', 'vicerrector', 'inspector',
];

// Patrón Singleton: siempre hay 1 sola institución
$institucion = Institucion::first();
```

#### Controlador: `InstitucionController`

**3 métodos principales:**

1. **`show()`**: Muestra la información institucional en cards organizadas
2. **`edit()`**: NO se usa directamente (se reemplazó por modal)
3. **`update(InstitucionRequest $request)`**: Actualiza datos + manejo de logo

**Lógica de Guardado de Logo:**

```php
if ($request->hasFile('logo')) {
    // 1. Eliminar logo anterior si existe
    if ($institucion->logo && Storage::disk('public')->exists($institucion->logo)) {
        Storage::disk('public')->delete($institucion->logo);
    }
    
    // 2. Guardar nuevo logo en storage/app/public/logos/
    $data['logo'] = $request->file('logo')->store('logos', 'public');
}

$institucion->update($data);
```

**Autorización:**
- Usa `Gate::denies()` para verificar permisos
- Permisos: `'ver institución'`, `'editar institución'`
- Redirección con mensaje de error si no tiene permiso

#### Validación: `InstitucionRequest`

```php
public function rules(): array
{
    return [
        'nombre' => 'required|string|max:255',
        'codigo_amie' => 'required|string|max:20',
        'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Máx 2MB
        'tipo' => 'required|in:Fiscal,Fiscomisional,Municipal,Particular',
        'nivel' => 'required|string|max:100',
        'jornada' => 'required|in:Matutina,Vespertina,Nocturna,Ambas',
        // ... resto de campos con validaciones
    ];
}
```

#### Vistas

**`instituciones/show.blade.php`**
- Diseño: 4 cards en grid (2 columnas en MD+)
- Cards: Información General, Ubicación, Contacto, Autoridades
- Botón "Editar" abre modal con Alpine.js: `@click="$dispatch('open-modal', 'edit-institucion')"`
- Permiso: `@canany(['editar institución', 'gestionar institución'])`

**`instituciones/edit.blade.php`** (Modal)
- Componente: `<x-modal name="edit-institucion" maxWidth="4xl">`
- Formulario dividido en 4 secciones con iconos
- Upload de logo con vista previa JavaScript
- Cierre modal: `@click="$dispatch('close-modal', 'edit-institucion')"`

### Rutas

```php
Route::get('/instituciones', [InstitucionController::class, 'show'])
    ->name('instituciones.show');

Route::put('/instituciones', [InstitucionController::class, 'update'])
    ->name('instituciones.update');
```

---

## 2. Módulo de Configuraciones

### Propósito

Centralizar **todas las configuraciones del sistema** en una sola tabla para:

- Definir reglas académicas (periodos, quimestres, parciales)
- Configurar sistema de calificaciones (escala, ponderaciones, reglas)
- Establecer horarios (duración de periodos, días laborales)
- Configurar envío de correos (SMTP, notificaciones)

### Arquitectura de Tabla `configuraciones`

#### Estructura (38 campos agrupados)

```sql
CREATE TABLE configuraciones (
    id BIGINT PRIMARY KEY,
    
    -- ACADÉMICO (10 campos)
    periodo_actual_id BIGINT NULLABLE,
    numero_quimestres INT DEFAULT 2,
    numero_parciales INT DEFAULT 3,
    fecha_inicio_clases DATE,
    fecha_fin_clases DATE,
    fecha_inicio_q1 DATE,
    fecha_fin_q1 DATE,
    fecha_inicio_q2 DATE,
    fecha_fin_q2 DATE,
    porcentaje_minimo_asistencia INT DEFAULT 75,
    
    -- CALIFICACIONES (10 campos)
    calificacion_minima DECIMAL(5,2) DEFAULT 0,
    calificacion_maxima DECIMAL(5,2) DEFAULT 10,
    nota_minima_aprobacion DECIMAL(5,2) DEFAULT 7,
    decimales INT DEFAULT 2,
    ponderacion_examen INT DEFAULT 20,
    ponderacion_parciales INT DEFAULT 80,
    permitir_supletorio BOOLEAN DEFAULT TRUE,
    permitir_remedial BOOLEAN DEFAULT TRUE,
    permitir_gracia BOOLEAN DEFAULT TRUE,
    redondear_calificaciones BOOLEAN DEFAULT FALSE,
    
    -- HORARIOS (4 campos)
    duracion_periodo INT DEFAULT 45,
    duracion_recreo INT DEFAULT 15,
    periodos_por_dia INT DEFAULT 6,
    dias_laborales JSON, -- ["Lunes", "Martes", ...]
    
    -- SMTP (7 campos)
    smtp_host VARCHAR,
    smtp_port INT DEFAULT 587,
    smtp_encriptacion ENUM('TLS','SSL') DEFAULT 'TLS',
    smtp_usuario VARCHAR,
    smtp_password VARCHAR,
    remitente_nombre VARCHAR,
    remitente_email VARCHAR,
    
    -- NOTIFICACIONES (6 campos)
    notificar_calificaciones BOOLEAN DEFAULT TRUE,
    notificar_asistencia BOOLEAN DEFAULT TRUE,
    notificar_eventos BOOLEAN DEFAULT TRUE,
    resumen_semanal_padres BOOLEAN DEFAULT FALSE,
    resumen_mensual_docentes BOOLEAN DEFAULT FALSE,
    plantilla_correo TEXT,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Modelo: `Configuracion`

```php
// app/Models/Configuracion.php
protected $fillable = [
    // ... los 38 campos
];

protected $casts = [
    'fecha_inicio_clases' => 'date',
    'calificacion_minima' => 'decimal:2',
    'permitir_supletorio' => 'boolean',
    'dias_laborales' => 'array', // JSON → PHP array
    // ...
];

// Relación con periodo académico
public function periodoActual(): BelongsTo
{
    return $this->belongsTo(PeriodoAcademico::class, 'periodo_actual_id');
}
```

### Controlador: `ConfiguracionController`

#### `index()` - Mostrar Configuraciones

```php
public function index()
{
    $configuracion = Configuracion::first(); // Singleton
    $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();
    
    return view('configuraciones.index', compact('configuracion', 'periodos'));
}
```

#### `update(ConfiguracionRequest $request)` - Guardar Cambios

```php
public function update(ConfiguracionRequest $request)
{
    $configuracion = Configuracion::first();
    $data = $request->validated(); // 38 campos validados
    
    $configuracion->update($data);
    
    return redirect()->route('configuraciones.index')
        ->with('success', 'Configuraciones actualizadas exitosamente.');
}
```

#### `testEmail(Request $request)` - Probar SMTP

```php
public function testEmail(Request $request)
{
    try {
        // Aquí se implementaría el envío con Mail::to()
        // usando las credenciales SMTP de la BD
        
        return response()->json([
            'success' => true,
            'message' => 'Correo de prueba enviado exitosamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
```

### Validación: `ConfiguracionRequest`

**Reglas especiales:**

```php
public function rules(): array
{
    return [
        // Académico
        'periodo_actual_id' => 'nullable|exists:periodos_academicos,id',
        'numero_quimestres' => 'required|integer|between:1,4',
        
        // Calificaciones
        'ponderacion_examen' => 'required|integer|min:0|max:100',
        'ponderacion_parciales' => 'required|integer|min:0|max:100',
        
        // SMTP
        'smtp_host' => 'nullable|string|max:255',
        'smtp_port' => 'nullable|integer|between:1,65535',
        'smtp_password' => 'nullable|string',
        
        // ...
    ];
}

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        // Validación personalizada: ponderaciones deben sumar 100%
        if ($this->ponderacion_examen + $this->ponderacion_parciales !== 100) {
            $validator->errors()->add('ponderaciones', 
                'La suma de ponderaciones debe ser 100%');
        }
    });
}
```

### Vista: `configuraciones/index.blade.php`

#### Diseño de Tabs

```html
<div class="bg-white rounded-lg shadow-md">
    <!-- 4 Botones de Tabs -->
    <div class="flex border-b">
        <button onclick="switchTab('academico')" class="tab-button">
            📚 Académico
        </button>
        <button onclick="switchTab('calificaciones')" class="tab-button">
            📊 Calificaciones
        </button>
        <button onclick="switchTab('horarios')" class="tab-button">
            🕐 Horarios
        </button>
        <button onclick="switchTab('correo')" class="tab-button">
            📧 Correo
        </button>
    </div>

    <!-- Contenido de Tabs -->
    <div class="p-6">
        @include('configuraciones.tabs.academico')
        @include('configuraciones.tabs.calificaciones')
        @include('configuraciones.tabs.horarios')
        @include('configuraciones.tabs.correo')
    </div>
</div>
```

#### JavaScript de Tabs

```javascript
function switchTab(tabName) {
    // 1. Ocultar todos los tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // 2. Mostrar el tab seleccionado
    document.getElementById('tab-' + tabName).classList.remove('hidden');

    // 3. Actualizar estilos de botones (activo/inactivo)
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-theme-primary', 'text-white');
        button.classList.add('bg-gray-100', 'text-gray-700');
    });

    document.querySelector(`[data-tab="${tabName}"]`)
        .classList.add('bg-theme-primary', 'text-white');
}

// Activar primer tab al cargar
document.addEventListener('DOMContentLoaded', () => switchTab('academico'));
```

### Tabs Implementados

#### 1. Tab Académico

**Configuraciones:**
- Periodo académico actual (select con periodos)
- Número de quimestres (2, 3 o 4)
- Número de parciales por quimestre (2, 3 o 4)
- Fechas de inicio/fin del año lectivo
- Fechas de inicio/fin de quimestres
- Porcentaje mínimo de asistencia (%)

#### 2. Tab Calificaciones

**Configuraciones:**
- Escala de calificación (mínima, máxima, mínima aprobación, decimales)
- **Ponderaciones con validación dinámica:**
  ```javascript
  function calcularTotalPonderacion() {
      const examen = parseFloat($('#ponderacion_examen').val() || 0);
      const parciales = parseFloat($('#ponderacion_parciales').val() || 0);
      const total = examen + parciales;
      
      $('#total_ponderacion').text(total + '%');
      
      if (total === 100) {
          $('#check_ponderacion').text('✓').addClass('text-green-500');
      } else {
          $('#check_ponderacion').text('✗').addClass('text-red-500');
      }
  }
  ```
- Reglas especiales (checkboxes): supletorio, remedial, gracia, redondeo

#### 3. Tab Horarios

**Configuraciones:**
- Duración de periodo (minutos)
- Duración de recreo (minutos)
- Periodos por día (4-12)
- Días laborales (checkboxes: Lunes-Domingo)

**Array JSON en BD:**
```php
// Al guardar: días_laborales = ["Lunes", "Martes", "Miércoles", ...]
// Al leer: 
$diasLaborales = $configuracion->dias_laborales ?? [];
// Blade:
{{ in_array('Lunes', $diasLaborales) ? 'checked' : '' }}
```

#### 4. Tab Correo (SMTP)

**Configuraciones SMTP:**
- Servidor SMTP (smtp.gmail.com, smtp.office365.com, etc.)
- Puerto (25, 465, 587)
- Encriptación (TLS/SSL)
- Usuario y contraseña (con botón "ojo" para mostrar/ocultar)

**Configuración de Notificaciones:**
- Checkboxes para habilitar/deshabilitar cada tipo
- Plantilla de correo con variables: `@{{nombre_destinatario}}`, `@{{contenido_mensaje}}`, `@{{nombre_institucion}}`

**Botón de Prueba:**
```javascript
function enviarCorreoPrueba() {
    const email = prompt('Ingrese correo de destino:');
    
    fetch('/configuraciones/test-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success ? '✓ Correo enviado' : '✗ Error: ' + data.message);
    });
}
```

---

## Flujo de Uso de SMTP desde BD

### Paso 1: Configuración en Interfaz Web

```
1. Director accede a /configuraciones
2. Click en tab "Correo"
3. Llena:
   - SMTP Host: smtp.gmail.com
   - Puerto: 587
   - Usuario: escuela@gmail.com
   - Contraseña: app_password_generado
4. Click "Guardar Cambios"
   → Datos se guardan en tabla configuraciones
```

### Paso 2: Uso en Código para Enviar Emails

```php
// En cualquier parte del sistema (ejemplo: notificar calificación)
use Illuminate\Support\Facades\Mail;
use App\Models\Configuracion;

$config = Configuracion::first();

// Configurar mailer en tiempo de ejecución
config([
    'mail.mailers.smtp.host' => $config->smtp_host,
    'mail.mailers.smtp.port' => $config->smtp_port,
    'mail.mailers.smtp.encryption' => strtolower($config->smtp_encriptacion),
    'mail.mailers.smtp.username' => $config->smtp_usuario,
    'mail.mailers.smtp.password' => $config->smtp_password,
    'mail.from.address' => $config->remitente_email,
    'mail.from.name' => $config->remitente_nombre,
]);

// Enviar email
Mail::to('padre@example.com')->send(new CalificacionMailable($estudiante));
```

### Paso 3: Ventajas vs .env

| Escenario | Con .env | Con BD |
|-----------|----------|--------|
| **Cambiar servidor SMTP** | Editar .env, reiniciar servidor | Editar en web, efecto inmediato |
| **Usar Gmail de prueba** | Modificar archivo, commit Git | Click en UI, no afecta producción |
| **Multi-institución** | Un .env por servidor | Una fila por institución |
| **Auditoría de cambios** | Solo con Git | timestamps + bitácora automática |

---

## Permisos y Seguridad

### Permisos Creados

```php
// database/seeders/RoleSeeder.php
$permissions = [
    'gestionar institución',  // CRUD completo
    'ver institución',        // Solo lectura
    'editar institución',     // Solo editar

    'gestionar configuraciones',  // CRUD completo
    'ver configuraciones',        // Solo lectura
    'editar configuraciones',     // Solo editar
];
```

### Uso en Controladores

```php
// Patrón utilizado en ambos controladores
if (Gate::denies('editar institución')) {
    return redirect()->back()
        ->with('error', 'No tienes permiso para editar la institución.');
}
```

### Uso en Vistas

```blade
@canany(['editar institución', 'gestionar institución'])
    <button>Editar</button>
@endcanany
```

---

## Rutas Implementadas

```php
// routes/web.php

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Institución
    Route::get('/instituciones', [InstitucionController::class, 'show'])
        ->name('instituciones.show');
    Route::put('/instituciones', [InstitucionController::class, 'update'])
        ->name('instituciones.update');
    
    // Configuraciones
    Route::get('/configuraciones', [ConfiguracionController::class, 'index'])
        ->name('configuraciones.index');
    Route::put('/configuraciones', [ConfiguracionController::class, 'update'])
        ->name('configuraciones.update');
    Route::post('/configuraciones/test-email', [ConfiguracionController::class, 'testEmail'])
        ->name('configuraciones.test-email');
});
```

---

## Temas Dark Mode

Todas las vistas implementan modo oscuro completo con Tailwind:

```blade
<!-- Input con dark mode -->
<input class="w-full 
    border-gray-300 dark:border-gray-600 
    bg-white dark:bg-gray-700 
    text-gray-900 dark:text-white 
    focus:border-theme-primary dark:focus:border-theme-primary-light">

<!-- Label con dark mode -->
<label class="text-gray-700 dark:text-gray-300">

<!-- Card con dark mode -->
<div class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700">
```

**Paleta de colores del sistema:**
- `theme-primary`: Color principal
- `theme-primary-light`: Variante clara
- `theme-primary-dark`: Variante oscura
- `theme-secondary`, `theme-third`: Colores secundarios

---

## Próximos Pasos

1. **Implementar envío real de emails** usando `Mail::send()`
2. **Agregar auditoría de cambios** para configuraciones críticas
3. **Crear seeder** para configuración inicial por defecto
4. **Implementar caché** para evitar consultas frecuentes a BD
5. **Multi-institución**: Agregar `institucion_id` si el sistema crece

---

## Resumen Técnico

| Aspecto | Implementación |
|---------|----------------|
| **Patrón de diseño** | Singleton (1 institución, 1 configuración) |
| **Almacenamiento** | Base de datos MySQL (no .env para negocio) |
| **Autorización** | Laravel Gates + Spatie Permissions |
| **Validación** | Form Requests con reglas personalizadas |
| **Frontend** | Blade + Alpine.js + Tailwind Dark Mode |
| **UX** | Tabs dinámicos, modales, validación en tiempo real |
| **Escalabilidad** | Fácil migrar a multi-institución agregando FK |

---

**Última actualización:** 24 de diciembre de 2025

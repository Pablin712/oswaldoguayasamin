# 📚 Documentación - Módulo de Calificaciones (Fase 6)

**Fecha de implementación:** 02-03 de febrero de 2026  
**Estado:** ✅ Completado y Validado  
**Desarrollador:** Sistema Educativo Oswaldo Guayasamín

---

## 📖 Índice

1. [Descripción General](#descripción-general)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Modelos y Relaciones](#modelos-y-relaciones)
4. [Controladores y Rutas](#controladores-y-rutas)
5. [Vista y Frontend](#vista-y-frontend)
6. [Permisos y Seguridad](#permisos-y-seguridad)
7. [Flujo de Trabajo](#flujo-de-trabajo)
8. [Seeder de Datos](#seeder-de-datos)
9. [Casos de Uso](#casos-de-uso)
10. [Solución de Problemas](#solución-de-problemas)

---

## 📋 Descripción General

El módulo de **Calificaciones** permite el registro, edición, publicación y consulta de calificaciones académicas de los estudiantes. Soporta un sistema de evaluación basado en componentes (tareas, lecciones, proyectos, exámenes, etc.) con ponderaciones personalizables.

### Características Principales

- ✅ **Sistema de filtros en cascada** para selección de contexto académico
- ✅ **Registro de calificaciones** por componentes ponderados
- ✅ **Cálculo automático** de nota final
- ✅ **Estados de calificación** (pendiente, registrada, modificada, publicada)
- ✅ **Estadísticas en tiempo real** del rendimiento del curso
- ✅ **Control de permisos** por rol (administrador, docente)
- ✅ **Validación de datos** con restricciones de negocio
- ✅ **Interfaz responsive** con modo oscuro

---

## 🏗️ Arquitectura del Sistema

### Estructura de Archivos

```
oswaldoguayasamin/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── CalificacionController.php
│   │   └── Requests/
│   │       └── CalificacionRequest.php
│   └── Models/
│       ├── Calificacion.php
│       └── ComponenteCalificacion.php
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_calificaciones_table.php
│   │   └── xxxx_create_componentes_calificacion_table.php
│   └── seeders/
│       └── CalificacionesSeeder.php
├── resources/
│   └── views/
│       └── academico/
│           └── calificaciones/
│               └── index.blade.php
└── routes/
    └── web.php
```

---

## 🗄️ Modelos y Relaciones

### 1. Modelo: Calificacion

**Ubicación:** `app/Models/Calificacion.php`

**Tabla:** `calificaciones`

**Campos:**
```php
- id                  : bigint (PK)
- matricula_id        : bigint (FK → matriculas)
- curso_materia_id    : bigint (FK → curso_materia)
- parcial_id          : bigint (FK → parciales)
- docente_id          : bigint (FK → docentes)
- nota_final          : decimal(4,2)
- observaciones       : text (nullable)
- fecha_registro      : date
- estado              : enum('pendiente','registrada','modificada','publicada')
- created_at          : timestamp
- updated_at          : timestamp
```

**Relaciones:**
```php
// Pertenece a una matrícula
public function matricula(): BelongsTo

// Pertenece a una asignación curso-materia
public function cursoMateria(): BelongsTo

// Pertenece a un parcial académico
public function parcial(): BelongsTo

// Pertenece a un docente
public function docente(): BelongsTo

// Tiene múltiples componentes de calificación
public function componentes(): HasMany
```

**Scopes:**
```php
// Filtrar calificaciones aprobadas
scopeAprobadas($query)
```

---

### 2. Modelo: ComponenteCalificacion

**Ubicación:** `app/Models/ComponenteCalificacion.php`

**Tabla:** `componentes_calificacion`

**Campos:**
```php
- id              : bigint (PK)
- calificacion_id : bigint (FK → calificaciones)
- nombre          : varchar(100)
- tipo            : enum('tarea','leccion','examen','proyecto','participacion','otro')
- nota            : decimal(4,2)
- porcentaje      : decimal(5,2)
- descripcion     : text (nullable)
- created_at      : timestamp
- updated_at      : timestamp
```

**Relaciones:**
```php
// Pertenece a una calificación
public function calificacion(): BelongsTo
```

**Validaciones:**
- La suma de porcentajes de todos los componentes debe ser 100%
- Nota entre 0 y 10
- Porcentaje entre 0 y 100

---

## 🎛️ Controladores y Rutas

### CalificacionController

**Ubicación:** `app/Http/Controllers/CalificacionController.php`

#### Métodos Principales

##### 1. `index()`
- **Descripción:** Muestra la vista principal del módulo
- **Permisos:** `ver calificaciones` o `gestionar calificaciones`
- **Retorna:** Vista Blade con filtros de contexto

##### 2. `cargarContexto(Request $request)`
- **Descripción:** Carga datos dinámicos para filtros en cascada
- **Ruta:** `GET /calificaciones/contexto`
- **Parámetros:**
  ```php
  - tipo: string (quimestres|parciales|paralelos|materias)
  - periodo_id: int
  - quimestre_id: int (opcional)
  - paralelo_id: int (opcional)
  - parcial_id: int (opcional)
  ```
- **Retorna:** JSON con opciones filtradas

**Ejemplo de uso:**
```javascript
// Cargar quimestres de un período
fetch('/calificaciones/contexto?tipo=quimestres&periodo_id=1')

// Cargar materias de un paralelo
fetch('/calificaciones/contexto?tipo=materias&paralelo_id=5&parcial_id=1')
```

##### 3. `cargarEstudiantes(Request $request)`
- **Descripción:** Carga lista de estudiantes con sus calificaciones
- **Ruta:** `GET /calificaciones/estudiantes`
- **Parámetros:**
  ```php
  - paralelo_id: int (requerido)
  - curso_materia_id: int (requerido)
  - parcial_id: int (requerido)
  ```
- **Retorna:** JSON array de estudiantes con datos de calificación

**Estructura de respuesta:**
```json
[
  {
    "matricula_id": 1,
    "estudiante_nombre": "Juan Pérez",
    "calificacion_id": 10,
    "nota_final": 8.5,
    "estado": "registrada",
    "observaciones": "Excelente desempeño",
    "puede_editar": true,
    "componentes": [
      {
        "id": 1,
        "nombre": "Tareas",
        "tipo": "tarea",
        "nota": 9.0,
        "porcentaje": 20.0
      }
    ]
  }
]
```

##### 4. `store(CalificacionRequest $request)`
- **Descripción:** Crea una nueva calificación
- **Ruta:** `POST /calificaciones`
- **Permisos:** `gestionar calificaciones`
- **Validación:** CalificacionRequest
- **Retorna:** JSON con éxito o error

##### 5. `update(CalificacionRequest $request, Calificacion $calificacion)`
- **Descripción:** Actualiza una calificación existente
- **Ruta:** `PUT /calificaciones/{id}`
- **Permisos:** `gestionar calificaciones`
- **Restricciones:**
  - No se pueden editar calificaciones publicadas (excepto administradores)
  - Cambia estado a "modificada" al actualizar

##### 6. `destroy(Calificacion $calificacion)`
- **Descripción:** Elimina una calificación
- **Ruta:** `DELETE /calificaciones/{id}`
- **Permisos:** `gestionar calificaciones`
- **Restricciones:**
  - No se pueden eliminar calificaciones publicadas
  - Elimina en cascada los componentes asociados

##### 7. `publicar(Request $request)`
- **Descripción:** Publica calificaciones para que sean visibles a estudiantes
- **Ruta:** `POST /calificaciones/publicar`
- **Permisos:** `gestionar calificaciones`
- **Parámetros:**
  ```php
  - calificaciones_ids: array (IDs a publicar)
  ```

##### 8. `estadisticas(Request $request)`
- **Descripción:** Genera estadísticas del rendimiento del curso
- **Ruta:** `GET /calificaciones/estadisticas`
- **Parámetros:**
  ```php
  - curso_materia_id: int
  - parcial_id: int
  ```
- **Retorna:** JSON con métricas

**Estructura de respuesta:**
```json
{
  "total": 39,
  "promedio": 7.45,
  "aprobados": 28,
  "enRiesgo": 8,
  "reprobados": 3,
  "porcentajeAprobados": 71.8,
  "porcentajeRiesgo": 20.5,
  "porcentajeReprobados": 7.7
}
```

---

### Rutas Configuradas

**Archivo:** `routes/web.php`

```php
Route::middleware(['auth'])->prefix('calificaciones')->group(function () {
    // Vista principal
    Route::get('/', [CalificacionController::class, 'index'])
        ->name('calificaciones.index')
        ->middleware('can:ver calificaciones');
    
    // Carga dinámica de contexto
    Route::get('/contexto', [CalificacionController::class, 'cargarContexto'])
        ->name('calificaciones.contexto')
        ->middleware('can:ver calificaciones');
    
    // Carga de estudiantes
    Route::get('/estudiantes', [CalificacionController::class, 'cargarEstudiantes'])
        ->name('calificaciones.estudiantes')
        ->middleware('can:ver calificaciones');
    
    // Estadísticas
    Route::get('/estadisticas', [CalificacionController::class, 'estadisticas'])
        ->name('calificaciones.estadisticas')
        ->middleware('can:ver calificaciones');
    
    // CRUD
    Route::post('/', [CalificacionController::class, 'store'])
        ->name('calificaciones.store')
        ->middleware('can:gestionar calificaciones');
    
    Route::put('/{calificacion}', [CalificacionController::class, 'update'])
        ->name('calificaciones.update')
        ->middleware('can:gestionar calificaciones');
    
    Route::delete('/{calificacion}', [CalificacionController::class, 'destroy'])
        ->name('calificaciones.destroy')
        ->middleware('can:gestionar calificaciones');
    
    // Publicar
    Route::post('/publicar', [CalificacionController::class, 'publicar'])
        ->name('calificaciones.publicar')
        ->middleware('can:gestionar calificaciones');
});
```

---

## 🎨 Vista y Frontend

### Vista Principal

**Ubicación:** `resources/views/academico/calificaciones/index.blade.php`

**Secciones:**

#### 1. Filtros en Cascada
```html
<select id="periodo">     <!-- Período Académico -->
<select id="quimestre">   <!-- Quimestre -->
<select id="parcial">     <!-- Parcial -->
<select id="paralelo">    <!-- Curso/Paralelo -->
<select id="materia">     <!-- Materia -->
```

**Funcionamiento:**
1. Usuario selecciona **Período Académico** → Carga quimestres del período
2. Selecciona **Quimestre** → Carga parciales del quimestre
3. Selecciona **Parcial** → Carga paralelos del período
4. Selecciona **Paralelo** → Carga materias del curso/paralelo
5. Al completar todos los filtros → Habilita botón "Cargar Calificaciones"

#### 2. Tabla de Calificaciones
```html
<table>
  <thead>
    <tr>
      <th>Estudiante</th>
      <th>Tareas (20%)</th>
      <th>Lecciones (20%)</th>
      <th>Proyecto (20%)</th>
      <th>Examen (40%)</th>
      <th>Nota Final</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody id="bodyCalificaciones">
    <!-- Se llena dinámicamente con JavaScript -->
  </tbody>
</table>
```

#### 3. Botones de Acción
- **Cargar Calificaciones:** Carga estudiantes y calificaciones existentes
- **Estadísticas:** Muestra modal con métricas del curso
- **Publicar Seleccionadas:** Publica calificaciones marcadas

---

### JavaScript Principal

**Variables Globales:**
```javascript
let contexto = {
    periodo_id: null,
    quimestre_id: null,
    parcial_id: null,
    paralelo_id: null,
    curso_materia_id: null
};
```

**Funciones Principales:**

##### `cargarContexto(tipo)`
Carga opciones para un filtro específico según el tipo.

##### `cargarEstudiantes()`
Obtiene lista de estudiantes y calificaciones, renderiza la tabla.

##### `crearFilaEstudiante(estudiante)`
Genera el HTML de una fila de la tabla con datos del estudiante.

##### `getColorNota(nota)`
Retorna clases CSS según el valor de la nota:
- Verde: nota ≥ 7
- Amarillo: 5 ≤ nota < 7
- Rojo: nota < 5

##### `verificarContextoCompleto()`
Habilita/deshabilita botón de carga según si todos los filtros están seleccionados.

---

## 🔒 Permisos y Seguridad

### Permisos Implementados

| Permiso | Descripción | Rol Asignado |
|---------|-------------|--------------|
| `ver calificaciones` | Ver listado y consultar calificaciones | Administrador, Docente |
| `gestionar calificaciones` | Crear, editar, eliminar y publicar | Administrador, Docente |
| `registrar calificaciones` | Registrar nuevas calificaciones | Docente |
| `editar calificaciones` | Modificar calificaciones existentes | Docente |
| `eliminar calificaciones` | Eliminar registros de calificaciones | Administrador |
| `publicar calificaciones` | Hacer visibles a estudiantes | Administrador, Docente |
| `generar reporte calificaciones` | Exportar reportes | Administrador, Docente |

### Protección de Rutas

**Nivel 1 - Middleware de Autenticación:**
```php
Route::middleware(['auth'])
```

**Nivel 2 - Middleware de Permisos:**
```php
->middleware('can:ver calificaciones')
```

**Nivel 3 - Gate en Controlador:**
```php
Gate::any(['ver calificaciones', 'gestionar calificaciones']);
```

**Nivel 4 - Protección en Vista:**
```blade
@canany(['gestionar calificaciones', 'ver calificaciones'])
    <!-- Contenido protegido -->
@else
    <p>No tienes permisos para acceder a esta sección.</p>
@endcanany
```

### Restricciones de Negocio

1. **Calificaciones Publicadas:**
   - No se pueden editar (excepto administradores)
   - No se pueden eliminar
   
2. **Docentes:**
   - Solo ven sus propias materias y paralelos
   - Solo gestionan calificaciones de sus estudiantes

3. **Administradores:**
   - Acceso total a todas las calificaciones
   - Pueden editar calificaciones publicadas

---

## 📊 Flujo de Trabajo

### Flujo Completo: Registro de Calificaciones

```
┌─────────────────────┐
│  1. Acceder Módulo  │
│  /calificaciones    │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 2. Seleccionar      │
│    Filtros          │
│    (5 niveles)      │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 3. Cargar           │
│    Estudiantes      │
│    (AJAX)           │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 4. Mostrar Tabla    │
│    con Datos        │
│    Existentes       │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 5. Registrar/       │
│    Editar Notas     │
│    por Componente   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 6. Calcular         │
│    Nota Final       │
│    (automático)     │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 7. Guardar          │
│    (POST/PUT)       │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ 8. Publicar         │
│    (opcional)       │
└─────────────────────┘
```

### Estados de una Calificación

```
pendiente → registrada → modificada → publicada
    ↑           ↓            ↓           │
    │           └────────────┘           │
    └───────────────────────────────────┘
           (solo admin puede revertir)
```

---

## 🌱 Seeder de Datos

### CalificacionesSeeder

**Ubicación:** `database/seeders/CalificacionesSeeder.php`

**Funcionalidad:**
- Genera datos de prueba realistas para el módulo
- Limpia calificaciones existentes antes de generar nuevas
- Crea calificaciones con componentes ponderados

**Datos Generados:**
- **294 calificaciones** para 39 estudiantes
- **1,176 componentes** (4 por calificación)
- **Distribución:** 70% registrada, 30% publicada

**Componentes Creados:**
```php
[
    ['nombre' => 'Tareas',    'tipo' => 'tarea',    'porcentaje' => 20],
    ['nombre' => 'Lecciones', 'tipo' => 'leccion',  'porcentaje' => 20],
    ['nombre' => 'Proyecto',  'tipo' => 'proyecto', 'porcentaje' => 20],
    ['nombre' => 'Examen',    'tipo' => 'examen',   'porcentaje' => 40],
]
```

**Notas Generadas:**
- Rango: 5.0 a 10.0
- Distribución realista
- Cálculo automático de nota final

**Observaciones Automáticas:**
- Nota < 7.0: "Requiere refuerzo"
- Nota ≥ 9.0: "Excelente desempeño"
- Resto: null

### Ejecutar Seeder

```bash
# Ejecutar solo CalificacionesSeeder
php artisan db:seed --class=CalificacionesSeeder

# Ejecutar todos los seeders
php artisan db:seed
```

---

## 💡 Casos de Uso

### Caso 1: Docente Registra Calificaciones

**Actor:** Docente de Matemáticas

**Flujo:**
1. Accede a `/calificaciones`
2. Selecciona:
   - Período: 2024-2025
   - Quimestre: Primer Quimestre
   - Parcial: Primer Parcial
   - Paralelo: 1ro de Básica - A
   - Materia: Matemáticas
3. Click en "Cargar Calificaciones"
4. Sistema muestra lista de 15 estudiantes
5. Ingresa notas para cada componente:
   - Tareas: 8.5
   - Lecciones: 7.0
   - Proyecto: 9.0
   - Examen: 8.0
6. Sistema calcula nota final automáticamente: 8.1
7. Click en "Guardar"
8. Calificación queda en estado "registrada"

---

### Caso 2: Administrador Consulta Estadísticas

**Actor:** Administrador Académico

**Flujo:**
1. Selecciona contexto académico
2. Carga calificaciones de un curso
3. Click en botón "Estadísticas"
4. Sistema muestra modal con:
   - Total estudiantes: 39
   - Promedio del curso: 7.45
   - Aprobados: 28 (71.8%)
   - En riesgo: 8 (20.5%)
   - Reprobados: 3 (7.7%)
5. Toma decisiones pedagógicas basadas en datos

---

### Caso 3: Docente Publica Calificaciones

**Actor:** Docente

**Flujo:**
1. Revisa todas las calificaciones registradas
2. Verifica que no haya errores
3. Selecciona checkbox de calificaciones a publicar
4. Click en "Publicar Seleccionadas"
5. Sistema cambia estado a "publicada"
6. Estudiantes ahora pueden ver sus notas
7. Calificaciones publicadas no se pueden modificar

---

## 🔧 Solución de Problemas

### Problema 1: Error 500 al cargar estudiantes

**Síntoma:**
```
Failed to load resource: the server responded with a status of 500
```

**Causa:** 
- Usuario sin relación `docente` (administradores)
- Relación incorrecta en modelo

**Solución:**
```php
// Usar optional() para evitar errores
$docenteId = optional($user->docente)->id;
```

---

### Problema 2: Botón "Cargar Calificaciones" deshabilitado

**Síntoma:** Botón permanece gris aunque todos los filtros estén seleccionados

**Causa:** Variable `contexto` no se actualiza correctamente

**Solución:**
```javascript
// Verificar que todos los eventos actualicen el contexto
$('#materia').on('select2:select', function(e) {
    contexto.curso_materia_id = e.params.data.id;
    verificarContextoCompleto(); // <-- Importante
});
```

---

### Problema 3: Componentes no se cargan

**Síntoma:** Error "componentesCalificacion is not a function"

**Causa:** Nombre de relación incorrecto

**Solución:**
```php
// En Calificacion.php, la relación se llama 'componentes', no 'componentesCalificacion'
$calificacion->componentes  // ✅ Correcto
$calificacion->componentesCalificacion  // ❌ Incorrecto
```

---

### Problema 4: Estado de matrícula incorrecto

**Síntoma:** No se encuentran matrículas activas

**Causa:** Estado en BD es 'activa' (femenino)

**Solución:**
```php
// Usar 'activa' en lugar de 'activo'
Matricula::where('estado', 'activa')  // ✅ Correcto
```

---

## 📈 Métricas de Rendimiento

### Consultas Optimizadas

```php
// ✅ BIEN: Eager Loading
Matricula::with(['estudiante.user'])->get();

// ❌ MAL: N+1 Problem
$matriculas = Matricula::all();
foreach ($matriculas as $m) {
    echo $m->estudiante->user->name; // Consulta por cada iteración
}
```

### Índices de Base de Datos

Asegurarse de que existan índices en:
- `calificaciones.matricula_id`
- `calificaciones.curso_materia_id`
- `calificaciones.parcial_id`
- `componentes_calificacion.calificacion_id`

---

## 🚀 Próximos Pasos (Fase 7)

1. **Módulo de Asistencias**
   - Registro diario/semanal
   - Reportes de inasistencias
   - Integración con justificaciones

2. **Módulo de Justificaciones**
   - Carga de documentos
   - Workflow de aprobación
   - Vinculación con asistencias

3. **Mejoras al Módulo de Calificaciones**
   - Edición inline en tabla
   - Importación desde Excel
   - Exportación de reportes PDF
   - Historial de cambios
   - Notificaciones automáticas

---

## 📝 Notas Finales

**Fecha de última actualización:** 03 de febrero de 2026

**Estado del módulo:** ✅ Producción - Completamente funcional

**Desarrollado por:** Sistema Educativo Oswaldo Guayasamín

**Contacto:** Para consultas sobre este módulo, revisar el código fuente o contactar al equipo de desarrollo.

---

## 🔗 Referencias

- [Documentación de Avances](6 - Avances.md)
- [Mockups y Vistas](7 - Mockups.md)
- [Diagrama de Base de Datos](4 - Diagrama DB.md)
- [Historias de Usuario](3 - Historias de Usuario.md)

# ✅ Fase 9 Completada: Tareas y Deberes

**Fecha de implementación:** 24 de diciembre de 2024

---

## 📊 Resumen

La **Fase 9** del sistema de gestión académica ha sido completada exitosamente. Esta fase implementa el sistema completo de gestión de tareas, incluyendo asignación, seguimiento y calificación.

### Tablas Implementadas

#### 1. **tareas** 
Tareas asignadas por docentes a sus estudiantes.

**Campos:**
- `id` - ID único
- `docente_id` (FK) - Docente que crea la tarea
- `materia_id` (FK) - Materia de la tarea
- `paralelo_id` (FK nullable) - Paralelo al que se asigna (opcional)
- `titulo` (VARCHAR 255) - Título de la tarea
- `descripcion` (TEXT nullable) - Descripción detallada
- `fecha_asignacion` (DATE) - Cuándo se asignó
- `fecha_entrega` (DATE) - Fecha límite de entrega
- `es_calificada` (BOOLEAN) - Si la tarea tiene calificación
- `puntaje_maximo` (DECIMAL 4,2 nullable) - Puntos máximos
- `timestamps`

**Índices:**
- `(docente_id, fecha_asignacion)` - Tareas por docente
- `(paralelo_id, fecha_entrega)` - Tareas por paralelo

#### 2. **archivos_tarea**
Archivos adjuntos a las tareas (materiales de apoyo).

**Campos:**
- `id` - ID único
- `tarea_id` (FK) - Tarea a la que pertenece
- `nombre_archivo` (VARCHAR 255) - Nombre del archivo
- `ruta_archivo` (VARCHAR 255) - Ruta de almacenamiento
- `tipo_mime` (VARCHAR 100 nullable) - Tipo MIME del archivo
- `tamanio` (INT nullable) - Tamaño en bytes
- `created_at` (TIMESTAMP)

#### 3. **tarea_estudiante**
Seguimiento individual del progreso de cada estudiante en las tareas.

**Campos:**
- `id` - ID único
- `tarea_id` (FK) - Tarea asignada
- `estudiante_id` (FK) - Estudiante
- `estado` (ENUM) - pendiente/completada/revisada
- `fecha_completada` (TIMESTAMP nullable) - Cuándo completó
- `calificacion` (DECIMAL 4,2 nullable) - Nota obtenida
- `comentarios_docente` (TEXT nullable) - Retroalimentación
- `fecha_revision` (TIMESTAMP nullable) - Cuándo se revisó
- `timestamps`

**Constraint único:** `(tarea_id, estudiante_id)`

---

## 🔗 Relaciones Implementadas

### Modelo Tarea
- `belongsTo(Docente)` - Docente que creó la tarea
- `belongsTo(Materia)` - Materia de la tarea
- `belongsTo(Paralelo)` - Paralelo (opcional)
- `hasMany(ArchivoTarea)` - Archivos adjuntos
- `hasMany(TareaEstudiante)` - Seguimiento por estudiante

**Scopes:**
- `proximasAVencer($dias)` - Tareas próximas a vencer
- `vencidas()` - Tareas ya vencidas
- `activas()` - Tareas no vencidas
- `deDocente($id)` - Tareas de un docente
- `deParalelo($id)` - Tareas de un paralelo

**Accessors:**
- `estaVencida` - Boolean si está vencida
- `diasRestantes` - Días hasta entrega

### Modelo ArchivoTarea
- `belongsTo(Tarea)` - Tarea a la que pertenece

**Accessors:**
- `tamanioFormateado` - Tamaño en formato legible (KB, MB, etc.)

### Modelo TareaEstudiante
- `belongsTo(Tarea)` - Tarea asignada
- `belongsTo(Estudiante)` - Estudiante

**Scopes:**
- `porEstado($estado)` - Filtrar por estado
- `pendientes()` - Solo pendientes
- `completadas()` - Solo completadas
- `revisadas()` - Solo revisadas
- `deEstudiante($id)` - Tareas de un estudiante

**Accessors:**
- `completadaATiempo` - Boolean si completó antes de la fecha límite

---

## 🔄 Actualizaciones en Modelos Existentes

### Docente
- ✅ Agregada relación `hasMany(Tarea)`

### Estudiante
- ✅ Agregada relación `hasMany(TareaEstudiante)`

### Materia
- ✅ Agregada relación `hasMany(Tarea)`

### Paralelo
- ✅ Agregada relación `hasMany(Tarea)`

---

## 📦 Seeders

### TareaSeeder
Genera datos de prueba realistas para el sistema de tareas:

**Características:**
- Crea 2-4 tareas por cada asignación docente-materia-paralelo
- Fechas de asignación en los últimos 30 días
- Plazos de entrega entre 3-14 días
- 70% de tareas son calificadas
- 0-2 archivos adjuntos por tarea
- Títulos y descripciones contextualizados por materia
- Asignación automática a estudiantes matriculados
- 80% de estudiantes completan las tareas
- 70% de tareas completadas están revisadas
- Calificaciones realistas (5.0 a 10.0)
- Comentarios según nivel de calificación

**Resultado:**
- ✅ 87 tareas creadas
- ✅ 75 archivos adjuntos
- ✅ 124 registros de seguimiento por estudiante

---

## 🎯 Casos de Uso

### 1. Crear Tarea
```php
// Docente asigna una nueva tarea
$tarea = Tarea::create([
    'docente_id' => $docente->id,
    'materia_id' => $materia->id,
    'paralelo_id' => $paralelo->id,
    'titulo' => 'Resolver ejercicios de álgebra',
    'descripcion' => 'Completar ejercicios 1-20 del libro',
    'fecha_asignacion' => now(),
    'fecha_entrega' => now()->addDays(7),
    'es_calificada' => true,
    'puntaje_maximo' => 10.00,
]);
```

### 2. Adjuntar Archivos a Tarea
```php
// Agregar material de apoyo
ArchivoTarea::create([
    'tarea_id' => $tarea->id,
    'nombre_archivo' => 'guia_ejercicios.pdf',
    'ruta_archivo' => Storage::put('tareas', $file),
    'tipo_mime' => $file->getMimeType(),
    'tamanio' => $file->getSize(),
]);
```

### 3. Estudiante Marca Tarea Como Completada
```php
// Estudiante completa la tarea
$tareaEstudiante = TareaEstudiante::where('tarea_id', $tarea->id)
    ->where('estudiante_id', $estudiante->id)
    ->first();

$tareaEstudiante->update([
    'estado' => 'completada',
    'fecha_completada' => now(),
]);
```

### 4. Docente Revisa y Califica
```php
// Docente revisa tarea completada
$tareaEstudiante->update([
    'estado' => 'revisada',
    'calificacion' => 9.5,
    'comentarios_docente' => 'Excelente trabajo, muy bien estructurado.',
    'fecha_revision' => now(),
]);
```

### 5. Consultar Tareas Pendientes de un Estudiante
```php
// Obtener tareas pendientes
$tareasPendientes = TareaEstudiante::deEstudiante($estudiante->id)
    ->pendientes()
    ->with(['tarea' => function($query) {
        $query->with(['materia', 'docente.user']);
    }])
    ->get();
```

### 6. Tareas Próximas a Vencer
```php
// Tareas que vencen en los próximos 3 días
$tareasUrgentes = Tarea::proximasAVencer(3)
    ->with(['materia', 'paralelo', 'docente.user'])
    ->get();
```

### 7. Reporte de Tareas de un Paralelo
```php
// Estadísticas de tareas por paralelo
$tareas = Tarea::deParalelo($paralelo->id)
    ->with(['tareaEstudiantes'])
    ->get();

foreach ($tareas as $tarea) {
    $total = $tarea->tareaEstudiantes->count();
    $completadas = $tarea->tareaEstudiantes->where('estado', '!=', 'pendiente')->count();
    $porcentaje = ($completadas / $total) * 100;
    
    echo "{$tarea->titulo}: {$porcentaje}% completadas\n";
}
```

### 8. Verificar si Tarea Está Vencida
```php
// Usar accessor para verificar
if ($tarea->esta_vencida) {
    echo "⚠️ Esta tarea está vencida";
}

// Días restantes
echo "Días restantes: {$tarea->dias_restantes}";
```

---

## 📈 Progreso del Proyecto

- **Fases Completadas:** 9/13 (69.2%)
- **Tablas Completadas:** 30/46 (65.2%)

---

## 🔜 Próximos Pasos

### Fase 10: Comunicación (4 tablas)
- `mensajes` - Mensajes entre usuarios
- `mensaje_adjuntos` - Archivos adjuntos a mensajes
- `mensaje_destinatarios` - Múltiples destinatarios
- `notificaciones` - Notificaciones del sistema

---

## 📝 Notas Técnicas

### Optimizaciones Implementadas
1. **Índices compuestos** para consultas frecuentes por docente y paralelo
2. **Scopes reutilizables** para filtrado común
3. **Eager loading** recomendado para evitar N+1 queries
4. **Accessors** para lógica de negocio común
5. **Constraint único** para evitar duplicados

### Validaciones Recomendadas
1. La fecha de entrega debe ser posterior a la de asignación
2. Solo tareas calificadas pueden tener puntaje_maximo
3. Solo tareas completadas pueden ser revisadas
4. La calificación no puede exceder el puntaje_maximo
5. Un estudiante solo puede tener un registro por tarea

### Flujo de Estados
```
Tarea Estudiante:
pendiente → completada → revisada
    ↑           ↓
    └───────────┘ (puede volver a pendiente)
```

---

## ✨ Características Destacadas

- ✅ Sistema completo de asignación de tareas
- ✅ Gestión de archivos adjuntos
- ✅ Seguimiento individual por estudiante
- ✅ Sistema de calificación flexible
- ✅ Retroalimentación docente
- ✅ Detección automática de tareas vencidas
- ✅ Cálculo de días restantes
- ✅ Validación de entrega a tiempo
- ✅ Scopes para reportes
- ✅ Datos de prueba contextualizados

---

**Estado:** ✅ **COMPLETADO**  
**Desarrollador:** GitHub Copilot  
**Framework:** Laravel 11  
**Base de datos:** MySQL/MariaDB

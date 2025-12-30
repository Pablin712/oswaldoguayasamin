# Mockup: Docente-Materia (Asignación de Docentes a Materias)

**Fecha:** 30/12/2025  
**Módulo:** Fase 5 - Asignaciones Académicas  
**Tipo:** Vista de asignación con filtros y tabla de materias

---

## 1. Propósito

Permitir asignar docentes a las materias de cada paralelo en un período académico específico. Este módulo conecta:
- **Docentes** (quien enseña)
- **Materias** (qué enseña)
- **Paralelos** (a quién enseña)
- **Período Académico** (cuándo enseña)

---

## 2. Estructura de Datos

### Arquitectura de Horarios (Sistema Real)

Para gestionar horarios reales y evitar conflictos, necesitamos **DOS tablas**:

#### Tabla 1: `docente_materia` (Asignación general)

```sql
CREATE TABLE docente_materia (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    docente_id BIGINT UNSIGNED NOT NULL,
    materia_id BIGINT UNSIGNED NOT NULL,
    paralelo_id BIGINT UNSIGNED NOT NULL,
    periodo_academico_id BIGINT UNSIGNED NOT NULL,
    rol VARCHAR(50) DEFAULT 'Principal',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE,
    FOREIGN KEY (paralelo_id) REFERENCES paralelos(id) ON DELETE CASCADE,
    FOREIGN KEY (periodo_academico_id) REFERENCES periodos_academicos(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_asignacion (docente_id, materia_id, paralelo_id, periodo_academico_id)
);
```

#### Tabla 2: `horarios` (Bloques horarios específicos)

```sql
CREATE TABLE horarios (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    docente_materia_id BIGINT UNSIGNED NOT NULL, -- Relación con asignación
    dia_semana ENUM('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado') NOT NULL,
    hora_inicio TIME NOT NULL, -- Ej: 08:00:00
    hora_fin TIME NOT NULL,    -- Ej: 09:00:00
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (docente_materia_id) REFERENCES docente_materia(id) ON DELETE CASCADE,
    
    -- Índice para búsquedas rápidas de conflictos
    INDEX idx_horario_busqueda (dia_semana, hora_inicio, hora_fin)
);
```

### Flujo de Datos

```
1. Asignar Docente a Materia → docente_materia
                                     ↓
2. Definir bloques horarios → horarios (múltiples registros)
                                     ↓
3. Validar conflictos → Verificar que el docente/aula no tenga otro horario al mismo tiempo
```

### Validaciones de Conflicto

**Conflicto de Docente:**
```sql
-- El mismo docente NO puede estar en dos lugares al mismo tiempo
SELECT * FROM horarios h1
JOIN docente_materia dm1 ON h1.docente_materia_id = dm1.id
WHERE dm1.docente_id = ? 
  AND h1.dia_semana = ?
  AND h1.hora_inicio < ? -- hora_fin del nuevo bloque
  AND h1.hora_fin > ?    -- hora_inicio del nuevo bloque
```

**Conflicto de Aula:**
```sql
-- La misma aula NO puede tener dos clases al mismo tiempo
SELECT * FROM horarios h1
JOIN docente_materia dm1 ON h1.docente_materia_id = dm1.id
JOIN paralelos p1 ON dm1.paralelo_id = p1.id
WHERE p1.aula_id = ?
  AND h1.dia_semana = ?
  AND h1.hora_inicio < ?
  AND h1.hora_fin > ?
```

**Conflicto de Paralelo:**
```sql
-- El mismo paralelo NO puede tener dos materias al mismo tiempo
SELECT * FROM horarios h1
JOIN docente_materia dm1 ON h1.docente_materia_id = dm1.id
WHERE dm1.paralelo_id = ?
  AND h1.dia_semana = ?
  AND h1.hora_inicio < ?
  AND h1.hora_fin > ?
```

### Validación de Negocio

#### Regla 1: Múltiples Docentes por Materia

Una materia en un paralelo puede tener **MÚLTIPLES docentes asignados**, pero el mismo docente no puede estar asignado dos veces.

```
✅ Ejemplos válidos:
- Matemáticas en 1ro A → Juan Pérez (Docente principal) ✅
- Matemáticas en 1ro A → María López (Docente auxiliar) ✅
- Matemáticas en 1ro A → Carlos Ruiz (Practicante) ✅

❌ Ejemplo inválido:
- Matemáticas en 1ro A → Juan Pérez ✅
- Matemáticas en 1ro A → Juan Pérez ❌ (duplicado)
```

#### Regla 2: Sin Conflictos de Horario

**A. Docente no puede estar en dos lugares al mismo tiempo:**
```
❌ Conflicto de Docente:
- Lunes 08:00-09:00 → Juan enseña Matemáticas en 1ro A
- Lunes 08:30-09:30 → Juan enseña Física en 2do B ❌ CONFLICTO
```

**B. Aula no puede tener dos clases simultáneas:**
```
❌ Conflicto de Aula:
- Lunes 08:00-09:00 → Matemáticas 1ro A en Aula 101
- Lunes 08:00-09:00 → Lengua 2do B en Aula 101 ❌ CONFLICTO
```

**C. Paralelo no puede tener dos materias al mismo tiempo:**
```
❌ Conflicto de Paralelo:
- Lunes 08:00-09:00 → 1ro A tiene Matemáticas
- Lunes 08:00-09:00 → 1ro A tiene Lengua ❌ CONFLICTO
```

#### Regla 3: Carga Horaria Máxima

- Docente: Máximo 20-25 horas semanales
- Paralelo: Máximo 35-40 horas semanales
- Advertir si se acerca al límite

---

## 3. Diseño de la Vista Principal

### Layout: `docente-materia/index.blade.php`

```
┌─────────────────────────────────────────────────────────────────┐
│  Asignación de Docentes                        [Usuario ▾]      │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────── FILTROS ─────────────────────────────┐   │
│  │                                                            │   │
│  │  Período Académico *      Curso *           Paralelo *     │   │
│  │  [2024-2025        ▾]   [1ro de Básica▾]  [Paralelo A ▾] │   │
│  │                                                            │   │
│  │                                           [🔍 Buscar]     │   │
│  └────────────────────────────────────────────────────────────┘   │
│                                                                   │
│  ┌────────────────── MATERIAS DEL PARALELO ─────────────────┐   │
│  │                                                            │   │
│  │  📚 1ro de Básica - Paralelo A                            │   │
│  │  📅 Período: 2024-2025                                    │   │
│  │                                                            │   │
│  │  ┌──────────────────────────────────────────────────────┐│   │
│  │  │ Materia            │ Horas │ Docentes Asignados│ Acc ││   │
│  │  ├──────────────────────────────────────────────────────┤│   │
│  │  │ 📘 Matemáticas     │  5h   │ • Juan Pérez      │[➕]  ││   │
│  │  │ 🎨 #FF5733         │       │   MAT-001         │[🗑]  ││   │
│  │  │                    │       │ • María López     │[🗑]  ││   │
│  │  │                    │       │   MAT-002 (Aux.)  │     ││   │
│  │  ├──────────────────────────────────────────────────────┤│   │
│  │  │ 📗 Lengua y Lit.   │  6h   │ • Ana García      │[➕]  ││   │
│  │  │ 🎨 #33C3FF         │       │   LEN-001         │[🗑]  ││   │
│  │  ├──────────────────────────────────────────────────────┤│   │
│  │  │ 📙 Ciencias Nat.   │  4h   │ Sin asignar       │[➕]  ││   │
│  │  │ 🎨 #4CAF50         │       │ -                 │     ││   │
│  │  ├──────────────────────────────────────────────────────┤│   │
│  │  │ 📕 Estudios Soc.   │  4h   │ • Carlos Ramírez  │[➕]  ││   │
│  │  │ 🎨 #FFC107         │       │   SOC-003         │[🗑]  ││   │
│  │  │                    │       │ • Luis Torres     │[🗑]  ││   │
│  │  │                    │       │   SOC-004 (Pract.)│     ││   │
│  │  └──────────────────────────────────────────────────────┘│   │
│  │                                                            │   │
│  │  📊 Total horas asignadas: 15h / 19h (78.95%)            │   │
│  │  👥 Docentes involucrados: 3                              │   │
│  │                                                            │   │
│  └────────────────────────────────────────────────────────────┘   │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

### Estados de la Materia

1. **Con Docente(s) Asignado(s):**
   - Lista de todos los docentes asignados
   - Cada docente muestra: nombre, código, rol (si aplica: Auxiliar, Practicante, etc.)
   - Botones por docente: Eliminar asignación individual (🗑)
   - Botón general: Agregar otro docente (➕ verde)

2. **Sin Docentes:**
   - Badge gris: "Sin asignar"
   - Texto: "-"
   - Botón: Asignar primer docente (➕ verde)

3. **Roles de Docentes (opcional):**
   - Principal/Titul Docente

```
┌─────────────────────────────────────────────────────────┐
│  ➕ Asignar Docente a Materia              [✖]          │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  Materia: 📙 Ciencias Naturales                         │
│  Paralelo: 1ro de Básica - Paralelo A                   │
│  Horas semanales: 4 horas                               │
│                                                          │
│  ℹ️ Docentes ya asignados:                              │
│  • Juan Pérez (CIE-001) - Principal                     │
│                                                          │
│  ┌────────────────────────────────────────────────────┐ │
│  │ Docente *                                          │ │
│  │ [🔍 Buscar docente...                           ▾] │ │
│  │                                                    │ │
│  │ Sugerencias (docentes con especialidad similar):  │ │
│  │  • Ana García - Biología (10h/20h) ⭐ Disponible  │ │
│  │  • María López - Ciencias (18h/20h) ⚠️ Alta carga │ │
│  │  ✖ Juan Pérez - Ya asignado a esta materia       │ │
│  └────────────────────────────────────────────────────┘ │
│                                                          │
│  ┌────────────────────────────────────────────────────┐ │
│  │ Rol del docente (opcional)                         │ │
│  │ [Principal ▾]                                      │ │
│  │ Opciones: Principal, Auxiliar, Practicante, etc.  │ │
│  └────────────────────────────────────────────────────┘ │
│                                                          │
│  ℹ️ Carga del docente seleccionado:                     │
│  ┌────────────────────────────────────────────────────┐ │
│  │ Docente: Ana García (BIO-002)                      │ │
│  │ Horas actuales: 10h                                │ │
│  │ Horas después de asignar: 14h / 20h (70%)          │ │
│  │ ✅ Carga adecuada                                 │ │
│  └────────────────────────────────────────────────────┘ │
│                                                          │
│  ℹ️ Carga actual del docente seleccionado:              │
│  ┌────────────────────────────────────────────────────┐ │
│  │ Docente: Juan Pérez (MAT-001)                      │ │
│  │ Horas actuales: 15h                                │ │
│  │ Horas después de asignar: 19h / 20h (95%)          │ │
│  │ ⚠️ El docente estará cerca del límite de carga    │ │
│  └────────────────────────────────────────────────────┘ │
│                                                          │
│                        [Cancelar]  [Asignar Docente]    │
└─────────────────────────────────────────────────────────┘
```

### Características del Modal

1. **Searchable Select con Docentes:**
   - Buscar por nombre o código
   - Mostrar especialidad del docente
   - Mostrar carga horaria actual
   
2. **Información Contextual:**
   - Materia y paralelo (read-only)
   - Horas de la materia
   - Carga actual del docente
   - Advertencias si supera límite

3. **Validaciones:**
   - Docente requerido
   - No duplicar asignación
   - Advertir si docente supera 20 horas

---

## 5. Modal: Eliminar Asignación

```
┌─────────────────────────────────────────────────────────┐
│  ⚠️ Eliminar Asignación                      [✖]        │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ¿Está seguro que desea eliminar esta asignación?       │
│                                                          │
│  Materia: 📘 Matemáticas                                │
│  Docente: Juan Pérez (MAT-001)                          │
│  Rol: Principal                                         │
│  Paralelo: 1ro de Básica - Paralelo A                   │
│  Horas: 5 horas semanales                               │
│                                                          │
│  ℹ️ Otros docentes asignados a esta materia:            │
│  • María López (MAT-002) - Auxiliar                     │
│                                                          │
│  ⚠️ Esta acción:                                         │
│  • Removerá a Juan Pérez de esta materia                │
│  • Liberará 5 horas de carga del docente                │
│  • No afectará calificaciones ya registradas            │
│  • La materia seguirá teniendo otros docentes           │
│                                                          │
│                          [Cancelar]  [🗑 Eliminar]       │
└─────────────────────────────────────────────────────────┘
```

---

## 6. Estadísticas y Resumen

### Panel Lateral (Opcional)

```
┌──────────── RESUMEN ────────────┐
│                                  │
│  📊 Estadísticas                 │
│                                  │
│  Total materias: 8               │
│  Materias asignadas: 5 (62.5%)  │
│  Materias sin asignar: 3         │
│                                  │
│  👥 Docentes involucrados        │
│                                  │
│  Juan Pérez      [15h/20h] 75%  │
│  ████████████▒▒▒▒▒▒              │
│                                  │
│  María López     [18h/20h] 90%  │
│  ██████████████▒▒▒               │
│                                  │
│  Carlos Ramírez  [12h/20h] 60%  │
│  ██████████▒▒▒▒▒▒▒▒▒             │
│                                  │
└──────────────────────────────────┘
```

---

## 7. Flujo de Trabajo

### Escenario: Asignar Docente a Materia

1. **Administrador selecciona filtros:**
   - Período: 2024-2025
   - Curso: 1ro de Básica
   - Paralelo: A

2. **Sistema muestra:**
   - Lista de materias del curso (de tabla `curso_materia`)
   - Estado de asignación de cada materia
   - Docentes ya asignados

3. **Administrador hace clic en "Asignar" (➕):**
   - Se abre modal
   - Select con todos los docentes activos
   - Muestra sugerencias (docentes con especialidad similar)

4. **Administrador selecciona docente:**
   - Sistema calcula carga horaria actual
   - Muestra advertencia si supera límite
   - Permite confirmar asignación

5. **Sistema guarda:**
   - Crea registro en `docente_materia`
   - Actualiza vista con docente asignado
   - Muestra mensaje de éxito

---

## 8. Controlador: `DocenteMateriaController`

### Métodos

```php
class DocenteMateriaController extends Controller
{
    // GET /asignaciones/docente-materia
    public function index(Request $request)
    {
        // Obtener filtros
        $periodoId = $request->get('periodo_id', PeriodoAcademico::activo()->id);
        $cursoId = $request->get('curso_id');
        $paraleloId = $request->get('paralelo_id');
        
        // Si hay paralelo seleccionado
        if ($paraleloId) {
            $paralelo = Paralelo::with(['curso', 'periodo'])->findOrFail($paraleloId);
            
            // Obtener materias del curso
            $materias = CursoMateria::where('curso_id', $paralelo->curso_id)
                ->where('periodo_academico_id', $periodoId)
                ->with('materia')
                ->get();
            
            // Para cada materia, obtener asignación de docente
            $asignaciones = DocenteMateria::where('paralelo_id', $paraleloId)
                ->where('periodo_academico_id', $periodoId)
                ->with('docente.user')
                ->get()
                ->keyBy('materia_id');
        }
        
        return view('academico.asignaciones.docente-materia.index', [
            'periodos' => PeriodoAcademico::all(),
            'cursos' => Curso::all(),
            'paralelos' => $cursoId ? Paralelo::where('curso_id', $cursoId)->get() : collect(),
            'materias' => $materias ?? collect(),
            'asignaciones' => $asignaciones ?? collect(),
            'paralelo' => $paralelo ?? null,
            'docentes' => Docente::with('user')->where('estado', 'activo')->get(),
            'periodoId' => $periodoId,
            'cursoId' => $cursoId,
            'paraleloId' => $paraleloId,
        ]);
    }el MISMO docente no esté asignado dos veces
        $existente = DocenteMateria::where('docente_id', $request->docente_id)
            ->where('materia_id', $request->materia_id)
            ->where('paralelo_id', $request->paralelo_id)
            ->where('periodo_academico_id', $request->periodo_academico_id)
            ->first();
        
        if ($existente) {
            return back()->with('error', 'Este docente ya está asignado a esta materia
            ->where('periodo_academico_id', $request->periodo_academico_id)
            ->first();
        
        if ($existente) {
            return back()->with('error', 'Esta materia ya tiene un docente asignado.');
        }
        
        DocenteMateria::create($request->validated());
        
        return back()->with('success', 'Docente asignado correctamente.');
    }
    
    // PUT /asignaciones/docente-materia/{id}
    public function update(DocenteMateriaRequest $request, $id)
    {
        $asignacion = DocenteMateria::findOrFail($id);
        $asignacion->update(['docente_id' => $request->docente_id]);
        
        return back()->with('success', 'Docente actualizado correctamente.');
    }
    
    // DELETE /asignaciones/docente-materia/{id}
    public function destroy($id)
    {
        $asignacion = DocenteMateria::findOrFail($id);
        $asignacion->delete();
        
        return back()->with('success', 'Asignación eliminada correctamente.');
    }
    
    // GET /asignaciones/docente-materia/carga-docente/{docenteId}
    public function cargaDocente($docenteId, $periodoId)
    {
        $carga = DocenteMateria::where('docente_id', $docenteId)
            ->where('periodo_academico_id', $periodoId)
            ->with(['materia', 'paralelo'])
            ->get();
        
        $totalHoras = $carga->sum(function($asignacion) {
            return $asignacion->materia->horas_semanales ?? 0;
        });
        
        return response()->json([
            'total_horas' => $totalHoras,
            'asignaciones' => $carga,
        ]);
    }
}
```

---

## 12. Form Request: `DocenteMateriaRequest`

```php
class DocenteMateriaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'paralelo_id' => 'required|exists:paralelos,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            'rol' => 'nullable|string|in:Principal,Auxiliar,Practicante,Suplente,Co-teaching',
            
            // Validación de horarios
            'horarios' => 'required|array|min:1',
            'horarios.*.dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
            'horarios.*.hora_inicio' => 'required|date_format:H:i',
            'horarios.*.hora_fin' => 'required|date_format:H:i|after:horarios.*.hora_inicio',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que el mismo docente no se asigne dos veces
            if ($this->isMethod('POST')) {
                $existe = DocenteMateria::where('docente_id', $this->docente_id)
                    ->where('materia_id', $this->materia_id)
                    ->where('paralelo_id', $this->paralelo_id)
                    ->where('periodo_academico_id', $this->periodo_academico_id)
                    ->exists();
                
                if ($existe) {
                    $validator->errors()->add('docente_id', 'Este docente ya está asignado a esta materia.');
                }
            }
            
            // Validar conflictos de horario
            foreach ($this->horarios ?? [] as $index => $horario) {
                $conflicto = $this->verificarConflictoHorario(
                    $this->docente_id,
                    $this->paralelo_id,
                    $horario['dia_semana'],
                    $horario['hora_inicio'],
                    $horario['hora_fin']
                );
                
                if ($conflicto) {
                    $validator->errors()->add(
                        "horarios.{$index}",
                        "Conflicto: {$conflicto}"
                    );
                }
            }
        });
    }
    
    private function verificarConflictoHorario($docenteId, $paraleloId, $dia, $horaInicio, $horaFin)
    {
        // Conflicto de docente
        $conflictoDocente = Horario::whereHas('docenteMateria', function($q) use ($docenteId) {
            $q->where('docente_id', $docenteId);
        })
        ->where('dia_semana', $dia)
        ->where('hora_inicio', '<', $horaFin)
        ->where('hora_fin', '>', $horaInicio)
        ->with('docenteMateria.materia')
        ->first();
        
        if ($conflictoDocente) {
            return "El docente ya tiene {$conflictoDocente->docenteMateria->materia->nombre} en este horario";
        }
        
        // Conflicto de paralelo
        $conflictoParalelo = Horario::whereHas('docenteMateria', function($q) use ($paraleloId) {
            $q->where('paralelo_id', $paraleloId);
        })
        ->where('dia_semana', $dia)
        ->where('hora_inicio', '<', $horaFin)
        ->where('hora_fin', '>', $horaInicio)
        ->with('docenteMateria.materia')
        ->first();
        
        if ($conflictoParalelo) {
            return "El paralelo ya tiene {$conflictoParalelo->docenteMateria->materia->nombre} en este horario";
        }
        
        return null;
    }
}
```

---

## 10. Modelo: `Horario`

```php
class Horario extends Model
{
    protected $table = 'horarios';
    
    protected $fillable = [
        'docente_materia_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];
    
    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
    ];
    
    // Relaciones
    public function docenteMateria()
    {
        return $this->belongsTo(DocenteMateria::class);
    }
    
    // Scopes
    public function scopeDelDia($query, $dia)
    {
        return $query->where('dia_semana', $dia);
    }
    
    public function scopeEnRango($query, $horaInicio, $horaFin)
    {
        return $query->where('hora_inicio', '<', $horaFin)
                     ->where('hora_fin', '>', $horaInicio);
    }
    
    // Helper: Verificar si hay traslape con otro horario
    public function traslapaConHorario($dia, $horaInicio, $horaFin)
    {
        return $this->dia_semana === $dia
            && $this->hora_inicio < $horaFin
            && $this->hora_fin > $horaInicio;
    }
}
```

## 11. Modelo: `DocenteMateria` (Actualizado)

```php
class DocenteMateria extends Model
{
    protected $table = 'docente_materia';
    
    protected $fillable = [
        'docente_id',
        'materia_id',
        'rol',
        'paralelo_id',
        'periodo_academico_id',
    ];
    
    // Relaciones
    public function docente()
    3. Migraciones

### Migration: `create_docente_materia_table.php`

```php
Schema::create('docente_materia', function (Blueprint $table) {
    $table->id();
    $table->foreignId('docente_id')->constrained()->onDelete('cascade');
    $table->foreignId('materia_id')->constrained()->onDelete('cascade');
    $table->foreignId('paralelo_id')->constrained()->onDelete('cascade');
    $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
    $table->string('rol', 50)->default('Principal');
    $table->timestamps();
    
    $table->unique(['docente_id', 'materia_id', 'paralelo_id', 'periodo_academico_id'], 'unique_asignacion');
});
```

### Migration: `create_horarios_table.php`

```php
Schema::create('horarios', function (Blueprint $table) {
    $table->id();
    $table->foreignId('docente_materia_id')->constrained('docente_materia')->onDelete('cascade');
    $table->enum('dia_semana', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']);
    $table->time('hora_inicio');
    $table->time('hora_fin');
    $table->timestamps();
    
    $table->index(['dia_semana', 'hora_inicio', 'hora_fin'], 'idx_horario_busqueda');
});
```
        return $this->belongsTo(Docente::class);
    }
    
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
    
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
    
    public function periodoAcademico()
    {
        return $this->belongsTo(PeriodoAcademico::class);
    }
    
    // Nueva relación
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    
    // Helper: Calcular total de horas asignadas
    public function totalHorasAsignadas()
    {
        return $this->horarios->sum(function($horario) {
            $inicio = Carbon::parse($horario->hora_inicio);
            $fin = Carbon::parse($horario->hora_fin);
            return $inicio->diffInHours($fin);
        });
    }
    
    // Scopes
    public function scopeDelPeriodo($query, $periodoId)
    {
        return $query->where('periodo_academico_id', $periodoId);
    }
    
    public function scopeDelParalelo($query, $paraleloId)
    {
        return $query->where('paralelo_id', $paraleloId);
    }
    
    public function scopeDelDocente($query, $docenteId)
    {
        return $query->where('docente_id', $docenteId);
    }
}
```

---

## 11. Permisos

```php
// RoleSeeder.php
Permission::create(['name' => 'gestionar asignaciones docentes']);
Permission::create(['name' => 'ver asignaciones docentes']);
Permission::create(['name' => 'crear asignaciones docentes']);
Permission::create(['name' => 'editar asignaciones docentes']);
Permission::create(['name' => 'eliminar asignaciones docentes']);
Permission::create(['name' => 'generar reporte asignaciones docentes']);
```

---

## 12. Rutas

```php
// routes/web.php
Route::prefix('asignaciones')->group(function () {
    Route::resource('docente-materia', DocenteMateriaController::class)
        ->except(['create', 'edit', 'show'])
        ->names('docente-materia');
    
    Route::get('docente-materia/carga-docente/{docente}/{periodo}', 
        [DocenteMateriaController::class, 'cargaDocente'])
        ->name('docente-materia.carga-docente');
});
```

---

## 13. Características Especiales

### 🔍 Filtros Dependientes
- Al seleccionar curso, se cargan paralelos de ese curso
- Al seleccionar paralelo, se cargan materias del curso

### 📊 Cálculo de Carga Docente
- Total de horas asignadas al docente
- Porcentaje de carga (máximo 20 horas)
- Advertencias si supera límite

### 🎨 Colores de Materias
- Cada materia mantiene su color (de tabla `materias`)
- **Permitir múltiples docentes** por materia/paralelo
- **No duplicar:** El mismo docente no puede asignarse dos veces a la misma materia/paralelo
- Verificar docente activo
- Verificar materia existe en curso
- Advertir sobrecarga docente (>20h)
- Excluir del select docentes ya asignados
- Verificar docente activo
- Verificar materia existe en curso
- Advertir sobrecarga docente

### 🔔 Notificaciones
- Success: "Docente asignado correctamente"
- Error: "Esta materia ya tiene un docente asignado"
- Warning: "El docente superará el límite de 20 horas"

---

## 14. Consideraciones Técnicas

### Consultas Optimizadas

```php
// Eager loading para evitar N+1
$materias = CursoMateria::with(['materia', 'asignacionDocente.docente.user'])
    ->where('curso_id', $cursoId)
    ->where('periodo_academico_id', $periodoId)
    ->get();
```

### Cálculo de Horas

```php
// Obtener carga total de un docente
$cargaHoras = DocenteMateria::where('docente_id', $docenteId)
    ->where('periodo_academico_id', $periodoId)
    ->with('materia')
    ->get()
    ->sum(function($asignacion) {
        // Obtener horas desde curso_materia
        $cursoMateria = CursoMateria::where('materia_id', $asignacion->materia_id)
            ->where('curso_id', $asignacion->paralelo->curso_id)
            ->first();
        
        return $cursoMateria->horas_semanales ?? 0;
    });
```

---

## 15. Resumen

✅ **Vista principal:** Filtros + Tabla de materias con estado de asignación  
✅ **Modal asignar:** Select de docentes + Cálculo de carga  
✅ **Modal eliminar:** Confirmación con advertencias  
✅ **Validaciones:** No duplicar, límite de horas  
✅ **Estadísticas:** Carga docente, materias asignadas  
✅ **Searchable-select:** En todos los filtros y selects  

**Próximo paso:** Aprobar mockup e implementar CRUD completo.

# 📐 Mockup: Paralelos - Vista de Cards

**Fecha:** 29 de diciembre de 2025  
**Módulo:** Paralelos  
**Tipo de vista:** Cards agrupados por curso (NO tabla estándar)

---

## 🎨 Diseño Propuesto

### Vista Principal: index.blade.php

```
┌──────────────────────────────────────────────────────────────────────────┐
│  PARALELOS                                    [+ Nuevo Paralelo]          │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                            │
│  [Filtros]                                                                │
│  Curso: [Todos ▼]  Período: [2024-2025 ▼]  [Buscar]                     │
│                                                                            │
│  ┌─────────────────────────────────────────────────────────────────┐     │
│  │ 📚 1RO DE BÁSICA                                    [+ Paralelo] │     │
│  ├─────────────────────────────────────────────────────────────────┤     │
│  │                                                                   │     │
│  │  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐             │     │
│  │  │ Paralelo A  │  │ Paralelo B  │  │ Paralelo C  │             │     │
│  │  ├─────────────┤  ├─────────────┤  ├─────────────┤             │     │
│  │  │ 🏫 Aula 101 │  │ 🏫 Aula 102 │  │ 🏫 Aula 103 │             │     │
│  │  │             │  │             │  │             │             │     │
│  │  │ 👥 28/30    │  │ 👥 30/30    │  │ 👥 25/30    │             │     │
│  │  │ estudiantes │  │ estudiantes │  │ estudiantes │             │     │
│  │  │             │  │             │  │             │             │     │
│  │  │ [Ver] [✏️]  │  │ [Ver] [✏️]  │  │ [Ver] [✏️]  │             │     │
│  │  │     [🗑️]    │  │     [🗑️]    │  │     [🗑️]    │             │     │
│  │  └─────────────┘  └─────────────┘  └─────────────┘             │     │
│  │                                                                   │     │
│  └─────────────────────────────────────────────────────────────────┘     │
│                                                                            │
│  ┌─────────────────────────────────────────────────────────────────┐     │
│  │ 📚 2DO DE BÁSICA                                    [+ Paralelo] │     │
│  ├─────────────────────────────────────────────────────────────────┤     │
│  │                                                                   │     │
│  │  ┌─────────────┐  ┌─────────────┐                               │     │
│  │  │ Paralelo A  │  │ Paralelo B  │                               │     │
│  │  ├─────────────┤  ├─────────────┤                               │     │
│  │  │ 🏫 Aula 201 │  │ 🏫 Aula 202 │                               │     │
│  │  │             │  │             │                               │     │
│  │  │ 👥 27/30    │  │ 👥 29/30    │                               │     │
│  │  │ estudiantes │  │ estudiantes │                               │     │
│  │  │             │  │             │                               │     │
│  │  │ [Ver] [✏️]  │  │ [Ver] [✏️]  │                               │     │
│  │  │     [🗑️]    │  │     [🗑️]    │                               │     │
│  │  └─────────────┘  └─────────────┘                               │     │
│  │                                                                   │     │
│  └─────────────────────────────────────────────────────────────────┘     │
│                                                                            │
│  [...más cursos...]                                                       │
│                                                                            │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 📋 Especificaciones Técnicas

### Estructura de Datos por Card

**Cada card de paralelo muestra:**
- Nombre del paralelo (A, B, C, etc.)
- 🏫 Aula asignada
- 👥 Estudiantes matriculados / Cupo máximo
- Badge de disponibilidad:
  - 🟢 Verde: < 90% capacidad
  - 🟡 Amarillo: 90-99% capacidad
  - 🔴 Rojo: 100% capacidad
- Botones de acción (con permisos)

### Agrupación por Curso

**Cada sección de curso contiene:**
- Título con ícono 📚 y nombre del curso
- Botón "[+ Paralelo]" (solo si tiene permisos)
- Grid responsive con todos los paralelos del curso

### Filtros Superiores

**Controles de filtrado:**
- Select de Curso (todos los cursos)
- Select de Período Académico (activos)
- Botón buscar para aplicar filtros

---

## 🔐 Sistema de Permisos

### Permisos requeridos:
```php
'gestionar paralelos'
'ver paralelos'
'crear paralelos'
'editar paralelos'
'eliminar paralelos'
'generar reporte paralelos'
'generar reportes'
```

### Uso en vistas:
```blade
{{-- Botón crear paralelo --}}
@canany(['gestionar paralelos', 'crear paralelos'])
    <button>+ Nuevo Paralelo</button>
@endcanany

{{-- Botón ver detalles --}}
@canany(['gestionar paralelos', 'ver paralelos'])
    <a href="{{ route('paralelos.show', $paralelo) }}">Ver</a>
@endcanany

{{-- Botón editar --}}
@canany(['gestionar paralelos', 'editar paralelos'])
    <button @click="open-edit-modal">✏️</button>
@endcanany

{{-- Botón eliminar --}}
@canany(['gestionar paralelos', 'eliminar paralelos'])
    <button @click="open-delete-modal">🗑️</button>
@endcanany
```

---

## 📄 Vistas Requeridas

### 1. index.blade.php
- Vista principal con cards agrupados por curso
- Filtros por curso y período académico
- Grid responsive (3-4 cards por fila en desktop)
- Botón "+ Nuevo Paralelo" global
- Botón "+ Paralelo" por cada curso

### 2. show.blade.php
- Detalles completos del paralelo
- Sección: Información General
  - Curso
  - Nombre del paralelo
  - Aula asignada
  - Cupo máximo
  - Período académico
- Sección: Estadísticas
  - Total estudiantes matriculados
  - Porcentaje de ocupación
  - Total docentes asignados
- Sección: Lista de Estudiantes Matriculados
  - Tabla con estudiantes del paralelo
  - Link a perfil de cada estudiante
- Sección: Materias y Docentes Asignados
  - Tabla con materias del paralelo
  - Docente asignado por materia
  - Link a horarios
- Botones de acción (Editar, Eliminar)

### 3. create.blade.php (Modal)
```blade
<x-modal name="create-paralelo-modal" maxWidth="lg">
    Formulario con campos:
    - Curso (select)
    - Nombre (input: A, B, C, etc.)
    - Aula (select de aulas disponibles)
    - Cupo máximo (number)
    - Período académico (select, default: actual)
</x-modal>
```

### 4. edit.blade.php (Modal)
```blade
<x-modal name="edit-paralelo-modal" maxWidth="lg">
    Mismo formulario que create, con datos prellenados
</x-modal>
```

### 5. delete.blade.php (Modal)
```blade
<x-modal name="delete-paralelo-modal">
    Confirmación de eliminación
    Advertencia si tiene estudiantes matriculados
</x-modal>
```

---

## 🎨 Estilos y Componentes

### Cards de Paralelos
```html
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
    <h4 class="font-semibold text-lg mb-2">Paralelo A</h4>
    <div class="space-y-2 text-sm text-gray-600">
        <div class="flex items-center gap-2">
            <span>🏫</span>
            <span>Aula 101</span>
        </div>
        <div class="flex items-center gap-2">
            <span>👥</span>
            <span>28/30 estudiantes</span>
        </div>
        <div class="mt-2">
            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                Disponible
            </span>
        </div>
    </div>
    <div class="flex gap-2 mt-4">
        <!-- Botones de acción -->
    </div>
</div>
```

### Sección de Curso
```html
<div class="bg-gray-50 rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">
            📚 1RO DE BÁSICA
        </h3>
        <button class="btn-primary">+ Paralelo</button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- Cards de paralelos -->
    </div>
</div>
```

---

## 🔄 Lógica de Negocio

### Validaciones en el Controller

1. **Al crear:**
   - El nombre del paralelo debe ser único dentro del mismo curso y período
   - El aula seleccionada no debe estar asignada a otro paralelo en el mismo horario
   - El cupo máximo debe ser mayor a 0

2. **Al editar:**
   - Si se reduce el cupo máximo, no puede ser menor al número de estudiantes actuales
   - Si se cambia el aula, verificar disponibilidad

3. **Al eliminar:**
   - Advertir si tiene estudiantes matriculados
   - Advertir si tiene docentes asignados
   - Opción: eliminar con cascada o impedir eliminación

### Cálculos Dinámicos

```php
// En el modelo Paralelo
public function getEstudiantesMatriculadosAttribute()
{
    return $this->matriculas()->where('estado', 'activa')->count();
}

public function getPorcentajeOcupacionAttribute()
{
    return ($this->estudiantes_matriculados / $this->cupo_maximo) * 100;
}

public function getDisponibilidadAttribute()
{
    $porcentaje = $this->porcentaje_ocupacion;
    if ($porcentaje < 90) return 'disponible';
    if ($porcentaje < 100) return 'limitado';
    return 'completo';
}
```

---

## 📊 Datos de Prueba (Seeder)

El seeder ya existe, pero asegurarse que incluya:
- Paralelos A, B, C para cursos de Básica (1ro a 10mo)
- Paralelos A, B para cursos de Bachillerato (1ro a 3ro)
- Asignación de aulas variadas
- Cupo máximo de 30-35 estudiantes

---

## ✅ Checklist de Implementación

- [ ] Actualizar RoleSeeder con permisos de paralelos
- [ ] Crear ParaleloController con métodos CRUD
- [ ] Crear ParaleloRequest para validaciones
- [ ] Crear vista index.blade.php (cards agrupados)
- [ ] Crear vista show.blade.php (detalles completos)
- [ ] Crear modal create.blade.php
- [ ] Crear modal edit.blade.php
- [ ] Crear modal delete.blade.php
- [ ] Agregar rutas en web.php
- [ ] Probar con datos de prueba
- [ ] Actualizar documentación

---

**¿Este diseño es apropiado o prefieres alguna modificación antes de implementar?**

# 📐 Mockup: Curso-Materia (Asignación de Materias a Cursos)

**Módulo:** Asignación Académica - Materias por Curso  
**Fecha:** 29 de diciembre de 2025  
**Tipo de Vista:** Interfaz de asignación con tabla editable

---

## 🎯 Objetivo

Permitir asignar materias a cada curso en un período académico específico, definiendo las horas semanales para cada materia. Esta asignación determina qué materias se imparten en cada grado.

---

## 📊 Estructura de la Vista Principal

### Layout General

```
┌─────────────────────────────────────────────────────────────┐
│ 📚 Asignación de Materias a Cursos                          │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  [Filtro: Período Académico ▼] [Filtro: Curso ▼] [Buscar]  │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Curso: 1ro de Básica │ Período: 2024-2025                 │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Materias Asignadas (8)              [+ Asignar Materia]│ │
│  ├────────────────────────────────────────────────────────┤ │
│  │                                                         │ │
│  │  ┌─────────────────────────────────────────────────┐  │ │
│  │  │ 🟦 Matemáticas                                  │  │ │
│  │  │ Horas semanales: 5    [🖊 Editar] [🗑 Eliminar] │  │ │
│  │  └─────────────────────────────────────────────────┘  │ │
│  │                                                         │ │
│  │  ┌─────────────────────────────────────────────────┐  │ │
│  │  │ 🟩 Lengua y Literatura                          │  │ │
│  │  │ Horas semanales: 5    [🖊 Editar] [🗑 Eliminar] │  │ │
│  │  └─────────────────────────────────────────────────┘  │ │
│  │                                                         │ │
│  │  ┌─────────────────────────────────────────────────┐  │ │
│  │  │ 🟨 Ciencias Naturales                           │  │ │
│  │  │ Horas semanales: 4    [🖊 Editar] [🗑 Eliminar] │  │ │
│  │  └─────────────────────────────────────────────────┘  │ │
│  │                                                         │ │
│  │  ┌─────────────────────────────────────────────────┐  │ │
│  │  │ 🟧 Estudios Sociales                            │  │ │
│  │  │ Horas semanales: 3    [🖊 Editar] [🗑 Eliminar] │  │ │
│  │  └─────────────────────────────────────────────────┘  │ │
│  │                                                         │ │
│  │  ┌─────────────────────────────────────────────────┐  │ │
│  │  │ 🟥 Educación Física                             │  │ │
│  │  │ Horas semanales: 2    [🖊 Editar] [🗑 Eliminar] │  │ │
│  │  └─────────────────────────────────────────────────┘  │ │
│  │                                                         │ │
│  │  ... (más materias)                                    │ │
│  │                                                         │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                              │
│  📊 Total de horas semanales: 30 horas                      │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## 🎨 Elementos de Diseño

### 1. Encabezado y Filtros

**Elementos:**
- Título del módulo: "📚 Asignación de Materias a Cursos"
- Filtro de Período Académico (select con períodos activos)
- Filtro de Curso (select con todos los cursos)
- Botón "Buscar" para aplicar filtros

**Comportamiento:**
- Al cambiar filtros, se carga la información del curso seleccionado
- Si no hay curso seleccionado, mostrar mensaje: "Seleccione un curso para gestionar sus materias"

### 2. Información del Curso

**Elementos:**
- Curso actual seleccionado (nombre completo)
- Período académico actual
- Contador de materias asignadas
- Botón "Asignar Materia" (verde, con icono +)

### 3. Cards de Materias Asignadas

**Cada card contiene:**
- Color de la materia (badge/border con color definido en base de datos)
- Nombre de la materia
- Horas semanales asignadas (número editable)
- Botón "Editar" (icono lápiz)
- Botón "Eliminar" (icono papelera, rojo)

**Diseño del card:**
```
┌─────────────────────────────────────────────────┐
│ [COLOR] Nombre de la Materia                    │
│ Horas semanales: 5    [🖊 Editar] [🗑 Eliminar] │
└─────────────────────────────────────────────────┘
```

**Estados:**
- Normal: fondo blanco, borde gris claro
- Hover: fondo gris claro, sombra elevada
- El color de la materia aparece como borde izquierdo grueso (4px)

### 4. Resumen de Horas

**Elemento:**
- Footer con el total de horas semanales asignadas
- Color de advertencia si excede 40 horas
- Color de éxito si está dentro del rango normal (25-35 horas)

### 5. Empty State

Si no hay materias asignadas:
```
┌─────────────────────────────────────────────────┐
│                                                  │
│           📚                                     │
│                                                  │
│     No hay materias asignadas a este curso      │
│                                                  │
│  [+ Asignar Primera Materia]                    │
│                                                  │
└─────────────────────────────────────────────────┘
```

---

## 📝 Modal: Asignar Materia

```
┌─────────────────────────────────────────────────┐
│ Asignar Materia                            [×]  │
├─────────────────────────────────────────────────┤
│                                                  │
│  Curso: 1ro de Básica                           │
│  Período: 2024-2025                             │
│                                                  │
│  ┌──────────────────────────────────────────┐  │
│  │ Materia *                                 │  │
│  │ [Seleccionar materia... ▼]               │  │
│  └──────────────────────────────────────────┘  │
│                                                  │
│  ┌──────────────────────────────────────────┐  │
│  │ Horas Semanales *                         │  │
│  │ [___] (número)                            │  │
│  └──────────────────────────────────────────┘  │
│                                                  │
│  💡 Sugerencia: Generalmente 2-6 horas         │
│                                                  │
├─────────────────────────────────────────────────┤
│                    [Cancelar] [Asignar Materia] │
└─────────────────────────────────────────────────┘
```

**Campos:**
- Materia (select con searchable-select, muestra solo materias no asignadas)
- Horas semanales (input number, min: 1, max: 10)

**Validaciones:**
- Materia: requerida, no debe estar ya asignada al curso en ese período
- Horas semanales: requerida, entre 1 y 10

---

## 📝 Modal: Editar Horas de Materia

```
┌─────────────────────────────────────────────────┐
│ Editar Horas de Materia                    [×]  │
├─────────────────────────────────────────────────┤
│                                                  │
│  Materia: Matemáticas                           │
│  Curso: 1ro de Básica                           │
│                                                  │
│  ┌──────────────────────────────────────────┐  │
│  │ Horas Semanales *                         │  │
│  │ [5]                                       │  │
│  └──────────────────────────────────────────┘  │
│                                                  │
│  💡 Ajuste las horas según la malla curricular │
│                                                  │
├─────────────────────────────────────────────────┤
│                    [Cancelar] [Guardar Cambios] │
└─────────────────────────────────────────────────┘
```

---

## 🗑️ Modal: Eliminar Asignación

```
┌─────────────────────────────────────────────────┐
│ Eliminar Asignación de Materia             [×]  │
├─────────────────────────────────────────────────┤
│                                                  │
│  ⚠️ ¿Está seguro de eliminar esta asignación?  │
│                                                  │
│  Materia: Matemáticas                           │
│  Curso: 1ro de Básica                           │
│  Período: 2024-2025                             │
│  Horas semanales: 5                             │
│                                                  │
│  Esta acción eliminará:                         │
│  • Asignaciones de docentes a esta materia     │
│  • Calificaciones relacionadas (si existen)    │
│  • Tareas y actividades (si existen)           │
│                                                  │
│  ⚠️ Esta acción no se puede deshacer           │
│                                                  │
├─────────────────────────────────────────────────┤
│                           [Cancelar] [Eliminar] │
└─────────────────────────────────────────────────┘
```

---

## 🎨 Paleta de Colores

**Cards:**
- Fondo: blanco (`bg-white dark:bg-gray-800`)
- Borde: gris claro (`border-gray-200 dark:border-gray-700`)
- Borde izquierdo de color: color de la materia (4px)
- Hover: `hover:shadow-lg transition-shadow duration-200`

**Botones:**
- Asignar: verde (`bg-green-600 hover:bg-green-700`)
- Editar: azul (`text-blue-600 hover:text-blue-800`)
- Eliminar: rojo (`text-red-600 hover:text-red-800`)

**Total de horas:**
- Normal (25-35): verde (`text-green-600`)
- Advertencia (36-40): amarillo (`text-yellow-600`)
- Peligro (>40 o <20): rojo (`text-red-600`)

---

## 🔒 Permisos

**Permisos necesarios:**
- `gestionar asignaciones` - Permiso general del módulo
- `ver asignaciones` - Ver listado de asignaciones
- `crear asignaciones` - Asignar nueva materia a curso
- `editar asignaciones` - Modificar horas semanales
- `eliminar asignaciones` - Quitar materia de curso

**Aplicación en vistas:**
```blade
@canany(['ver asignaciones', 'gestionar asignaciones'])
    <!-- Vista principal -->
@endcanany

@canany(['crear asignaciones', 'gestionar asignaciones'])
    <!-- Botón asignar materia -->
@endcanany

@canany(['editar asignaciones', 'gestionar asignaciones'])
    <!-- Botón editar -->
@endcanany

@canany(['eliminar asignaciones', 'gestionar asignaciones'])
    <!-- Botón eliminar -->
@endcanany
```

---

## 📋 Funcionalidades Especiales

### 1. Validación de Duplicados
- No permitir asignar la misma materia dos veces al mismo curso en el mismo período
- Mostrar mensaje claro: "Esta materia ya está asignada a este curso"

### 2. Filtro de Materias Disponibles
- En el modal de asignar, mostrar solo materias que NO estén asignadas
- Búsqueda con searchable-select para facilitar selección

### 3. Cálculo Automático de Total de Horas
- Actualizar en tiempo real el total de horas semanales
- Mostrar advertencia visual si excede límites normales

### 4. Carga Dinámica
- Al cambiar de curso o período, cargar materias asignadas automáticamente
- Loader mientras se cargan los datos

### 5. Ordenamiento
- Materias ordenadas por nombre (alfabético)
- Opcionalmente: permitir orden por área académica

---

## 🛠️ Consideraciones Técnicas

**Tabla BD:** `curso_materia`
**Campos:**
- `curso_id` (FK)
- `materia_id` (FK)
- `periodo_academico_id` (FK)
- `horas_semanales` (integer)

**Relaciones:**
- BelongsTo: Curso, Materia, PeriodoAcademico

**Rutas:**
- `GET /asignaciones/curso-materia` - Vista principal (index)
- `POST /asignaciones/curso-materia` - Crear asignación (store)
- `PUT /asignaciones/curso-materia/{id}` - Actualizar horas (update)
- `DELETE /asignaciones/curso-materia/{id}` - Eliminar asignación (destroy)

**Controlador:** `CursoMateriaController`
**Request:** `CursoMateriaRequest`

---

## 📱 Responsive

**Desktop (>768px):**
- Cards en grid de 2 columnas
- Filtros en una sola línea

**Tablet (768px):**
- Cards en 1 columna
- Filtros en línea

**Mobile (<640px):**
- Cards en 1 columna full width
- Filtros apilados verticalmente
- Botones de acción más grandes

---

## ✅ Checklist de Implementación

- [ ] Crear CursoMateriaController
- [ ] Crear CursoMateriaRequest con validaciones
- [ ] Crear vista index.blade.php con filtros
- [ ] Crear modal create.blade.php
- [ ] Crear modal edit.blade.php
- [ ] Crear modal delete.blade.php
- [ ] Agregar rutas en web.php
- [ ] Agregar permisos en RoleSeeder
- [ ] Aplicar componente searchable-select
- [ ] Implementar cálculo de total de horas
- [ ] Validar duplicados
- [ ] Testing en navegador

---

**¿Apruebas este diseño para proceder con la implementación?**

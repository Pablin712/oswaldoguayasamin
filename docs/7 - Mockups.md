# 🎨 Mockups y Vistas del Sistema

**Última actualización:** 24 de diciembre de 2025

---

## 📊 Estado de Vistas

### ✅ Vistas Completadas (8)
- Login
- Recuperar contraseña (Recover password)
- Editar perfil (Edit profile)
- Usuarios (CRUD completo)
- Roles (CRUD completo)
- Permisos (CRUD completo)
- Instituciones (Vista + Modal) ✅ **FASE 2**
- Configuraciones (Vista con pestañas) ✅ **FASE 2**

### 🔄 Vistas por Editar/Cambiar (3)
- Welcome
- Register
- Dashboard

### ⏳ Vistas Pendientes (31 módulos)
Todos los módulos de las tablas restantes requieren mockups y vistas

---

## 📐 Patrón de Diseño para Vistas

### Estructura Estándar de CRUDs

**Archivos y carpetas:**
- Carpeta en `resources/views/[modulo]/`
- `index.blade.php` → Lista principal (hereda de `layouts.app`)
- `show.blade.php` → Vista detalle (hereda de `layouts.app`)
- `create.blade.php` → Modal de creación (usa componente `modal`)
- `edit.blade.php` → Modal de edición (usa componente `modal`)
- `delete.blade.php` → Modal de confirmación (usa componente `modal`)

**Componentes:**
- Tablas → usar componente `enhanced-table`
- Tablas grandes → agregar parámetro `server-side`
- Modals → usar componente `modal`

**Controladores:**
- Excluir métodos `create()` y `edit()` (son modals, no vistas)
- Cada método protegido con `Gate` usando 2 permisos (gestionar + específico)
- **Importante:** Gate debe redirigir a la vista anterior, NO a 403

**Sistema de Permisos:**

Permisos estándar por módulo:
- `gestionar [módulo]` - Permiso general del módulo
- `ver [módulo]` - Ver listado y detalles
- `crear [módulo]` - Crear nuevos registros
- `editar [módulo]` - Modificar registros
- `eliminar [módulo]` - Eliminar registros
- `generar reporte [módulo]` - Exportar reportes

**En las vistas:**
```blade
@canany(['ver usuarios', 'gestionar usuarios'])
    <!-- Contenido visible -->
@endcanany
```

**En los controladores:**
```php
Gate::authorize(['ver usuarios', 'gestionar usuarios']);
```

**Todos los permisos deben estar en el RoleSeeder**

---

### Vistas No Estándar (Requieren Mockup Previo)

Para vistas que no usen tablas (cards, listas, calendarios, burbujas, etc.):
1. Crear mockup primero
2. Esperar confirmación del usuario
3. Implementar vista aprobada
4. Mantener sistema de permisos con `@canany` y `Gate`

---

## 🎯 Plan de Implementación por Fases

### Fase 1: Autenticación y Permisos ✅ COMPLETADA
**Vistas necesarias:** 3 vistas
- [x] Login - ✅ COMPLETA
- [x] Usuarios (CRUD) - ✅ COMPLETA
- [x] Roles (CRUD) - ✅ COMPLETA
- [x] Permisos (CRUD) - ✅ COMPLETA

---

### Fase 2: Configuración Institucional ✅ COMPLETADA
**Vistas necesarias:** 2 módulos

- [x] **Instituciones** ✅ COMPLETA
  - Tipo: Vista única (card/formulario)
  - Mockup: ✅ Completado (docs/FASE_02_MOCKUPS.md)
  - Campos: nombre, codigo_amie, tipo, nivel, jornada, provincia, ciudad, canton, parroquia, direccion, telefono, email, sitio_web, rector, vicerrector, inspector, logo
  - Permisos: gestionar institución, ver institución, editar institución
  - Controlador: ✅ InstitucionController
  - Vistas: ✅ show.blade.php, edit.blade.php (modal)
  - Rutas: ✅ instituciones.show, instituciones.update

- [x] **Configuraciones** ✅ COMPLETA
  - Tipo: Vista única con pestañas (4 tabs)
  - Mockup: ✅ Completado (docs/FASE_02_MOCKUPS.md)
  - Campos: Ver mockup para detalles completos
  - Permisos: gestionar configuraciones, ver configuraciones, editar configuraciones
  - Controlador: ✅ ConfiguracionController
  - Vistas: ✅ index.blade.php con 4 tabs (academico, calificaciones, horarios, correo)
  - Rutas: ✅ configuraciones.index, configuraciones.update, configuraciones.test-email

---

### Fase 3: Estructura Académica ⏳ PENDIENTE
  - Mockup: Requerido (no es tabla estándar)
  - Permisos: gestionar institución, ver institución, editar institución

- [ ] **Configuraciones**
  - Tipo: Formulario de ajustes
  - Mockup: Requerido (vista de configuración)
  - Permisos: gestionar configuraciones, ver configuraciones, editar configuraciones

---

### Fase 3: Estructura Académica Base ⏳ PENDIENTE
**Vistas necesarias:** 5 módulos

- [ ] **Periodos Académicos**
  - Tipo: Tabla estándar
  - Mockup: No requerido (tabla convencional)
  - Campos: nombre, fecha_inicio, fecha_fin, estado
  - Permisos: gestionar periodos académicos, ver, crear, editar, eliminar, generar reporte

- [ ] **Quimestres**
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, periodo_académico, fecha_inicio, fecha_fin
  - Permisos: gestionar quimestres, ver, crear, editar, eliminar, generar reporte

- [ ] **Parciales**
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, quimestre, fecha_inicio, fecha_fin, orden
  - Permisos: gestionar parciales, ver, crear, editar, eliminar, generar reporte

- [ ] **Cursos**
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, nivel, orden
  - Permisos: gestionar cursos, ver, crear, editar, eliminar, generar reporte

- [ ] **Materias**
  - Tipo: Tabla con colores
  - Mockup: Requerido (tabla con badge de color por área)
  - Campos: código, nombre, área, color
  - Permisos: gestionar materias, ver, crear, editar, eliminar, generar reporte

- [ ] **Aulas**
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, capacidad, edificio, piso, estado
  - Permisos: gestionar aulas, ver, crear, editar, eliminar, generar reporte

---

### Fase 4: Usuarios Especializados ⏳ PENDIENTE
**Vistas necesarias:** 3 módulos

- [ ] **Docentes**
  - Tipo: Tabla extendida
  - Mockup: Requerido (incluye foto, especialidad, estado)
  - Campos: código, nombre completo, especialidad, título, tipo contrato, estado
  - Permisos: gestionar docentes, ver, crear, editar, eliminar, generar reporte

- [ ] **Estudiantes**
  - Tipo: Tabla con foto
  - Mockup: Requerido (foto, estado, información adicional)
  - Campos: código, foto, nombre completo, fecha ingreso, paralelo actual, estado
  - Permisos: gestionar estudiantes, ver, crear, editar, eliminar, generar reporte

- [ ] **Padres**
  - Tipo: Tabla estándar con relación estudiantes
  - Mockup: Requerido (mostrar estudiantes asociados)
  - Campos: nombre, cédula, teléfono, email, estudiantes
  - Permisos: gestionar padres, ver, crear, editar, eliminar, generar reporte

---

### Fase 5: Asignaciones Académicas ⏳ PENDIENTE
**Vistas necesarias:** 4 módulos

- [ ] **Paralelos**
  - Tipo: Cards agrupados por curso
  - Mockup: Requerido (vista de cards/grid, no tabla)
  - Campos: curso, nombre (A, B, C), aula, cupo máximo, estudiantes matriculados
  - Permisos: gestionar paralelos, ver, crear, editar, eliminar

- [ ] **Curso-Materia** (Asignación de materias a cursos)
  - Tipo: Vista de asignación visual/matriz
  - Mockup: Requerido (interfaz de asignación)
  - Campos: curso, materias asignadas, horas semanales
  - Permisos: gestionar asignaciones, ver, crear, editar, eliminar

- [ ] **Docente-Materia** (Asignación de docentes)
  - Tipo: Vista de asignación con horario
  - Mockup: Requerido (interfaz de asignación docente-paralelo-materia)
  - Campos: docente, materia, paralelo, periodo
  - Permisos: gestionar asignaciones docentes, ver, crear, editar, eliminar

- [ ] **Matrículas**
  - Tipo: Tabla con estados y búsqueda avanzada
  - Mockup: Requerido (incluye badges de estado, filtros)
  - Campos: estudiante, paralelo, número matrícula, fecha, estado
  - Permisos: gestionar matrículas, ver, crear, editar, eliminar, generar reporte

---

### Fase 6: Sistema de Calificaciones ⏳ PENDIENTE
**Vistas necesarias:** 2 módulos

- [ ] **Calificaciones**
  - Tipo: Tabla con entrada de notas
  - Mockup: Requerido (interfaz de calificación, colores según nota)
  - Campos: estudiante, materia, parcial, nota final, componentes, estado
  - Permisos: gestionar calificaciones, ver, crear, editar, eliminar, generar reporte

- [ ] **Componentes de Calificación**
  - Tipo: Vista detalle/desglose (dentro de calificaciones)
  - Mockup: Requerido (desglose de nota: tareas, lecciones, examen)
  - Campos: componente, tipo, nota, porcentaje
  - Permisos: gestionar componentes, ver, crear, editar, eliminar

---

### Fase 7: Control de Asistencia ⏳ PENDIENTE
**Vistas necesarias:** 2 módulos

- [ ] **Asistencias**
  - Tipo: Calendario/tabla de asistencia
  - Mockup: Requerido (vista calendario + tabla, colores por estado)
  - Campos: estudiante, fecha, hora, estado (presente/ausente/atrasado/justificado)
  - Permisos: gestionar asistencias, ver, crear, editar, eliminar, generar reporte

- [ ] **Justificaciones**
  - Tipo: Tabla con workflow de aprobación
  - Mockup: Requerido (estados: pendiente/aprobada/rechazada)
  - Campos: asistencia, padre, motivo, archivo adjunto, estado, revisado por
  - Permisos: gestionar justificaciones, ver, crear, editar, eliminar, aprobar justificaciones

---

### Fase 8: Tareas y Deberes ⏳ PENDIENTE
**Vistas necesarias:** 2 módulos

- [ ] **Tareas**
  - Tipo: Cards/tabla con estado
  - Mockup: Requerido (cards con fecha límite, estado)
  - Campos: título, descripción, materia, paralelo, fecha asignación, fecha entrega, archivos
  - Permisos: gestionar tareas, ver, crear, editar, eliminar

- [ ] **Tarea Estudiante** (Entregas)
  - Tipo: Vista detalle con estados
  - Mockup: Requerido (lista de entregas, calificaciones)
  - Campos: estudiante, estado, fecha completada, calificación, comentarios
  - Permisos: gestionar entregas, ver, calificar entregas

---

### Fase 9: Comunicación ⏳ PENDIENTE
**Vistas necesarias:** 2 módulos

- [ ] **Mensajes**
  - Tipo: Bandeja estilo email
  - Mockup: Requerido (inbox/outbox, mensajes individuales/masivos)
  - Campos: remitente, destinatarios, asunto, cuerpo, adjuntos, fecha
  - Permisos: gestionar mensajes, ver, crear, eliminar mensajes

- [ ] **Notificaciones**
  - Tipo: Lista/dropdown de notificaciones
  - Mockup: Requerido (panel de notificaciones, tipos con iconos)
  - Campos: tipo, título, mensaje, leída, fecha
  - Permisos: ver notificaciones, marcar como leída

---

### Fase 10: Eventos y Calendario ⏳ PENDIENTE
**Vistas necesarias:** 2 módulos

- [ ] **Eventos**
  - Tipo: Vista de calendario + lista
  - Mockup: Requerido (calendario mensual/semanal, tipos de eventos con colores)
  - Campos: título, tipo, fecha inicio/fin, hora, ubicación, paralelos
  - Permisos: gestionar eventos, ver, crear, editar, eliminar

- [ ] **Confirmaciones de Eventos**
  - Tipo: Lista de confirmaciones por evento
  - Mockup: Requerido (lista de asistentes, estado confirmación)
  - Campos: evento, usuario, estudiante, confirmado, fecha confirmación
  - Permisos: ver confirmaciones, confirmar asistencia

---

### Fase 11: Horarios ⏳ PENDIENTE
**Vistas necesarias:** 1 módulo

- [ ] **Horarios**
  - Tipo: Cuadrícula semanal (lunes-viernes)
  - Mockup: Requerido (grid de horario escolar, colores por materia)
  - Campos: día, hora inicio/fin, materia, docente, aula, paralelo
  - Permisos: gestionar horarios, ver, crear, editar, eliminar, generar reporte

---

### Fase 12: Auditoría ⏳ PENDIENTE
**Vistas necesarias:** 1 módulo

- [ ] **Auditoría de Accesos**
  - Tipo: Tabla filtrable con búsqueda avanzada
  - Mockup: Requerido (tabla con filtros por usuario, acción, fecha, tabla afectada)
  - Campos: usuario, acción, tabla, registro, IP, fecha, cambios (antes/después)
  - Permisos: ver auditoría, generar reporte auditoría

---

## 📊 Resumen de Vistas

**Total de módulos:** 38 módulos
- ✅ **Completados:** 4 módulos (10.5%)
- 🔄 **Por editar:** 3 módulos (7.9%)
- ⏳ **Pendientes:** 31 módulos (81.6%)

**Tipos de vistas:**
- Tablas estándar: 15 módulos
- Vistas con mockup requerido: 16 módulos
- Vistas editables: 3 módulos

**Próximos pasos:**
1. Confirmar fase inicial para mockups
2. Crear mockups para vistas no estándar
3. Implementar vistas fase por fase
4. Agregar permisos al RoleSeeder por cada fase

---

**Fecha inicio:** 24 de diciembre de 2025  
**Estado:** En planificación

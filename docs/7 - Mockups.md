# 🎨 Mockups y Vistas del Sistema (FRONTEND)

**Última actualización:** 02 de febrero de 2026  
**Estado:** 🔄 En Progreso - Fase 6 Completada (02/02/2026)

---

## ⚠️ IMPORTANTE: ESTE DOCUMENTO SE REFIERE AL FRONTEND

**Backend (BD y Modelos):** Consultar [6 - Avances.md](6 - Avances.md) - ✅ 100% Completo  
**Frontend (Vistas y CRUDs):** Este documento - 🔄 En progreso (29/38 módulos = 76.3%)

---

## 📊 Estado de Vistas

### ✅ Vistas Completadas (29 de 38 módulos)
- Login
- Recuperar contraseña (Recover password)
- Editar perfil (Edit profile)
- Usuarios (CRUD completo)
- Roles (CRUD completo)
- Permisos (CRUD completo)
- Instituciones (Vista + Modal) ✅ **FASE 2**
- Configuraciones (Vista con pestañas) ✅ **FASE 2**
- Periodos Académicos (CRUD completo) ✅ **FASE 3**
- Quimestres (CRUD completo) ✅ **FASE 3**
- Parciales (CRUD completo) ✅ **FASE 3**
- Cursos (CRUD completo) ✅ **FASE 3**
- Materias (CRUD completo con color picker) ✅ **FASE 3**
- Áreas (CRUD completo) ✅ **FASE 3**
- Aulas (CRUD completo) ✅ **FASE 3**
- Docentes (CRUD completo) ✅ **FASE 4**
- Estudiantes (CRUD completo + Relaciones) ✅ **FASE 4**
- Padres (CRUD completo + Relaciones) ✅ **FASE 4**
- Paralelos (Cards agrupados) ✅ **FASE 5**
- Curso-Materia (Cards asignación) ✅ **FASE 5**
- Docente-Materia (Tabla con horarios) ✅ **FASE 5**
- Configuración de Matrículas ✅ **FASE 5**
- Solicitudes de Matrícula ✅ **FASE 5**
- Órdenes de Pago ✅ **FASE 5**
- Calificaciones (Contexto + Registro) ✅ **FASE 6** (02/02/2026)
- Componentes de Calificación (API CRUD) ✅ **FASE 6** (02/02/2026)

### ⏳ Vistas Pendientes (9 módulos)
- Asistencias (Calendario/tabla) **FASE 7**
- Justificaciones (Workflow) **FASE 7**
- Tareas (Cards con estado) **FASE 8**
- Entregas de Tareas (Calificaciones) **FASE 8**
- Mensajes (Bandeja email) **FASE 9**
- Notificaciones (Dropdown) **FASE 9**
- Eventos (Calendario) **FASE 10**
- Confirmaciones de Eventos **FASE 10**
- Horarios (Grid semanal) **FASE 11**
- Auditoría (Tabla de logs) **FASE 12**

---
- Áreas (CRUD completo con gestión de estado) ✅ **FASE 3**
- Aulas (CRUD completo) ✅ **FASE 3**

### 🔄 Vistas por Editar/Cambiar (3)
- Welcome
- Register
- Dashboard

### ⏳ Vistas Pendientes (23 módulos)
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

- [x] **Configuraciones** ✅ COMPLETA + ACTUALIZADA
  - Tipo: Vista única con pestañas (4 tabs)
  - Mockup: ✅ Completado (docs/FASE_02_MOCKUPS.md)
  - **Actualización 24/12/2025:** Ahora vinculada a instituciones con `institucion_id`
  - **Estructura:** Cada institución tiene su propia configuración única
  - Campos académicos: periodo_actual, número de quimestres/parciales, fechas, asistencia mínima
  - Campos calificaciones: escalas, ponderaciones, permisos de supletorio/remedial/gracia
  - Campos horarios: duración períodos, recreos, períodos por día, días laborales
  - Campos correo/notificaciones: SMTP, remitentes, flags de notificación, plantillas
  - Permisos: gestionar configuraciones, ver configuraciones, editar configuraciones
  - Controlador: ✅ ConfiguracionController
  - Vistas: ✅ index.blade.php con 4 tabs (academico, calificaciones, horarios, correo)
  - Rutas: ✅ configuraciones.index, configuraciones.update, configuraciones.test-email
  - **Modelo:** ✅ Relaciones con Institucion y PeriodoAcademico
  - **Seeder:** ✅ Crea configuración por cada institución automáticamente

---

### Fase 3: Estructura Académica Base ✅ COMPLETADA (7/7)
**Vistas necesarias:** 7 módulos

- [x] **Periodos Académicos** ✅ COMPLETA
  - Tipo: Tabla estándar
  - Mockup: No requerido (tabla convencional)
  - Campos: nombre, fecha_inicio, fecha_fin, estado
  - Permisos: gestionar periodos académicos, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ PeriodoAcademicoController
  - Form Request: ✅ PeriodoAcademicoRequest
  - Vistas: ✅ index.blade.php con modales
  - Rutas: ✅ periodos-academicos.* (resource)
  - **Fecha completada:** 28/12/2025

- [x] **Quimestres** ✅ COMPLETA
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, periodo_académico, fecha_inicio, fecha_fin, número
  - Permisos: gestionar quimestres, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ QuimestreController
  - Form Request: ✅ QuimestreRequest
  - Vistas: ✅ index.blade.php con modales
  - Rutas: ✅ quimestres.* (resource)
  - **Fecha completada:** 28/12/2025

- [x] **Parciales** ✅ COMPLETA
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, quimestre, fecha_inicio, fecha_fin, número, permite_edicion
  - Permisos: gestionar parciales, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ ParcialController
  - Form Request: ✅ ParcialRequest
  - Vistas: ✅ index.blade.php con modales
  - Rutas: ✅ parciales.* (resource)
  - **Fecha completada:** 28/12/2025

- [x] **Cursos** ✅ COMPLETA
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, nivel, orden
  - Permisos: gestionar cursos, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ CursoController
  - Form Request: ✅ CursoRequest
  - Vistas: ✅ index.blade.php con modales
  - Rutas: ✅ cursos.* (resource)
  - **Fecha completada:** 28/12/2025

- [x] **Materias** ✅ COMPLETA
  - Tipo: Tabla con colores
  - Mockup: No requerido (implementado con color picker HTML5)
  - Campos: código, nombre, área_id (FK), color
  - Permisos: gestionar materias, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ MateriaController
  - Form Request: ✅ MateriaRequest
  - Vistas: ✅ index.blade.php con modales y color picker
  - Rutas: ✅ materias.* (resource)
  - **Características especiales:** Color picker HTML5, badges dinámicos con color personalizado, select de áreas
  - **Fecha completada:** 28/12/2025
  - **Actualización:** 29/12/2025 - Normalización de campo área a tabla relacional

- [x] **Áreas** ✅ COMPLETA
  - Tipo: Tabla estándar con gestión de estado
  - Mockup: No requerido
  - Campos: nombre, descripción, estado
  - Permisos: gestionar areas, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ AreaController
  - Form Request: ✅ AreaRequest
  - Modelo: ✅ Area.php con relación hasMany materias
  - Seeder: ✅ AreaSeeder con 10 áreas comunes
  - Vistas: ✅ index.blade.php, create.blade.php, edit.blade.php, delete.blade.php
  - Rutas: ✅ areas.* (resource)
  - **Características especiales:** Badge purple para área, contador de materias asociadas, control de estado activa/inactiva, validación de eliminación si tiene materias
  - **Fecha completada:** 29/12/2025

- [x] **Aulas** ✅ COMPLETA
  - Tipo: Tabla estándar
  - Mockup: No requerido
  - Campos: nombre, capacidad, edificio, piso
  - Permisos: gestionar aulas, ver, crear, editar, eliminar, generar reporte
  - Controlador: ✅ AulaController
  - Form Request: ✅ AulaRequest
  - Vistas: ✅ index.blade.php con modales
  - Rutas: ✅ aulas.* (resource)
  - **Fecha completada:** 28/12/2025
  - Permisos: gestionar aulas, ver, crear, editar, eliminar, generar reporte

---

### Fase 4: Usuarios Especializados ✅ COMPLETADA (20/12/2025 - 29/12/2025)
**Vistas necesarias:** 3 módulos + Sistema de Relaciones

- [x] **Docentes** ✅ COMPLETA
  - Tipo: Tabla estándar con DataTables
  - Campos: código, nombre completo, especialidad, título, tipo contrato, email, teléfono, estado
  - Permisos: gestionar docentes, ver, crear, editar, eliminar, generar reporte docentes, generar reportes
  - Controlador: ✅ DocenteController (7 métodos)
  - Form Request: ✅ DocenteRequest con validaciones
  - Vistas: ✅ index.blade.php, show.blade.php, create.blade.php, edit.blade.php, delete.blade.php
  - Rutas: ✅ docentes.* (resource)
  - **Características especiales:** Badges de estado, foto de perfil, historial completo, componente enhanced-table con exportación
  - **Fecha completada:** 28/12/2025

- [x] **Estudiantes** ✅ COMPLETA
  - Tipo: Tabla estándar con gestión de relaciones
  - Campos: código estudiante, nombre completo, cédula, email, teléfono, fecha ingreso, tipo sangre, estado
  - Permisos: gestionar estudiantes, ver, crear, editar, eliminar, generar reporte estudiantes, generar reportes
  - Controlador: ✅ EstudianteController (10 métodos: 7 CRUD + 3 relaciones)
  - Form Request: ✅ EstudianteRequest con validaciones médicas y académicas
  - Vistas: ✅ index.blade.php, show.blade.php, create.blade.php, edit.blade.php, delete.blade.php, associate-padre.blade.php, edit-padre-relation.blade.php
  - Rutas: ✅ estudiantes.* (resource) + 3 rutas de relaciones con padres
  - **Características especiales:** Gestión de relaciones Many-to-Many con padres, información médica completa, badges de estado
  - **Fecha completada:** 29/12/2025

- [x] **Padres/Representantes** ✅ COMPLETA
  - Tipo: Tabla estándar con gestión de relaciones
  - Campos: nombre, cédula, email, teléfono, ocupación, lugar de trabajo, teléfono trabajo
  - Permisos: gestionar padres, ver, crear, editar, eliminar, generar reporte padres, generar reportes
  - Controlador: ✅ PadreController (10 métodos: 7 CRUD + 3 relaciones)
  - Form Request: ✅ PadreRequest con validaciones
  - Vistas: ✅ index.blade.php, show.blade.php, create.blade.php, edit.blade.php, delete.blade.php, associate-estudiante.blade.php, edit-estudiante-relation.blade.php
  - Rutas: ✅ padres.* (resource) + 3 rutas de relaciones con estudiantes
  - **Características especiales:** Gestión de relaciones Many-to-Many con estudiantes, información laboral, parentesco
  - **Fecha completada:** 29/12/2025

- [x] **Sistema de Relaciones Estudiante-Padre** ✅ COMPLETA
  - Tipo: Many-to-Many con datos pivot (parentesco, es_principal)
  - Tabla pivot: estudiante_padre
  - Funcionalidad: Asociar, editar, desvincular padres/estudiantes desde ambos lados
  - Validaciones: Prevención de duplicados, selección de parentesco, designación de representante principal
  - UI: Modals separados para cada operación, cards con información completa
  - Documentación: ✅ FASE_04_COMPLETADA.md, FASE_04_RELACIONES_COMPLETADAS.md, FASE_04_RESUMEN_FINAL.md, FASE_04_GUIA_USO.md
  - **Fecha completada:** 29/12/2025

---

### Fase 5: Asignaciones Académicas ✅ COMPLETADA (4/4)
**Vistas necesarias:** 4 módulos

- [x] **Paralelos** ✅ COMPLETA
  - Tipo: Cards agrupados por curso
  - Mockup: ✅ Completado (docs/FASE_05_MOCKUP_PARALELOS.md)
  - Campos: curso, nombre (A, B, C), aula, cupo máximo, período académico
  - Permisos: gestionar paralelos, ver, crear, editar, eliminar, generar reporte paralelos
  - Controlador: ✅ ParaleloController
  - Form Request: ✅ ParaleloRequest
  - Vistas: ✅ index.blade.php, show.blade.php, create.blade.php, edit.blade.php, delete.blade.php
  - Rutas: ✅ paralelos.* (resource)
  - **Características especiales:** Cards agrupados por curso, estadísticas, searchable-select, filtros por período
  - **Fecha completada:** 29/12/2025

- [x] **Curso-Materia** (Asignación de materias a cursos) ✅ COMPLETA
  - Tipo: Vista de asignación con cards de materias
  - Mockup: ✅ Completado (docs/FASE_05_MOCKUP_CURSO_MATERIA.md)
  - Campos: curso, materia, período académico, horas semanales
  - Permisos: gestionar asignaciones, ver, crear, editar, eliminar, generar reporte asignaciones
  - Controlador: ✅ CursoMateriaController
  - Form Request: ✅ CursoMateriaRequest
  - Vistas: ✅ index.blade.php, create.blade.php, edit.blade.php, delete.blade.php
  - Rutas: ✅ asignaciones/curso-materia.* (resource sin show)
  - **Características especiales:** Cards con colores de materia, cálculo total horas, validación duplicados, filtro de materias disponibles, searchable-select
  - **Fecha completada:** 29/12/2025

- [x] **Docente-Materia** (Asignación de docentes) ✅ COMPLETA
  - Tipo: Vista de asignación con horario
  - Mockup: No requerido (tabla estándar con selects múltiples)
  - Campos: docente, materia, paralelo, periodo
  - Permisos: gestionar asignaciones docentes, ver, crear, editar, eliminar
  - Controlador: ✅ DocenteMateriaController
  - Vistas: ✅ index.blade.php con modales y filtros
  - Rutas: ✅ asignaciones/docente-materia.* (resource)
  - **Características especiales:** Sistema multi-docente, validación de conflictos de horario
  - **Fecha completada:** 30/12/2025

- [x] **Matrículas** (Sistema completo con órdenes de pago) ✅ COMPLETA
  - Tipo: Sistema multi-módulo con 3 subsistemas
  - **Subsistemas implementados:**
    - **Configuración de Costos** (configuracion_matriculas)
    - **Solicitudes de Matrícula** (solicitudes_matricula) - Estudiantes externos
    - **Órdenes de Pago** (ordenes_pago)
    - **Matrículas Actualizadas** (matriculas) - Con tipo, pagos y aprobación
  - Campos actualizados: tipo_matricula, orden_pago_id, solicitud_matricula_id, aprobado_por, fecha_aprobacion
  - Permisos: gestionar matrículas, ver, crear, editar, eliminar, gestionar configuración costos, aprobar solicitudes, aprobar pagos, ver reportes, gestionar órdenes pago
  - Controladores: ✅ ConfiguracionMatriculaController, SolicitudMatriculaController, OrdenPagoController
  - Form Requests: ✅ Validaciones implementadas en controllers
  - Vistas: ✅ configuracion/index, solicitudes/create/index/show, ordenes-pago/index/show
  - Rutas: ✅ configuracion-costos.*, solicitudes-matricula.*, ordenes-pago.*
  - **Características especiales:** 
    - Formulario público para estudiantes externos
    - Sistema de aprobación de solicitudes con adjuntos (cédula, certificado)
    - Gestión de órdenes de pago con upload/download de comprobantes
    - Configuración de costos por institución (fiscal/fiscomisional/particular)
    - Flujo completo: Solicitud → Aprobación → Orden de Pago → Matrícula
    - Validación de segunda matrícula (máximo 2 por curso)
    - Storage privado para documentos sensibles
    - Sidebar con dropdown y accesos desde welcome page
    - Soporte multi-institución con validación de períodos activos
  - **Fecha completada:** 04/01/2026

---

### Fase 6: Sistema de Calificaciones ✅ COMPLETADA (2/2)
**Vistas necesarias:** 2 módulos

- [x] **Calificaciones** ✅ COMPLETA
  - Tipo: Vista de selección de contexto + tabla de registro de notas
  - Mockup: ✅ Completado (docs/FASE_06_MOCKUP_CALIFICACIONES.md)
  - Campos: matricula_id, curso_materia_id, parcial_id, docente_id, nota_final (DECIMAL 5,2), observaciones, fecha_registro, estado (registrada/modificada/aprobada/publicada)
  - Permisos: gestionar calificaciones, ver, registrar, editar, eliminar, publicar, generar reporte
  - Controlador: ✅ CalificacionController
  - Form Request: ✅ CalificacionRequest
  - Vistas: ✅ index.blade.php con contexto + tabla dinámica + modal estadísticas
  - Rutas: ✅ calificaciones.index, contexto, estudiantes, estadisticas, store, update, destroy, publicar
  - Permisos: ✅ Protegida con @canany y Gate::any
  - Sidebar: ✅ Agrupada en dropdown "Académico"
  - **Características especiales:**
    - Selección cascada: Período → Quimestre → Parcial → Curso → Materia (con searchable-select)
    - Filtros por rol: Docentes solo ven sus materias/paralelos asignados
    - Sistema de colores: 🟢 Verde (7.0-10.0 APROBADO), 🟡 Amarillo (5.0-6.9 EN RIESGO), 🔴 Rojo (0-4.9 REPROBADO)
    - Cálculo automático de nota final: (tareas*0.2 + lecciones*0.2 + trabajo*0.2 + examen*0.4)
    - Validación de rango 0-10 con 2 decimales
    - Auto-save en cambios
    - Restricción de edición en calificaciones publicadas (solo admin puede modificar)
    - Modal de estadísticas: Total estudiantes, promedio, aprobados, en riesgo, reprobados
    - Botón con gradiente azul e indicador de progreso
    - Scroll automático a tabla de resultados
  - **Fecha completada:** 02/02/2026

- [x] **Componentes de Calificación** ✅ COMPLETA
  - Tipo: Vista detalle/desglose (API dentro de calificaciones)
  - Mockup: ✅ Incluido en mockup principal (docs/FASE_06_MOCKUP_CALIFICACIONES.md)
  - Campos: calificacion_id, nombre, tipo (tarea/leccion/examen/proyecto/trabajo), nota (DECIMAL 5,2), porcentaje (DECIMAL 5,2), descripcion
  - Permisos: gestionar componentes, ver, crear, editar, eliminar
  - Controlador: ✅ ComponenteCalificacionController
  - Form Request: ✅ ComponenteCalificacionRequest
  - Rutas: ✅ componentes.index, store, update, destroy (APIs)
  - **Características especiales:**
    - CRUD completo de componentes individuales (tareas específicas, lecciones, exámenes)
    - Recálculo automático de nota final al crear/editar/eliminar componentes
    - Validación de tipo ENUM (tarea, leccion, examen, proyecto, trabajo)
    - Porcentajes configurables por tipo
    - Agrupación por tipo para promedio ponderado
    - Restricción de edición en calificaciones publicadas
  - **Fecha completada:** 02/02/2026

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
- ✅ **Completados:** 29 módulos (76.3%)
  - Fase 1: 4 módulos ✅
  - Fase 2: 2 módulos ✅
  - Fase 3: 7 módulos ✅
  - Fase 4: 3 módulos + relaciones ✅
  - Fase 5: 4 módulos (incluye sistema completo de matrículas) ✅
  - Fase 6: 2 módulos (calificaciones + componentes) ✅
- ⏳ **Pendientes:** 9 módulos (23.7%)

**Tipos de vistas:**
- Tablas estándar: 15 módulos
- Vistas con mockup requerido: 14 módulos
- Vistas editables: 3 módulos

**Próximos pasos:**
1. ✅ Fase 6 completada con todas las validaciones
2. Iniciar Fase 7: Sistema de Asistencias y Justificaciones
3. Crear mockups para módulos de asistencia
4. Continuar implementación fase por fase

---

**Fecha inicio:** 24 de diciembre de 2025  
**Última actualización:** 02 de febrero de 2026
**Estado:** Fase 6 completada ✅

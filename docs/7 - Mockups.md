# 🎨 Mockups y Vistas del Sistema (FRONTEND)

**Última actualización:** 2 de marzo de 2026  
**Estado:** 🔄 En Progreso - Fase 6 Completada | Fase 8 Backend+Frontend Completado (17/02/2026) | Fase 10 Comunicación Completada (02/03/2026)

---

## ⚠️ IMPORTANTE: ESTE DOCUMENTO SE REFIERE AL FRONTEND

**Backend (BD y Modelos):** Consultar [6 - Avances.md](6 - Avances.md) - ✅ 100% Completo  
**Frontend (Vistas y CRUDs):** Este documento - 🔄 En progreso (33/46 módulos = 71.7%)

---

## 📊 Estado de Vistas

### ✅ Vistas Frontend Completadas (33 de 46 módulos)
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
- Calificaciones (Contexto + Registro + Seeder) ✅ **FASE 6** (03/02/2026)
- Componentes de Calificación (API CRUD) ✅ **FASE 6** (03/02/2026)
- Auditoría (Logs + Estadísticas) ✅ **FASE 13** (17/02/2026)
- Asistencias (CRUD + Registro masivo + Estadísticas) ✅ **FASE 8** (17/02/2026)
- Justificaciones (Workflow completo de aprobación) ✅ **FASE 8** (17/02/2026)
- Notificaciones (Sistema de alertas + Email) ✅ **FASE 10** (18/02/2026)
- Mensajes (Sistema de mensajería interna) ✅ **FASE 10** (02/03/2026)

### 🔧 Backend Completado - Vistas Frontend Pendientes (3 módulos)
**⚠️ IMPORTANTE:** Estos módulos tienen **controllers, models, migrations, seeders, routes y permissions** completados.
Solo falta la implementación del **frontend (vistas Blade)**.

- Tareas (CRUD + Calificación + Archivos) **FASE 9** ⚡ Backend completado (17/02/2026)
- Eventos (Calendario + Confirmaciones) **FASE 11** ⚡ Backend completado (17/02/2026)
- Horarios (Grid semanal + Conflictos) **FASE 12** ⚡ Backend completado (17/02/2026)

### ⏳ Vistas Totalmente Pendientes (9 módulos)
Estos módulos NO tienen backend ni frontend:
- Fase 7: Módulos adicionales de asistencia (si aplica)
- Otros módulos futuros según planificación

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

### Fase 7: Control de Asistencia ⏳ PENDIENTE (0/2)
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

### Fase 8: Control de Asistencia 🔧 BACKEND COMPLETO (2/2)
**⚠️ Backend completado el 17/02/2026 - Solo falta FRONTEND**

- [x] **Asistencias** ⚡ Backend completado
  - Tipo: Registro masivo + estadísticas + calendario
  - Mockup: Requerido (vista calendario + tabla de registro masivo)
  - Campos: matricula_id, docente_materia_id, fecha, hora, estado (presente/ausente/atrasado/justificado), observaciones
  - Backend completado:
    - ✅ Controlador: AsistenciaController (11 métodos)
      - index() - Listado con filtros
      - create(), store(), edit(), update(), destroy() - CRUD estándar
      - cargarEstudiantes() - Carga estudiantes del paralelo
      - registroMasivo() - Registra asistencia de todo el paralelo de una vez
      - estadisticas() - Total presente/ausente/atrasado/justificado
    - ✅ Form Request: AsistenciaRequest con validaciones
    - ✅ Modelo: Asistencia con relaciones
    - ✅ Rutas: asistencias.* (resource) + routes adicionales
    - ✅ Permisos: gestionar asistencias, ver, crear, editar, eliminar, registro masivo, ver estadísticas, generar reporte
  - Frontend pendiente: ❌ Vistas Blade no creadas

- [x] **Justificaciones** ✅ COMPLETA
  - Tipo: Workflow de aprobación con archivos adjuntos
  - Mockup: No requerido (flujo estándar de aprobación)
  - Campos: asistencia_id, padre_id, motivo, archivo_adjunto, estado (pendiente/aprobada/rechazada), fecha_revision, revisado_por, motivo_rechazo
  - Backend completado:
    - ✅ Controlador: JustificacionController (9 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - aprobar() - Aprueba justificación y actualiza asistencia a "justificado"
      - rechazar() - Rechaza justificación con motivo opcional
      - pendientes() - Lista solo pendientes de aprobación
    - ✅ Form Request: JustificacionRequest con validación de archivos
    - ✅ Modelo: Justificacion con relaciones (asistencia, padre, revisor)
    - ✅ Rutas: justificaciones.* + aprobar, rechazar, pendientes (ordenadas correctamente)
    - ✅ Permisos: gestionar justificaciones, ver, crear, editar, eliminar, aprobar, rechazar
    - ✅ Migración adicional: Campo motivo_rechazo agregado
  - Frontend completado: ✅
    - ✅ index.blade.php - Tabla con filtros por estado
    - ✅ create.blade.php - Modal de creación con archivo adjunto
    - ✅ edit.blade.php - Modal de edición (solo pendientes)
    - ✅ delete.blade.php - Modal de confirmación
    - ✅ show.blade.php - Vista detalle con información completa
    - ✅ pendientes.blade.php - Vista especial para revisión rápida
    - ✅ approve.blade.php - Modal de aprobación
    - ✅ reject.blade.php - Modal de rechazo con motivo
  - **Fecha completada:** 17/02/2026

---

### Fase 9: Tareas y Deberes 🔧 BACKEND COMPLETO (1/1)
**⚠️ Backend completado el 17/02/2026 - Solo falta FRONTEND**

- [x] **Tareas** ⚡ Backend completado
  - Tipo: Sistema completo de tareas con calificación y archivos
  - Mockup: Requerido (cards con fecha límite + formulario de entrega)
  - Campos: 
    - Tarea: curso_materia_id, paralelo_id, docente_id, titulo, descripcion, fecha_asignacion, fecha_entrega, archivos_permitidos, puntos_totales
    - TareaEstudiante: tarea_id, matricula_id, estado (pendiente/entregada/calificada/vencida), fecha_entrega, calificacion, comentario_docente
    - ArchivoTarea: tarea_estudiante_id, nombre_archivo, ruta_archivo, tipo
  - Backend completado:
    - ✅ Controlador: TareaController (11 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - proximasVencer() - Tareas próximas a vencer
      - completar() - Estudiante entrega tarea con archivos
      - calificar() - Docente califica tarea entregada
      - eliminarArchivo() - Elimina archivo adjunto
    - ✅ Form Request: TareaRequest con validaciones
    - ✅ Modelos: Tarea, TareaEstudiante, ArchivoTarea con relaciones
    - ✅ Rutas: tareas.* + calificar, completar, proximas-vencer, eliminar-archivo
    - ✅ Permisos: gestionar tareas, ver, crear, editar, eliminar, calificar, ver entregas
    - ✅ Storage: Manejo de archivos adjuntos (subida/descarga/eliminación)
  - Frontend pendiente: ❌ Vistas Blade no creadas

---

### Fase 10: Comunicación 🔧 BACKEND COMPLETO - 1/2 FRONTEND COMPLETO
**✅ Notificaciones frontend completado el 18/02/2026 - Solo falta Mensajes**

- [x] **Mensajes** ⚡ Backend completado
  - Tipo: Sistema de mensajería interna estilo email
  - Mockup: Requerido (bandeja entrada/salida + redacción)
  - Campos:
    - Mensaje: remitente_id, asunto, cuerpo, tipo (individual/masivo/anuncio), fecha_envio
    - MensajeDestinatario: mensaje_id, destinatario_id, leido, fecha_lectura
    - MensajeAdjunto: mensaje_id, nombre_archivo, ruta_archivo, tamanio
  - Backend completado:
    - ✅ Controlador: MensajeController (9 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - marcarLeido() - Marca mensaje como leído
      - marcarNoLeido() - Marca como no leído
      - conteoNoLeidos() - Contador para badge de notificaciones
    - ✅ Form Request: MensajeRequest con validaciones
    - ✅ Modelos: Mensaje, MensajeDestinatario, MensajeAdjunto
    - ✅ Rutas: mensajes.* + marcar-leido, marcar-no-leido, conteo-no-leidos
    - ✅ Permisos: gestionar mensajes, ver, crear, editar, eliminar, enviar masivos
    - ✅ Storage: Manejo de archivos adjuntos
  - Frontend pendiente: ❌ Vistas Blade no creadas

- [x] **Notificaciones** ✅ **COMPLETADO**
  - Tipo: Sistema de notificaciones push + email
  - Mockup: ✅ Completado (18/02/2026)
  - Campos: usuario_id, tipo (info/warning/success/error), titulo, mensaje, leida, email_enviado, fecha_envio, url_accion
  - Backend completado:
    - ✅ Controlador: NotificacionController (13 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - recientes() - Últimas 10 notificaciones
      - conteoNoLeidas() - Contador para badge
      - marcarLeida() - Marca una como leída
      - marcarNoLeida() - Marca como no leída
      - marcarTodasLeidas() - Marca todas como leídas
      - eliminarLeidas() - Limpia notificaciones leídas
    - ✅ Form Request: NotificacionRequest con validaciones
    - ✅ Modelo: Notificacion con relaciones
    - ✅ Rutas: notificaciones.* + recientes, conteo-no-leidas, marcar-leida, marcar-no-leida, marcar-todas-leidas, eliminar-leidas
    - ✅ Permisos: 7 permisos completos (gestionar, ver, crear, editar, eliminar, marcar leidas, generar reporte)
    - ✅ Email: Integración con sistema de correo
  - Frontend completado:
    - ✅ vista index.blade.php con enhanced-table (6 columnas: Estado, Tipo, Título, Mensaje, Fecha, Acciones)
    - ✅ Modal create.blade.php (x-modal con selección múltiple usuarios, tipo, título, mensaje, URL, enviar email)
    - ✅ Modal delete.blade.php (x-modal de confirmación)
    - ✅ Permisos @canany(['gestionar notificaciones', 'ver notificaciones'])
    - ✅ Permisos granulares: @can('crear'), @can('eliminar'), @can('marcar leidas')
    - ✅ Sistema de filtros por tipo (info/warning/success/error) y estado (leídas/no leídas)
    - ✅ Badges dinámicos según tipo (azul/amarillo/verde/rojo) y estado (gris/azul)
    - ✅ Acciones: Marcar leída/no leída individual, Marcar todas leídas, Eliminar
    - ✅ Enhanced-table con búsqueda y exportación
    - ✅ Contador de no leídas en header
    - ✅ Navegación: Agregada en dropdown de perfil (no en sidebar)

---

### Fase 11: Eventos y Calendario 🔧 BACKEND COMPLETO (1/1)
**⚠️ Backend completado el 17/02/2026 - Solo falta FRONTEND**

- [x] **Eventos** ⚡ Backend completado
  - Tipo: Sistema de eventos con calendario y confirmaciones
  - Mockup: Requerido (calendario FullCalendar + formulario de evento)
  - Campos:
    - Evento: titulo, descripcion, tipo (academico/cultural/deportivo/reunion/otro), fecha_inicio, fecha_fin, hora_inicio, hora_fin, ubicacion, es_publico, permite_confirmacion
    - EventoParalelo: evento_id, paralelo_id
    - ConfirmacionEvento: evento_id, user_id, estudiante_id, confirmado, fecha_confirmacion, comentario
  - Backend completado:
    - ✅ Controlador: EventoController (10 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - verCalendario() - Vista de calendario
      - calendario() - Datos JSON para FullCalendar
      - confirmar() - Confirma asistencia a evento
    - ✅ Form Request: EventoRequest con validaciones de fechas
    - ✅ Modelos: Evento, EventoParalelo, ConfirmacionEvento
    - ✅ Rutas: eventos.* + calendario, calendario.datos, confirmar
    - ✅ Permisos: gestionar eventos, ver, crear, editar, eliminar, confirmar asistencia
    - ✅ FullCalendar: Endpoint JSON listo para integración
  - Frontend pendiente: ❌ Vistas Blade no creadas (requiere FullCalendar.js)

---

### Fase 12: Horarios 🔧 BACKEND COMPLETO (1/1)
**⚠️ Backend completado el 17/02/2026 - Solo falta FRONTEND**

- [x] **Horarios** ⚡ Backend completado
  - Tipo: Grid semanal con detección de conflictos
  - Mockup: Requerido (cuadrícula lunes-viernes con períodos)
  - Campos: periodo_academico_id, paralelo_id, docente_materia_id, aula_id, dia_semana (1-5), hora_inicio, hora_fin, orden
  - Backend completado:
    - ✅ Controlador: HorarioController (11 métodos)
      - index(), create(), store(), edit(), update(), destroy() - CRUD estándar
      - verParalelo() - Horario completo del paralelo (grid)
      - verDocente() - Horario del docente
      - verAula() - Horario del aula
      - verificarConflictos() - Detecta colisiones de horario
    - ✅ Form Request: HorarioRequest con validaciones de horario
    - ✅ Modelo: Horario con relaciones
    - ✅ Rutas: horarios.* + paralelo, docente, aula
    - ✅ Permisos: gestionar horarios, ver, crear, editar, eliminar, ver por paralelo, ver por docente, ver por aula
    - ✅ Validación: Sistema de detección de conflictos (mismo docente/aula/estudiantes)
  - Frontend pendiente: ❌ Vistas Blade no creadas (requiere grid de horario)

---

### Fase 13: Auditoría ✅ COMPLETADO (1/1)
**✅ Backend y Frontend completado el 17/02/2026**

- [x] **Auditoría de Accesos** ✅ Completado
  - Tipo: Sistema de logs con auditoría completa
  - Mockup: ✅ Implementado (tabla filtrable con detalles de cambios)
  - Campos: user_id, accion (login/logout/crear/editar/eliminar), tabla_afectada, registro_id, datos_anteriores, datos_nuevos, ip_address, user_agent, fecha
  - Backend completado:
    - ✅ Controlador: AuditoriaAccesoController (8 métodos - solo lectura)
      - index() - Listado con filtros potentes
      - show() - Detalle de acción específica
      - reciente() - Últimas 50 acciones
      - estadisticas() - Total acciones, por tipo, por tabla, usuarios activos, IPs únicas
      - actividadUsuario() - Historial de un usuario específico
      - historialRegistro() - Historial de un registro específico (ej: todas las modificaciones de un estudiante)
      - exportar() - Exporta log a CSV/Excel
      - limpiar() - Limpia logs antiguos (>6 meses, con confirmación)
    - ✅ Modelo: AuditoriaAcceso con relaciones
    - ✅ Rutas: auditoria.index, show, reciente, estadisticas, usuario, historial-registro, exportar, limpiar
    - ✅ Permisos: ver auditoria, generar reporte auditoria, limpiar logs
    - ✅ No tiene CRUD: Es solo lectura (no se pueden crear/editar/eliminar logs manualmente)
  - Frontend completado: ✅
    - ✅ index.blade.php - Tabla filtrable con búsqueda por usuario, acción, tabla, IP, fechas
    - ✅ show.blade.php - Detalle de acción con comparación de datos anteriores/nuevos
    - ✅ usuario.blade.php - Vista de actividad por usuario con estadísticas
    - ✅ estadisticas.blade.php - Dashboard con gráficas y top 10 tablas
    - ✅ historial.blade.php - Timeline de cambios de un registro específico
    - ✅ Modal de limpieza de registros antiguos
    - Características: Filtros avanzados, badges de colores por tipo de acción, tablas responsivas, dark mode

---

## 📊 Resumen de Vistas

**Total de módulos:** 46 módulos
- ✅ **Frontend Completado:** 30 módulos (65.2%)
  - Fase 1: 4 módulos ✅
  - Fase 2: 2 módulos ✅
  - Fase 3: 7 módulos ✅
  - Fase 4: 3 módulos + relaciones ✅
  - Fase 5: 4 módulos (incluye sistema completo de matrículas) ✅
  - Fase 6: 2 módulos (calificaciones + componentes) ✅ **Validado con datos de prueba**
  - Fase 13: 1 módulo (Auditoría) ✅ **Completado 17/02/2026**
  
- 🔧 **Backend Completado - Frontend Pendiente:** 7 módulos (15.2%)
  - Fase 8: 2 módulos (Asistencias, Justificaciones) ⚡
  - Fase 9: 1 módulo (Tareas completo) ⚡
  - Fase 10: 2 módulos (Mensajes, Notificaciones) ⚡
  - Fase 11: 1 módulo (Eventos) ⚡
  - Fase 12: 1 módulo (Horarios) ⚡
  
- ⏳ **Totalmente Pendientes:** 9 módulos (19.6%)
  - Fase 7: Módulos pendientes o adicionales

**Desglose por backend:**
- ✅ Controllers completados: 37 (8 nuevos en Fases 8-13)
- ✅ Form Requests completados: 32 (6 nuevos en Fases 8-13)
- ✅ Rutas registradas: ~200 rutas totales (65 nuevas en Fases 8-13)
- ✅ Permisos en sistema: ~150 permisos (70+ nuevos en Fases 8-13)

**Tipos de vistas:**
- Tablas estándar: 20 módulos
- Vistas con mockup requerido: 17 módulos
- Vistas editables: 3 módulos
- Calendarios/Grids: 3 módulos (Eventos, Horarios, Asistencias)

**Estado detallado de Fases 8-13:**
- ✅ Modelos: Todos creados con relaciones
- ✅ Migraciones: Todas ejecutadas
- ✅ Seeders: Disponibles para pruebas
- ✅ Controllers: Todos con métodos completos
- ✅ Form Requests: Validaciones implementadas
- ✅ Rutas: Registradas en web.php con middleware
- ✅ Permisos: Agregados a RoleSeeder y ejecutados
- ✅ Sidebar: Actualizado con nuevas secciones (17/02/2026)
- ❌ Vistas Blade: **PENDIENTES DE CREAR**

**Estado de Fase 6 - Calificaciones:**
- ✅ Vista de contexto (5 filtros en cascada)
- ✅ Tabla de registro de calificaciones
- ✅ CRUD de componentes (API)
- ✅ Seeder con 294 calificaciones de prueba
- ✅ 1,176 componentes de calificación (4 por calificación)
- ✅ Protección con permisos (@canany, Gate, middleware)
- ✅ Validación completa de datos

**Próximos pasos:**
1. ✅ Fase 6 completada y validada con datos de prueba
2. ✅ Fases 8-13 backend completado con 65 rutas y 70+ permisos
3. ✅ Sidebar actualizado con nuevas secciones
4. **Siguiente:** Crear vistas Blade para Fases 8-13 (8 módulos pendientes de frontend)
5. Implementar Fase 7 completa si es necesaria

---

## 🎯 Detalle de Controladores Creados (Fases 8-13)

### Fase 8: Control de Asistencia
1. **AsistenciaController** (11 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - cargarEstudiantes() - Carga lista de estudiantes del paralelo
   - registroMasivo() - Registra asistencia de todo un paralelo
   - estadisticas() - Dashboard de estadísticas de asistencia

2. **JustificacionController** (9 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - aprobar() - Aprueba justificación y actualiza asistencia
   - rechazar() - Rechaza justificación con motivo
   - pendientes() - Lista solo pendientes de revisión

### Fase 9: Tareas y Deberes
3. **TareaController** (11 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - proximasVencer() - Notifica tareas próximas a vencer
   - completar() - Estudiante entrega tarea con archivos
   - calificar() - Docente califica entrega de tarea
   - eliminarArchivo() - Elimina archivo adjunto de tarea

### Fase 10: Comunicación
4. **MensajeController** (9 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - marcarLeido() - Marca mensaje individual como leído
   - marcarNoLeido() - Marca mensaje como no leído
   - conteoNoLeidos() - API para badge de notificaciones

5. **NotificacionController** (13 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - recientes() - Últimas 10 notificaciones
   - conteoNoLeidas() - API para badge
   - marcarLeida() - Marca una notificación como leída
   - marcarNoLeida() - Marca como no leída
   - marcarTodasLeidas() - Marca todas como leídas
   - eliminarLeidas() - Limpia notificaciones antiguas leídas

### Fase 11: Eventos y Calendario
6. **EventoController** (10 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - verCalendario() - Vista de calendario
   - calendario() - API JSON para FullCalendar
   - confirmar() - Confirma asistencia a evento

### Fase 12: Horarios
7. **HorarioController** (11 métodos)
   - CRUD estándar (index, create, store, edit, update, destroy)
   - verParalelo() - Grid de horario del paralelo
   - verDocente() - Horario del docente
   - verAula() - Horario del aula
   - verificarConflictos() - Detecta colisiones de horario

### Fase 13: Auditoría
8. **AuditoriaAccesoController** (8 métodos - solo lectura)
   - index() - Listado con filtros avanzados
   - show() - Detalle de acción específica
   - reciente() - Últimas 50 acciones
   - estadisticas() - Dashboard de auditoría
   - actividadUsuario() - Historial por usuario
   - historialRegistro() - Historial de un registro
   - exportar() - Exporta logs a CSV/Excel
   - limpiar() - Limpia logs antiguos (>6 meses)

---

**Fecha inicio:** 24 de diciembre de 2025  
**Última actualización:** 17 de febrero de 2026  
**Estado:** Fase 8 completada ✅ | Asistencias y Justificaciones frontend completados ✅ | Sidebar actualizado ✅

---

## 📝 Detalle de Implementación - Fase 8: Justificaciones

### Vistas Completadas: 17/02/2026

#### Archivos Creados:
1. **index.blade.php**
   - Enhanced-table con 7 columnas (Fecha Solicitud, Estudiante, Padre/Representante, Asistencia, Estado, Revisado Por, Acciones)
   - Filtro por estado (pendiente, aprobada, rechazada)
   - Badges de estado con colores: pendiente (amarillo), aprobada (verde), rechazada (rojo)
   - Botón "Pendientes" que redirige a vista de revisión
   - Botón "Nueva Justificación" que abre modal
   - Acciones por fila según estado: Ver (siempre), Aprobar/Rechazar (pendientes), Editar (pendientes), Eliminar (pendientes y rechazadas)

2. **create.blade.php**
   - Modal x-modal con asistencia_id, motivo, archivo_adjunto
   - Upload de archivos (PDF, JPG, PNG, máx 2MB)
   - Selectbox para asistencias del estudiante sin justificación
   - Validación de archivos y campos requeridos

3. **edit.blade.php**
   - Modal x-modal con Alpine.js
   - Event listener para 'open-modal-data'
   - Fetch API para cargar datos: `/justificaciones/${id}`
   - Edición de motivo y reemplazo de archivo
   - Solo editable si estado = 'pendiente'

4. **delete.blade.php**
   - Modal de confirmación
   - Muestra nombre del estudiante
   - Alpine.js para capturar datos del evento
   - Action dinámico con método DELETE
   - Solo permite eliminar pendientes o rechazadas

5. **show.blade.php**
   - Vista de detalle completa con 3 columnas
   - Información Principal: estado, motivo, archivo adjunto, motivo_rechazo
   - Sidebar Derecha: datos de estudiante, padre, asistencia relacionada, revisor
   - Acciones rápidas si estado = pendiente (aprobar/rechazar)
   - Descarga de archivo adjunto

6. **pendientes.blade.php**
   - Vista especial para revisión de justificaciones pendientes
   - Cards expandidos con toda la información
   - Contador en header con total de pendientes
   - Acciones rápidas: Ver Detalle, Aprobar, Rechazar
   - Vista optimizada para flujo de trabajo

7. **approve.blade.php**
   - Modal de confirmación de aprobación
   - Muestra nombre del estudiante
   - Explica consecuencias: asistencia → "justificado", no editable
   - Form POST a route('justificaciones.aprobar')

8. **reject.blade.php**
   - Modal de rechazo con campo motivo_rechazo
   - Textarea opcional para explicar motivo
   - Muestra nombre del estudiante
   - Form POST a route('justificaciones.rechazar')

#### Rutas Actualizadas:
```php
Route::get('justificaciones/pendientes', [JustificacionController::class, 'pendientes'])
    ->name('justificaciones.pendientes')
    ->middleware('can:aprobar justificaciones');
Route::post('justificaciones/{justificacion}/aprobar', [JustificacionController::class, 'aprobar'])
    ->name('justificaciones.aprobar')
    ->middleware('can:aprobar justificaciones');
Route::post('justificaciones/{justificacion}/rechazar', [JustificacionController::class, 'rechazar'])
    ->name('justificaciones.rechazar')
    ->middleware('can:rechazar justificaciones');
Route::resource('justificaciones', JustificacionController::class)
    ->middleware('can:ver justificaciones');
```
**Nota:** Rutas específicas (pendientes, aprobar, rechazar) ANTES de Route::resource.

#### Controller Actualizado:
- Método `show()` modificado para manejar JSON cuando `wantsJson()` = true (para edit modal)
- Método `aprobar()` actualiza estado de justificación y asistencia en transacción
- Método `rechazar()` almacena motivo_rechazo opcional
- Filtros en index() según rol (padres solo ven sus justificaciones)

#### Componentes Utilizados:
- ✅ Enhanced-table (exportación, búsqueda, paginación)
- ✅ X-modal (create, edit, delete, approve, reject)
- ✅ Alpine.js (interactividad, AJAX, open-modal-data events)
- ✅ Badges con dark mode
- ✅ File upload con validación

#### Permisos Verificados:
- `ver justificaciones` - Listado y detalles
- `crear justificaciones` - Crear justificación
- `editar justificaciones` - Modificar pendientes
- `eliminar justificaciones` - Eliminar pendientes/rechazadas
- `aprobar justificaciones` - Aprobar y ver pendientes
- `rechazar justificaciones` - Rechazar con motivo

#### Migración Adicional:
- Campo `motivo_rechazo` agregado a tabla justificaciones (TEXT nullable)
- Actualizado fillable en modelo Justificacion

#### Estado Final:
✅ CRUD completo funcional  
✅ Workflow aprobación/rechazo implementado  
✅ Vista de pendientes implementada  
✅ Vistas siguen patrón de documentación  
✅ Componentes enhanced-table y x-modal usados correctamente  
✅ Rutas ordenadas correctamente  
✅ Dark mode compatible  
✅ Responsive design  
✅ Relación `revisor` corregida en controlador

---

## 📝 Detalle de Implementación - Fase 8: Asistencias

### Vista Completada: 17/02/2026

#### Archivos Creados:
1. **index.blade.php**
   - Enhanced-table con 7 columnas (Fecha/Hora, Estudiante, Paralelo, Materia, Estado, Docente, Acciones)
   - 4 filtros: paralelo (searchable-select), estudiante (searchable-select), fecha, estado (dropdown)
   - Badges de estado con colores: presente (verde), ausente (rojo), atrasado (amarillo), justificado (azul)
   - Botón "Registro Masivo" que redirige a vista especial
   - Botón "Nueva Asistencia" que abre modal
   - Botones de acción por fila: Ver, Editar, Eliminar

2. **create.blade.php**
   - Modal x-modal con width 2xl
   - 8 campos: paralelo_id*, estudiante_id*, fecha*, hora, estado*, materia_id, observaciones
   - Searchable-select para paralelo, estudiante y materia
   - Dropdown para estado (presente, ausente, atrasado, justificado)
   - Date y time inputs con validación HTML5

3. **edit.blade.php**
   - Modal x-modal con Alpine.js
   - Event listener para 'open-edit-modal'
   - Fetch API para cargar datos de asistencia: `/asistencias/${id}`
   - Mismo formulario que create pero con datos precargados
   - Action dinámico: `/asistencias/${id}` con método PUT

4. **delete.blade.php**
   - Modal de confirmación
   - Muestra nombre del estudiante y fecha
   - Alpine.js para capturar datos del evento
   - Action dinámico con método DELETE

5. **show.blade.php**
   - Vista de detalle completa
   - 2 secciones: "Información General" y "Justificaciones"
   - Grid responsive con 9 campos de información
   - Badge de estado con formato condicional
   - Sección de justificaciones relacionadas con estado (aprobado/rechazado/pendiente)
   - Botón "Volver" al listado

6. **registro-masivo.blade.php**
   - Vista especial para registro por paralelo
   - Alpine.js con función `registroMasivo()`
   - 3 filtros superiores: paralelo*, fecha*, materia (opcional)
   - Carga dinámica de estudiantes vía AJAX: `/asistencias/cargar-estudiantes`
   - Tabla con columnas: #, Estudiante, Estado (select), Observaciones (input)
   - Botones de acción rápida: "Marcar Todos Presente", "Marcar Todos Ausente"
   - Detecta asistencias ya registradas y precarga datos
   - Submit en batch a `/asistencias/registro-masivo` (POST)
   - Loading states y validaciones

#### Rutas Actualizadas:
```php
Route::get('asistencias/registro-masivo', [AsistenciaController::class, 'registroMasivo'])
    ->name('asistencias.registro-masivo.form');
Route::post('asistencias/registro-masivo', [AsistenciaController::class, 'registroMasivo'])
    ->name('asistencias.registro-masivo');
Route::get('asistencias/estadisticas', [AsistenciaController::class, 'estadisticas'])
    ->name('asistencias.estadisticas');
Route::get('asistencias/cargar-estudiantes', [AsistenciaController::class, 'cargarEstudiantes'])
    ->name('asistencias.cargar-estudiantes');
Route::resource('asistencias', AsistenciaController::class);
```
**Nota:** Rutas específicas antes de Route::resource para evitar captura incorrecta.

#### Controller Actualizado:
- Método `registroMasivo()` modificado para manejar GET (mostrar vista) y POST (guardar)
- GET retorna vista con $paralelos y $materias
- POST valida y ejecuta updateOrCreate en transacción DB

#### Componentes Utilizados:
- ✅ Enhanced-table (exportación, búsqueda, paginación, ordenamiento)
- ✅ Searchable-select (paralelos, estudiantes, materias)
- ✅ X-modal (create, edit, delete)
- ✅ Alpine.js (interactividad, AJAX)
- ✅ Badges con dark mode

#### Permisos Verificados:
- `ver asistencias` - Listado y detalles
- `crear asistencias` - Crear individual y registro masivo
- `editar asistencias` - Modificar asistencias
- `eliminar asistencias` - Eliminar registros

#### Estado Final:
✅ CRUD completo funcional  
✅ Registro masivo implementado  
✅ Vistas siguen patrón de documentación  
✅ Componentes enhanced-table y searchable-select usados correctamente  
✅ Rutas ordenadas correctamente  
✅ Dark mode compatible  
✅ Responsive design

---

## 📝 Detalle de Implementación - Fase 10: Mensajes

### Vista Completada: 02/03/2026

#### Archivos de Vista Implementados:
1. **index.blade.php**
2. **create.blade.php**
3. **create-masivo.blade.php**
4. **show.blade.php**
5. **delete.blade.php**

#### Descripción Detallada:

##### 1. **index.blade.php**
   - Layout con 2 pestañas: "Recibidos" y "Enviados"
   - Filtros: tipo_mensaje (individual, masivo, anuncio), estado de lectura
   - Diseño tipo card para cada mensaje en lugar de enhanced-table
   - Columna izquierda: remitente, asunto, preview del contenido
   - Columna derecha: fecha, hora, badges (masivo/anuncio), estado leído/no leído
   - Acciones rápidas: ver detalle, marcar leído/no leído, eliminar
   - Contador de mensajes no leídos en header
   - Búsqueda por asunto, remitente o contenido
   - Paginación con 20 mensajes por página
   - Botones del header con permisos:
     - "Nuevo Mensaje" → @canany(['gestionar mensajes', 'enviar mensajes'])
     - "Mensaje Masivo" → @can('enviar mensajes masivos')

##### 2. **create.blade.php**
   - Modal x-modal con Alpine.js (`name="create-mensaje"`)
   - Campos:
     - destinatario_id (x-searchable-select de usuarios)
     - asunto (input text, max 200)
     - mensaje (textarea, requerido)
     - adjuntos[] (file upload múltiple, máx 5 archivos, 5MB c/u)
     - programar_envio (opcional, datetime-local)
   - Tipos de mensaje: individual (default), anuncio
   - Validación de campos en frontend
   - Submit a route('mensajes.store')

##### 3. **create-masivo.blade.php**
   - Modal x-modal con Alpine.js (`name="create-mensaje-masivo"`)
   - Radio buttons para destinatarios:
     - Por rol (administradores, docentes, estudiantes, padres)
     - Por curso/paralelo (x-searchable-select de paralelos)
     - Selección manual (x-searchable-select múltiple de usuarios)
   - Campos compartidos con create.blade.php
   - Alpine.js para mostrar/ocultar opciones según radio seleccionado
   - Badge "MASIVO" visible en el header del modal
   - Submit a route('mensajes.store') con tipo='masivo'

##### 4. **show.blade.php**
   - Vista de detalle completa con diseño de email
   - Header con gradiente y badges (masivo/anuncio)
   - Sección remitente: foto, nombre, email, fecha/hora
   - Asunto destacado con tipografía grande
   - Contenido del mensaje con formato preservado
   - Sección de adjuntos con iconos según tipo de archivo
   - Botones de acción:
     - "Responder" (abre create.blade.php con destinatario precargado)
     - "Marcar leído/no leído" (toggle dinámico)
     - "Eliminar" (solo si mensaje recibido)
   - Marca automáticamente como leído al abrir
   - Lista de destinatarios si es mensaje masivo

##### 5. **delete.blade.php**
   - Modal de confirmación (`name="delete-mensaje"`)
   - Muestra asunto del mensaje a eliminar
   - Alpine.js con x-data para manejar mensajeId y mensajeAsunto dinámicos
   - Event listener @open-delete-modal.window
   - Action dinámico con método DELETE
   - Advertencia sobre eliminación permanente

#### Rutas Actualizadas:
```php
Route::get('mensajes/conteo-no-leidos', [MensajeController::class, 'conteoNoLeidos'])
    ->name('mensajes.conteo-no-leidos');
Route::post('mensajes/{mensaje}/marcar-leido', [MensajeController::class, 'marcarLeido'])
    ->name('mensajes.marcar-leido');
Route::post('mensajes/{mensaje}/marcar-no-leido', [MensajeController::class, 'marcarNoLeido'])
    ->name('mensajes.marcar-no-leido');
Route::resource('mensajes', MensajeController::class)
    ->middleware('can:ver mensajes');
```
**Nota:** Rutas específicas ANTES de Route::resource para evitar conflictos.

#### Controller Actualizado:
- Método `index()` filtra mensajes por tipo (recibidos/enviados) y tipo_mensaje
- Método `store()` maneja 3 tipos: individual, masivo (por rol/paralelo/manual), anuncio
- Método `store()` guarda adjuntos en storage/app/public/mensajes con nombres únicos
- Método `show()` marca automáticamente como leído si es mensaje recibido
- Método `marcarLeido()` actualiza campo leido=true en tabla mensaje_destinatarios
- Método `marcarNoLeido()` actualiza campo leido=false
- Método `conteoNoLeidos()` retorna JSON con cantidad para badge en navbar
- Filtro por roles: docentes/padres solo ven sus mensajes, admin ve todos

#### Modelos Relacionados:
- **Mensaje**: asunto, mensaje, remitente_id, tipo (individual/masivo/anuncio)
- **MensajeDestinatario**: mensaje_id, destinatario_id, leido (boolean), leido_en (timestamp)
- **MensajeAdjunto**: mensaje_id, nombre_original, nombre_archivo, ruta, tipo_archivo, tamaño

#### Componentes Utilizados:
- ✅ X-searchable-select (usuarios, paralelos con selección múltiple)
- ✅ X-modal (create, create-masivo, delete)
- ✅ Alpine.js (interactividad, eventos open-modal, manejo de estado)
- ✅ Badges con dark mode (masivo, anuncio, leído/no leído)
- ✅ File upload con validación (múltiples archivos)
- ✅ Cards layout para mensajes (mejor UX que tabla)

#### Permisos Verificados (7 permisos completos):
- `gestionar mensajes` - Acceso total al módulo
- `ver mensajes` - Ver listado y detalles
- `enviar mensajes` - Crear mensajes individuales
- `editar mensajes` - Modificar mensajes (no implementado en UI, solo backend)
- `eliminar mensajes` - Eliminar mensajes propios
- `enviar mensajes masivos` - Crear mensajes masivos (por rol/curso)
- `generar reporte mensajes` - Generar reportes (pendiente implementación)

#### Permisos en Includes:
```blade
@canany(['gestionar mensajes', 'enviar mensajes'])
    @include('comunicacion.mensajes.create')
@endcanany

@can('enviar mensajes masivos')
    @include('comunicacion.mensajes.create-masivo')
@endcan

@canany(['gestionar mensajes', 'eliminar mensajes'])
    @include('comunicacion.mensajes.delete')
@endcanany
```

#### Funcionalidad Especial:
- **Envío programado**: Campo opcional `programar_envio` para mensajes futuros
- **Adjuntos múltiples**: Hasta 5 archivos por mensaje, 5MB cada uno
- **Tipos de destinatarios masivos**:
  1. Por rol: todos los usuarios con rol específico
  2. Por curso/paralelo: todos los estudiantes + padres del paralelo
  3. Selección manual: lista personalizada de usuarios
- **Estado de lectura**: tracking individual por destinatario con timestamp
- **Contador en tiempo real**: Badge en navbar con mensajes no leídos
- **Responder**: Botón en show.blade.php que abre modal con destinatario precargado

#### Estado Final:
✅ CRUD completo funcional  
✅ Sistema de mensajería individual y masiva implementado  
✅ Gestión de adjuntos con upload múltiple  
✅ Estados de lectura con tracking individual  
✅ Envío programado disponible  
✅ Vistas siguen patrón de documentación  
✅ Componentes x-modal y searchable-select usados correctamente  
✅ Permisos granulares aplicados (7 permisos completos)  
✅ Rutas ordenadas correctamente  
✅ Dark mode compatible  
✅ Responsive design  
✅ Layout tipo email para mejor UX

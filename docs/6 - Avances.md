# 📊 Avances del Sistema de Gestión Académica

**Última actualización:** 03 de enero de 2026  
**Estado:** ✅ BACKEND COMPLETADO AL 100% (BD, Modelos, Relaciones, Seeders)
**Frontend:** ✅ Fase 5 COMPLETADA (Sistema de Matrículas con Órdenes de Pago + Controllers + Views)

---

## ⚠️ IMPORTANTE: ESTE DOCUMENTO SE REFIERE AL BACKEND

**Este documento registra el progreso del BACKEND:**
- ✅ Migraciones de base de datos
- ✅ Modelos Eloquent con relaciones
- ✅ Scopes y métodos de modelos
- ✅ Seeders con datos de prueba

**Para el progreso del FRONTEND (Vistas/CRUDs), consultar:** [7 - Mockups.md](7 - Mockups.md)

## 🎉 BACKEND COMPLETADO + MEJORAS

### ✨ Actualización Reciente (03/01/2026) - FASE 5 COMPLETADA

**Sistema Completo de Gestión de Matrículas Implementado:**

**Backend (Base de Datos):**
- ✅ Tabla `configuracion_matriculas` - Costos por institución (fiscal/fiscomisional/particular)
- ✅ Tabla `solicitudes_matricula` - Solicitudes de estudiantes nuevos/externos
- ✅ Tabla `ordenes_pago` - Órdenes de pago con comprobantes
- ✅ Tabla `matriculas` actualizada con tipo_matricula, orden_pago_id, aprobación
- ✅ Tabla `estudiantes` actualizada con estado transferido y conteo de matrículas
- ✅ Modelos con relaciones completas y métodos de negocio
- ✅ Seeders con datos de prueba
- ✅ Documentación completa en "8 - Gestión de matrículas.md"
- ✅ Diagrama de BD actualizado

**Frontend (Controllers y Views - 100% COMPLETADO):**
- ✅ **ConfiguracionMatriculaController** (5 métodos) - CRUD completo con modales
- ✅ **SolicitudMatriculaController** (9 métodos) - Gestión completa con aprobación/rechazo/download
- ✅ **OrdenPagoController** (9 métodos) - Gestión completa con upload/aprobación/download
- ✅ **configuracion/index.blade.php** - Enhanced-table + Export buttons + Modales CRUD
- ✅ **solicitudes/create.blade.php** - Formulario público con diseño atractivo
- ✅ **solicitudes/index.blade.php** - Enhanced-table + Filtros + Iconos SVG + Canany
- ✅ **solicitudes/show.blade.php** - Vista detalle con download de documentos
- ✅ **ordenes-pago/index.blade.php** - Enhanced-table + Filtros + Download comprobantes
- ✅ **ordenes-pago/show.blade.php** - Vista detalle con upload/download comprobantes
- ✅ Rutas públicas (`/solicitar-matricula`) y protegidas configuradas
- ✅ Sidebar con dropdown "Matrículas" (3 submenu items con iconos)
- ✅ Storage privado configurado + Directorios creados
- ✅ 11 permisos nuevos agregados al RoleSeeder y ejecutados en BD
- ✅ Todas las vistas siguen el patrón del proyecto (enhanced-table, modales, canany, SVG icons)

**Características del Sistema de Matrículas:**
- 🎓 Gestión de primera y segunda matrícula (máximo 2 por curso)
- 💰 Órdenes de pago configurables por institución
- 📄 Solicitudes para estudiantes externos con adjuntos (cédula, certificado)
- ✅ Aprobación de pagos con comprobantes (upload y download)
- 📋 Validación de aprobación del año anterior
- 🚫 Bloqueo automático tras segunda matrícula reprobada
- 🔐 Permisos granulares (13 permisos específicos)
- 💾 Almacenamiento privado de documentos sensibles
- 🎨 Interfaz completa con formularios, filtros y tablas responsive

### ✨ Actualización (24/12/2025)

**Sistema Multi-Institución Implementado:**
- ✅ Tabla `configuraciones` ahora tiene `institucion_id` (FK a instituciones, UNIQUE)
- ✅ Tabla `users` ahora tiene `institucion_id` (FK a instituciones)
- ✅ Cada institución tiene su propia configuración independiente
- ✅ Los usuarios están afiliados a una institución específica
- ✅ Seeders actualizados para crear configuración por cada institución
- ✅ Documentación del diagrama de base de datos actualizada

**Beneficios:**
- 🏫 Soporte completo para múltiples instituciones en la misma base de datos
- ⚙️ Configuraciones personalizadas por institución
- 👥 Usuarios segregados por institución
- 📊 Preparado para comercialización como SaaS

### Estadísticas del Proyecto

**Total de tablas identificadas en el diagrama:** 50 tablas

#### Por categoría:
- **Tablas principales (núcleo):** 10 tablas
- **Tablas secundarias (dependientes):** 27 tablas
- **Tablas intermedias (relaciones):** 13 tablas

#### Estado de implementación:
- ✅ **Completadas:** 50 tablas (100%) 🎉
- 🔄 **En progreso:** 0 tablas (0%)
- ⏳ **Pendientes:** 0 tablas (0%)

---

## 🎯 Orden de Implementación Recomendado

### Fase 1: Fundamentos (Prioridad Alta) ✅ COMPLETADA
Establecer la base del sistema con autenticación y permisos.

1. ✅ `users` - Usuarios del sistema (COMPLETA)
2. ✅ `roles` - Roles (Spatie)
3. ✅ `permissions` - Permisos (Spatie)
4. ✅ `model_has_roles` - Asignación roles (Spatie)
5. ✅ `model_has_permissions` - Asignación permisos (Spatie)
6. ✅ `role_has_permissions` - Permisos por rol (Spatie)

### Fase 2: Configuración Institucional (Prioridad Alta) ✅ COMPLETADA
Configurar la estructura institucional básica.

7. ✅ `instituciones` - Datos de la institución (COMPLETA)
8. ✅ `configuraciones` - Configuraciones del sistema (COMPLETA)

### Fase 3: Estructura Académica Base (Prioridad Alta) ✅ COMPLETADA
Crear la jerarquía académica fundamental.

9. ✅ `periodos_academicos` - Años lectivos (COMPLETA)
10. ✅ `quimestres` - División del año (COMPLETA)
11. ✅ `parciales` - Períodos de evaluación (COMPLETA)
12. ✅ `cursos` - Grados educativos (COMPLETA)
13. ✅ `materias` - Catálogo de materias (COMPLETA)
14. ✅ `aulas` - Salones de clase (COMPLETA)

### Fase 4: Relaciones Académicas (Prioridad Alta) ✅ COMPLETADA
Conectar cursos, materias y paralelos.

15. ✅ `paralelos` - Secciones de cursos (COMPLETA)
16. ✅ `curso_materia` - Materias por curso (COMPLETA)

### Fase 5: Usuarios Especializados (Prioridad Media) ✅ COMPLETADA
Extender users con información específica.

17. ✅ `docentes` - Información de profesores (COMPLETA)
18. ✅ `estudiantes` - Información de alumnos (COMPLETA)
19. ✅ `padres` - Información de tutores (COMPLETA)
20. ✅ `estudiante_padre` - Relación tutor-estudiante (COMPLETA)

### Fase 6: Asignaciones Académicas (Prioridad Media) ✅ COMPLETADA
Asignar docentes y matricular estudiantes.

21. ✅ `docente_materia` - Asignación docente-materia-paralelo (COMPLETA)
22. ✅ `matriculas` - Matrícula de estudiantes (COMPLETA)

### Fase 7: Sistema de Calificaciones (Prioridad Media) ✅ COMPLETADA
Gestión completa de notas.

23. ✅ `calificaciones` - Registro de notas (COMPLETA)
24. ✅ `componentes_calificacion` - Desglose de notas (COMPLETA)

### Fase 8: Control de Asistencia (Prioridad Media) ✅ COMPLETADA
Registro y justificaciones.

25. ✅ `asistencias` - Registro diario (COMPLETA)
26. ✅ `justificaciones` - Justificaciones de ausencias (COMPLETA)

### Fase 9: Tareas y Deberes (Prioridad Media) ✅ COMPLETADA
Sistema de asignación de tareas.

27. ✅ `tareas` - Tareas asignadas (COMPLETA)
28. ✅ `archivos_tarea` - Archivos de tareas (COMPLETA)
29. ✅ `tarea_estudiante` - Seguimiento individual (COMPLETA)

### Fase 10: Comunicación (Prioridad Baja) ✅ COMPLETADA
Sistema de mensajería y notificaciones.

30. ✅ `mensajes` - Mensajes entre usuarios (COMPLETA)
31. ✅ `mensaje_adjuntos` - Archivos adjuntos (COMPLETA)
32. ✅ `mensaje_destinatarios` - Destinatarios múltiples (COMPLETA)
33. ✅ `notificaciones` - Notificaciones del sistema (COMPLETA)

### Fase 11: Eventos y Calendario (Prioridad Baja) ✅ COMPLETADA
Gestión de eventos académicos.

34. ✅ `eventos` - Eventos institucionales (COMPLETA)
35. ✅ `evento_curso` - Eventos por curso (COMPLETA)
36. ✅ `evento_confirmacion` - Confirmaciones de asistencia (COMPLETA)

### Fase 12: Horarios (Prioridad Baja) ✅ COMPLETADA
Programación de clases.

37. ✅ `horarios` - Horarios de clase (COMPLETA)

### Fase 13: Auditoría (Prioridad Baja) ✅ COMPLETADA
Trazabilidad del sistema.

38. ✅ `auditoria_accesos` - Registro de auditoría (COMPLETA)

---

## 🎊 TODAS LAS FASES COMPLETADAS

**Sistema al 100%:** Las 46 tablas han sido implementadas exitosamente con sus modelos, relaciones, scopes y seeders.

## 📋 Checklist de Implementación

### ✅ Tablas Completadas (21)

#### Sistema de Autenticación y Permisos (Spatie)
- [x] **users** - Tabla base de usuarios
  - Estado: ✅ **COMPLETA + ACTUALIZADA** 
  - Fecha: 23/12/2024 | Actualización: 24/12/2024
  - Campos implementados: 
    - `id`, `institucion_id` (FK instituciones.id) ✅ **NUEVO**
    - `name`, `email`, `email_verified_at`, `password`
    - `cedula` (VARCHAR 10, UNIQUE) ✅
    - `telefono` (VARCHAR 20) ✅
    - `direccion` (TEXT) ✅
    - `foto` (VARCHAR 255) ✅
    - `fecha_nacimiento` (DATE) ✅
    - `estado` (ENUM: activo/inactivo/bloqueado, DEFAULT 'activo') ✅
    - `ultimo_acceso` (TIMESTAMP) ✅
    - `intentos_fallidos` (INT, DEFAULT 0) ✅
    - `remember_token`, `timestamps`
  - **Modelo actualizado:** Relación belongsTo con Institucion implementada
  - **Nota:** Usuarios ahora están afiliados a una institución específica

- [x] **roles** - Roles del sistema (Spatie)
  - Estado: ✅ Completa
  - Roles definidos: administrador, profesor, representante, estudiante

- [x] **permissions** - Permisos del sistema (Spatie)
  - Estado: ✅ Completa
  - CRUD funcional implementado

- [x] **model_has_roles** - Asignación de roles (Spatie)
  - Estado: ✅ Completa (tabla pivote polimórfica)

- [x] **model_has_permissions** - Asignación de permisos directos (Spatie)
  - Estado: ✅ Completa (tabla pivote polimórfica)

- [x] **role_has_permissions** - Permisos por rol (Spatie)
  - Estado: ✅ Completa (tabla pivote)

#### Configuración Institucional
- [x] **instituciones** - Datos de la institución educativa
  - Estado: ✅ **COMPLETA + ACTUALIZADA**
  - Fecha: 23/12/2024 | Actualización: 24/12/2024
  - Campos implementados:
    - `id`, `nombre`, `codigo_amie` (UNIQUE), `logo`
    - `tipo`, `nivel`, `jornada`
    - `provincia`, `ciudad`, `canton`, `parroquia`, `direccion`
    - `telefono`, `email`, `sitio_web`
    - `rector`, `vicerrector`, `inspector`
    - `timestamps`
  - **Modelo:** Con relaciones hasMany(users), hasOne(configuraciones)
  - **Seeder:** Crea 2 instituciones de ejemplo
  - **Nota:** Base del sistema multi-institución

- [x] **configuraciones** - Configuraciones del sistema por institución
  - Estado: ✅ **COMPLETA + ACTUALIZADA**
  - Fecha: 23/12/2024 | Actualización: 24/12/2024
  - Campos implementados:
    - `id`, `institucion_id` (FK instituciones.id, UNIQUE) ✅ **ACTUALIZADO**
    - **Académico:** `periodo_actual_id`, `numero_quimestres`, `numero_parciales`, fechas de clases y quimestres, `porcentaje_minimo_asistencia`
    - **Calificaciones:** `calificacion_minima/maxima`, `nota_minima_aprobacion`, `decimales`, ponderaciones, permisos de supletorio/remedial/gracia, `redondear_calificaciones`
    - **Horarios:** `duracion_periodo`, `duracion_recreo`, `periodos_por_dia`, `dias_laborales` (JSON)
    - **Correo:** `smtp_host/port/encriptacion/usuario/password`, `remitente_nombre/email`
    - **Notificaciones:** Flags para notificaciones de calificaciones/asistencia/eventos, resúmenes, `plantilla_correo`
    - `timestamps`
  - **Modelo:** Con belongsTo Institucion y belongsTo PeriodoAcademico
  - **Seeder:** Crea una configuración por cada institución con valores por defecto
  - **Nota:** Cada institución tiene configuración única e independiente

#### Estructura Académica Base
- [x] **periodos_academicos** - Años lectivos
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `nombre`, `fecha_inicio`, `fecha_fin`, `estado`, `timestamps`
  - **Modelo:** Con relaciones y scopes implementados
  - **Seeder:** Período 2024-2025 creado

- [x] **quimestres** - División del año lectivo
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `periodo_academico_id` (FK), `nombre`, `numero`, `fecha_inicio`, `fecha_fin`, `timestamps`
  - **Modelo:** Con belongsTo PeriodoAcademico y hasMany Parciales
  - **Seeder:** 2 quimestres creados

- [x] **parciales** - Períodos de evaluación
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `quimestre_id` (FK), `nombre`, `numero`, `fecha_inicio`, `fecha_fin`, `permite_edicion`, `timestamps`
  - **Modelo:** Con belongsTo Quimestre
  - **Seeder:** 6 parciales creados (3 por quimestre)

- [x] **cursos** - Grados educativos
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `nombre`, `nivel`, `orden`, `timestamps`
  - **Modelo:** Con belongsToMany Materias, hasMany Paralelos
  - **Seeder:** 13 cursos creados (1ro-10mo Básica, 1ro-3ro Bachillerato)

- [x] **materias** - Catálogo de materias
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `codigo` (UNIQUE), `nombre`, `area`, `color`, `timestamps`
  - **Modelo:** Con belongsToMany Cursos
  - **Seeder:** 12 materias creadas con códigos y colores

- [x] **aulas** - Salones de clase
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `nombre`, `capacidad`, `edificio`, `piso`, `timestamps`
  - **Modelo:** Con hasMany Paralelos
  - **Seeder:** 10 aulas creadas

#### Relaciones Académicas
- [x] **paralelos** - Secciones de cursos (A, B, C)
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `curso_id` (FK), `periodo_academico_id` (FK), `aula_id` (FK), `nombre`, `cupo_maximo`, `timestamps`
  - **Modelo:** Con relaciones belongsTo y belongsToMany
  - **Seeder:** 36 paralelos creados (A, B, C por curso)

- [x] **curso_materia** - Materias asignadas a cursos
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos: `id`, `curso_id` (FK), `materia_id` (FK), `periodo_academico_id` (FK), `horas_semanales`, `timestamps`
  - **Modelo:** Con belongsTo Curso, Materia, PeriodoAcademico
  - **Seeder:** 100 asignaciones creadas con diferenciaciónpor nivel

#### Usuarios Especializados
- [x] **docentes** - Información específica de docentes
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `user_id` (FK UNIQUE), `codigo_docente` (UNIQUE)
    - `titulo_profesional`, `especialidad`, `fecha_ingreso`
    - `tipo_contrato` (ENUM: nombramiento/contrato)
    - `estado` (ENUM: activo/inactivo/licencia, DEFAULT 'activo')
    - `timestamps`
  - **Modelo:** belongsTo User, scope activos(), accessor nombreCompleto
  - **Seeder:** 8 docentes creados con especialidades diversas

- [x] **estudiantes** - Información de alumnos
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `user_id` (FK UNIQUE), `codigo_estudiante` (UNIQUE)
    - `fecha_ingreso`, `tipo_sangre`, `alergias`
    - `contacto_emergencia`, `telefono_emergencia`
    - `estado` (ENUM: activo/inactivo/retirado, DEFAULT 'activo')
    - `timestamps`
  - **Modelo:** belongsTo User, belongsToMany Padres, scope activos(), accessor nombreCompleto
  - **Seeder:** 40 estudiantes creados con datos médicos

- [x] **padres** - Información de tutores
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `user_id` (FK UNIQUE)
    - `ocupacion`, `lugar_trabajo`, `telefono_trabajo`
    - `timestamps`
  - **Modelo:** belongsTo User, belongsToMany Estudiantes, accessor nombreCompleto
  - **Seeder:** 20 padres/madres creados

- [x] **estudiante_padre** - Relación tutor-estudiante
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `estudiante_id` (FK), `padre_id` (FK)
    - `parentesco` (ENUM: padre/madre/tutor/otro)
    - `es_principal` (BOOLEAN, DEFAULT FALSE)
    - `timestamps`
    - UNIQUE constraint (estudiante_id, padre_id)
  - **Seeder:** 80 relaciones creadas (cada estudiante vinculado a 2 padres)

#### Asignaciones Académicas
- [x] **docente_materia** - Asignación docente-materia-paralelo (Multi-docente)
  - Estado: ✅ **COMPLETA Y ACTUALIZADA**
  - Fecha: 30/12/2024
  - Arquitectura: Sistema de 2 tablas (asignaciones + bloques de tiempo)
  - Campos implementados:
    - `id`, `docente_id` (FK), `materia_id` (FK) - **Relación directa a materias**
    - `paralelo_id` (FK), `periodo_academico_id` (FK)
    - `rol` (VARCHAR 50, DEFAULT 'Principal')
    - `timestamps`
    - UNIQUE constraint (docente_id, materia_id, paralelo_id, periodo_academico_id)
  - **Modelo:** belongsTo Docente, Materia, Paralelo, PeriodoAcademico; hasMany Horarios
  - **Funcionalidades:** 
    - Permite múltiples docentes por materia (co-teaching, auxiliar, practicante)
    - Helper totalHorasAsignadas() para calcular carga horaria
    - Previene asignación duplicada del mismo docente
  - **Seeder:** 270 asignaciones creadas con rol 'Principal' con rol 'Principal'

- [x] **horarios** - Bloques de tiempo para asignaciones docente-materia
  - Estado: ✅ **COMPLETA Y ACTUALIZADA**
  - Fecha: 30/12/2024
  - Arquitectura: Depende de docente_materia_id (relación padre-hijo)
  - Campos implementados:
    - `id`, `docente_materia_id` (FK con CASCADE)
    - `dia_semana` (ENUM: Lunes/Martes/Miércoles/Jueves/Viernes/Sábado)
    - `hora_inicio` (TIME), `hora_fin` (TIME)
    - `timestamps`
  - **Modelo:** belongsTo DocenteMateria; Accessors para Docente, Materia, Paralelo
  - **Funcionalidades:**
    - Detección de conflictos (docente, aula, paralelo)
    - Validación de solapamiento de horarios
    - Cascade delete al eliminar asignación
  - **Seeder:** 900 horarios creados (distribución: Lunes-Jueves 216 c/u, Viernes 36)

- [x] **matriculas** - Matrícula de estudiantes por período
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `estudiante_id` (FK), `paralelo_id` (FK), `periodo_academico_id` (FK)
    - `numero_matricula` (UNIQUE), `fecha_matricula`, `estado` (ENUM: activa/retirada/trasladada/finalizada)
    - `observaciones`, `timestamps`
    - UNIQUE constraint (estudiante_id, paralelo_id, periodo_academico_id)
  - **Modelo:** belongsTo Estudiante, Paralelo, PeriodoAcademico; hasMany Calificaciones; scope activas()
  - **Seeder:** 40 matrículas creadas

#### Sistema de Calificaciones
- [x] **calificaciones** - Registro de calificaciones
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `matricula_id` (FK), `curso_materia_id` (FK), `parcial_id` (FK), `docente_id` (FK)
    - `nota_final` (DECIMAL 5,2), `observaciones`, `fecha_registro`
    - `estado` (ENUM: registrada/modificada/aprobada/publicada, DEFAULT 'registrada')
    - `timestamps`
    - UNIQUE constraint (matricula_id, curso_materia_id, parcial_id)
  - **Modelo:** belongsTo Matricula, CursoMateria, Parcial, Docente; hasMany Componentes; scopes aprobadas/publicadas
  - **Seeder:** Calificaciones generadas por estudiante, materia y parcial (6 parciales × materias × 40 estudiantes)

- [x] **componentes_calificacion** - Desglose de notas
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `calificacion_id` (FK)
    - `nombre` (VARCHAR 100), `tipo` (ENUM: tarea/leccion/examen/proyecto/participacion/otro)
    - `nota` (DECIMAL 5,2), `porcentaje` (DECIMAL 5,2)
    - `descripcion`, `timestamps`
  - **Modelo:** belongsTo Calificacion
  - **Seeder:** 4 componentes por calificación (Tareas 20%, Lecciones 20%, Trabajo en Clase 20%, Examen Parcial 40%)

---

### ✅ Tablas Completadas (30)

### ⏳ Tablas Pendientes (16)

#### Control de Asistencia
- [x] **asistencias** - Registro diario de asistencia
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `estudiante_id` (FK), `paralelo_id` (FK), `materia_id` (FK nullable), `docente_id` (FK)
    - `fecha` (DATE), `hora` (TIME nullable)
    - `estado` (ENUM: presente/ausente/atrasado/justificado, DEFAULT 'presente')
    - `observaciones` (TEXT nullable), `timestamps`
  - **Modelo:** 
    - belongsTo: Estudiante, Paralelo, Materia, Docente
    - hasMany: Justificaciones
    - Scopes: porFecha, porEstado, deEstudiante, deParalelo
  - **Índices:** (estudiante_id, fecha), (paralelo_id, fecha)

- [x] **justificaciones** - Justificaciones de inasistencias
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `asistencia_id` (FK), `padre_id` (FK)
    - `motivo` (TEXT), `archivo_adjunto` (VARCHAR 255 nullable)
    - `estado` (ENUM: pendiente/aprobada/rechazada, DEFAULT 'pendiente')
    - `revisado_por` (FK users nullable), `fecha_revision` (TIMESTAMP nullable)
    - `timestamps`
  - **Modelo:**
    - belongsTo: Asistencia, Padre, User (revisor)
    - Scopes: porEstado, pendientes, aprobadas, rechazadas

#### Tareas y Deberes
- [x] **tareas** - Tareas asignadas por docentes
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `docente_id` (FK), `materia_id` (FK), `paralelo_id` (FK nullable)
    - `titulo` (VARCHAR 255), `descripcion` (TEXT nullable)
    - `fecha_asignacion` (DATE), `fecha_entrega` (DATE)
    - `es_calificada` (BOOLEAN, DEFAULT false), `puntaje_maximo` (DECIMAL 4,2 nullable)
    - `timestamps`
  - **Modelo:**
    - belongsTo: Docente, Materia, Paralelo
    - hasMany: ArchivoTarea, TareaEstudiante
    - Scopes: proximasAVencer, vencidas, activas, deDocente, deParalelo
    - Accessors: estaVencida, diasRestantes
  - **Índices:** (docente_id, fecha_asignacion), (paralelo_id, fecha_entrega)

- [x] **archivos_tarea** - Archivos adjuntos a tareas
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `tarea_id` (FK)
    - `nombre_archivo` (VARCHAR 255), `ruta_archivo` (VARCHAR 255)
    - `tipo_mime` (VARCHAR 100 nullable), `tamanio` (INT nullable)
    - `created_at` (TIMESTAMP)
  - **Modelo:**
    - belongsTo: Tarea
    - Accessor: tamanioFormateado

- [x] **tarea_estudiante** - Seguimiento individual de tareas
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `tarea_id` (FK), `estudiante_id` (FK)
    - `estado` (ENUM: pendiente/completada/revisada, DEFAULT 'pendiente')
    - `fecha_completada` (TIMESTAMP nullable), `calificacion` (DECIMAL 4,2 nullable)
    - `comentarios_docente` (TEXT nullable), `fecha_revision` (TIMESTAMP nullable)
    - `timestamps`
    - UNIQUE constraint (tarea_id, estudiante_id)
  - **Modelo:**
    - belongsTo: Tarea, Estudiante
    - Scopes: porEstado, pendientes, completadas, revisadas, deEstudiante
    - Accessor: completadaATiempo

#### 💬 Comunicación (4 tablas - Secundarias)
- [ ] **mensajes** - Mensajes entre usuarios
---

### ✅ Tablas Completadas (46) - TODAS ✅

### ⏳ Tablas Pendientes (0) - NINGUNA 🎉

#### Comunicación
- [x] **mensajes** - Mensajes entre usuarios
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `remitente_id` (FK), `destinatario_id` (FK nullable)
    - `tipo` (ENUM: individual/masivo/anuncio, DEFAULT 'individual')
    - `asunto` (VARCHAR 255), `cuerpo` (TEXT)
    - `es_leido` (BOOLEAN), `fecha_lectura` (TIMESTAMP nullable)
    - `fecha_envio` (TIMESTAMP nullable), `programado_para` (TIMESTAMP nullable)
    - `timestamps`
  - **Modelo:**
    - belongsTo: Remitente (User), Destinatario (User)
    - hasMany: Adjuntos, Destinatarios
    - Scopes: noLeidos, leidos, recibidosPor, enviadosPor, porTipo, programados
    - Método: marcarComoLeido()
  - **Índices:** remitente_id, destinatario_id, fecha_envio

- [x] **mensaje_adjuntos** - Archivos adjuntos a mensajes
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `mensaje_id` (FK)
    - `nombre_archivo` (VARCHAR 255), `ruta_archivo` (VARCHAR 255)
    - `tipo_mime` (VARCHAR 100 nullable), `tamanio` (INT nullable)
    - `created_at` (TIMESTAMP)
  - **Modelo:**
    - belongsTo: Mensaje
    - Accessor: tamanioFormateado

- [x] **mensaje_destinatarios** - Destinatarios de mensajes masivos
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `mensaje_id` (FK), `destinatario_id` (FK)
    - `es_leido` (BOOLEAN, DEFAULT false), `fecha_lectura` (TIMESTAMP nullable)
    - `timestamps`
  - **Modelo:**
    - belongsTo: Mensaje, Destinatario (User)
    - Scopes: noLeidos, leidos
    - Método: marcarComoLeido()

- [x] **notificaciones** - Notificaciones del sistema
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `user_id` (FK)
    - `tipo` (VARCHAR 50), `titulo` (VARCHAR 255), `mensaje` (TEXT)
    - `url` (VARCHAR 255 nullable), `es_leida` (BOOLEAN, DEFAULT false)
    - `enviar_email` (BOOLEAN, DEFAULT false), `email_enviado` (BOOLEAN, DEFAULT false)
    - `fecha_envio` (TIMESTAMP nullable), `timestamps`
  - **Modelo:**
    - belongsTo: User
    - Scopes: noLeidas, leidas, porTipo, deUsuario, recientes
    - Métodos: marcarComoLeida(), marcarEmailEnviado()
  - **Índices:** (user_id, es_leida), tipo

#### 📅 Eventos y Calendario (3 tablas - Secundarias)
- [x] **eventos** - Eventos académicos y actividades
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `periodo_academico_id` (FK)
    - `tipo` (ENUM: examen/reunion/actividad/feriado/ceremonia/otro, DEFAULT 'actividad')
    - `titulo` (VARCHAR 255), `descripcion` (TEXT nullable)
    - `fecha_inicio` (DATE), `fecha_fin` (DATE nullable)
    - `hora_inicio` (TIME nullable), `hora_fin` (TIME nullable)
    - `ubicacion` (VARCHAR 255 nullable)
    - `requiere_confirmacion` (BOOLEAN DEFAULT false), `es_publico` (BOOLEAN DEFAULT true)
    - `timestamps`
  - **Modelo:**
    - belongsTo: PeriodoAcademico
    - belongsToMany: Paralelos
    - hasMany: Confirmaciones
    - Scopes: proximos, pasados, enCurso, porTipo, publicos, delPeriodo, delParalelo
    - Accessors: estaEnCurso, duracionDias, porcentajeConfirmacion
  - **Índices:** (periodo_academico_id, fecha_inicio), (tipo, fecha_inicio)
  - **Seeder:** 20 eventos generados (6 exámenes, 4 reuniones, 5 actividades, 2 ceremonias, 3 feriados)

- [x] **evento_curso** - Eventos dirigidos a cursos específicos
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `evento_id` (FK), `paralelo_id` (FK)
    - `timestamps`
    - UNIQUE constraint (evento_id, paralelo_id)
  - **Modelo:**
    - belongsTo: Evento, Paralelo
  - **Índices:** paralelo_id
  - **Seeder:** Relaciones generadas automáticamente con eventos

- [x] **evento_confirmacion** - Confirmaciones de asistencia
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `evento_id` (FK), `user_id` (FK), `estudiante_id` (FK nullable)
    - `confirmado` (BOOLEAN DEFAULT false)
    - `fecha_confirmacion` (TIMESTAMP nullable)
    - `observaciones` (TEXT nullable)
    - `timestamps`
    - UNIQUE constraint (evento_id, user_id, estudiante_id)
  - **Modelo:**
    - belongsTo: Evento, Usuario (User), Estudiante
    - Scopes: confirmados, pendientes, delEvento, delUsuario
    - Método: confirmar()
  - **Índices:** (evento_id, confirmado), user_id
  - **Seeder:** 640 confirmaciones generadas (465 confirmadas, 72.7% tasa)

#### ⏰ Horarios (1 tabla - Secundaria)
- [x] **horarios** - Horarios de clases
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `paralelo_id` (FK), `materia_id` (FK), `docente_id` (FK), `aula_id` (FK nullable)
    - `periodo_academico_id` (FK)
    - `dia_semana` (ENUM: lunes/martes/miercoles/jueves/viernes)
    - `hora_inicio` (TIME), `hora_fin` (TIME)
    - `timestamps`
    - UNIQUE constraint (paralelo_id, dia_semana, hora_inicio, periodo_academico_id)
  - **Modelo:**
    - belongsTo: Paralelo, Materia, Docente, Aula, PeriodoAcademico
    - Scopes: delParalelo, delDocente, delAula, porDia, delPeriodo, ordenadoPorHora
    - Accessors: duracionMinutos, horarioFormateado
    - Método: seSuperpone()
  - **Índices:** (paralelo_id, dia_semana), (docente_id, dia_semana), (aula_id, dia_semana)
  - **Seeder:** 900 horarios generados (216/216/216/216/36 por día L-V)

#### 🔍 Auditoría (1 tabla - Secundaria)
- [x] **auditoria_accesos** - Registro de auditoría
  - Estado: ✅ **COMPLETA**
  - Fecha: 24/12/2024
  - Campos implementados:
    - `id`, `user_id` (FK nullable)
    - `accion` (VARCHAR 100: login/logout/create/update/delete/view)
    - `tabla_afectada` (VARCHAR 100 nullable), `registro_id` (BIGINT nullable)
    - `ip_address` (IP nullable), `user_agent` (TEXT nullable)
    - `datos_anteriores` (JSON nullable), `datos_nuevos` (JSON nullable)
    - `descripcion` (TEXT nullable)
    - `created_at` (solo created_at, sin updated_at)
  - **Modelo:**
    - belongsTo: User (como usuario)
    - Scopes: delUsuario, porAccion, deTabla, deRegistro, entreFechas, recientes, porIp
    - Accessors: tieneModificaciones, cambios
    - Métodos estáticos: registrarAccion, registrarLogin, registrarLogout, registrarCreacion, registrarActualizacion, registrarEliminacion
  - **Índices:** (user_id, created_at), (tabla_afectada, registro_id), (accion, created_at), created_at
  - **Seeder:** 200 registros de auditoría (últimos 30 días, 6 tipos de acciones)

---

## 📊 Clasificación de Tablas

### 🔵 Tablas Principales (9) - Núcleo del Sistema
**Definición:** Tablas independientes que no dependen de otras (excepto referencias opcionales).

1. `users` - Base de autenticación
2. `instituciones` - Datos institucionales
3. `periodos_academicos` - Años lectivos
4. `cursos` - Grados educativos
5. `materias` - Catálogo de asignaturas
6. `aulas` - Salones físicos
7. `roles` - Roles del sistema (Spatie)
8. `permissions` - Permisos del sistema (Spatie)
9. `configuraciones` - Config sistema (depende de instituciones)

### 🟢 Tablas Secundarias (24) - Datos Dependientes
**Definición:** Tablas que extienden o dependen de las principales, pero no son solo relaciones.

#### Estructura Académica
10. `quimestres` - Depende de periodos_academicos
11. `parciales` - Depende de quimestres
12. `paralelos` - Depende de cursos

#### Usuarios Especializados
13. `docentes` - Extiende users
14. `estudiantes` - Extiende users
15. `padres` - Extiende users

#### Gestión Académica
16. `matriculas` - Depende de estudiantes, paralelos, periodos
17. `calificaciones` - Depende de matriculas, materias, parciales
18. `componentes_calificacion` - Depende de calificaciones
19. `asistencias` - Depende de estudiantes, paralelos, docentes
20. `justificaciones` - Depende de asistencias, padres

#### Tareas
21. `tareas` - Depende de docentes, materias, paralelos
22. `archivos_tarea` - Depende de tareas

#### Comunicación
23. `mensajes` - Depende de users
24. `mensaje_adjuntos` - Depende de mensajes
25. `notificaciones` - Depende de users

#### Eventos
26. `eventos` - Depende de periodos_academicos, users

#### Horarios
27. `horarios` - Depende de múltiples tablas

#### Auditoría
28. `auditoria_accesos` - Depende de users

#### Tablas adicionales (5 más)
29. `password_reset_tokens` - Relacionada con users
30. `sessions` - Sesiones de Laravel
31. `personal_access_tokens` - Tokens API (si se usa)
32. `failed_jobs` - Jobs fallidos de Laravel
33. `jobs` - Jobs pendientes de Laravel

### 🟡 Tablas Intermedias (13) - Relaciones Muchos a Muchos
**Definición:** Tablas pivote que conectan dos o más tablas principales/secundarias.

#### Spatie Laravel Permission (3)
34. `model_has_roles` - Polimórfica: users ↔ roles
35. `model_has_permissions` - Polimórfica: users ↔ permissions
36. `role_has_permissions` - roles ↔ permissions

#### Relaciones Académicas (6)
37. `curso_materia` - cursos ↔ materias
38. `docente_materia` - docentes ↔ curso_materia ↔ paralelos
39. `estudiante_padre` - estudiantes ↔ padres
40. `tarea_estudiante` - tareas ↔ estudiantes (con seguimiento)
41. `evento_curso` - eventos ↔ paralelos
42. `evento_confirmacion` - eventos ↔ users (con confirmación)

#### Comunicación (2)
43. `mensaje_destinatarios` - mensajes ↔ users (masivos)
44. `cache` - Cache de Laravel
45. `cache_locks` - Locks del cache
46. `job_batches` - Batches de jobs

---Refrescar base de datos ✅ LISTO
**Acción:** Ejecutar migraciones frescas

```bash
php artisan migrate:fresh --seed
``
**Actualizar modelo User:**
- Agregar nuevos campos a `$fillable`
- Agregar cast para `fecha_nacimiento` y `ultimo_acceso`
- Renombrar accessor `getFotoUrlAttribute` a `getFotoPerfilUrlAttribute`

### 2. Implementar Fase 2: Configuración Institucional
- Crear migración y modelo `Institucion`
- Crear migración y modelo `Configuracion`
- Seeders con datos iniciales

### 3. Implementar Fase 3: Estructura Académica Base
- Crear sistema de periodos académicos (Periodo, Quimestre, Parcial)
- Crear catálogos (Curso, Materia, Aula)

---

## 📝 Notas Importantes

### Consideraciones de Diseño

1. **Orden de creación de migraciones:**
   - Usar timestamps ordenados para mantener dependencias
   - Ejemplo: `2025_01_01_000001_` para instituciones antes que `2025_01_01_000002_` para configuraciones

2. **Relaciones Eloquent:**
   - Definir todas las relaciones en los modelos desde el inicio
   - Usar eager loading para optimizar consultas

3. **Validaciones:**
   - Crear Form Requests para cada operación CRUD
   - Validar unicidad de códigos (estudiantes, docentes, matrículas)

4. **Seeders:**
   - Crear seeders para datos de prueba de todas las tablas
   - Mantener seeders separados por categoría

5. **Políticas y Permisos:**
   - Definir políticas (Policies) para cada modelo
   - Usar gates cuando sea necesario

---

## 🎯 Objetivos por Semana

### Semana 1-2 (Actual)
- [x] Sistema de autenticación y permisos (Spatie)
- [x] CRUD de usuarios básico
- [x] CRUD de roles y permisos
- [x] Completar tabla users con todos los campos ✅ HECHO (23/12/2024)
- [x] Configuración institucional completa ✅ HECHO (23/12/2024)
- [x] Estructura académica base (periodos, cursos, materias) ✅ HECHO (23/12/2024)
- [x] Relaciones académicas (paralelos, curso_materia) ✅ HECHO (23/12/2024)

### Semana 3-4
- [ ] Sistema de docentes completo
- [ ] Sistema de estudiantes y padres

### Semana 5-6
- [ ] Sistema de docentes completo
- [ ] Sistema de estudiantes y padres
- [ ] Matrículas

### Semana 7-8
- [ ] Sistema de calificaciones
- [ ] Control de asistencia

### Semana 9-10
- [ ] Tareas y deberes
- [ ] Sistema de comunicación básico

### Semana 11-12
- [ ] Eventos y calendario
- [ ] Horarios
- [ ] Pulir y optimizar

---

## 📚 Referencias

- [Diagrama de Base de Datos](./4%20-%20Diagrama%20DB.md)
- [Historias de Usuario](./3%20-%20Historias%20de%20Usuario.md)
- [Requisitos del Sistema](./2%20-%20Requisitos.md)
- [Documentación Spatie Permission](https://spatie.be/docs/laravel-permission/v6)
- [Laravel Eloquent Relationships](https://laravel.com/docs/11.x/eloquent-relationships)

---

**Última revisión:** 23 de diciembre de 2024

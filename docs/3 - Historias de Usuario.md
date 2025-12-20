# Historias de Usuario

## Sistema de Gestión Académica y Comunicación Escolar
**Unidad Educativa Oswaldo Guayasamín - Galápagos**

---

## 📋 Índice

1. [Perfiles de Usuario](#perfiles-de-usuario)
2. [Historias de Usuario por Rol](#historias-de-usuario-por-rol)
3. [Épicas del Proyecto](#épicas-del-proyecto)
4. [Criterios de Aceptación Generales](#criterios-de-aceptación-generales)

---

## Perfiles de Usuario

### 👤 ROL 1: Administrador del Sistema

**Descripción**: Responsable de la gestión completa del sistema, configuración institucional y administración de usuarios.

**Características**:
- Acceso completo a todos los módulos
- Gestiona estructura académica (cursos, materias, períodos)
- Administra usuarios y asigna roles
- Configura parámetros del sistema
- Genera reportes institucionales
- Supervisa el funcionamiento general

**Contexto de Uso**: 
- Trabaja principalmente desde oficina administrativa
- Uso intensivo al inicio de año lectivo
- Acceso frecuente para resolver problemas y consultas

**Necesidades Principales**:
- Visibilidad global del sistema
- Herramientas de auditoría y monitoreo
- Reportes estadísticos institucionales
- Configuración flexible del sistema

---

### 👨‍🏫 ROL 2: Docente

**Descripción**: Profesor que imparte clases en una o varias materias y cursos.

**Características**:
- Registra calificaciones de estudiantes
- Toma asistencia diaria
- Crea y asigna tareas
- Comunica con padres y administradores
- Consulta información de sus estudiantes
- Genera reportes de su materia/curso

**Contexto de Uso**:
- Acceso diario desde aula o sala de profesores
- Uso en horario escolar principalmente
- Necesita acceso rápido durante clases
- Puede tener conectividad limitada

**Necesidades Principales**:
- Interfaces rápidas y sencillas
- Acceso móvil para tomar asistencia
- Visualización clara de sus cursos y estudiantes
- Herramientas de comunicación efectivas

---

### 👪 ROL 3: Padre/Madre de Familia

**Descripción**: Tutor legal del estudiante interesado en el seguimiento académico y conductual.

**Características**:
- Consulta calificaciones de sus hijos
- Revisa asistencia y justifica faltas
- Ve tareas y deberes asignados
- Recibe notificaciones importantes
- Se comunica con docentes
- Consulta calendario de eventos
- Puede tener varios hijos en la institución

**Contexto de Uso**:
- Acceso desde casa, trabajo o dispositivo móvil
- Horarios variables (tardes, fines de semana)
- Nivel variable de conocimiento tecnológico
- Prioridad: información clara y actualizada

**Necesidades Principales**:
- Interfaz intuitiva y simple
- Notificaciones oportunas
- Información consolidada de todos sus hijos
- Canal de comunicación directo con docentes

---

### 🎓 ROL 4: Estudiante

**Descripción**: Alumno matriculado en la institución que utiliza el sistema para seguimiento académico.

**Características**:
- Consulta sus calificaciones
- Ve tareas asignadas y fechas de entrega
- Marca tareas como completadas
- Consulta horario de clases
- Ve calendario de eventos
- Consulta su asistencia

**Contexto de Uso**:
- Acceso desde dispositivos móviles principalmente
- Uso durante y después de clases
- Edad variable (niños y adolescentes)
- Necesita interfaz amigable y motivadora

**Necesidades Principales**:
- Interfaz visual y atractiva
- Acceso rápido a tareas pendientes
- Recordatorios de fechas importantes
- Visualización clara de calificaciones

---

### 🔧 ROL 5: Administrador Técnico (Opcional)

**Descripción**: Personal técnico responsable del mantenimiento y soporte del sistema.

**Características**:
- Gestiona respaldos del sistema
- Monitorea rendimiento y errores
- Realiza mantenimiento técnico
- Configura aspectos técnicos del sistema
- Brinda soporte a usuarios

**Contexto de Uso**:
- Acceso según necesidad o programación
- Trabaja en backend del sistema
- Resuelve problemas técnicos

---

## Historias de Usuario por Rol

### 🎯 ÉPICA 1: Gestión de Usuarios y Autenticación

#### HU-001: Registro en el Sistema
**Como** Administrador  
**Quiero** registrar nuevos usuarios en el sistema (docentes, padres, estudiantes)  
**Para** que puedan acceder y utilizar las funcionalidades según su rol

**Criterios de Aceptación**:
- ✅ Puedo crear usuario seleccionando tipo de rol
- ✅ El sistema valida que el correo electrónico no esté duplicado
- ✅ Puedo asignar múltiples roles a un usuario (ej: docente-padre)
- ✅ El sistema envía correo con credenciales de acceso
- ✅ El usuario recibe contraseña temporal que debe cambiar en primer acceso
- ✅ Puedo configurar el estado del usuario (activo/inactivo)

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-002: Inicio de Sesión
**Como** Usuario del sistema (cualquier rol)  
**Quiero** iniciar sesión con mi correo y contraseña  
**Para** acceder a las funcionalidades del sistema según mi rol

**Criterios de Aceptación**:
- ✅ Puedo ingresar con correo electrónico y contraseña
- ✅ El sistema valida las credenciales correctamente
- ✅ Soy redirigido al dashboard correspondiente a mi rol
- ✅ El sistema muestra mensaje de error claro si las credenciales son incorrectas
- ✅ Mi cuenta se bloquea después de 5 intentos fallidos
- ✅ El sistema registra fecha y hora de mi último acceso
- ✅ La sesión expira después de 30 minutos de inactividad

**Prioridad**: Alta  
**Estimación**: 3 puntos

---

#### HU-003: Recuperación de Contraseña
**Como** Usuario que olvidó su contraseña  
**Quiero** recuperarla mediante mi correo electrónico  
**Para** poder acceder nuevamente al sistema

**Criterios de Aceptación**:
- ✅ Puedo solicitar recuperación ingresando mi correo electrónico
- ✅ Recibo un correo con enlace de restablecimiento
- ✅ El enlace expira después de 1 hora
- ✅ Puedo establecer una nueva contraseña
- ✅ La nueva contraseña debe cumplir requisitos de seguridad
- ✅ Recibo confirmación cuando la contraseña se cambió exitosamente

**Prioridad**: Alta  
**Estimación**: 3 puntos

---

#### HU-004: Actualizar Perfil Personal
**Como** Usuario del sistema  
**Quiero** actualizar mi información personal (foto, teléfono, dirección)  
**Para** mantener mis datos actualizados en el sistema

**Criterios de Aceptación**:
- ✅ Puedo acceder a mi perfil desde cualquier página
- ✅ Puedo cambiar mi foto de perfil (formatos: JPG, PNG, máximo 2MB)
- ✅ Puedo actualizar teléfono, dirección y otros datos de contacto
- ✅ Puedo cambiar mi contraseña desde el perfil
- ✅ Los cambios se guardan y reflejan inmediatamente
- ✅ Recibo confirmación de que los cambios fueron guardados

**Prioridad**: Media  
**Estimación**: 3 puntos

---

### 🎯 ÉPICA 2: Gestión Académica

#### HU-005: Crear Estructura Académica
**Como** Administrador  
**Quiero** crear y gestionar períodos académicos, cursos, paralelos y materias  
**Para** establecer la estructura educativa de la institución

**Criterios de Aceptación**:
- ✅ Puedo crear año lectivo con fechas de inicio y fin
- ✅ Puedo dividir el año en quimestres y parciales
- ✅ Puedo crear cursos/grados (1ro básica, 2do básica, etc.)
- ✅ Puedo crear paralelos por curso (A, B, C)
- ✅ Puedo asignar materias a cada curso
- ✅ Puedo definir carga horaria por materia
- ✅ El sistema valida que no haya duplicados

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-006: Asignar Docentes a Materias
**Como** Administrador  
**Quiero** asignar docentes a materias específicas de cada curso  
**Para** establecer la carga académica de los profesores

**Criterios de Aceptación**:
- ✅ Puedo buscar y seleccionar docentes registrados
- ✅ Puedo asignar un docente a una o varias materias
- ✅ Puedo asignar varias materias al mismo docente
- ✅ Puedo visualizar la carga horaria total del docente
- ✅ El sistema alerta si hay conflictos de horario
- ✅ Puedo reasignar o remover asignaciones

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-007: Matricular Estudiantes
**Como** Administrador  
**Quiero** matricular estudiantes en cursos específicos  
**Para** formalizar su inscripción en el año lectivo

**Criterios de Aceptación**:
- ✅ Puedo crear perfil de nuevo estudiante con datos personales
- ✅ Puedo asignar estudiante a curso y paralelo específico
- ✅ Puedo vincular estudiante con su padre/madre/tutor
- ✅ Puedo registrar datos de contacto de emergencia
- ✅ Puedo adjuntar documentación requerida
- ✅ El sistema genera código único de estudiante
- ✅ Puedo cambiar estudiante de curso si es necesario

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-008: Configurar Horario de Clases
**Como** Administrador  
**Quiero** configurar horarios de clase por curso  
**Para** organizar la distribución de materias durante la semana

**Criterios de Aceptación**:
- ✅ Puedo definir bloques horarios (ej: 7:00-7:40, 7:40-8:20)
- ✅ Puedo asignar materia y docente a cada bloque
- ✅ El sistema detecta conflictos de horario (docente/aula)
- ✅ Puedo visualizar horario semanal completo
- ✅ Puedo imprimir/exportar horario
- ✅ Puedo copiar horario de un paralelo a otro

**Prioridad**: Media  
**Estimación**: 8 puntos

---

### 🎯 ÉPICA 3: Gestión de Calificaciones

#### HU-009: Registrar Calificaciones
**Como** Docente  
**Quiero** registrar calificaciones de mis estudiantes por materia y período  
**Para** llevar control del rendimiento académico

**Criterios de Aceptación**:
- ✅ Puedo acceder a listado de estudiantes de mi materia/curso
- ✅ Puedo ingresar calificaciones individuales o por componentes
- ✅ El sistema valida que las notas estén en rango 0-10
- ✅ Puedo registrar observaciones cualitativas
- ✅ El sistema calcula automáticamente promedios
- ✅ Puedo editar calificaciones dentro del plazo permitido
- ✅ Los padres reciben notificación de nuevas calificaciones

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-010: Consultar Calificaciones (Padre)
**Como** Padre de familia  
**Quiero** consultar las calificaciones de mi hijo  
**Para** hacer seguimiento de su rendimiento académico

**Criterios de Aceptación**:
- ✅ Puedo ver todas las materias de mi hijo
- ✅ Puedo ver calificaciones por parcial y quimestre
- ✅ Puedo ver promedio general actualizado
- ✅ Puedo ver observaciones del docente
- ✅ Puedo ver histórico de calificaciones
- ✅ Puedo exportar/imprimir boletín de calificaciones
- ✅ Veo alertas si mi hijo está en riesgo académico (promedio < 7)

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-011: Consultar Mis Calificaciones (Estudiante)
**Como** Estudiante  
**Quiero** consultar mis calificaciones  
**Para** conocer mi rendimiento en cada materia

**Criterios de Aceptación**:
- ✅ Puedo ver mis calificaciones por materia
- ✅ Puedo ver desglose por componentes (tareas, lecciones, exámenes)
- ✅ Puedo ver mi promedio actual
- ✅ La información se presenta de forma visual y clara
- ✅ Puedo comparar mi rendimiento entre períodos
- ✅ Veo gráficos de mi evolución académica

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

### 🎯 ÉPICA 4: Gestión de Asistencia

#### HU-012: Registrar Asistencia Diaria
**Como** Docente  
**Quiero** registrar la asistencia de estudiantes en mi clase  
**Para** llevar control de presencia y puntualidad

**Criterios de Aceptación**:
- ✅ Puedo acceder a lista de estudiantes de mi clase actual
- ✅ Puedo marcar cada estudiante como: Presente, Ausente, Atrasado, Justificado
- ✅ Puedo marcar asistencia masiva (todos presentes)
- ✅ Puedo agregar observaciones si es necesario
- ✅ El sistema guarda fecha, hora y materia de registro
- ✅ Los padres reciben notificación cuando estudiante está ausente
- ✅ Puedo corregir asistencia el mismo día

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-013: Justificar Inasistencias
**Como** Padre de familia  
**Quiero** justificar las inasistencias de mi hijo  
**Para** que queden registradas como faltas justificadas

**Criterios de Aceptación**:
- ✅ Puedo ver listado de inasistencias de mi hijo
- ✅ Puedo enviar justificación describiendo el motivo
- ✅ Puedo adjuntar certificado médico u otro documento (PDF, imagen)
- ✅ El docente/administrador recibe la justificación
- ✅ Puedo ver estado de mi justificación (pendiente/aprobada/rechazada)
- ✅ Recibo notificación cuando mi justificación es procesada

**Prioridad**: Media  
**Estimación**: 5 puntos

---

#### HU-014: Consultar Asistencia
**Como** Padre de familia  
**Quiero** consultar el registro de asistencia de mi hijo  
**Para** conocer su puntualidad y asistencia a clases

**Criterios de Aceptación**:
- ✅ Puedo ver porcentaje de asistencia del período
- ✅ Puedo ver calendario con días presente/ausente/atrasado
- ✅ Puedo filtrar por mes o período
- ✅ Puedo ver alertas si se acerca a límite de inasistencias
- ✅ Puedo ver reporte detallado por materia
- ✅ Puedo exportar reporte de asistencia

**Prioridad**: Media  
**Estimación**: 5 puntos

---

### 🎯 ÉPICA 5: Gestión de Tareas y Deberes

#### HU-015: Crear y Asignar Tareas
**Como** Docente  
**Quiero** crear tareas y asignarlas a mis estudiantes  
**Para** reforzar el aprendizaje y evaluar comprensión

**Criterios de Aceptación**:
- ✅ Puedo crear tarea con título, descripción y fecha de entrega
- ✅ Puedo adjuntar archivos de apoyo (PDF, imágenes, documentos)
- ✅ Puedo asignar tarea a uno o varios cursos
- ✅ Puedo definir si la tarea es calificada o no
- ✅ Los estudiantes y padres reciben notificación de nueva tarea
- ✅ Puedo editar o eliminar tarea antes de fecha de entrega
- ✅ Puedo duplicar tareas para otras secciones

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-016: Ver Tareas Asignadas (Estudiante)
**Como** Estudiante  
**Quiero** ver las tareas que me han asignado  
**Para** completarlas a tiempo

**Criterios de Aceptación**:
- ✅ Puedo ver listado de todas mis tareas pendientes
- ✅ Puedo ver descripción completa y archivos adjuntos
- ✅ Puedo ver fecha de entrega claramente
- ✅ Veo alerta si tarea vence en menos de 24 horas
- ✅ Puedo marcar tarea como completada
- ✅ Puedo ver calendario visual con tareas del mes
- ✅ Puedo filtrar tareas por materia

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-017: Revisar Tareas Entregadas
**Como** Docente  
**Quiero** revisar las tareas marcadas como completadas  
**Para** calificarlas y dar retroalimentación

**Criterios de Aceptación**:
- ✅ Puedo ver listado de estudiantes que completaron la tarea
- ✅ Puedo ver quiénes no han completado
- ✅ Puedo registrar calificación de la tarea
- ✅ Puedo agregar comentarios/retroalimentación
- ✅ El estudiante recibe notificación de calificación
- ✅ Puedo exportar reporte de tareas completadas

**Prioridad**: Media  
**Estimación**: 5 puntos

---

### 🎯 ÉPICA 6: Sistema de Comunicación

#### HU-018: Enviar Mensajes Individuales
**Como** Docente o Administrador  
**Quiero** enviar mensajes a padres o colegas  
**Para** comunicar información importante

**Criterios de Aceptación**:
- ✅ Puedo seleccionar destinatario desde listado
- ✅ Puedo redactar mensaje con título y cuerpo
- ✅ Puedo adjuntar archivos al mensaje
- ✅ El destinatario recibe notificación en plataforma y email
- ✅ Puedo ver historial de mensajes enviados
- ✅ Puedo ver si el mensaje fue leído
- ✅ El destinatario puede responder el mensaje

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-019: Enviar Comunicados Masivos
**Como** Administrador o Docente  
**Quiero** enviar comunicados a todos los padres de un curso  
**Para** informar sobre eventos o situaciones importantes

**Criterios de Aceptación**:
- ✅ Puedo seleccionar curso o nivel completo
- ✅ Puedo redactar comunicado y adjuntar archivos
- ✅ Puedo previsualizar antes de enviar
- ✅ Todos los destinatarios reciben notificación
- ✅ Puedo ver estadísticas de mensajes leídos
- ✅ Puedo programar envío para fecha futura
- ✅ Puedo guardar como borrador

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-020: Recibir Notificaciones
**Como** Usuario del sistema  
**Quiero** recibir notificaciones de eventos importantes  
**Para** mantenerme informado oportunamente

**Criterios de Aceptación**:
- ✅ Recibo notificaciones en tiempo real dentro de la plataforma
- ✅ Veo contador de notificaciones no leídas
- ✅ Puedo configurar qué notificaciones recibir por email
- ✅ Puedo marcar notificaciones como leídas
- ✅ Puedo acceder al contenido desde la notificación
- ✅ Las notificaciones se agrupan por tipo
- ✅ Puedo eliminar notificaciones antiguas

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

### 🎯 ÉPICA 7: Reportes y Estadísticas

#### HU-021: Generar Boletín de Calificaciones
**Como** Administrador o Docente  
**Quiero** generar boletines de calificaciones  
**Para** entregar documentos oficiales a padres

**Criterios de Aceptación**:
- ✅ Puedo generar boletín individual o por curso
- ✅ El boletín incluye todas las materias y promedios
- ✅ El boletín incluye logo y datos de la institución
- ✅ El boletín se genera en formato PDF
- ✅ Puedo seleccionar período (parcial, quimestre, anual)
- ✅ El documento cumple con formato oficial ecuatoriano
- ✅ Puedo descargar o enviar por email

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-022: Ver Estadísticas de Curso
**Como** Docente  
**Quiero** ver estadísticas de rendimiento de mi curso  
**Para** identificar tendencias y áreas de mejora

**Criterios de Aceptación**:
- ✅ Puedo ver promedio general del curso
- ✅ Puedo ver distribución de calificaciones (cuántos en cada rango)
- ✅ Puedo ver estudiantes con mejor y menor rendimiento
- ✅ Puedo ver porcentaje de asistencia del curso
- ✅ Puedo ver gráficos visuales de estadísticas
- ✅ Puedo comparar con períodos anteriores
- ✅ Puedo exportar reportes en Excel o PDF

**Prioridad**: Media  
**Estimación**: 8 puntos

---

#### HU-023: Generar Reportes Institucionales
**Como** Administrador  
**Quiero** generar reportes estadísticos institucionales  
**Para** tomar decisiones informadas y cumplir reportes oficiales

**Criterios de Aceptación**:
- ✅ Puedo generar reporte de rendimiento por curso/nivel
- ✅ Puedo generar reporte de asistencia institucional
- ✅ Puedo generar reporte de estudiantes en riesgo académico
- ✅ Puedo generar listados de estudiantes por diversos criterios
- ✅ Puedo comparar períodos académicos
- ✅ Puedo exportar en múltiples formatos (PDF, Excel)
- ✅ Los reportes incluyen gráficos estadísticos

**Prioridad**: Media  
**Estimación**: 13 puntos

---

### 🎯 ÉPICA 8: Dashboard y Visualización

#### HU-024: Dashboard de Docente
**Como** Docente  
**Quiero** ver un dashboard personalizado al iniciar sesión  
**Para** acceder rápidamente a información relevante

**Criterios de Aceptación**:
- ✅ Veo mis cursos y materias asignadas
- ✅ Veo lista de clases del día con horarios
- ✅ Veo tareas pendientes de revisión con contador
- ✅ Veo notificaciones recientes
- ✅ Veo accesos rápidos a funciones frecuentes
- ✅ Veo calendario con eventos próximos
- ✅ El dashboard se actualiza en tiempo real

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-025: Dashboard de Padre
**Como** Padre de familia  
**Quiero** ver un dashboard con información de mis hijos  
**Para** tener vista consolidada de su situación académica

**Criterios de Aceptación**:
- ✅ Veo calificaciones recientes de cada hijo
- ✅ Veo asistencia de la semana
- ✅ Veo tareas pendientes
- ✅ Veo próximos eventos y reuniones
- ✅ Veo notificaciones importantes
- ✅ Puedo cambiar entre hijos si tengo varios
- ✅ Veo alertas si hay situaciones que requieren atención

**Prioridad**: Alta  
**Estimación**: 8 puntos

---

#### HU-026: Dashboard de Estudiante
**Como** Estudiante  
**Quiero** ver un dashboard personalizado  
**Para** conocer mi situación académica actual

**Criterios de Aceptación**:
- ✅ Veo mis próximas tareas con fechas de entrega
- ✅ Veo mi horario de clases del día
- ✅ Veo mis calificaciones recientes
- ✅ Veo calendario de eventos
- ✅ Veo notificaciones importantes
- ✅ Veo progreso visual de mi rendimiento
- ✅ La interfaz es visual y motivadora

**Prioridad**: Alta  
**Estimación**: 5 puntos

---

#### HU-027: Dashboard de Administrador
**Como** Administrador  
**Quiero** ver dashboard con estadísticas generales  
**Para** monitorear el funcionamiento institucional

**Criterios de Aceptación**:
- ✅ Veo cantidad total de estudiantes, docentes, cursos
- ✅ Veo gráficos de rendimiento académico general
- ✅ Veo estadísticas de asistencia institucional
- ✅ Veo alertas del sistema y situaciones pendientes
- ✅ Veo usuarios activos en el sistema
- ✅ Veo eventos próximos del calendario
- ✅ Veo accesos rápidos a funciones administrativas

**Prioridad**: Media  
**Estimación**: 8 puntos

---

### 🎯 ÉPICA 9: Gestión de Eventos y Calendario

#### HU-028: Crear Eventos Académicos
**Como** Administrador o Docente  
**Quiero** crear eventos en el calendario académico  
**Para** que todos los usuarios estén informados

**Criterios de Aceptación**:
- ✅ Puedo crear evento con título, descripción, fecha y hora
- ✅ Puedo categorizar evento (examen, reunión, actividad, feriado)
- ✅ Puedo asignar evento a cursos específicos o institucional
- ✅ Puedo configurar recordatorios automáticos
- ✅ Puedo adjuntar documentos al evento
- ✅ Los usuarios relacionados reciben notificación
- ✅ Puedo editar o cancelar eventos

**Prioridad**: Media  
**Estimación**: 5 puntos

---

#### HU-029: Consultar Calendario Académico
**Como** Usuario del sistema  
**Quiero** consultar el calendario de eventos  
**Para** planificar y estar preparado

**Criterios de Aceptación**:
- ✅ Puedo ver calendario mensual con eventos
- ✅ Puedo cambiar entre vistas: mes, semana, día
- ✅ Puedo hacer clic en evento para ver detalles
- ✅ Los eventos tienen código de colores según categoría
- ✅ Puedo filtrar eventos por tipo
- ✅ Puedo exportar calendario a formato iCal
- ✅ Recibo recordatorios de eventos próximos

**Prioridad**: Media  
**Estimación**: 8 puntos

---

#### HU-030: Programar Reuniones con Padres
**Como** Docente  
**Quiero** programar reuniones individuales con padres  
**Para** coordinar entrevistas y seguimiento

**Criterios de Aceptación**:
- ✅ Puedo crear evento de reunión seleccionando padre
- ✅ Puedo definir fecha, hora y duración
- ✅ Puedo agregar motivo de la reunión
- ✅ El padre recibe invitación con opción de confirmar
- ✅ Puedo ver estado de confirmación
- ✅ Ambos reciben recordatorio antes de la reunión
- ✅ Puedo reprogramar o cancelar reunión

**Prioridad**: Baja  
**Estimación**: 5 puntos

---

### 🎯 ÉPICA 10: Configuración del Sistema

#### HU-031: Configurar Parámetros Institucionales
**Como** Administrador  
**Quiero** configurar parámetros del sistema  
**Para** personalizar el funcionamiento según necesidades

**Criterios de Aceptación**:
- ✅ Puedo subir logo y personalizar colores institucionales
- ✅ Puedo configurar escala de calificaciones
- ✅ Puedo definir límite de inasistencias permitidas
- ✅ Puedo configurar períodos de bloqueo para edición de notas
- ✅ Puedo configurar horarios de envío de notificaciones
- ✅ Puedo personalizar plantillas de correos
- ✅ Los cambios se aplican inmediatamente

**Prioridad**: Media  
**Estimación**: 8 puntos

---

#### HU-032: Gestionar Respaldos
**Como** Administrador  
**Quiero** configurar respaldos automáticos  
**Para** proteger la información del sistema

**Criterios de Aceptación**:
- ✅ Puedo configurar frecuencia de respaldos automáticos
- ✅ Puedo ejecutar respaldo manual cuando sea necesario
- ✅ Puedo ver historial de respaldos realizados
- ✅ Puedo descargar respaldos previos
- ✅ El sistema me alerta si un respaldo falla
- ✅ Los respaldos incluyen base de datos y archivos

**Prioridad**: Media  
**Estimación**: 8 puntos

---

## Épicas del Proyecto

| # | Épica | Historias | Puntos Total | Prioridad |
|---|-------|-----------|--------------|-----------|
| 1 | Gestión de Usuarios y Autenticación | HU-001 a HU-004 | 14 | Alta |
| 2 | Gestión Académica | HU-005 a HU-008 | 29 | Alta |
| 3 | Gestión de Calificaciones | HU-009 a HU-011 | 18 | Alta |
| 4 | Gestión de Asistencia | HU-012 a HU-014 | 15 | Alta |
| 5 | Gestión de Tareas y Deberes | HU-015 a HU-017 | 15 | Alta |
| 6 | Sistema de Comunicación | HU-018 a HU-020 | 15 | Alta |
| 7 | Reportes y Estadísticas | HU-021 a HU-023 | 29 | Media |
| 8 | Dashboard y Visualización | HU-024 a HU-027 | 29 | Alta |
| 9 | Gestión de Eventos y Calendario | HU-028 a HU-030 | 18 | Media |
| 10 | Configuración del Sistema | HU-031 a HU-032 | 16 | Media |
| **TOTAL** | **10 Épicas** | **32 Historias** | **198 puntos** | - |

---

## Criterios de Aceptación Generales

### Todos los Formularios:
- ✅ Validación de campos requeridos en cliente y servidor
- ✅ Mensajes de error claros y específicos
- ✅ Feedback visual de campos con error
- ✅ Confirmación exitosa después de guardar
- ✅ Botón de cancelar que no pierde datos sin confirmar

### Todas las Tablas/Listados:
- ✅ Paginación con selector de registros por página
- ✅ Búsqueda en tiempo real
- ✅ Ordenación por columnas
- ✅ Filtros relevantes según contexto
- ✅ Exportación a PDF/Excel cuando sea relevante
- ✅ Responsive en dispositivos móviles

### Todas las Notificaciones:
- ✅ Visible en plataforma con contador
- ✅ Opción de envío por email configurable
- ✅ Marca de leído/no leído
- ✅ Enlace directo al contenido relacionado
- ✅ Opción de eliminar

### Seguridad:
- ✅ Control de acceso basado en roles
- ✅ Validación de permisos en cada acción
- ✅ Protección CSRF en formularios
- ✅ Sanitización de entradas
- ✅ Registro de auditoría en acciones críticas

### Usabilidad:
- ✅ Tiempos de carga menores a 3 segundos
- ✅ Responsive design para móviles y tablets
- ✅ Navegación intuitiva con máximo 3 clics
- ✅ Ayuda contextual disponible
- ✅ Confirmación antes de acciones destructivas

---

## Priorización de Desarrollo

### Sprint 1-2: Fundamentos (Prioridad Alta)
- HU-001, HU-002, HU-003, HU-004 (Autenticación)
- HU-005, HU-006, HU-007 (Estructura académica básica)

### Sprint 3-4: Core Académico (Prioridad Alta)
- HU-009, HU-010, HU-011 (Calificaciones)
- HU-012, HU-014 (Asistencia básica)
- HU-024, HU-025, HU-026 (Dashboards)

### Sprint 5-6: Comunicación y Tareas (Prioridad Alta)
- HU-015, HU-016, HU-017 (Tareas)
- HU-018, HU-019, HU-020 (Comunicación)

### Sprint 7-8: Reportes y Eventos (Prioridad Media)
- HU-021, HU-022 (Reportes básicos)
- HU-028, HU-029 (Calendario)
- HU-008 (Horarios)

### Sprint 9-10: Funcionalidades Avanzadas (Prioridad Media-Baja)
- HU-013 (Justificaciones)
- HU-023, HU-027 (Reportes avanzados)
- HU-030, HU-031, HU-032 (Configuración)

---

## Definición de Hecho (Definition of Done)

Una historia de usuario se considera completa cuando:

1. ✅ Código desarrollado y revisado
2. ✅ Pruebas unitarias implementadas y pasando
3. ✅ Pruebas de integración ejecutadas exitosamente
4. ✅ Validado por usuario final (QA)
5. ✅ Documentación técnica actualizada
6. ✅ Responsive y funcional en móviles
7. ✅ Sin errores críticos ni bloqueantes
8. ✅ Cumple criterios de aceptación específicos
9. ✅ Deployado en ambiente de pruebas
10. ✅ Aprobado por Product Owner

---

**Documento preparado para**: Unidad Educativa Oswaldo Guayasamín - Galápagos  
**Proyecto**: Sistema de Gestión Académica y Comunicación Escolar  
**Total de Historias**: 32  
**Total Story Points**: 198  
**Última actualización**: 20 de diciembre de 2025

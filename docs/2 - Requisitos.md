# Requisitos Funcionales y No Funcionales

## Sistema de Gestión Académica y Comunicación Escolar
**Unidad Educativa Oswaldo Guayasamín - Galápagos**

---

## 📋 Índice

1. [Requisitos Funcionales](#requisitos-funcionales)
2. [Requisitos No Funcionales](#requisitos-no-funcionales)
3. [Componentes Reutilizables del Sistema](#componentes-reutilizables-del-sistema)
4. [Resumen de Requisitos](#resumen-de-requisitos)

---

## Requisitos Funcionales

### RF001 - Gestión de Usuarios

1. El sistema debe permitir el registro de usuarios con roles: Administrador, Docente, Padre/Madre, Estudiante
2. El sistema debe permitir la autenticación mediante correo electrónico y contraseña
3. El sistema debe permitir la recuperación de contraseña mediante correo electrónico
4. El sistema debe permitir al administrador crear, editar, desactivar y eliminar cuentas de usuario
5. El sistema debe permitir a los usuarios actualizar su información de perfil (foto, teléfono, dirección)
6. El sistema debe mantener un registro de auditoría de accesos al sistema
7. El sistema debe permitir la asignación de múltiples roles a un usuario (ej: Docente que también es padre)
8. El sistema debe cerrar sesión automáticamente después de 30 minutos de inactividad

### RF002 - Gestión Académica - Estructura

1. El sistema debe permitir crear y gestionar períodos académicos (año lectivo, quimestres, parciales)
2. El sistema debe permitir crear y gestionar cursos/grados (1ro básica, 2do básica, etc.)
3. El sistema debe permitir crear y gestionar paralelos por curso (A, B, C)
4. El sistema debe permitir asignar materias a cada curso
5. El sistema debe permitir asignar docentes a materias específicas de un curso
6. El sistema debe permitir matricular estudiantes en cursos específicos
7. El sistema debe permitir configurar horarios de clase por curso
8. El sistema debe permitir gestionar aulas/salones de clase

### RF003 - Gestión de Calificaciones

1. El sistema debe permitir a los docentes registrar calificaciones por materia, estudiante y período
2. El sistema debe validar que las calificaciones estén en el rango permitido (0-10 en Ecuador)
3. El sistema debe calcular automáticamente promedios por quimestre y año lectivo
4. El sistema debe permitir el registro de calificaciones por componentes (tareas, lecciones, exámenes)
5. El sistema debe permitir editar calificaciones dentro de un plazo configurable
6. El sistema debe notificar a los padres cuando se registren nuevas calificaciones
7. El sistema debe permitir registrar observaciones cualitativas junto a las calificaciones
8. El sistema debe generar promedios finales automáticamente según normativa educativa ecuatoriana
9. El sistema debe identificar estudiantes en riesgo académico (promedio < 7)

### RF004 - Gestión de Asistencia

1. El sistema debe permitir a los docentes registrar asistencia diaria por clase
2. El sistema debe permitir marcar estudiantes como: Presente, Ausente, Atrasado, Justificado
3. El sistema debe calcular automáticamente el porcentaje de asistencia por estudiante
4. El sistema debe notificar a los padres cuando un estudiante falte a clase
5. El sistema debe permitir justificar inasistencias adjuntando documentos
6. El sistema debe generar reportes de asistencia por estudiante, curso y período
7. El sistema debe alertar cuando un estudiante supere el límite de inasistencias permitido
8. El sistema debe permitir registrar asistencia masiva (todos presentes/ausentes)

### RF005 - Gestión de Tareas y Deberes

1. El sistema debe permitir a los docentes crear y publicar tareas con fecha de entrega
2. El sistema debe permitir adjuntar archivos a las tareas (PDF, imágenes, documentos)
3. El sistema debe notificar a estudiantes y padres sobre nuevas tareas asignadas
4. El sistema debe mostrar un calendario de tareas pendientes para estudiantes
5. El sistema debe permitir a los estudiantes marcar tareas como completadas
6. El sistema debe alertar sobre tareas próximas a vencer (24 horas antes)
7. El sistema debe permitir al docente revisar y calificar tareas entregadas
8. El sistema debe mantener un historial de todas las tareas asignadas

### RF006 - Sistema de Comunicación

1. El sistema debe permitir enviar mensajes entre docentes, padres y administradores
2. El sistema debe permitir enviar comunicados masivos por curso o nivel
3. El sistema debe permitir notificaciones en tiempo real dentro de la plataforma
4. El sistema debe enviar notificaciones por correo electrónico (configurable por usuario)
5. El sistema debe permitir adjuntar archivos en los mensajes
6. El sistema debe mantener un historial de todos los mensajes enviados y recibidos
7. El sistema debe permitir marcar mensajes como leídos/no leídos
8. El sistema debe permitir crear anuncios institucionales visibles en el dashboard
9. El sistema debe permitir programar el envío de mensajes para fecha futura

### RF007 - Reportes y Estadísticas

1. El sistema debe generar boletines de calificaciones individuales por estudiante
2. El sistema debe generar reportes de rendimiento académico por curso
3. El sistema debe generar reportes de asistencia individuales y grupales
4. El sistema debe generar listados de estudiantes por curso y paralelo
5. El sistema debe generar estadísticas de desempeño por materia
6. El sistema debe permitir exportar reportes en formato PDF y Excel
7. El sistema debe generar reportes comparativos entre períodos académicos
8. El sistema debe generar reportes de estudiantes en riesgo académico
9. El sistema debe generar certificados de notas digitales

### RF008 - Dashboard y Visualización

1. El sistema debe mostrar un dashboard personalizado según el rol del usuario
2. Los docentes deben ver: cursos asignados, tareas pendientes de revisión, asistencias del día
3. Los padres deben ver: calificaciones recientes, asistencia, tareas pendientes de sus hijos
4. Los estudiantes deben ver: próximas tareas, calificaciones, horario de clases
5. Los administradores deben ver: estadísticas generales, alertas del sistema, usuarios activos
6. El sistema debe mostrar gráficos de rendimiento académico
7. El sistema debe mostrar un calendario académico con eventos importantes

### RF009 - Gestión de Eventos y Calendario

1. El sistema debe permitir crear y gestionar eventos académicos (exámenes, reuniones, actividades)
2. El sistema debe mostrar un calendario académico visible para todos los usuarios
3. El sistema debe permitir programar reuniones con padres de familia
4. El sistema debe enviar recordatorios automáticos de eventos próximos
5. El sistema debe permitir que los padres confirmen asistencia a eventos
6. El sistema debe sincronizar eventos con calendarios externos (Google Calendar, opcional)

### RF010 - Configuración del Sistema

1. El sistema debe permitir configurar la escala de calificaciones
2. El sistema debe permitir configurar períodos de bloqueo para edición de notas
3. El sistema debe permitir configurar plantillas de notificaciones
4. El sistema debe permitir personalizar el logo y colores de la institución
5. El sistema debe permitir configurar el límite de inasistencias permitidas
6. El sistema debe permitir configurar horarios de notificaciones
7. El sistema debe mantener respaldos automáticos de la base de datos

---

## Requisitos No Funcionales

### RNF001 - Usabilidad

1. La interfaz debe ser intuitiva y fácil de usar para usuarios con conocimientos básicos de computación
2. El sistema debe ser responsive y funcionar en dispositivos móviles, tablets y computadoras
3. El sistema debe proporcionar mensajes de error claros y orientativos
4. El sistema debe incluir ayuda contextual en cada módulo
5. El tiempo de carga de páginas no debe exceder 3 segundos
6. El sistema debe mantener consistencia visual en todos los módulos

### RNF002 - Rendimiento

1. El sistema debe soportar al menos 200 usuarios concurrentes
2. Las consultas a la base de datos deben responder en menos de 2 segundos
3. El sistema debe funcionar eficientemente con conectividad limitada (optimización para Galápagos)
4. El sistema debe cargar recursos estáticos mediante caché del navegador
5. El sistema debe implementar paginación para listados con más de 50 registros

### RNF003 - Seguridad

1. El sistema debe encriptar todas las contraseñas usando algoritmos seguros (bcrypt)
2. El sistema debe implementar protección contra ataques SQL Injection
3. El sistema debe implementar protección contra ataques XSS (Cross-Site Scripting)
4. El sistema debe implementar protección CSRF (Cross-Site Request Forgery)
5. El sistema debe validar todos los datos de entrada en el servidor
6. El sistema debe implementar control de acceso basado en roles (RBAC)
7. El sistema debe usar conexiones HTTPS para todas las comunicaciones
8. El sistema debe registrar intentos fallidos de inicio de sesión
9. El sistema debe bloquear cuentas después de 5 intentos fallidos de login

### RNF004 - Disponibilidad

1. El sistema debe tener una disponibilidad del 99% durante horario escolar
2. El sistema debe realizar respaldos automáticos diarios
3. El sistema debe mantener logs de errores para diagnóstico
4. El sistema debe permitir mantenimiento sin interrumpir el servicio (cuando sea posible)

### RNF005 - Mantenibilidad

1. El código debe seguir estándares PSR (PHP Standard Recommendations)
2. El código debe estar documentado con comentarios claros
3. El sistema debe usar migraciones para control de cambios en la base de datos
4. El sistema debe implementar arquitectura MVC (Model-View-Controller)
5. El sistema debe usar versionamiento de código (Git)

### RNF006 - Escalabilidad

1. El sistema debe permitir agregar nuevos módulos sin afectar los existentes
2. La arquitectura debe soportar crecimiento de usuarios hasta 1000 estudiantes
3. El sistema debe permitir integración con APIs externas futuras

### RNF007 - Compatibilidad

1. El sistema debe funcionar en navegadores: Chrome, Firefox, Safari, Edge (versiones actuales)
2. El sistema debe ser compatible con MySQL 8.0 o superior
3. El sistema debe funcionar en servidores con PHP 8.1 o superior
4. El sistema debe ser compatible con Laravel 10.x o superior

### RNF008 - Accesibilidad

1. El sistema debe seguir pautas básicas de accesibilidad WCAG 2.1 nivel AA
2. El sistema debe permitir navegación mediante teclado
3. El sistema debe usar etiquetas alt en todas las imágenes
4. El sistema debe mantener contraste adecuado de colores para legibilidad

---

## Componentes Reutilizables del Sistema

### COMP001 - Componente de Tabla de Datos (DataTable)

El sistema debe implementar un componente de tabla de datos reutilizable con las siguientes características:

#### Características Generales
1. El componente debe ser reutilizable en todos los módulos del sistema
2. El componente debe adaptarse responsivamente a diferentes tamaños de pantalla
3. El componente debe mantener consistencia visual con el diseño del sistema

#### Paginación
1. El componente debe implementar paginación del lado del servidor (server-side) para soportar gran volumen de datos
2. El componente debe permitir configurar el número de registros por página (10, 25, 50, 100)
3. El componente debe cargar datos mediante AJAX para evitar recarga completa de página
4. El componente debe mostrar información de paginación (ej: "Mostrando 1-25 de 150 registros")
5. El componente debe incluir controles de navegación: Primera página, Anterior, Siguiente, Última página
6. El componente debe permitir navegación directa a página específica mediante input numérico

#### Ordenación de Columnas
1. El componente debe permitir ordenar datos por cualquier columna clickeable
2. El componente debe soportar ordenación ascendente (ASC) y descendente (DESC)
3. El componente debe mostrar indicadores visuales del estado de ordenación (flechas ↑↓)
4. El componente debe mantener el estado de ordenación durante la sesión
5. El componente debe permitir ordenación multi-columna (opcional)

#### Búsqueda
1. El componente debe incluir campo de búsqueda global
2. La búsqueda debe ejecutarse mediante AJAX sin recargar la página
3. La búsqueda debe implementar debounce (retraso de 300-500ms) para optimizar consultas
4. El componente debe destacar visualmente los términos de búsqueda en los resultados
5. El componente debe mostrar mensaje cuando no hay resultados

#### Filtros
1. El componente debe soportar filtros personalizables por columna
2. El componente debe permitir filtros por: texto, fecha, rango numérico, selección múltiple
3. Los filtros deben aplicarse de forma acumulativa (AND entre filtros)
4. El componente debe mostrar contador de filtros activos
5. El componente debe permitir limpiar todos los filtros con un solo clic
6. Los filtros deben persistir durante la navegación dentro del módulo

#### Mostrar/Ocultar Columnas
1. El componente debe permitir al usuario seleccionar qué columnas mostrar
2. El componente debe incluir menú desplegable con lista de columnas disponibles
3. El componente debe guardar las preferencias de columnas visibles por usuario
4. El componente debe incluir opción "Restablecer vista predeterminada"
5. El componente debe mantener al menos una columna visible en todo momento

#### Acciones y Controles
1. El componente debe soportar botones de acción por fila (Ver, Editar, Eliminar, etc.)
2. El componente debe soportar selección múltiple de filas con checkboxes
3. El componente debe permitir acciones masivas sobre filas seleccionadas
4. El componente debe incluir botones de exportación (CSV, Excel, PDF) cuando sea configurado

#### Optimización y Rendimiento
1. El componente debe implementar lazy loading para imágenes dentro de la tabla
2. El componente debe cachear consultas frecuentes del lado del servidor
3. El componente debe mostrar indicador de carga (spinner/skeleton) durante peticiones AJAX
4. El componente debe implementar virtual scrolling para tablas con más de 1000 registros (opcional)

### COMP002 - Componente de Calendario

El sistema debe implementar un componente de calendario reutilizable con las siguientes características:

#### Vistas del Calendario
1. El componente debe soportar vista mensual (month view)
2. El componente debe soportar vista semanal (week view)
3. El componente debe soportar vista diaria (day view)
4. El componente debe soportar vista de agenda/lista (agenda view)
5. El componente debe permitir cambiar entre vistas mediante controles intuitivos

#### Visualización de Eventos
1. El componente debe mostrar eventos con código de colores según tipo/categoría
2. El componente debe mostrar título y hora del evento en la celda del día
3. El componente debe permitir múltiples eventos en el mismo día
4. El componente debe mostrar indicador cuando hay más eventos de los que caben visualmente
5. El componente debe resaltar el día actual
6. El componente debe distinguir visualmente días del mes actual vs días de meses adyacentes

#### Interacción con Eventos
1. El componente debe permitir hacer clic en un evento para ver detalles completos
2. El componente debe mostrar modal o panel lateral con información detallada del evento
3. El componente debe permitir crear nuevos eventos haciendo clic en una fecha/hora
4. El componente debe soportar drag-and-drop para cambiar fecha/hora de eventos (si el usuario tiene permisos)
5. El componente debe soportar redimensionar eventos para cambiar duración (en vista semanal/diaria)
6. El componente debe mostrar tooltip con información del evento al pasar el cursor (hover)

#### Navegación
1. El componente debe incluir controles para navegar entre períodos (anterior/siguiente)
2. El componente debe incluir botón "Hoy" para volver rápidamente a la fecha actual
3. El componente debe permitir selección de fecha mediante datepicker
4. El componente debe mantener el estado de vista seleccionada durante la sesión
5. El componente debe permitir saltar directamente a un mes/año específico

#### Filtros y Categorías
1. El componente debe permitir filtrar eventos por tipo/categoría
2. El componente debe permitir filtrar eventos por materia/curso (según contexto)
3. El componente debe incluir leyenda de colores explicando categorías
4. El componente debe aplicar filtros sin recargar la página (AJAX)

#### Integración y Datos
1. El componente debe cargar eventos mediante AJAX de forma asíncrona
2. El componente debe implementar lazy loading: cargar solo eventos del rango visible
3. El componente debe soportar eventos recurrentes (diario, semanal, mensual, anual)
4. El componente debe permitir establecer recordatorios para eventos
5. El componente debe sincronizar automáticamente cuando se crean/modifican eventos

#### Responsive y Accesibilidad
1. El componente debe adaptarse a dispositivos móviles (touch-friendly)
2. El componente debe ser navegable mediante teclado
3. El componente debe incluir atributos ARIA para lectores de pantalla
4. En móviles, debe priorizar vista de lista sobre vista mensual completa

#### Exportación e Integración
1. El componente debe permitir exportar eventos a formato iCal (.ics)
2. El componente debe generar enlaces para agregar eventos a Google Calendar (opcional)
3. El componente debe permitir imprimir vista de calendario
4. El componente debe soportar suscripción a calendario mediante URL (feed)

#### Notificaciones
1. El componente debe mostrar badge/contador de eventos próximos
2. El componente debe integrarse con el sistema de notificaciones para recordatorios
3. El componente debe resaltar visualmente eventos que requieren acción del usuario

---

## Resumen de Requisitos

### Estadísticas Generales

| Categoría | Cantidad | Módulos/Subcategorías |
|-----------|----------|----------------------|
| **Requisitos Funcionales** | 69 | 10 módulos |
| **Requisitos No Funcionales** | 43 | 8 categorías |
| **Componentes Reutilizables** | 2 | DataTable y Calendario |
| **Total de Requisitos** | 114+ | - |

### Desglose de Requisitos Funcionales

| Código | Módulo | Cantidad |
|--------|--------|----------|
| RF001 | Gestión de Usuarios | 8 |
| RF002 | Gestión Académica - Estructura | 8 |
| RF003 | Gestión de Calificaciones | 9 |
| RF004 | Gestión de Asistencia | 8 |
| RF005 | Gestión de Tareas y Deberes | 8 |
| RF006 | Sistema de Comunicación | 9 |
| RF007 | Reportes y Estadísticas | 9 |
| RF008 | Dashboard y Visualización | 7 |
| RF009 | Gestión de Eventos y Calendario | 6 |
| RF010 | Configuración del Sistema | 7 |

### Desglose de Requisitos No Funcionales

| Código | Categoría | Cantidad |
|--------|-----------|----------|
| RNF001 | Usabilidad | 6 |
| RNF002 | Rendimiento | 5 |
| RNF003 | Seguridad | 9 |
| RNF004 | Disponibilidad | 4 |
| RNF005 | Mantenibilidad | 5 |
| RNF006 | Escalabilidad | 3 |
| RNF007 | Compatibilidad | 4 |
| RNF008 | Accesibilidad | 4 |

### Priorización de Desarrollo (Sugerida)

#### Fase 1 - Core del Sistema (Prioridad Alta)
- RF001: Gestión de Usuarios
- RF002: Gestión Académica - Estructura
- RF008: Dashboard y Visualización
- COMP001: Componente DataTable
- COMP002: Componente Calendario

#### Fase 2 - Funcionalidades Académicas (Prioridad Alta)
- RF003: Gestión de Calificaciones
- RF004: Gestión de Asistencia
- RF005: Gestión de Tareas y Deberes

#### Fase 3 - Comunicación y Reportes (Prioridad Media)
- RF006: Sistema de Comunicación
- RF007: Reportes y Estadísticas
- RF009: Gestión de Eventos y Calendario

#### Fase 4 - Configuración y Optimización (Prioridad Media-Baja)
- RF010: Configuración del Sistema
- Optimizaciones de rendimiento
- Mejoras de accesibilidad

---

## Notas Importantes

### Consideraciones Técnicas
- Todos los componentes deben desarrollarse siguiendo los principios de diseño atómico
- Los componentes reutilizables deben ser independientes y documentados con Storybook o similar
- La implementación debe priorizar la experiencia de usuario en conexiones lentas (contexto Galápagos)

### Validación y Ajustes
Estos requisitos son la base para el desarrollo del sistema. Cada requisito debe ser:
1. Validado con los usuarios finales durante la fase de análisis
2. Ajustado según las necesidades específicas identificadas en el levantamiento de información
3. Priorizado según el impacto y urgencia para la institución educativa
4. Revisado y actualizado al menos cada trimestre durante el desarrollo

### Control de Cambios
| Versión | Fecha | Autor | Cambios |
|---------|-------|-------|---------|
| 1.0 | 2025-12-20 | Equipo Desarrollo | Documento inicial basado en levantamiento de requisitos |
| 1.1 | 2025-12-20 | Equipo Desarrollo | Agregados componentes reutilizables (DataTable y Calendario) |

---

**Documento preparado para**: Unidad Educativa Oswaldo Guayasamín - Galápagos  
**Proyecto**: Sistema de Gestión Académica y Comunicación Escolar  
**Última actualización**: 20 de diciembre de 2025

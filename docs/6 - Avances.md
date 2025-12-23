# 📊 Avances del Sistema de Gestión Académica

**Última actualización:** 23 de diciembre de 2024

---

## 📈 Resumen Ejecutivo

### Estadísticas del Proyecto

**Total de tablas identificadas en el diagrama:** 46 tablas

#### Por categoría:
- **Tablas principales (núcleo):** 9 tablas
- **Tablas secundarias (dependientes):** 24 tablas
- **Tablas intermedias (relaciones):** 13 tablas

#### Estado de implementación:
- ✅ **Completadas:** 17 tablas (37%)
- 🔄 **En progreso:** 0 tablas (0%)
- ⏳ **Pendientes:** 29 tablas (63%)

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

### Fase 5: Usuarios Especializados (Prioridad Media) ⏳
Extender users con información específica.

17. ⏳ `docentes` - Información de profesores
18. ⏳ `estudiantes` - Información de alumnos
19. ⏳ `padres` - Información de tutores
20. ⏳ `estudiante_padre` - Relación tutor-estudiante

### Fase 6: Asignaciones Académicas (Prioridad Media) ⏳
Asignar docentes y matricular estudiantes.

21. ⏳ `docente_materia` - Asignación docente-materia-paralelo
22. ⏳ `matriculas` - Matrícula de estudiantes

### Fase 7: Sistema de Calificaciones (Prioridad Media) ⏳
Gestión completa de notas.

23. ⏳ `calificaciones` - Registro de notas
24. ⏳ `componentes_calificacion` - Desglose de notas

### Fase 8: Control de Asistencia (Prioridad Media) ⏳
Registro y justificaciones.

25. ⏳ `asistencias` - Registro diario
26. ⏳ `justificaciones` - Justificaciones de ausencias

### Fase 9: Tareas y Deberes (Prioridad Media) ⏳
Sistema de asignación de tareas.

27. ⏳ `tareas` - Tareas asignadas
28. ⏳ `archivos_tarea` - Archivos de tareas
29. ⏳ `tarea_estudiante` - Seguimiento individual

### Fase 10: Comunicación (Prioridad Baja) ⏳
Sistema de mensajería y notificaciones.

30. ⏳ `mensajes` - Mensajes entre usuarios
31. ⏳ `mensaje_adjuntos` - Archivos adjuntos
32. ⏳ `mensaje_destinatarios` - Destinatarios múltiples
33. ⏳ `notificaciones` - Notificaciones del sistema

### Fase 11: Eventos y Calendario (Prioridad Baja) ⏳
Gestión de eventos académicos.

34. ⏳ `eventos` - Eventos institucionales
35. ⏳ `evento_curso` - Eventos por curso
36. ⏳ `evento_confirmacion` - Confirmaciones de asistencia

### Fase 12: Horarios (Prioridad Baja) ⏳
Programación de clases.

37. ⏳ `horarios` - Horarios de clase

### Fase 13: Auditoría (Prioridad Baja) ⏳
Trazabilidad del sistema.

38. ⏳ `auditoria_accesos` - Registro de auditoría

---

## 📋 Checklist de Implementación

### ✅ Tablas Completadas (9)

#### Sistema de Autenticación y Permisos (Spatie)
- [x] **users** - Tabla base de usuarios
  - Estado: ✅ **COMPLETA** - Todos los campos implementados
  - Fecha: 23/12/2024
  - Campos implementados: 
    - `id`, `name`, `email`, `email_verified_at`, `password`
    - `cedula` (VARCHAR 10, UNIQUE) ✅
    - `telefono` (VARCHAR 20) ✅
    - `direccion` (TEXT) ✅
    - `foto` (VARCHAR 255) ✅
    - `fecha_nacimiento` (DATE) ✅
    - `estado` (ENUM: activo/inactivo/bloqueado, DEFAULT 'activo') ✅
    - `ultimo_acceso` (TIMESTAMP) ✅
    - `intentos_fallidos` (INT, DEFAULT 0) ✅
    - `remember_token`, `timestamps`
  - **Modelo actualizado:** Fillable, casts y accessor implementados
  - **Factory actualizado:** Genera datos de prueba completos

- [x] **roles** - Roles del sistema (Spatie)
  - Estado: ✅ Completa
  - Roles definidos: administrador, docente, padre, estudiante, admin_tecnico

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
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `nombre`, `codigo_amie` (UNIQUE), `logo`
    - `direccion`, `telefono`, `email`, `sitio_web`
    - `timestamps`
  - **Modelo:** Con relación hasMany a configuraciones
  - **Seeder:** Datos iniciales de la institución

- [x] **configuraciones** - Configuraciones del sistema
  - Estado: ✅ **COMPLETA**
  - Fecha: 23/12/2024
  - Campos implementados:
    - `id`, `institucion_id` (FK), `clave` (UNIQUE)
    - `valor`, `tipo` (ENUM), `categoria`, `descripcion`
    - `timestamps`
  - **Modelo:** Con relación belongsTo a institución y accessor para valor tipificado
  - **Seeder:** 9 configuraciones iniciales (calificaciones, asistencia, seguridad, sistema)

---

### ⏳ Tablas Pendientes (37)

#### Usuarios Especializados
- [ ] **docentes** - Información específica de docentes
  - Estado: ⏳ **Pendiente crear migración**
  - Depende de: `users` ✅
  - Campos: `user_id`, `codigo_docente`, `titulo_profesional`, `especialidad`, etc.

---

### ⏳ Tablas Pendientes por Implementargo_docente`, `titulo_profesional`, `especialidad`, etc.

---

### ⏳ Tablas Pendientes (39)

#### 🏢 Configuración Institucional (2 tablas)
- [ ] **instituciones** - Datos de la institución
  - Prioridad: Alta
  - Dependencias: Ninguna (tabla independiente)
  - Campos: nombre, codigo_amie, logo, dirección, contactos

- [ ] **configuraciones** - Configuraciones del sistema
  - Prioridad: Alta
  - Depende de: `instituciones`
  - Campos: clave-valor para configuraciones generales

#### 📚 Estructura Académica Base (6 tablas - Principales)
- [ ] **periodos_academicos** - Años lectivos
  - Prioridad: Alta
  - Dependencias: Ninguna (tabla principal)
  - Campos: nombre ("2024-2025"), fecha_inicio, fecha_fin, estado

- [ ] **quimestres** - División del año lectivo
  - Prioridad: Alta
  - Depende de: `periodos_academicos`
  - Campos: nombre, número (1 o 2), fechas

- [ ] **parciales** - Períodos de evaluación
  - Prioridad: Alta
  - Depende de: `quimestres`
  - Campos: nombre, número (1, 2 o 3), fechas, permite_edicion

- [ ] **cursos** - Grados educativos
  - Prioridad: Alta
  - Dependencias: Ninguna (tabla principal)
  - Campos: nombre, nivel (Inicial/Básica/Bachillerato), orden

- [ ] **materias** - Catálogo de materias
  - Prioridad: Alta
  - Dependencias: Ninguna (tabla principal)
  - Campos: nombre, código, área, color

- [ ] **aulas** - Salones de clase
  - Prioridad: Alta
  - Dependencias: Ninguna (tabla principal)
  - Campos: nombre, capacidad, edificio, piso

#### 🔗 Relaciones Académicas (2 tablas - Intermedias)
- [ ] **paralelos** - Secciones de cursos (A, B, C)
  - Prioridad: Alta
  - Depende de: `cursos`, `aulas`
  - Campos: nombre, cupo_maximo, aula_id

- [ ] **curso_materia** - Materias asignadas a cursos
  - Prioridad: Alta
  - Depende de: `cursos`, `materias`, `periodos_academicos`
  - Tabla intermedia: Muchos a Muchos

#### 👥 Usuarios Especializados (3 tablas - Secundarias)
- [ ] **estudiantes** - Información de estudiantes
  - Prioridad: Media
  - Depende de: `users`
  - Campos: codigo_estudiante, fecha_ingreso, tipo_sangre, alergias

- [ ] **padres** - Información de padres/tutores
  - Prioridad: Media
  - Depende de: `users`
  - Campos: ocupacion, lugar_trabajo, telefono_trabajo

- [ ] **estudiante_padre** - Relación tutor-estudiante
  - Prioridad: Media
  - Depende de: `estudiantes`, `padres`
  - Tabla intermedia: Muchos a Muchos con parentesco

#### 🎓 Asignaciones Académicas (2 tablas - Intermedias)
- [ ] **docente_materia** - Asignación docente-materia-paralelo
  - Prioridad: Media
  - Depende de: `docentes`, `curso_materia`, `paralelos`, `periodos_academicos`
  - Tabla intermedia compleja

- [ ] **matriculas** - Matrícula de estudiantes por período
  - Prioridad: Media
  - Depende de: `estudiantes`, `paralelos`, `periodos_academicos`
  - Campos: numero_matricula, fecha_matricula, estado

#### 📊 Sistema de Calificaciones (2 tablas - Secundarias)
- [ ] **calificaciones** - Registro de calificaciones
  - Prioridad: Media
  - Depende de: `matriculas`, `materias`, `parciales`, `docentes`
  - Campos: nota_final, observaciones, fecha_registro

- [ ] **componentes_calificacion** - Desglose de notas
  - Prioridad: Media
  - Depende de: `calificaciones`
  - Campos: nombre (Tareas/Lecciones), tipo, nota, porcentaje

#### ✅ Control de Asistencia (2 tablas - Secundarias)
- [ ] **asistencias** - Registro diario de asistencia
  - Prioridad: Media
  - Depende de: `estudiantes`, `paralelos`, `materias`, `docentes`
  - Campos: fecha, hora, estado (presente/ausente/atrasado/justificado)

- [ ] **justificaciones** - Justificaciones de inasistencias
  - Prioridad: Media
  - Depende de: `asistencias`, `padres`, `users`
  - Campos: motivo, archivo_adjunto, estado, revisado_por

#### 📝 Tareas y Deberes (3 tablas - Secundarias)
- [ ] **tareas** - Tareas asignadas por docentes
  - Prioridad: Media
  - Depende de: `docentes`, `materias`, `paralelos`
  - Campos: titulo, descripcion, fechas, es_calificada

- [ ] **archivos_tarea** - Archivos adjuntos a tareas
  - Prioridad: Media
  - Depende de: `tareas`
  - Campos: nombre_archivo, ruta, tipo_mime, tamaño

- [ ] **tarea_estudiante** - Seguimiento individual de tareas
  - Prioridad: Media
  - Depende de: `tareas`, `estudiantes`
  - Tabla intermedia con seguimiento

#### 💬 Comunicación (4 tablas - Secundarias)
- [ ] **mensajes** - Mensajes entre usuarios
  - Prioridad: Baja
  - Depende de: `users`
  - Campos: tipo (individual/masivo/anuncio), asunto, cuerpo

- [ ] **mensaje_adjuntos** - Archivos adjuntos a mensajes
  - Prioridad: Baja
  - Depende de: `mensajes`
  - Campos: nombre_archivo, ruta, tipo_mime

- [ ] **mensaje_destinatarios** - Destinatarios de mensajes masivos
  - Prioridad: Baja
  - Depende de: `mensajes`, `users`
  - Tabla intermedia para mensajes masivos

- [ ] **notificaciones** - Notificaciones del sistema
  - Prioridad: Baja
  - Depende de: `users`
  - Campos: tipo, titulo, mensaje, url, es_leida

#### 📅 Eventos y Calendario (3 tablas - Secundarias)
- [ ] **eventos** - Eventos académicos y actividades
  - Prioridad: Baja
  - Depende de: `periodos_academicos`, `users`
  - Campos: tipo (examen/reunion/actividad/feriado), fechas, ubicación

- [ ] **evento_curso** - Eventos dirigidos a cursos específicos
  - Prioridad: Baja
  - Depende de: `eventos`, `paralelos`
  - Tabla intermedia: Muchos a Muchos

- [ ] **evento_confirmacion** - Confirmaciones de asistencia
  - Prioridad: Baja
  - Depende de: `eventos`, `users`, `estudiantes`
  - Campos: confirmado, fecha_confirmacion

#### ⏰ Horarios (1 tabla - Secundaria)
- [ ] **horarios** - Horarios de clases
  - Prioridad: Baja
  - Depende de: `paralelos`, `materias`, `docentes`, `aulas`, `periodos_academicos`
  - Campos: dia_semana, hora_inicio, hora_fin

#### 🔍 Auditoría (1 tabla - Secundaria)
- [ ] **auditoria_accesos** - Registro de auditoría
  - Prioridad: Baja
  - Depende de: `users`
  - Campos: accion, tabla, registro_id, ip_address, datos JSON

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

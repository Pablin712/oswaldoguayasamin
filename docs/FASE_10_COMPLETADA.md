# ✅ Fase 10 Completada: Comunicación

**Fecha de implementación:** 24 de diciembre de 2024

---

## 📊 Resumen

La **Fase 10** del sistema de gestión académica ha sido completada exitosamente. Esta fase implementa el sistema completo de comunicación interna, incluyendo mensajería entre usuarios y notificaciones del sistema.

### Tablas Implementadas

#### 1. **mensajes** 
Sistema de mensajería entre usuarios con soporte para mensajes individuales, masivos y anuncios.

**Campos:**
- `id` - ID único
- `remitente_id` (FK) - Usuario que envía
- `destinatario_id` (FK nullable) - Usuario que recibe (individual)
- `tipo` (ENUM) - individual/masivo/anuncio
- `asunto` (VARCHAR 255) - Asunto del mensaje
- `cuerpo` (TEXT) - Contenido del mensaje
- `es_leido` (BOOLEAN) - Estado de lectura
- `fecha_lectura` (TIMESTAMP nullable) - Cuándo se leyó
- `fecha_envio` (TIMESTAMP nullable) - Cuándo se envió
- `programado_para` (TIMESTAMP nullable) - Envío programado
- `timestamps`

**Índices:**
- `remitente_id` - Mensajes por remitente
- `destinatario_id` - Mensajes por destinatario
- `fecha_envio` - Ordenamiento temporal

#### 2. **mensaje_adjuntos**
Archivos adjuntos a los mensajes.

**Campos:**
- `id` - ID único
- `mensaje_id` (FK) - Mensaje al que pertenece
- `nombre_archivo` (VARCHAR 255) - Nombre del archivo
- `ruta_archivo` (VARCHAR 255) - Ruta de almacenamiento
- `tipo_mime` (VARCHAR 100 nullable) - Tipo MIME
- `tamanio` (INT nullable) - Tamaño en bytes
- `created_at` (TIMESTAMP)

#### 3. **mensaje_destinatarios**
Destinatarios para mensajes masivos (muchos a muchos).

**Campos:**
- `id` - ID único
- `mensaje_id` (FK) - Mensaje
- `destinatario_id` (FK) - Usuario destinatario
- `es_leido` (BOOLEAN) - Estado de lectura individual
- `fecha_lectura` (TIMESTAMP nullable) - Cuándo leyó este destinatario
- `timestamps`

#### 4. **notificaciones**
Sistema de notificaciones del sistema con soporte para envío por email.

**Campos:**
- `id` - ID único
- `user_id` (FK) - Usuario receptor
- `tipo` (VARCHAR 50) - Tipo de notificación
- `titulo` (VARCHAR 255) - Título
- `mensaje` (TEXT) - Contenido
- `url` (VARCHAR 255 nullable) - URL relacionada
- `es_leida` (BOOLEAN) - Estado de lectura
- `enviar_email` (BOOLEAN) - Si debe enviarse por email
- `email_enviado` (BOOLEAN) - Si ya se envió el email
- `fecha_envio` (TIMESTAMP nullable) - Cuándo se envió
- `timestamps`

**Índices:**
- `(user_id, es_leida)` - Notificaciones no leídas por usuario
- `tipo` - Filtrado por tipo

---

## 🔗 Relaciones Implementadas

### Modelo Mensaje
- `belongsTo(User, 'remitente_id')` - Remitente del mensaje
- `belongsTo(User, 'destinatario_id')` - Destinatario (individual)
- `hasMany(MensajeAdjunto)` - Archivos adjuntos
- `hasMany(MensajeDestinatario)` - Destinatarios (masivos)

**Scopes:**
- `noLeidos()` - Mensajes no leídos
- `leidos()` - Mensajes leídos
- `recibidosPor($userId)` - Mensajes recibidos por usuario
- `enviadosPor($userId)` - Mensajes enviados por usuario
- `porTipo($tipo)` - Filtrar por tipo
- `programados()` - Mensajes con envío programado

**Métodos:**
- `marcarComoLeido()` - Marca el mensaje como leído

### Modelo MensajeAdjunto
- `belongsTo(Mensaje)` - Mensaje al que pertenece

**Accessors:**
- `tamanioFormateado` - Tamaño en formato legible (KB, MB, etc.)

### Modelo MensajeDestinatario
- `belongsTo(Mensaje)` - Mensaje
- `belongsTo(User, 'destinatario_id')` - Usuario destinatario

**Scopes:**
- `noLeidos()` - No leídos
- `leidos()` - Leídos

**Métodos:**
- `marcarComoLeido()` - Marca como leído

### Modelo Notificacion
- `belongsTo(User)` - Usuario receptor

**Scopes:**
- `noLeidas()` - No leídas
- `leidas()` - Leídas
- `porTipo($tipo)` - Por tipo
- `deUsuario($userId)` - De un usuario específico
- `recientes($dias)` - Últimos N días

**Métodos:**
- `marcarComoLeida()` - Marca como leída
- `marcarEmailEnviado()` - Marca email como enviado

---

## 🔄 Actualizaciones en Modelos Existentes

### User
- ✅ Agregada relación `hasMany(Mensaje, 'remitente_id')` - mensajesEnviados
- ✅ Agregada relación `hasMany(Mensaje, 'destinatario_id')` - mensajesRecibidos
- ✅ Agregada relación `hasMany(Notificacion)` - notificaciones

---

## 📦 Seeders

### ComunicacionSeeder
Genera datos de prueba realistas para el sistema de comunicación:

**Características:**
- Mensajes individuales entre usuarios aleatorios
- Mensajes masivos/anuncios desde administradores y docentes
- 70% de mensajes individuales leídos
- 60% de destinatarios de mensajes masivos han leído
- 30% de mensajes con adjuntos
- Múltiples tipos de notificaciones (calificación, asistencia, tarea, etc.)
- 65% de notificaciones leídas
- 40% configuradas para envío por email
- Fechas realistas de envío y lectura

**Resultado:**
- ✅ 33 mensajes creados
- ✅ 13 archivos adjuntos
- ✅ 30 registros de destinatarios
- ✅ 80 notificaciones creadas
- 7 mensajes no leídos
- 27 notificaciones no leídas

---

## 🎯 Casos de Uso

### 1. Enviar Mensaje Individual
```php
// Usuario envía mensaje a otro usuario
$mensaje = Mensaje::create([
    'remitente_id' => auth()->id(),
    'destinatario_id' => $destinatario->id,
    'tipo' => 'individual',
    'asunto' => 'Consulta sobre calificaciones',
    'cuerpo' => 'Estimado profesor, quisiera consultar...',
    'fecha_envio' => now(),
]);
```

### 2. Enviar Mensaje Masivo con Adjuntos
```php
// Crear mensaje masivo
$mensaje = Mensaje::create([
    'remitente_id' => auth()->id(),
    'destinatario_id' => null,
    'tipo' => 'masivo',
    'asunto' => 'Importante: Cambio de horario',
    'cuerpo' => 'Se informa a todos los estudiantes...',
    'fecha_envio' => now(),
]);

// Agregar adjunto
MensajeAdjunto::create([
    'mensaje_id' => $mensaje->id,
    'nombre_archivo' => 'nuevo_horario.pdf',
    'ruta_archivo' => Storage::put('mensajes', $file),
    'tipo_mime' => $file->getMimeType(),
    'tamanio' => $file->getSize(),
]);

// Agregar destinatarios
foreach ($estudiantes as $estudiante) {
    MensajeDestinatario::create([
        'mensaje_id' => $mensaje->id,
        'destinatario_id' => $estudiante->user_id,
    ]);
}
```

### 3. Consultar Mensajes Recibidos No Leídos
```php
// Bandeja de entrada - no leídos
$mensajesNoLeidos = Mensaje::recibidosPor(auth()->id())
    ->noLeidos()
    ->with(['remitente', 'adjuntos'])
    ->orderBy('fecha_envio', 'desc')
    ->get();

// Para mensajes masivos
$masivosPendientes = MensajeDestinatario::where('destinatario_id', auth()->id())
    ->noLeidos()
    ->with(['mensaje.remitente', 'mensaje.adjuntos'])
    ->get();
```

### 4. Marcar Mensaje Como Leído
```php
// Mensaje individual
$mensaje->marcarComoLeido();

// Mensaje masivo (destinatario específico)
$destinatario = MensajeDestinatario::where('mensaje_id', $mensajeId)
    ->where('destinatario_id', auth()->id())
    ->first();

$destinatario->marcarComoLeido();
```

### 5. Crear Notificación
```php
// Nueva calificación publicada
Notificacion::create([
    'user_id' => $estudiante->user_id,
    'tipo' => 'calificacion',
    'titulo' => 'Nueva calificación registrada',
    'mensaje' => 'Se ha registrado tu calificación en Matemática.',
    'url' => '/calificaciones',
    'enviar_email' => true,
]);
```

### 6. Obtener Notificaciones No Leídas
```php
// Notificaciones del usuario actual
$notificaciones = Notificacion::deUsuario(auth()->id())
    ->noLeidas()
    ->recientes(30)
    ->orderBy('created_at', 'desc')
    ->get();

// Contador de no leídas
$contador = Notificacion::deUsuario(auth()->id())
    ->noLeidas()
    ->count();
```

### 7. Mensajes Enviados por Usuario
```php
// Bandeja de salida
$mensajesEnviados = Mensaje::enviadosPor(auth()->id())
    ->with(['destinatario', 'destinatarios.destinatario'])
    ->orderBy('fecha_envio', 'desc')
    ->paginate(20);
```

### 8. Programar Mensaje para Envío Futuro
```php
// Mensaje programado
$mensaje = Mensaje::create([
    'remitente_id' => auth()->id(),
    'destinatario_id' => $destinatario->id,
    'tipo' => 'individual',
    'asunto' => 'Recordatorio de reunión',
    'cuerpo' => 'Recuerda que mañana tenemos reunión...',
    'programado_para' => now()->addDay(),
    'fecha_envio' => null, // Se llenará cuando se envíe
]);

// Obtener mensajes pendientes de envío
$pendientes = Mensaje::programados()->get();
```

---

## 📈 Progreso del Proyecto

- **Fases Completadas:** 10/13 (76.9%)
- **Tablas Completadas:** 34/46 (73.9%)

---

## 🔜 Próximos Pasos

### Fase 11: Eventos y Calendario (3 tablas)
- `eventos` - Eventos institucionales
- `evento_curso` - Eventos por curso
- `evento_confirmacion` - Confirmaciones de asistencia

---

## 📝 Notas Técnicas

### Tipos de Mensajes
1. **Individual**: Un remitente, un destinatario
2. **Masivo**: Un remitente, múltiples destinatarios
3. **Anuncio**: Comunicados generales de la institución

### Sistema de Lectura
- Mensajes individuales: campo `es_leido` en tabla `mensajes`
- Mensajes masivos: campo `es_leido` en tabla `mensaje_destinatarios` (por destinatario)

### Tipos de Notificaciones Soportados
- `calificacion` - Nuevas notas publicadas
- `asistencia` - Registros de asistencia
- `tarea` - Asignaciones y calificaciones de tareas
- `mensaje` - Nuevos mensajes recibidos
- `evento` - Eventos y actividades
- `general` - Avisos generales del sistema

### Optimizaciones Implementadas
1. **Índices compuestos** para consultas frecuentes
2. **Scopes reutilizables** para lógica común
3. **Eager loading** recomendado para relaciones
4. **Soft deletes** no implementado (se puede agregar si se requiere)

---

## ✨ Características Destacadas

- ✅ Sistema completo de mensajería interna
- ✅ Soporte para mensajes individuales y masivos
- ✅ Archivos adjuntos en mensajes
- ✅ Sistema de notificaciones con múltiples tipos
- ✅ Soporte para envío de notificaciones por email
- ✅ Mensajes programados para envío futuro
- ✅ Seguimiento individual de lectura en mensajes masivos
- ✅ URLs contextuales en notificaciones
- ✅ Scopes para consultas comunes
- ✅ Métodos helper para marcar como leído

---

**Estado:** ✅ **COMPLETADO**  
**Desarrollador:** GitHub Copilot  
**Framework:** Laravel 11  
**Base de datos:** MySQL/MariaDB

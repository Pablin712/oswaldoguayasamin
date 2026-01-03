# 8. Gestión de Matrículas

## Descripción General
Sistema completo de gestión de matrículas que permite manejar estudiantes propios, estudiantes nuevos/externos, órdenes de pago, comprobantes y estados de matrícula.

---

## 1. Reglas de Negocio

### 1.1 Estudiantes Propios (de la institución)
- **Requisito**: Deben haber aprobado el año anterior para matricularse en el siguiente curso
- **Primera Matrícula**: Primera vez que el estudiante cursa ese nivel/grado
- **Segunda Matrícula**: Si el estudiante repite el año (reprobó)
- **Límite de matrículas**: Máximo 2 matrículas por curso
- **Restricción**: Si reprueba en segunda matrícula, no se permite tercera matrícula y queda con estado "retirado"

### 1.2 Estudiantes Nuevos/Externos
- Deben llenar **Solicitud de Matrícula**
- **Documentos requeridos**:
  - Cédula de identidad
  - Certificado de aprobación del año anterior (trayectoria académica)
- **Flujo**:
  1. Llenar solicitud con adjuntos
  2. Revisión y aprobación de la solicitud
  3. Si se aprueba → Genera orden de pago
  4. Pago de orden → Matrícula aprobada

### 1.3 Cambio de Institución
- El estudiante puede solicitar su **carpeta académica**
- Se genera documento PDF con:
  - Historial de matrículas
  - Certificado de aprobación del último nivel/período cursado en la institución
  - Calificaciones y trayectoria completa

---

## 2. Órdenes de Pago

### 2.1 Institución Fiscal
- **Primera Matrícula**: $0 (gratuita)
- **Segunda Matrícula**: Monto definido por la institución (configurable)
- Si el monto es $0 → Matrícula automática sin comprobante

### 2.2 Institución Fiscomisional / Particular
- **Primera Matrícula**: Monto definido por la institución
- **Segunda Matrícula**: Monto definido por la institución
- **Proceso**:
  1. Se genera orden de pago con monto según configuración
  2. Estudiante adjunta foto/comprobante de pago
  3. Orden queda en estado "pendiente"
  4. Rol autorizado (Admin/Contador) revisa y aprueba
  5. Al aprobar → Matrícula queda con estado "aprobada"

### 2.3 Estados de Orden de Pago
- **Pendiente**: Esperando adjunto de comprobante o aprobación
- **Aprobada**: Pago verificado y aprobado
- **Rechazada**: Comprobante rechazado (estudiante debe volver a intentar)

---

## 3. Estados de Matrícula

- **Pendiente**: Esperando orden de pago o aprobación
- **Aprobada**: Matrícula confirmada, estudiante activo en el curso
- **Rechazada**: Solicitud o pago rechazado
- **Retirada**: Estudiante se retiró o fue retirado por exceder límite de matrículas

---

## 4. Estructura de Base de Datos

### 4.1 Tabla: `configuracion_matriculas`
Configuración de montos por institución
```
- id
- institucion_id (FK)
- tipo_institucion (enum: fiscal, fiscomisional, particular)
- monto_primera_matricula (decimal)
- monto_segunda_matricula (decimal)
- created_at, updated_at
```

### 4.2 Tabla: `solicitudes_matricula`
Solicitudes de estudiantes nuevos/externos
```
- id
- estudiante_id (FK) - puede ser null si aún no existe
- nombres
- apellidos
- cedula
- email
- telefono
- institucion_origen
- curso_solicitado_id (FK)
- periodo_academico_id (FK)
- adjunto_cedula_path
- adjunto_certificado_path
- estado (enum: pendiente, aprobada, rechazada)
- observaciones
- revisado_por (FK user_id)
- fecha_revision
- created_at, updated_at
```

### 4.3 Tabla: `matriculas` (actualización)
Agregar campos adicionales:
```
- tipo_matricula (enum: primera, segunda)
- orden_pago_id (FK) - relación con orden de pago
- solicitud_matricula_id (FK) - si viene de solicitud externa
- fecha_aprobacion
- aprobado_por (FK user_id)
```

### 4.4 Tabla: `ordenes_pago`
Órdenes de pago y comprobantes
```
- id
- matricula_id (FK)
- codigo_orden (único)
- monto (decimal)
- tipo_pago (enum: primera_matricula, segunda_matricula)
- estado (enum: pendiente, aprobada, rechazada)
- comprobante_path
- fecha_pago
- observaciones
- revisado_por (FK user_id)
- fecha_revision
- created_at, updated_at
```

### 4.5 Tabla: `estudiantes` (actualización)
Agregar campos para trayectoria:
```
- estado (enum: activo, inactivo, retirado, transferido)
- conteo_matriculas_actuales (json) - {curso_id: cantidad}
```

---

## 5. Flujos de Trabajo

### 5.1 Flujo: Estudiante Propio se Matricula
1. Sistema verifica que aprobó el año anterior
2. Identifica si es primera o segunda matrícula en ese curso
3. Consulta configuración de montos de la institución
4. Genera orden de pago
5. Si monto = $0 → Matrícula aprobada automáticamente
6. Si monto > $0 → Estudiante adjunta comprobante → Espera aprobación

### 5.2 Flujo: Estudiante Nuevo/Externo
1. Llena formulario de solicitud
2. Adjunta cédula y certificado
3. Administrador revisa solicitud
4. Si aprueba → Crea usuario y perfil de estudiante
5. Genera orden de pago
6. Proceso continúa como flujo 5.1

### 5.3 Flujo: Aprobación de Pago
1. Rol autorizado accede a lista de órdenes pendientes
2. Revisa comprobante adjunto
3. Aprueba o rechaza con observaciones
4. Si aprueba → Matrícula cambia a "aprobada"
5. Si rechaza → Estudiante debe adjuntar nuevo comprobante

### 5.4 Flujo: Cambio de Institución
1. Estudiante solicita carpeta académica
2. Sistema genera PDF con:
   - Datos personales
   - Historial de matrículas
   - Calificaciones por período
   - Certificado de último año aprobado
3. Se marca como "transferido"

---

## 6. Validaciones Importantes

- ✅ Verificar que estudiante aprobó el año anterior antes de matricular
- ✅ No permitir más de 2 matrículas en el mismo curso
- ✅ Si está en segunda matrícula y reprueba → Estado "retirado"
- ✅ Estudiantes externos deben tener solicitud aprobada
- ✅ Solo roles autorizados pueden aprobar órdenes de pago
- ✅ Comprobantes de pago se almacenan en storage privado
- ✅ No permitir matricular si tiene orden de pago pendiente

---

## 7. Roles y Permisos

### Permisos necesarios:
- `ver solicitudes matricula`
- `aprobar solicitudes matricula`
- `rechazar solicitudes matricula`
- `ver ordenes pago`
- `aprobar ordenes pago`
- `rechazar ordenes pago`
- `gestionar configuracion matriculas`
- `generar carpeta academica`
- `ver matriculas`
- `crear matriculas`
- `editar matriculas`
- `eliminar matriculas`

---

## 8. Módulos del Sistema

### 8.1 Configuración de Matrículas
- CRUD para definir montos por institución
- Tipo de institución (fiscal/fiscomisional/particular)
- Montos de primera y segunda matrícula

### 8.2 Solicitudes de Matrícula
- Formulario público/estudiante para solicitar matrícula
- Panel de administración para revisar solicitudes
- Aprobación/Rechazo con observaciones

### 8.3 Órdenes de Pago
- Lista de órdenes pendientes/aprobadas/rechazadas
- Adjuntar comprobantes (estudiantes)
- Revisar y aprobar comprobantes (admin/contador)

### 8.4 Matrículas
- Lista de matrículas por período
- Filtros: curso, paralelo, estado, tipo
- Generación automática de matrícula tras aprobación
- Historial de matrículas por estudiante

### 8.5 Carpeta Académica
- Generación de PDF con trayectoria completa
- Descarga de certificados
- Historial de documentos generados

---

## 9. Notas Técnicas

- **Storage**: Usar `storage/app/private/comprobantes` para archivos sensibles
- **PDF**: Usar DomPDF o similar para generar carpetas académicas
- **Validación**: Implementar reglas de negocio en requests personalizados
- **Notificaciones**: Enviar emails cuando se apruebe/rechace solicitud u orden
- **Logs**: Auditoría de aprobaciones y cambios de estado

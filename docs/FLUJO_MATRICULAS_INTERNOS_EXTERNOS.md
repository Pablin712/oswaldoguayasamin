# 📚 Flujo de Matrículas: Estudiantes Internos vs Externos

---

## 🎯 Diferencias Clave

### 👨‍🎓 **Estudiantes INTERNOS** (Ya están en el sistema)
- **Definición**: Estudiantes que YA tienen un registro en la tabla `estudiantes`
- **Estado**: Ya aprobados y matriculados en periodos anteriores
- **Objetivo**: Renovar matrícula para el nuevo periodo académico (primera o segunda matrícula)
- **Acceso**: A través de su cuenta de usuario (login como estudiante)
- **Vista**: Dashboard interno → Sección "Mi Matrícula"

### 🌍 **Estudiantes EXTERNOS** (Nuevos/Transferidos)
- **Definición**: Personas que NO tienen registro en la tabla `estudiantes`
- **Estado**: Primera vez aplicando a la institución
- **Objetivo**: Solicitar ingreso a la institución
- **Acceso**: Formulario público sin login
- **Vista**: `/solicitar-matricula` (público)

---

## 🔄 Flujo Completo

### **ESTUDIANTES EXTERNOS (Nuevos)**

```
1. Acceso Público
   └─→ /solicitar-matricula (sin login)
        └─→ Llenar formulario completo
             ├─ Datos personales
             ├─ Datos de padres
             ├─ Datos académicos
             ├─ Upload: Cédula
             └─ Upload: Certificado de notas
        
2. Estado: "PENDIENTE"
   └─→ Admin revisa en: /solicitudes-matricula
        ├─ Verifica documentos
        ├─ Valida información
        └─ Toma decisión
        
3. Admin APRUEBA
   └─→ Se crea registro en tabla `estudiantes`
   └─→ Se crea registro en tabla `matriculas`
   └─→ Se genera `orden_pago`
   └─→ Estado solicitud: "APROBADA"
   └─→ Email al estudiante con credenciales
   
4. Estudiante ahora es INTERNO
   └─→ Puede hacer login
   └─→ Sube comprobante de pago
   └─→ Admin aprueba pago
   └─→ Matrícula ACTIVA
```

### **ESTUDIANTES INTERNOS (Renovación)**

```
1. Login como Estudiante
   └─→ Dashboard → "Mi Matrícula"
        └─→ Ver estado de matrícula actual
        └─→ Botón: "Renovar Matrícula" (si periodo nuevo disponible)
        
2. Click en "Renovar Matrícula"
   └─→ Sistema verifica:
        ├─ ¿Ya tiene 2 matrículas en este periodo? → BLOQUEO
        ├─ ¿Tiene orden de pago pendiente? → Mostrar orden
        └─ Si todo OK → Crear nueva matrícula
        
3. Se crea automáticamente:
   └─→ Registro en tabla `matriculas`
        ├─ tipo_matricula: primera_matricula o segunda_matricula
        ├─ estado: pendiente
        └─→ Se genera `orden_pago`
        
4. Estudiante ve su orden de pago
   └─→ Dashboard → "Órdenes de Pago"
        └─→ Upload comprobante de pago
        └─→ Espera aprobación admin
        
5. Admin aprueba pago
   └─→ /ordenes-pago
        └─→ Revisa comprobante
        └─→ Aprueba orden
        └─→ Estado matrícula: "APROBADA"
```

---

## 🖥️ Vistas Necesarias

### **Para EXTERNOS (Públicas - Sin Login)**

#### 1. `/solicitar-matricula` (GET) ✅ YA EXISTE
- Formulario completo de solicitud
- Upload de documentos
- Submit público

#### 2. `/solicitar-matricula` (POST) ✅ YA EXISTE
- Procesa la solicitud
- Guarda en BD
- Email confirmación

#### 3. `/consultar-solicitud` (Nueva - Opcional)
- Consultar estado de solicitud por cédula
- Ver si fue aprobada/rechazada
- Mostrar próximos pasos

---

### **Para INTERNOS (Requieren Login como Estudiante)**

#### 4. `/dashboard/estudiante/mi-matricula` (Nueva - NECESARIA) ⚠️
```php
Vista: resources/views/estudiante/matricula/index.blade.php

Muestra:
- Estado de matrícula actual
- Información del curso
- Periodo académico
- Botón "Renovar Matrícula" (si aplica)
- Lista de órdenes de pago pendientes
```

#### 5. `/dashboard/estudiante/renovar-matricula` (Nueva - NECESARIA) ⚠️
```php
Vista: resources/views/estudiante/matricula/renovar.blade.php

Proceso:
- Selecciona curso (mismo o diferente)
- Confirma datos personales
- Sistema valida límite de 2 matrículas
- Crea matrícula + orden de pago
- Redirige a ver orden
```

#### 6. `/dashboard/estudiante/ordenes-pago` (Nueva - NECESARIA) ⚠️
```php
Vista: resources/views/estudiante/ordenes-pago/index.blade.php

Muestra:
- Lista de órdenes propias
- Estado de cada orden
- Upload comprobante (si pendiente)
- Download orden de pago PDF
- Ver detalles
```

#### 7. `/dashboard/estudiante/ordenes-pago/{id}` (Nueva - NECESARIA) ⚠️
```php
Vista: resources/views/estudiante/ordenes-pago/show.blade.php

Muestra:
- Detalle completo de la orden
- Monto a pagar
- Datos bancarios institución
- Formulario upload comprobante
- Estado actual
- Historial
```

---

## 🛠️ Ajustes a la Vista de Configuración

Según tu sugerencia, la vista de configuración debería funcionar como el CRUD de institución:

### **Cambios Necesarios**

#### ❌ ELIMINAR:
- Vista: `configuracion/index.blade.php` (lista de todas las configuraciones)
- Ruta: `configuracion-matriculas.index`
- Modal "Nueva Configuración"

#### ✅ MANTENER:
- Vista: `configuracion/show.blade.php` (ver configuración de MI institución)
- Vista: `configuracion/edit.blade.php` (editar configuración de MI institución)
- Controller métodos: `show()` y `update()`

#### 📝 NUEVA ESTRUCTURA:
```php
// En vez de:
Route::resource('configuracion-matriculas', ConfiguracionMatriculaController::class);

// Usar:
Route::get('/configuracion/matricula', [ConfiguracionMatriculaController::class, 'show'])
    ->name('configuracion.matricula.show');
    
Route::get('/configuracion/matricula/editar', [ConfiguracionMatriculaController::class, 'edit'])
    ->name('configuracion.matricula.edit');
    
Route::put('/configuracion/matricula', [ConfiguracionMatriculaController::class, 'update'])
    ->name('configuracion.matricula.update');
```

#### 📍 UBICACIÓN EN SIDEBAR:
```blade
<!-- Mover a módulo "Configuraciones" -->
<x-nav-dropdown label="Configuraciones" icon="cog">
    <x-nav-link href="{{ route('instituciones.edit', auth()->user()->institucion_id) }}">
        Mi Institución
    </x-nav-link>
    
    <x-nav-link href="{{ route('configuracion.matricula.show') }}">
        Costos de Matrícula
    </x-nav-link>
    
    <x-nav-link href="{{ route('configuraciones.general') }}">
        Configuración General
    </x-nav-link>
</x-nav-dropdown>
```

---

## ⚙️ Lógica del Controller

### ConfiguracionMatriculaController (Ajustado)

```php
public function show()
{
    // Obtener configuración de MI institución
    $institucion = auth()->user()->institucion;
    
    $configuracion = ConfiguracionMatricula::where('institucion_id', $institucion->id)
        ->firstOrFail();
    
    return view('configuracion.matricula.show', compact('configuracion', 'institucion'));
}

public function edit()
{
    $institucion = auth()->user()->institucion;
    
    $configuracion = ConfiguracionMatricula::where('institucion_id', $institucion->id)
        ->firstOrFail();
    
    return view('configuracion.matricula.edit', compact('configuracion', 'institucion'));
}

public function update(Request $request)
{
    $institucion = auth()->user()->institucion;
    
    $configuracion = ConfiguracionMatricula::where('institucion_id', $institucion->id)
        ->firstOrFail();
    
    $validated = $request->validate([
        'tipo_institucion' => 'required|in:fiscal,fiscomisional,particular',
        'monto_primera_matricula' => 'required|numeric|min:0',
        'monto_segunda_matricula' => 'required|numeric|min:0',
    ]);
    
    $configuracion->update($validated);
    
    return redirect()->route('configuracion.matricula.show')
        ->with('success', 'Configuración actualizada correctamente.');
}
```

---

## 📋 Resumen de Tareas Pendientes

### ✅ COMPLETADO:
- [x] Seeders de ConfiguracionMatricula
- [x] Seeders de SolicitudMatricula
- [x] Seeders de OrdenPago
- [x] Formulario público de solicitud (externos)
- [x] CRUD admin de solicitudes
- [x] CRUD admin de órdenes de pago

### ⚠️ PENDIENTE:
- [ ] Ajustar vista configuración a modelo show/edit
- [ ] Mover a módulo "Configuraciones" en sidebar
- [ ] Crear vistas para estudiantes internos:
  - [ ] Mi Matrícula (dashboard)
  - [ ] Renovar Matrícula
  - [ ] Mis Órdenes de Pago
  - [ ] Ver Orden de Pago + Upload Comprobante
- [ ] Vista pública: Consultar Estado Solicitud (opcional)
- [ ] Controller: EstudianteMatriculaController
- [ ] Rutas para estudiantes internos
- [ ] Lógica validación 2 matrículas máximo
- [ ] Email notificaciones (aprobación, rechazo)

---

## 🚀 Siguiente Paso

¿Quieres que proceda a:
1. ✅ **Poblar la BD** (ejecutar seeders)
2. ✅ **Ajustar vista de configuración** (show/edit en vez de index)
3. ✅ **Crear vistas para estudiantes internos** (dashboard matrícula)
4. ⚠️ **Todo lo anterior**

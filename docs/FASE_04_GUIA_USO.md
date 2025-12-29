# 📖 Guía de Uso - Gestión de Relaciones Estudiante-Padre

## 🎯 Propósito

Esta guía explica cómo usar el sistema de gestión de relaciones entre Estudiantes y Padres/Representantes implementado en la Fase 4.

---

## 🚀 Acceso al Sistema

### Rutas Principales
- **Lista de Estudiantes:** `/estudiantes`
- **Detalle de Estudiante:** `/estudiantes/{id}`
- **Lista de Padres:** `/padres`
- **Detalle de Padre:** `/padres/{id}`

### Permisos Requeridos
- `ver estudiantes` o `gestionar estudiantes` - Para ver estudiantes
- `editar estudiantes` o `gestionar estudiantes` - Para gestionar relaciones desde estudiante
- `ver padres` o `gestionar padres` - Para ver padres
- `editar padres` o `gestionar padres` - Para gestionar relaciones desde padre

---

## 📋 Caso de Uso 1: Asociar un Padre a un Estudiante

### Escenario
Necesitas registrar que María González (madre) es la representante de Juan Pérez (estudiante).

### Pasos

1. **Navegar al estudiante**
   ```
   Ir a: Menú > Usuarios Especializados > Estudiantes
   Click en el ícono de "Ver" (ojo) del estudiante Juan Pérez
   ```

2. **Acceder a gestión de padres**
   ```
   En la vista de detalles, desplázate hasta la sección 
   "Padres/Representantes"
   ```

3. **Abrir modal de asociación**
   ```
   Click en el botón verde "Asociar Padre"
   Se abrirá un modal con un formulario
   ```

4. **Completar formulario**
   ```
   - Padre: Seleccionar "María González - 1234567890"
   - Parentesco: Seleccionar "madre"
   - [✓] Marcar checkbox "Representante Principal"
   ```

5. **Guardar**
   ```
   Click en botón "Asociar"
   El modal se cierra y aparece mensaje de éxito
   Nueva tarjeta con información de María aparece en la lista
   ```

### Resultado
```
✅ María González está asociada como madre de Juan Pérez
✅ Marcada como representante principal
✅ Visible en la vista de detalles del estudiante
```

---

## 📋 Caso de Uso 2: Registrar Hermanos

### Escenario
Carlos y Ana Pérez son hermanos. Ambos tienen a María González como madre representante.

### Pasos

1. **Asociar al primer hijo (ya hecho en Caso 1)**
   ```
   Juan Pérez ← María González (madre, principal)
   ```

2. **Navegar al padre**
   ```
   Ir a: Menú > Usuarios Especializados > Padres/Representantes
   Click en "Ver" de María González
   ```

3. **Asociar segundo hijo**
   ```
   Click en botón verde "Asociar Estudiante"
   - Estudiante: Seleccionar "EST-0002 - Ana Pérez"
   - Parentesco: Seleccionar "madre"
   - [✓] Marcar "Representante Principal"
   - Click en "Asociar"
   ```

4. **Verificar relaciones**
   ```
   En la sección "Estudiantes a Cargo" verás 2 tarjetas:
   - Juan Pérez (EST-0001)
   - Ana Pérez (EST-0002)
   Ambos con parentesco "Madre" y badge "Principal"
   ```

### Resultado
```
✅ María González tiene 2 estudiantes asociados
✅ Badge muestra "2 estudiante(s)"
✅ Ambos la tienen como representante principal
```

---

## 📋 Caso de Uso 3: Familia con Padres Separados

### Escenario
Pedro Ramírez tiene:
- Madre: Carmen López (representante principal, vive con él)
- Padre: Luis Ramírez (no vive con él)

### Pasos

1. **Asociar representante principal (madre)**
   ```
   Desde Pedro Ramírez:
   - Padre: Carmen López
   - Parentesco: madre
   - [✓] Representante Principal
   ```

2. **Asociar padre**
   ```
   Desde Pedro Ramírez:
   - Click en "Asociar Padre"
   - Padre: Luis Ramírez
   - Parentesco: padre
   - [ ] Representante Principal (desmarcar)
   ```

### Resultado
```
✅ Pedro tiene 2 padres asociados
✅ Carmen López: madre, principal ⭐
✅ Luis Ramírez: padre, no principal
```

---

## 📋 Caso de Uso 4: Estudiante con Tutor

### Escenario
Carlos Mendoza vive con su abuela Rosa Mendoza quien es su tutora legal.

### Pasos

1. **Crear padre/representante**
   ```
   Si la tutora no existe:
   - Ir a Padres/Representantes
   - Click en "Nuevo Padre/Representante"
   - Completar datos de Rosa Mendoza
   - Guardar
   ```

2. **Asociar como tutor**
   ```
   Desde Carlos Mendoza:
   - Click en "Asociar Padre"
   - Padre: Rosa Mendoza
   - Parentesco: tutor
   - [✓] Representante Principal
   ```

### Resultado
```
✅ Carlos tiene a Rosa como tutora
✅ Rosa es su representante principal
✅ El parentesco se muestra como "Tutor"
```

---

## ✏️ Editar una Relación Existente

### Escenario
Necesitas cambiar el parentesco de "padre" a "tutor" porque el padre ahora es tutor legal.

### Pasos

1. **Navegar a la relación**
   ```
   Ir a detalles del estudiante
   Buscar la tarjeta del padre en "Padres/Representantes"
   ```

2. **Abrir modal de edición**
   ```
   Click en el ícono de lápiz (editar) junto al nombre del padre
   Se abre modal "Editar Relación"
   ```

3. **Modificar datos**
   ```
   - Parentesco: Cambiar a "tutor"
   - Checkbox "Representante Principal": Ajustar según necesidad
   ```

4. **Guardar cambios**
   ```
   Click en "Actualizar"
   Modal se cierra y cambios se reflejan inmediatamente
   ```

### Resultado
```
✅ Parentesco actualizado de "padre" a "tutor"
✅ Los cambios se reflejan en ambas vistas (estudiante y padre)
```

---

## ❌ Desvincular un Padre/Representante

### Escenario
El estudiante cambió de representante y necesitas eliminar la relación anterior.

### Pasos

1. **Ubicar la relación**
   ```
   Ir a detalles del estudiante
   Buscar la tarjeta del padre a desvincular
   ```

2. **Ejecutar desvinculación**
   ```
   Click en el ícono X rojo junto al nombre
   Aparece confirmación: "¿Estás seguro de desvincular?"
   Click en "Aceptar"
   ```

3. **Verificar**
   ```
   La tarjeta desaparece de la lista
   Mensaje de éxito: "Padre/Representante desvinculado exitosamente"
   ```

### Resultado
```
✅ Relación eliminada permanentemente
✅ No afecta los registros de estudiante o padre
✅ Solo se elimina el vínculo entre ambos
```

---

## ⚠️ Validaciones y Restricciones

### Prevención de Duplicados
```
❌ No se puede asociar el mismo padre dos veces al mismo estudiante
El sistema valida y muestra: "Este padre ya está asociado"
```

### Campos Requeridos
```
✅ Padre/Estudiante: Obligatorio (select)
✅ Parentesco: Obligatorio (select)
✅ Representante Principal: Opcional (checkbox)
```

### Valores de Parentesco
```
- padre
- madre
- tutor
- otro
```

### Integridad Referencial
```
Si eliminas un estudiante → se eliminan sus relaciones automáticamente
Si eliminas un padre → se eliminan sus relaciones automáticamente
```

---

## 📊 Visualización de Información

### En Vista de Estudiante

**Sección "Padres/Representantes"**
```
┌─────────────────────────────────────┐
│ Padres/Representantes    [Asociar] │
├─────────────────────────────────────┤
│ ┌─────────────────────────────────┐ │
│ │ María González  [Principal] ✏️ ❌│ │
│ │ Parentesco: Madre                │ │
│ │ Cédula: 1234567890               │ │
│ │ Teléfono: 0999999999             │ │
│ │ Email: maria@email.com           │ │
│ └─────────────────────────────────┘ │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ Luis González              ✏️ ❌ │ │
│ │ Parentesco: Padre                │ │
│ │ Cédula: 0987654321               │ │
│ │ Teléfono: 0988888888             │ │
│ │ Email: luis@email.com            │ │
│ └─────────────────────────────────┘ │
└─────────────────────────────────────┘
```

### En Vista de Padre

**Sección "Estudiantes a Cargo"**
```
┌─────────────────────────────────────┐
│ Estudiantes a Cargo  [Asociar]     │
├─────────────────────────────────────┤
│ ┌─────────────────────────────────┐ │
│ │ Juan Pérez [Principal]    ✏️ ❌ │ │
│ │ Código: EST-0001                 │ │
│ │ Parentesco: Madre                │ │
│ │ Cédula: 1111111111               │ │
│ │ Estado: [Activo]                 │ │
│ └─────────────────────────────────┘ │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ Ana Pérez [Principal]     ✏️ ❌ │ │
│ │ Código: EST-0002                 │ │
│ │ Parentesco: Madre                │ │
│ │ Cédula: 2222222222               │ │
│ │ Estado: [Activo]                 │ │
│ └─────────────────────────────────┘ │
└─────────────────────────────────────┘

Badge: "2 estudiante(s)"
```

---

## 🔍 Búsqueda y Filtrado

### Encontrar Estudiantes sin Representante

1. **Ir a lista de estudiantes**
2. **Buscar visualmente** estudiantes con "0" en la columna de padres
3. **Hacer click en "Ver"** para asociar un representante

### Encontrar Padres con Múltiples Hijos

1. **Ir a lista de padres**
2. **Buscar** en la columna "Estudiantes" los que tengan 2+ estudiantes
3. **Hacer click en "Ver"** para ver detalles de todos los hijos

---

## 💡 Mejores Prácticas

### ✅ Recomendaciones

1. **Siempre designar un representante principal**
   - Cada estudiante debe tener un representante principal marcado
   - Útil para notificaciones y comunicaciones oficiales

2. **Mantener información actualizada**
   - Si cambia el representante, actualizar inmediatamente
   - Desvincular padres que ya no tengan custodia

3. **Usar parentesco correcto**
   - "padre" o "madre" para padres biológicos
   - "tutor" para tutores legales
   - "otro" para casos especiales

4. **Verificar duplicados antes de crear**
   - Buscar si el padre ya existe antes de crear uno nuevo
   - Evita duplicados en el sistema

### ❌ Errores Comunes

1. **No marcar representante principal**
   - Problema: No se sabe a quién contactar
   - Solución: Siempre marcar uno como principal

2. **Olvidar actualizar relaciones**
   - Problema: Información desactualizada
   - Solución: Revisar y actualizar periódicamente

3. **Crear padres duplicados**
   - Problema: Mismo padre con diferentes registros
   - Solución: Buscar primero en la lista de padres

---

## 🆘 Solución de Problemas

### Problema: "Este padre ya está asociado"
**Causa:** Intentas asociar un padre que ya está vinculado  
**Solución:** Verifica la lista actual de padres del estudiante

### Problema: No aparece el padre en el select
**Causa:** El padre ya está asociado o no existe  
**Solución:** 
- Verifica si ya está en la lista de asociados
- Si no existe, créalo primero en Padres/Representantes

### Problema: No puedo editar la relación
**Causa:** No tienes permisos de edición  
**Solución:** Solicita permiso "editar estudiantes" o "gestionar estudiantes"

### Problema: Cambios no se reflejan
**Causa:** Caché del navegador  
**Solución:** Refresca la página (F5) o limpia caché

---

## 📞 Contacto y Soporte

Para más información o problemas técnicos:
- Revisar documentación en `docs/FASE_04_RELACIONES_COMPLETADAS.md`
- Contactar al administrador del sistema
- Revisar los logs de Laravel en `storage/logs/laravel.log`

---

**Última actualización:** 29 de Diciembre, 2025  
**Versión:** 1.0  
**Sistema:** Oswaldo Guayasamín - Gestión Educativa

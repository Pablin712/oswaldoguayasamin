# 🎨 Sistema de Colores - Documentación Completa

## 📋 Tabla de Contenidos
1. [Estructura de Paletas](#estructura-de-paletas)
2. [Paletas Disponibles](#paletas-disponibles)
3. [Cómo Usar los Colores](#cómo-usar-los-colores)
4. [Cómo Agregar Nuevas Paletas](#cómo-agregar-nuevas-paletas)
5. [Modo Oscuro](#modo-oscuro)
6. [Variables CSS Dinámicas](#variables-css-dinámicas)
7. [Reglas de Contraste](#reglas-de-contraste)

---

## 📐 Estructura de Paletas

Cada paleta de colores tiene **5 colores principales**, cada uno con **3 variantes**:

```javascript
styleN: {
    primary:   { DEFAULT: '#color', light: '#lighter', dark: '#darker' },
    secondary: { DEFAULT: '#color', light: '#lighter', dark: '#darker' },
    third:     { DEFAULT: '#color', light: '#lighter', dark: '#darker' },
    fourth:    { DEFAULT: '#color', light: '#lighter', dark: '#darker' },
    five:      { DEFAULT: '#color', light: '#lighter', dark: '#darker' },
}
```

### Nomenclatura:
- **PRIMARY**: Color principal/destacado de la paleta
- **SECONDARY**: Color secundario/acento
- **THIRD**: Color terciario (usualmente oscuro para textos)
- **FOURTH**: Color neutral/intermedio
- **FIVE**: Color de fondo/claro

---

## 🎨 Paletas Disponibles

### **Paleta 1 (style1)** - Colores Originales de la Escuela
```
primary:   #62ff6d (Verde brillante)
secondary: #fffa3f (Amarillo brillante)
third:     #112405 (Verde oscuro)
fourth:    #868679 (Gris)
five:      #fffaf2 (Crema claro)
```

**Uso recomendado:**
- Primary: Botones principales, enlaces importantes
- Secondary: Alertas, notificaciones, badges
- Third: Textos oscuros, headers, pie de página
- Fourth: Bordes, divisores, textos secundarios
- Five: Fondos de tarjetas, secciones claras

### **Paleta 2 (style2)** - Tonos Verdes y Amarillos
```
primary:   #008c00 (Verde oscuro)
secondary: #6eb003 (Verde lima)
third:     #d9db58 (Amarillo verdoso)
fourth:    #ffffa9 (Amarillo claro)
five:      #fffff4 (Casi blanco)
```

**Uso recomendado:**
- Primary: Navegación, headers oscuros
- Secondary: Botones de acción, CTAs
- Third: Resaltados, tags, labels
- Fourth: Fondos suaves, hover states
- Five: Fondo principal de la página

---

## 💻 Cómo Usar los Colores

### **Opción 1: Clases Estáticas de Tailwind**
Los colores siempre serán los mismos, sin importar la paleta seleccionada:

```html
<!-- Fondo -->
<div class="bg-style1-primary">Siempre verde brillante</div>
<div class="bg-style2-primary">Siempre verde oscuro</div>

<!-- Texto -->
<h1 class="text-style1-secondary">Texto amarillo</h1>
<p class="text-style2-third">Texto amarillo verdoso</p>

<!-- Bordes -->
<div class="border-2 border-style1-third">Con borde verde oscuro</div>

<!-- Variantes -->
<button class="bg-style1-primary-light hover:bg-style1-primary-dark">
    Botón con hover
</button>
```

### **Opción 2: Variables CSS Dinámicas** ⭐ RECOMENDADO
Los colores cambian automáticamente según la paleta seleccionada por el usuario:

```html
<!-- Fondo -->
<div class="bg-theme-primary">Se adapta a la paleta activa</div>

<!-- Texto -->
<h1 class="text-theme-secondary">Color cambia con el selector</h1>

<!-- Bordes -->
<div class="border-2 border-theme-third">Borde dinámico</div>

<!-- Con variantes -->
<button class="bg-theme-primary-dark hover:bg-theme-primary text-white">
    Botón adaptable
</button>
```

### **Clases de Variables CSS Disponibles:**

#### Fondos:
- `bg-theme-primary`, `bg-theme-primary-light`, `bg-theme-primary-dark`
- `bg-theme-secondary`, `bg-theme-secondary-light`, `bg-theme-secondary-dark`
- `bg-theme-third`, `bg-theme-third-light`, `bg-theme-third-dark`
- `bg-theme-fourth`, `bg-theme-fourth-light`, `bg-theme-fourth-dark`
- `bg-theme-five`, `bg-theme-five-light`, `bg-theme-five-dark`

#### Textos:
- `text-theme-primary`, `text-theme-primary-light`, `text-theme-primary-dark`
- `text-theme-secondary`, `text-theme-secondary-light`, `text-theme-secondary-dark`
- `text-theme-third`, `text-theme-third-light`, `text-theme-third-dark`
- `text-theme-fourth`, `text-theme-fourth-light`, `text-theme-fourth-dark`
- `text-theme-five`, `text-theme-five-light`, `text-theme-five-dark`

#### Bordes:
- `border-theme-primary`, `border-theme-secondary`, `border-theme-third`
- `border-theme-fourth`, `border-theme-five`

---

## ➕ Cómo Agregar Nuevas Paletas

### **Paso 1: Agregar en tailwind.config.js**

Abre `tailwind.config.js` y agrega tu nueva paleta en la sección `colors`:

```javascript
// En tailwind.config.js dentro de theme.extend.colors

// ===== PALETA 3: Tu nueva paleta =====
style3: {
    primary: {
        DEFAULT: '#tu-color-base',
        light: '#versión-más-clara',    // +20-30% luminosidad
        dark: '#versión-más-oscura',    // -20-30% luminosidad
    },
    secondary: {
        DEFAULT: '#tu-color-base',
        light: '#versión-más-clara',
        dark: '#versión-más-oscura',
    },
    third: {
        DEFAULT: '#tu-color-base',
        light: '#versión-más-clara',
        dark: '#versión-más-oscura',
    },
    fourth: {
        DEFAULT: '#tu-color-base',
        light: '#versión-más-clara',
        dark: '#versión-más-oscura',
    },
    five: {
        DEFAULT: '#tu-color-base',
        light: '#versión-más-clara',
        dark: '#versión-más-oscura',
    },
},
```

### **Paso 2: Agregar Variables CSS en app.css**

Abre `resources/css/app.css` y agrega las variables CSS para tu nueva paleta:

```css
/* En la sección @layer base */

/* Paleta 3 - Tu Nueva Paleta */
[data-theme="style3"] {
    --color-primary: #tu-color-base;
    --color-primary-light: #versión-clara;
    --color-primary-dark: #versión-oscura;
    --color-secondary: #tu-color-base;
    --color-secondary-light: #versión-clara;
    --color-secondary-dark: #versión-oscura;
    --color-third: #tu-color-base;
    --color-third-light: #versión-clara;
    --color-third-dark: #versión-oscura;
    --color-fourth: #tu-color-base;
    --color-fourth-light: #versión-clara;
    --color-fourth-dark: #versión-oscura;
    --color-five: #tu-color-base;
    --color-five-light: #versión-clara;
    --color-five-dark: #versión-oscura;
}
```

### **Paso 3: Agregar en el Selector del Navbar**

Abre `resources/views/layouts/navigation.blade.php` y agrega la opción en el dropdown:

```html
<!-- Busca el selector de paletas y agrega -->
<button @click="changeTheme('style3'); themeOpen = false"
        :class="currentTheme === 'style3' ? 'bg-gray-100 dark:bg-gray-600' : ''"
        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
    <div class="flex gap-1">
        <span class="w-4 h-4 rounded-full bg-[#tu-color-1]"></span>
        <span class="w-4 h-4 rounded-full bg-[#tu-color-2]"></span>
        <span class="w-4 h-4 rounded-full bg-[#tu-color-3]"></span>
    </div>
    Paleta 3
</button>
```

Y actualiza el texto del botón principal:

```html
<!-- Encuentra el <span x-text...> y actualiza -->
<span x-text="currentTheme === 'style1' ? 'Paleta 1' : currentTheme === 'style2' ? 'Paleta 2' : 'Paleta 3'"></span>
```

### **Paso 4: Agregar versión móvil**

En el mismo archivo, en la sección de responsive (mobile), agrega el botón:

```html
<button @click="changeTheme('style3')"
        :class="currentTheme === 'style3' ? 'ring-2 ring-blue-500' : ''"
        class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
    <div class="flex gap-1 justify-center mb-1">
        <span class="w-3 h-3 rounded-full bg-[#tu-color-1]"></span>
        <span class="w-3 h-3 rounded-full bg-[#tu-color-2]"></span>
        <span class="w-3 h-3 rounded-full bg-[#tu-color-3]"></span>
    </div>
    <span class="text-gray-700 dark:text-gray-300">Paleta 3</span>
</button>
```

### **Paso 5: Compilar Assets**

Ejecuta en la terminal:
```bash
npm run dev
```

¡Listo! Tu nueva paleta ya está disponible. 🎉

---

## 🌙 Modo Oscuro

### **Activación Automática**
El modo oscuro se activa/desactiva desde el navbar (icono sol/luna) y se guarda en `localStorage`.

### **Uso en HTML**

```html
<!-- Colores que cambian en modo oscuro -->
<div class="bg-white dark:bg-gray-800">
    <h1 class="text-gray-900 dark:text-gray-100">Título</h1>
    <p class="text-gray-600 dark:text-gray-400">Texto</p>
</div>

<!-- Con colores del tema -->
<div class="bg-theme-five dark:bg-theme-third">
    <h2 class="text-theme-third dark:text-theme-five">Adaptable</h2>
</div>
```

### **Clases de Tailwind para Dark Mode:**
- **Fondos**: `dark:bg-gray-800`, `dark:bg-theme-third`
- **Textos**: `dark:text-gray-100`, `dark:text-theme-five`
- **Bordes**: `dark:border-gray-700`, `dark:border-theme-primary`

---

## 📊 Reglas de Contraste (WCAG Accesibilidad)

Para garantizar que los textos sean legibles:

### **Fondos Claros (light, five):**
✅ Usar texto oscuro: `text-gray-900`, `text-theme-third`

### **Fondos Oscuros (dark, third):**
✅ Usar texto claro: `text-white`, `text-gray-100`

### **Fondos Intermedios (primary, secondary, fourth):**
🔍 Revisar contraste según el color:
- **Verde brillante (#62ff6d)**: texto oscuro `text-gray-900`
- **Amarillo (#fffa3f)**: texto oscuro `text-gray-900`
- **Verde oscuro (#008c00)**: texto claro `text-white`
- **Gris (#868679)**: texto claro `text-white`

### **Herramientas Recomendadas:**
- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Coolors Contrast Checker](https://coolors.co/contrast-checker)

### **Estándar WCAG:**
- **AA Normal**: Contraste mínimo 4.5:1
- **AA Grande**: Contraste mínimo 3:1
- **AAA Normal**: Contraste mínimo 7:1

---

## 📝 Ejemplos Completos

### **Tarjeta con Tema Dinámico**
```html
<div class="bg-theme-five dark:bg-gray-800 rounded-lg shadow-lg p-6">
    <h3 class="text-theme-primary-dark dark:text-theme-primary-light font-bold text-xl mb-2">
        Título Adaptable
    </h3>
    <p class="text-gray-600 dark:text-gray-400 mb-4">
        Descripción que se adapta al modo oscuro
    </p>
    <button class="bg-theme-primary-dark hover:bg-theme-primary text-white font-semibold px-4 py-2 rounded">
        Acción
    </button>
</div>
```

### **Formulario con Colores del Sistema**
```html
<form class="space-y-4">
    <div>
        <label class="block text-theme-third dark:text-theme-five font-medium mb-2">
            Nombre
        </label>
        <input type="text" 
               class="w-full px-4 py-2 border-2 border-theme-fourth 
                      bg-theme-five dark:bg-gray-700 
                      text-theme-third dark:text-gray-100
                      focus:border-theme-primary focus:ring focus:ring-theme-primary/20
                      rounded-lg">
    </div>
    
    <button type="submit" 
            class="bg-theme-primary-dark hover:bg-theme-primary 
                   text-white font-semibold px-6 py-3 rounded-lg 
                   shadow hover:shadow-lg transition">
        Enviar
    </button>
</form>
```

---

## 🔧 Mantenimiento

### **Cambiar un color de una paleta existente:**
1. Modifica en `tailwind.config.js`
2. Actualiza las variables CSS en `app.css`
3. Ejecuta `npm run dev`

### **Establecer paleta por defecto:**
En `navigation.blade.php`, cambia:
```javascript
currentTheme: localStorage.getItem('theme') || 'style1', // Cambia 'style1'
```

### **Desactivar modo oscuro por defecto:**
En `navigation.blade.php`, cambia:
```javascript
darkMode: localStorage.getItem('darkMode') === 'true', // Ya está correcto
```

---

## 📚 Recursos Adicionales

- [Tailwind CSS Colors](https://tailwindcss.com/docs/customizing-colors)
- [Tailwind Dark Mode](https://tailwindcss.com/docs/dark-mode)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [CSS Variables Guide](https://developer.mozilla.org/en-US/docs/Web/CSS/Using_CSS_custom_properties)

---

## ✅ Checklist para Nueva Paleta

- [ ] Definir 5 colores base con significado claro
- [ ] Crear variantes light y dark para cada color
- [ ] Agregar en `tailwind.config.js`
- [ ] Crear variables CSS en `app.css`
- [ ] Agregar opción en selector del navbar (desktop)
- [ ] Agregar opción en selector del navbar (mobile)
- [ ] Probar contraste de todos los colores
- [ ] Verificar accesibilidad WCAG
- [ ] Compilar assets con `npm run dev`
- [ ] Probar en navegador con modo claro y oscuro

---

**Última actualización:** Diciembre 2025
**Versión:** 1.0
**Mantenido por:** Equipo de Desarrollo

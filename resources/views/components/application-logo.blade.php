@php
    $user = auth()->user();
    $logoUrl = $user && $user->institucion && $user->institucion->logo
        ? Storage::url($user->institucion->logo)
        : null;
@endphp

@if($logoUrl)
    <img src="{{ $logoUrl }}" alt="Logo Institución" {{ $attributes }} style="object-fit: contain;" />
@else
<!-- Logo escolar estilo emoji: libro abierto con birrete de graduación -->
<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Sombra del libro -->
    <ellipse cx="50" cy="72" rx="32" ry="4" fill="#00000020"/>

    <!-- Libro abierto con colores -->
    <g>
        <!-- Página izquierda con gradiente -->
        <path d="M 20 35 Q 20 25, 30 25 L 48 25 L 48 70 L 30 70 Q 20 70, 20 60 Z"
              fill="#FFE5B4" stroke="#8B4513" stroke-width="2"/>
        <!-- Sombra interna izquierda -->
        <path d="M 20 35 Q 20 25, 30 25 L 35 25 L 35 70 L 30 70 Q 20 70, 20 60 Z"
              fill="#00000010"/>

        <!-- Página derecha con gradiente -->
        <path d="M 52 25 L 70 25 Q 80 25, 80 35 L 80 60 Q 80 70, 70 70 L 52 70 Z"
              fill="#FFF8DC" stroke="#8B4513" stroke-width="2"/>
        <!-- Sombra interna derecha -->
        <path d="M 75 25 L 70 25 Q 80 25, 80 35 L 80 60 Q 80 70, 70 70 L 75 70 Q 80 70, 80 60 L 80 35 Q 80 25, 75 25 Z"
              fill="#00000010"/>

        <!-- Líneas del libro -->
        <line x1="25" y1="35" x2="43" y2="35" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="25" y1="42" x2="43" y2="42" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="25" y1="49" x2="43" y2="49" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="25" y1="56" x2="43" y2="56" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="57" y1="35" x2="75" y2="35" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="57" y1="42" x2="75" y2="42" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="57" y1="49" x2="75" y2="49" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>
        <line x1="57" y1="56" x2="75" y2="56" stroke="#8B4513" stroke-width="1.5" opacity="0.4"/>

        <!-- Lomo del libro con volumen -->
        <rect x="47" y="25" width="6" height="45" fill="#8B4513" stroke="#5C2E0F" stroke-width="1.5"/>
        <rect x="48.5" y="25" width="1.5" height="45" fill="#A0522D" opacity="0.6"/>
    </g>

    <!-- Birrete de graduación con colores -->
    <g>
        <!-- Sombra del birrete -->
        <ellipse cx="50" cy="23" rx="18" ry="4" fill="#00000020"/>

        <!-- Base del birrete (negro) -->
        <ellipse cx="50" cy="22" rx="18" ry="4" fill="#2C2C2C" stroke="#000000" stroke-width="1.5"/>
        <ellipse cx="50" cy="22" rx="18" ry="3" fill="#1A1A1A"/>

        <!-- Parte superior plana del birrete (negro con brillo) -->
        <rect x="34" y="13" width="32" height="4" fill="#2C2C2C" stroke="#000000" stroke-width="1.5" rx="1"/>
        <rect x="35" y="13.5" width="30" height="1.5" fill="#404040" opacity="0.8"/>

        <!-- Botón central (dorado) -->
        <circle cx="50" cy="15" r="2.5" fill="#FFD700" stroke="#B8860B" stroke-width="1"/>
        <circle cx="50" cy="14.5" r="1.5" fill="#FFED4E" opacity="0.7"/>

        <!-- Borla (azul/morado) -->
        <line x1="50" y1="15" x2="60" y2="6" stroke="#4169E1" stroke-width="2" stroke-linecap="round"/>
        <!-- Pompón de la borla -->
        <circle cx="60" cy="6" r="3" fill="#4169E1" stroke="#1E3A8A" stroke-width="1.5"/>
        <circle cx="60" cy="5.5" r="2" fill="#5B7FE8" opacity="0.8"/>
        <!-- Detalles del pompón -->
        <circle cx="59" cy="5" r="0.8" fill="#6B8FFF" opacity="0.9"/>
        <circle cx="61" cy="6" r="0.8" fill="#6B8FFF" opacity="0.9"/>
    </g>
</svg>
@endif

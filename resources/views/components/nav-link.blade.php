{{-- resources/views/components/nav-link.blade.php--}}
@props(['active'])

@php
// Clases para tema claro
$lightBg = 'bg-lightBg text-lightText hover:bg-lightBg/80 focus:bg-lightBg/80 border-darkText';
$lightClasses = 'border-lightBg text-xs whitespace-nowrap inline-flex items-center px-2 py-1 rounded-lg transition
duration-150 ease-in-out';

// Clases para tema oscuro
$darkBg = 'dark:bg-darkBg dark:text-darkText dark:hover:bg-darkBg/80 dark:focus:bg-darkBg/80 dark:border-lightText';
$darkClasses = 'dark:border-darkBg';

// Clase base para el enlace activo e inactivo
$activeClasses = $active
? 'border-b-2 border-indigo-400 dark:border-indigo-600 font-medium focus:border-indigo-700'
: 'border-b-2 border-transparent font-medium';

// Fusionar todas las clases
$classes = "{$activeClasses} {$lightClasses} {$darkClasses}";
@endphp

<a {{ $attributes->merge(['class' => $classes . ' ' . $lightBg . ' ' . $darkBg]) }}>
  {{ $slot }}
</a>
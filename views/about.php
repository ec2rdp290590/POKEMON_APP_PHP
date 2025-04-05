<?php
// Establecer título de la página
$pageTitle = 'Acerca de';
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-center">Acerca de <?= APP_NAME ?></h1>
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-4">Nuestro Proyecto</h2>
        <p class="mb-4">
            Bienvenido a nuestro Blog de Pokémon, un proyecto desarrollado con PHP puro que utiliza la PokeAPI para mostrar
            información detallada sobre los Pokémon.
        </p>
        <p class="mb-4">
            Este proyecto fue creado como una demostración de cómo construir una aplicación web sin utilizar bases de datos,
            almacenando toda la información en memoria mediante arreglos y sesiones de PHP.
        </p>
        
        <h2 class="text-2xl font-bold mt-8 mb-4">Características</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>Exploración de Pokémon con paginación</li>
            <li>Detalles completos de cada Pokémon</li>
            <li>Sistema de "Me gusta" para marcar tus Pokémon favoritos</li>
            <li>Posibilidad de ocultar Pokémon que no te interesen</li>
            <li>Sección de comentarios para cada Pokémon</li>
            <li>Blog con artículos sobre el mundo Pokémon</li>
        </ul>
        
        <h2 class="text-2xl font-bold mt-8 mb-4">Tecnologías Utilizadas</h2>
        <ul class="list-disc pl-6 space-y-2">
            <li>PHP 7.4+</li>
            <li>Tailwind CSS para el diseño</li>
            <li>PokeAPI para obtener datos de Pokémon</li>
            <li>Sesiones de PHP para almacenamiento en memoria</li>
        </ul>
        
        <div class="mt-8 p-6 bg-gray-100 rounded-lg">
            <h3 class="text-xl font-bold mb-4">¿Cómo funciona?</h3>
            <p class="mb-4">
                En lugar de utilizar una base de datos tradicional, este proyecto almacena todos los datos de interacción
                del usuario (me gusta, comentarios, etc.) en la sesión de PHP. Esto significa que los datos se mantienen
                solo durante la sesión del navegador.
            </p>
            <p>
                Los datos de los Pokémon se obtienen en tiempo real desde la PokeAPI, lo que garantiza información
                actualizada sin necesidad de mantener una base de datos propia.
            </p>
        </div>
    </div>
</div>

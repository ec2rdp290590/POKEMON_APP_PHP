<?php
// Colores para las diferentes estadísticas
$statColors = [
    'hp' => '#FF0000',
    'attack' => '#F08030',
    'defense' => '#F8D030',
    'special-attack' => '#6890F0',
    'special-defense' => '#78C850',
    'speed' => '#F85888'
];

// Valor máximo posible para una estadística
$maxStatValue = 255;

// Obtener el color para esta estadística
$color = $statColors[$statName] ?? '#A8A878';

// Calcular el porcentaje para la barra de progreso
$percentage = min(100, ($statValue / $maxStatValue) * 100);
?>

<div class="mb-3">
    <div class="flex justify-between items-center mb-1">
        <span class="text-sm font-medium"><?= getStatName($statName) ?></span>
        <span class="text-sm font-medium"><?= $statValue ?></span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="h-2.5 rounded-full" style="width: <?= $percentage ?>%; background-color: <?= $color ?>;"></div>
    </div>
</div>

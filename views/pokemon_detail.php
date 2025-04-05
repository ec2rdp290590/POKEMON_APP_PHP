<?php
// Obtener el ID del Pokémon
$pokemonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($pokemonId <= 0) {
    // Redirigir a la página principal si no hay ID válido
    header('Location: index.php');
    exit;
}

// Obtener el servicio de Pokémon
$pokemonService = new PokemonService();

// Obtener los detalles del Pokémon
$pokemon = $pokemonService->getPokemonById($pokemonId);

if (!$pokemon) {
    // Redirigir a la página principal si no se encuentra el Pokémon
    header('Location: index.php');
    exit;
}

// Obtener el almacén de datos
$dataStore = $_SESSION['data_store'];

// Verificar si el Pokémon es favorito
$isLiked = in_array($pokemonId, $dataStore->getLikedPokemon());

// Obtener los comentarios del Pokémon
$comments = $dataStore->getComments($pokemonId);
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="?page=home" class="text-blue-500 hover:underline flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a la lista
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 bg-gray-100 flex items-center justify-center p-8">
                <img src="<?php echo $pokemon['image']; ?>" alt="<?php echo $pokemon['name']; ?>" class="w-full max-w-xs">
            </div>
            <div class="md:w-2/3 p-8">
                <div class="flex justify-between items-start">
                    <h1 class="text-3xl font-bold mb-2 capitalize"><?php echo $pokemon['name']; ?></h1>
                    <div class="flex gap-2">
                        <a href="?page=pokemon&id=<?php echo $pokemonId; ?>&action=<?php echo $isLiked ? 'unlike' : 'like'; ?>" class="text-<?php echo $isLiked ? 'red' : 'gray'; ?>-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="<?php echo $isLiked ? 'currentColor' : 'none'; ?>" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php foreach ($pokemon['types'] as $type): ?>
                        <span class="px-3 py-1 rounded-full text-white text-sm" style="background-color: <?php echo getTypeColor($type); ?>">
                            <?php echo $type; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                
                <?php if (!empty($pokemon['description'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Descripción</h2>
                        <p class="text-gray-700"><?php echo $pokemon['description']; ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Información</h2>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <span class="text-gray-600">Altura:</span>
                                <span class="font-medium"><?php echo $pokemon['height']; ?> m</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Peso:</span>
                                <span class="font-medium"><?php echo $pokemon['weight']; ?> kg</span>
                            </li>
                            <li>
                                <span class="text-gray-600">Habilidades:</span>
                                <ul class="list-disc list-inside ml-2 mt-1">
                                    <?php foreach ($pokemon['abilities'] as $ability): ?>
                                        <li><?php echo $ability; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Estadísticas</h2>
                        <div class="space-y-3">
                            <?php 
                            $statNames = [
                                'hp' => 'HP',
                                'attack' => 'Ataque',
                                'defense' => 'Defensa',
                                'special_attack' => 'Ataque Especial',
                                'special_defense' => 'Defensa Especial',
                                'speed' => 'Velocidad'
                            ];
                            
                            foreach ($statNames as $key => $name): 
                                $value = isset($pokemon['stats'][$key]) ? $pokemon['stats'][$key] : 0;
                                $percentage = min(100, ($value / 255) * 100);
                            ?>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-gray-600"><?php echo $name; ?></span>
                                        <span class="font-medium"><?php echo $value; ?></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sección de comentarios -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-6">Comentarios</h2>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Deja tu comentario</h3>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="add_comment">
                <input type="hidden" name="pokemon_id" value="<?php echo $pokemonId; ?>">
                <div class="mb-4">
                    <textarea name="comment" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Enviar comentario
                </button>
            </form>
        </div>
        
        <?php if (empty($comments)): ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                No hay comentarios aún. ¡Sé el primero en comentar!
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach (array_reverse($comments) as $comment): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Usuario anónimo</div>
                                    <div class="text-xs text-gray-500"><?php echo date('d/m/Y H:i', strtotime($comment['date'])); ?></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($comment['text'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


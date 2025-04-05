<?php
// Obtener el número de página actual
$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($currentPage < 1) $currentPage = 1;

// Obtener el servicio de Pokémon
$pokemonService = new PokemonService();

// Obtener la lista de Pokémon para la página actual
$pokemonList = $pokemonService->getPokemonList($currentPage, POKEMON_PER_PAGE);

// Obtener el total de Pokémon para calcular la paginación
$totalPokemon = $pokemonService->getTotalPokemonCount();
$totalPages = ceil($totalPokemon / POKEMON_PER_PAGE);

// Obtener los Pokémon favoritos y ocultos del usuario
$dataStore = $_SESSION['data_store'];
$likedPokemon = $dataStore->getLikedPokemon();
$hiddenPokemon = $dataStore->getHiddenPokemon();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Explora el mundo Pokémon</h1>
    
    <!-- Filtros -->
    <div class="mb-6 flex flex-wrap justify-center gap-4">
        <a href="?page=home" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Todos
        </a>
        <a href="?page=home&filter=liked" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Mis favoritos
        </a>
    </div>
    
    <!-- Lista de Pokémon -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($pokemonList as $pokemon): 
            // Verificar si el Pokémon está oculto
            if (in_array($pokemon['id'], $hiddenPokemon)) continue;
            
            // Verificar si estamos filtrando por favoritos
            if (isset($_GET['filter']) && $_GET['filter'] === 'liked' && !in_array($pokemon['id'], $likedPokemon)) continue;
            
            // Verificar si el Pokémon es favorito
            $isLiked = in_array($pokemon['id'], $likedPokemon);
        ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <img src="<?php echo $pokemon['image']; ?>" alt="<?php echo $pokemon['name']; ?>" class="w-full h-48 object-contain bg-gray-100">
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2 capitalize"><?php echo $pokemon['name']; ?></h2>
                    <div class="flex items-center mb-3">
                        <?php foreach ($pokemon['types'] as $type): ?>
                            <span class="mr-2 px-2 py-1 text-xs rounded bg-<?php echo strtolower($type); ?>-100 text-<?php echo strtolower($type); ?>-800">
                                <?php echo $type; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="?page=pokemon&id=<?php echo $pokemon['id']; ?>" class="text-blue-500 hover:underline">Ver detalles</a>
                        <div class="flex gap-2">
                            <a href="?page=home&action=<?php echo $isLiked ? 'unlike' : 'like'; ?>&id=<?php echo $pokemon['id']; ?>" class="text-<?php echo $isLiked ? 'red' : 'gray'; ?>-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="<?php echo $isLiked ? 'currentColor' : 'none'; ?>" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </a>
                            <a href="?page=home&action=hide&id=<?php echo $pokemon['id']; ?>" class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Paginación -->
    <div class="mt-8 flex justify-center">
        <div class="flex space-x-2">
            <?php if ($currentPage > 1): ?>
                <a href="?page=home&p=<?php echo $currentPage - 1; ?>" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Anterior
                </a>
            <?php endif; ?>
            
            <?php
            // Mostrar un número limitado de páginas
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
            
            for ($i = $startPage; $i <= $endPage; $i++):
            ?>
                <a href="?page=home&p=<?php echo $i; ?>" class="px-4 py-2 <?php echo $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?> rounded hover:bg-<?php echo $i === $currentPage ? 'blue-600' : 'gray-300'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=home&p=<?php echo $currentPage + 1; ?>" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Siguiente
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>


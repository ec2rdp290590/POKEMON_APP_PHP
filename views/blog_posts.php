<?php
// Obtener el servicio de blog
$dataStore = $_SESSION['data_store'];
$blogPosts = $dataStore->getBlogPosts();

// Si no hay posts, crear algunos de ejemplo
if (empty($blogPosts)) {
    $blogPosts = [
        [
            'id' => 1,
            'title' => 'Los 10 Pokémon más poderosos de la primera generación',
            'excerpt' => 'Un análisis detallado de los Pokémon más fuertes de Kanto basado en estadísticas y utilidad en combate.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl.',
            'image' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/150.png',
            'author' => 'Profesor Oak',
            'date' => '2023-05-15',
            'tags' => ['Kanto', 'Poder', 'Competitivo']
        ],
        [
            'id' => 2,
            'title' => 'Guía completa para evolucionar a Eevee',
            'excerpt' => 'Descubre todas las evoluciones de Eevee y cómo obtenerlas en los diferentes juegos de la saga.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl.',
            'image' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/133.png',
            'author' => 'Investigador Pokémon',
            'date' => '2023-06-22',
            'tags' => ['Eevee', 'Evolución', 'Guía']
        ],
        [
            'id' => 3,
            'title' => 'Historia y origen de los Pokémon legendarios',
            'excerpt' => 'Un recorrido por la mitología detrás de los Pokémon legendarios y su importancia en el universo Pokémon.',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquam nisl, vel aliquam nisl nisl vel nisl.',
            'image' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/249.png',
            'author' => 'Historiador Pokémon',
            'date' => '2023-07-10',
            'tags' => ['Legendarios', 'Mitología', 'Historia']
        ]
    ];
    
    // Guardar los posts de ejemplo
    $dataStore->setBlogPosts($blogPosts);
}
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Blog Pokémon</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($blogPosts as $post): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-3">
                        <?php foreach ($post['tags'] as $tag): ?>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                <?php echo $tag; ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <h2 class="text-xl font-semibold mb-2"><?php echo $post['title']; ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo $post['excerpt']; ?></p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>Por <?php echo $post['author']; ?></span>
                        <span><?php echo date('d/m/Y', strtotime($post['date'])); ?></span>
                    </div>
                    <a href="?page=blog&id=<?php echo $post['id']; ?>" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Leer más
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


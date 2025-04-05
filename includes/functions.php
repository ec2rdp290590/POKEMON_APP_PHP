<?php
/**
 * Procesar los envíos de formularios
 */
function processFormSubmissions() {
    $dataStore = $_SESSION['data_store'];
    
    // Procesar comentarios
    if (isset($_POST['action']) && $_POST['action'] === 'add_comment') {
        $pokemonId = isset($_POST['pokemon_id']) ? (int)$_POST['pokemon_id'] : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        
        if ($pokemonId > 0 && !empty($comment)) {
            $dataStore->addComment($pokemonId, $comment);
        }
        
        // Redirigir para evitar reenvío del formulario
        header("Location: index.php?page=pokemon&id={$pokemonId}");
        exit;
    }
}

/**
 * Procesar acciones de URL
 */
function processUrlActions($action, $id) {
    $dataStore = $_SESSION['data_store'];
    $id = (int)$id;
    
    switch ($action) {
        case 'like':
            $dataStore->likePokemon($id);
            break;
        case 'unlike':
            $dataStore->unlikePokemon($id);
            break;
        case 'hide':
            $dataStore->hidePokemon($id);
            break;
        case 'show':
            $dataStore->showPokemon($id);
            break;
    }
    
    // Redirigir para evitar que la acción se repita al refrescar
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: {$redirectUrl}");
    exit;
}

/**
 * Formatear un nombre para mostrar (capitalizar y reemplazar guiones por espacios)
 */
function formatName($name) {
    return ucfirst(str_replace('-', ' ', $name));
}

/**
 * Obtener el color de fondo según el tipo de Pokémon
 */
function getTypeColor($type) {
    $colors = [
        'normal' => '#A8A878',
        'fire' => '#F08030',
        'water' => '#6890F0',
        'electric' => '#F8D030',
        'grass' => '#78C850',
        'ice' => '#98D8D8',
        'fighting' => '#C03028',
        'poison' => '#A040A0',
        'ground' => '#E0C068',
        'flying' => '#A890F0',
        'psychic' => '#F85888',
        'bug' => '#A8B820',
        'rock' => '#B8A038',
        'ghost' => '#705898',
        'dragon' => '#7038F8',
        'dark' => '#705848',
        'steel' => '#B8B8D0',
        'fairy' => '#EE99AC'
    ];
    
    $type = strtolower($type);
    return isset($colors[$type]) ? $colors[$type] : '#777777';
}



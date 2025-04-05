<?php
/**
 * Clase DataStore
 * 
 * Esta clase reemplaza la funcionalidad de la base de datos
 * almacenando todos los datos en arreglos en memoria (sesión)
 */
class DataStore {
    private $likedPokemon = [];
    private $hiddenPokemon = [];
    private $comments = [];
    private $blogPosts = [];
    
    public function __construct() {
        // Inicializar con algunos datos de ejemplo para el blog
        $this->blogPosts = [
            [
                'id' => 1,
                'title' => 'Los 10 Pokémon más poderosos de la primera generación',
                'content' => "La primera generación de Pokémon introdujo 151 criaturas únicas, pero algunas destacaron por su poder en combate.\n\nMewtwo, creado genéticamente a partir del ADN de Mew, es sin duda el más poderoso con estadísticas base impresionantes y un conjunto de movimientos versátil. Otros Pokémon notables incluyen Dragonite, Gyarados, Alakazam y Gengar.\n\nLa mayoría de estos Pokémon siguen siendo relevantes incluso en las generaciones actuales, demostrando el excelente diseño y balance que Game Freak logró desde el principio.",
                'featured_pokemon_id' => 150,
                'author' => 'Profesor Oak',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 2,
                'title' => 'Guía para evolucionar a Eevee: Todas las posibilidades',
                'content' => "Eevee es uno de los Pokémon más versátiles cuando se trata de evolución. A diferencia de la mayoría de los Pokémon que tienen una o dos evoluciones, Eevee puede evolucionar en ocho formas diferentes.\n\nCada evolución requiere un método específico:\n- Vaporeon: Piedra Agua\n- Jolteon: Piedra Trueno\n- Flareon: Piedra Fuego\n- Espeon: Subir nivel con alta amistad durante el día\n- Umbreon: Subir nivel con alta amistad durante la noche\n- Leafeon: Subir nivel cerca de una roca musgo\n- Glaceon: Subir nivel cerca de una roca hielo\n- Sylveon: Conocer un movimiento de tipo Hada y tener alta amistad\n\nCada evolución tiene sus propias fortalezas y debilidades, lo que hace que Eevee sea un Pokémon extremadamente valioso para cualquier entrenador.",
                'featured_pokemon_id' => 133,
                'author' => 'Entrenadora Valeria',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ]
        ];
    }
    
    // Métodos para "me gusta"
    public function isPokemonLiked($pokemonId) {
        return in_array($pokemonId, $this->likedPokemon);
    }
    
    public function toggleLike($pokemonId) {
        if ($this->isPokemonLiked($pokemonId)) {
            // Eliminar de los favoritos
            $this->likedPokemon = array_diff($this->likedPokemon, [$pokemonId]);
            return false;
        } else {
            // Agregar a favoritos
            $this->likedPokemon[] = $pokemonId;
            return true;
        }
    }
    
    public function getLikedPokemonIds() {
        return $this->likedPokemon;
    }
    
    // Métodos para Pokémon ocultos
    public function isPokemonHidden($pokemonId) {
        return in_array($pokemonId, $this->hiddenPokemon);
    }
    
    public function hidePokemon($pokemonId) {
        if (!$this->isPokemonHidden($pokemonId)) {
            $this->hiddenPokemon[] = $pokemonId;
            return true;
        }
        return false;
    }
    
    public function getHiddenPokemonIds() {
        return $this->hiddenPokemon;
    }
    
    // Métodos para comentarios
    public function getCommentsForPokemon($pokemonId) {
        if (!isset($this->comments[$pokemonId])) {
            return [];
        }
        return $this->comments[$pokemonId];
    }
    
    public function addComment($pokemonId, $comment, $username) {
        if (!isset($this->comments[$pokemonId])) {
            $this->comments[$pokemonId] = [];
        }
        
        $this->comments[$pokemonId][] = [
            'id' => count($this->comments[$pokemonId]) + 1,
            'user_id' => session_id(),
            'username' => $username,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return true;
    }
    
    // Métodos para artículos del blog
    public function getBlogPosts() {
        return $this->blogPosts;
    }
    
    public function getBlogPostById($id) {
        foreach ($this->blogPosts as $post) {
            if ($post['id'] == $id) {
                return $post;
            }
        }
        return null;
    }
}
?>

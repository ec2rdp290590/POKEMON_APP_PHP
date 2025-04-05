<?php
/**
 * Clase para almacenar datos en la sesión
 */
class DataStore {
    private $likedPokemon = [];
    private $hiddenPokemon = [];
    private $comments = [];
    private $blogPosts = [];
    
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar las propiedades desde la sesión si existen
        if (isset($_SESSION['liked_pokemon'])) {
            $this->likedPokemon = $_SESSION['liked_pokemon'];
        }
        
        if (isset($_SESSION['hidden_pokemon'])) {
            $this->hiddenPokemon = $_SESSION['hidden_pokemon'];
        }
        
        if (isset($_SESSION['comments'])) {
            $this->comments = $_SESSION['comments'];
        }
        
        if (isset($_SESSION['blog_posts'])) {
            $this->blogPosts = $_SESSION['blog_posts'];
        }
    }
    
    /**
     * Guardar los cambios en la sesión
     */
    private function saveToSession() {
        $_SESSION['liked_pokemon'] = $this->likedPokemon;
        $_SESSION['hidden_pokemon'] = $this->hiddenPokemon;
        $_SESSION['comments'] = $this->comments;
        $_SESSION['blog_posts'] = $this->blogPosts;
    }
    
    /**
     * Añadir un Pokémon a favoritos
     */
    public function likePokemon($pokemonId) {
        if (!in_array($pokemonId, $this->likedPokemon)) {
            $this->likedPokemon[] = $pokemonId;
            $this->saveToSession();
        }
    }
    
    /**
     * Quitar un Pokémon de favoritos
     */
    public function unlikePokemon($pokemonId) {
        $key = array_search($pokemonId, $this->likedPokemon);
        if ($key !== false) {
            unset($this->likedPokemon[$key]);
            $this->likedPokemon = array_values($this->likedPokemon); // Reindexar el array
            $this->saveToSession();
        }
    }
    
    /**
     * Ocultar un Pokémon
     */
    public function hidePokemon($pokemonId) {
        if (!in_array($pokemonId, $this->hiddenPokemon)) {
            $this->hiddenPokemon[] = $pokemonId;
            $this->saveToSession();
        }
    }
    
    /**
     * Mostrar un Pokémon oculto
     */
    public function showPokemon($pokemonId) {
        $key = array_search($pokemonId, $this->hiddenPokemon);
        if ($key !== false) {
            unset($this->hiddenPokemon[$key]);
            $this->hiddenPokemon = array_values($this->hiddenPokemon); // Reindexar el array
            $this->saveToSession();
        }
    }
    
    /**
     * Añadir un comentario
     */
    public function addComment($pokemonId, $comment) {
        if (!isset($this->comments[$pokemonId])) {
            $this->comments[$pokemonId] = [];
        }
        
        $this->comments[$pokemonId][] = [
            'text' => $comment,
            'date' => date('Y-m-d H:i:s')
        ];
        
        $this->saveToSession();
    }
    
    /**
     * Obtener los comentarios de un Pokémon
     */
    public function getComments($pokemonId) {
        return isset($this->comments[$pokemonId]) ? $this->comments[$pokemonId] : [];
    }
    
    /**
     * Obtener los Pokémon favoritos
     */
    public function getLikedPokemon() {
        return $this->likedPokemon;
    }
    
    /**
     * Obtener los Pokémon ocultos
     */
    public function getHiddenPokemon() {
        return $this->hiddenPokemon;
    }
    
    /**
     * Establecer los posts del blog
     */
    public function setBlogPosts($posts) {
        $this->blogPosts = $posts;
        $this->saveToSession();
    }
    
    /**
     * Obtener los posts del blog
     */
    public function getBlogPosts() {
        return $this->blogPosts;
    }
    
    /**
     * Obtener un post del blog por ID
     */
    public function getBlogPost($id) {
        foreach ($this->blogPosts as $post) {
            if ($post['id'] == $id) {
                return $post;
            }
        }
        return null;
    }
}



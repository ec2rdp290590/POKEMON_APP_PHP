<?php
/**
 * Servicio para interactuar con la PokeAPI
 */
class PokemonService {
    private $baseUrl = POKEAPI_BASE_URL;
    private $cacheTime = 3600; // 1 hora en segundos
    
    /**
     * Obtener datos de la API con caché
     */
    private function fetchFromApi($endpoint) {
        $cacheKey = md5($endpoint);
        
        // Verificar si los datos están en caché
        if (isset($_SESSION['api_cache'][$cacheKey])) {
            $cache = $_SESSION['api_cache'][$cacheKey];
            
            // Verificar si la caché aún es válida
            if ($cache['timestamp'] + $this->cacheTime > time()) {
                return $cache['data'];
            }
        }
        
        // Si no está en caché o expiró, hacer la petición
        $url = $this->baseUrl . $endpoint;
        $response = file_get_contents($url);
        
        if ($response === false) {
            return null;
        }
        
        $data = json_decode($response, true);
        
        // Guardar en caché
        if (!isset($_SESSION['api_cache'])) {
            $_SESSION['api_cache'] = [];
        }
        
        $_SESSION['api_cache'][$cacheKey] = [
            'data' => $data,
            'timestamp' => time()
        ];
        
        return $data;
    }
    
    /**
     * Obtener la lista de Pokémon paginada
     */
    public function getPokemonList($page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $data = $this->fetchFromApi("/pokemon?offset={$offset}&limit={$limit}");
        
        if (!$data || !isset($data['results'])) {
            return [];
        }
        
        $pokemonList = [];
        
        foreach ($data['results'] as $pokemon) {
            $pokemonData = $this->fetchFromApi(str_replace($this->baseUrl, '', $pokemon['url']));
            
            if ($pokemonData) {
                $types = [];
                foreach ($pokemonData['types'] as $type) {
                    $types[] = ucfirst($type['type']['name']);
                }
                
                $pokemonList[] = [
                    'id' => $pokemonData['id'],
                    'name' => $pokemonData['name'],
                    'image' => $pokemonData['sprites']['other']['official-artwork']['front_default'],
                    'types' => $types,
                    'height' => $pokemonData['height'] / 10, // Convertir a metros
                    'weight' => $pokemonData['weight'] / 10, // Convertir a kg
                    'abilities' => array_map(function($ability) {
                        return ucfirst($ability['ability']['name']);
                    }, $pokemonData['abilities']),
                    'stats' => array_reduce($pokemonData['stats'], function($carry, $stat) {
                        $carry[str_replace('-', '_', $stat['stat']['name'])] = $stat['base_stat'];
                        return $carry;
                    }, [])
                ];
            }
        }
        
        return $pokemonList;
    }
    
    /**
     * Obtener detalles de un Pokémon por ID
     */
    public function getPokemonById($id) {
        $pokemonData = $this->fetchFromApi("/pokemon/{$id}");
        
        if (!$pokemonData) {
            return null;
        }
        
        $types = [];
        foreach ($pokemonData['types'] as $type) {
            $types[] = ucfirst($type['type']['name']);
        }
        
        $speciesData = $this->fetchFromApi(str_replace($this->baseUrl, '', $pokemonData['species']['url']));
        $description = '';
        
        if ($speciesData && isset($speciesData['flavor_text_entries'])) {
            foreach ($speciesData['flavor_text_entries'] as $entry) {
                if ($entry['language']['name'] === 'es') {
                    $description = $entry['flavor_text'];
                    break;
                }
            }
        }
        
        return [
            'id' => $pokemonData['id'],
            'name' => $pokemonData['name'],
            'image' => $pokemonData['sprites']['other']['official-artwork']['front_default'],
            'types' => $types,
            'height' => $pokemonData['height'] / 10, // Convertir a metros
            'weight' => $pokemonData['weight'] / 10, // Convertir a kg
            'abilities' => array_map(function($ability) {
                return ucfirst($ability['ability']['name']);
            }, $pokemonData['abilities']),
            'stats' => array_reduce($pokemonData['stats'], function($carry, $stat) {
                $carry[str_replace('-', '_', $stat['stat']['name'])] = $stat['base_stat'];
                return $carry;
            }, []),
            'description' => $description
        ];
    }
    
    /**
     * Obtener el total de Pokémon
     */
    public function getTotalPokemonCount() {
        $data = $this->fetchFromApi("/pokemon-species");
        
        if (!$data || !isset($data['count'])) {
            return 0;
        }
        
        return $data['count'];
    }
}


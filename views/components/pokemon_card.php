<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="h-40 flex items-center justify-center" 
         style="background: linear-gradient(135deg, <?= $pokemon->getTypeColor($pokemon->types[0]) ?> 0%, <?= adjustBrightness($pokemon->getTypeColor($pokemon->types[0]), 30) ?> 100%);">
        <a href="index.php?page=pokemon&id=<?= $pokemon->id ?>">
            <img src="<?= $pokemon->imageUrl ?>" alt="<?= $pokemon->getCapitalizedName() ?>" 
                 class="h-32 object-contain transition-transform duration-300 hover:scale-110">
        </a>
    </div>
    
    <div class="p-4">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-bold">
                <a href="index.php?page=pokemon&id=<?= $pokemon->id ?>" class="hover:text-primary">
                    <?= $pokemon->getCapitalizedName() ?>
                </a>
            </h3>
            <span class="text-gray-500 font-medium"><?= $pokemon->getFormattedId() ?></span>
        </div>
        
        <div class="flex flex-wrap gap-1 mb-3">
            <?php foreach ($pokemon->types as $type): ?>
                <span class="inline-block px-2 py-1 text-xs text-white rounded-full" 
                      style="background-color: <?= $pokemon->getTypeColor($type) ?>;">
                    <?= capitalizeFirst($type) ?>
                </span>
            <?php endforeach; ?>
        </div>
        
        <div class="flex justify-between items-center">
            <a href="index.php?page=pokemon&id=<?= $pokemon->id ?>" 
               class="text-sm text-primary font-medium hover:underline">
                Ver detalles
            </a>
            
            <a href="index.php?action=like&id=<?= $pokemon->id ?>" class="text-2xl">
                <?= in_array($pokemon->id, $likedPokemonIds) ? '❤️' : '🤍' ?>
            </a>
        </div>
    </div>
</div>

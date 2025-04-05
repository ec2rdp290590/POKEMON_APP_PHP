    </main>
    
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-4"><?= APP_NAME ?></h3>
                    <p class="text-gray-400">Explora el mundo Pokémon con nuestra Pokédex y blog.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white">Inicio</a></li>
                        <li><a href="index.php?page=blog" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="index.php?page=about" class="text-gray-400 hover:text-white">Acerca de</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Todos los derechos reservados.</p>
                <p class="mt-2 text-sm">Pokémon y todos los nombres relacionados son marcas registradas de Nintendo.</p>
            </div>
        </div>
    </footer>
</body>
</html>

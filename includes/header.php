<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#E3350D',
                        secondary: '#30A7D7',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .prose {
                max-width: 65ch;
                color: #374151;
                line-height: 1.75;
            }
            .prose p {
                margin-top: 1.25em;
                margin-bottom: 1.25em;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-primary text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <a href="index.php" class="text-2xl font-bold">
                        <?= APP_NAME ?>
                    </a>
                </div>
                <nav>
                    <ul class="flex space-x-6">
                        <li><a href="index.php" class="hover:underline">Inicio</a></li>
                        <li><a href="index.php?page=blog" class="hover:underline">Blog</a></li>
                        <li><a href="index.php?page=about" class="hover:underline">Acerca de</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <main class="container mx-auto px-4 py-8">

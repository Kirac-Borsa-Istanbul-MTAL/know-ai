<?php
if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'tr')) {
    setcookie('preferred_language', $_GET['lang'], time() + (86400 * 30), url('/'));
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

$current_lang = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
$current_theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

require_once __DIR__ . '/components/navbar.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" class="<?php echo $current_theme === 'dark' ? 'dark' : ''; ?>">

<head>
    <meta charset="UTF-8">
    <title>Know AI - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <?php renderNavbar($current_lang, $current_theme); ?>

    <div class="container mx-auto px-4 py-8 mt-16">
        <div class="max-w-4xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                    <input type="text"
                        class="w-full px-4 py-2 text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="<?php echo translate('search', $current_lang); ?>">
                </div>
                <div class="max-w-4xl mx-auto mt-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?php echo translate('home', $current_lang); ?>
                            </h1>
                            <div class="relative">
                                <input type="text"
                                    class="w-64 px-4 py-2 text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="<?php echo translate('search', $current_lang); ?>">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                                <?php echo translate('new_question', $current_lang); ?>
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                <?php echo translate('ask_anything', $current_lang); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <?php echo translate('ask', $current_lang); ?>
                                    </button>
                                </div>
                            </div>

                            <div id="results" class="space-y-4">
                                
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div id="loading-spinner" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 flex flex-col items-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="mt-4 text-gray-700 dark:text-gray-300"><?php echo translate('loading', $current_lang); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
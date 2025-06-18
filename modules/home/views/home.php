<?php
if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'tr')) {
    setcookie('preferred_language', $_GET['lang'], time() + (86400 * 30), url('/'));
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

$current_lang = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
$current_theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

require_once __DIR__ . '/components/navbar.php';
require_once __DIR__ . '/components/search.php';
require_once __DIR__ . '/components/card.php';
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
               <?php renderSearch($current_lang); ?>
                <?php renderCard($current_lang); ?>
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
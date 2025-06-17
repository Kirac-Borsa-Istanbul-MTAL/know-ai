<?php
require_once __DIR__ . '/../../utils/localization.php';
$current_lang = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
$current_theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" class="<?php echo $current_theme === 'dark' ? 'dark' : ''; ?>">

<head>
    <meta charset="UTF-8">
    <title>Know AI - 404</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 h-screen">
    <div class="h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <img src="./assets/know-ai.png" alt="Kıraç.ai Logo" class="h-32 mb-6 mx-auto">
            <p class="text-6xl sm:text-8xl font-bold text-indigo-600 dark:text-indigo-400">404</p>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                <?php echo translate('404_heading', $current_lang); ?>
            </h1>
            
            <p class="mt-6 text-base leading-7 text-gray-600 dark:text-gray-300">
                <?php echo translate('404_message', $current_lang); ?>
            </p>
            
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="<?php echo url('dashboard'); ?>" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <?php echo translate('404_button', $current_lang); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="absolute top-4 right-4">
        <button id="theme-toggle" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
            <svg id="dark-icon" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="light-icon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            const theme = isDark ? 'dark' : 'light';
            document.cookie = `theme=${theme};path=/;max-age=${60 * 60 * 24 * 30}`;
        });
    </script>
</body>
</html>
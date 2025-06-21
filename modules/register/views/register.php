<?php
if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'tr')) {
    setcookie('preferred_language', $_GET['lang'], time() + (86400 * 30), "/");
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

$current_lang = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
$current_theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" class="<?php echo $current_theme === 'dark' ? 'dark' : ''; ?>">

<head>
    <meta charset="UTF-8">
    <title>Know AI - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 h-screen">
    <div class="absolute top-4 right-4">
        <div class="flex gap-2 items-center">
            <button id="theme-toggle" class="p-2 rounded-lg bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                <svg id="dark-icon" class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="light-icon" class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <a href="?lang=tr" class="px-3 py-1 rounded <?php echo $current_lang === 'tr' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                TR
            </a>
            <a href="?lang=en" class="px-3 py-1 rounded <?php echo $current_lang === 'en' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'; ?>">
                EN
            </a>
        </div>
    </div>

    <div class="h-full flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-96">
            <div class="text-center mb-8 flex flex-col items-center">
                <img src="./assets/know-ai.png" alt="Know.ai Logo" class="h-32 mx-auto mb-2">
                <h2 class="text-center text-gray-800 dark:text-white"><?php echo translate('welcome', $current_lang); ?></h2>
                <p class="text-gray-600 dark:text-gray-300"><?php echo translate('register', $current_lang); ?></p>
            </div>

            <form class="space-y-6" action="<?php echo url('/register'); ?>" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo translate('name', $current_lang); ?></label>
                    <input type="text" id="name" name="name" required autocomplete="off"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo translate('email', $current_lang); ?></label>
                    <input type="email" id="email" name="email" required autocomplete="off"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo translate('password', $current_lang); ?></label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300"><?php echo translate('remember', $current_lang); ?></label>
                    </div>
                    <a href="<?php echo url('/login'); ?>" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"><?php echo translate('already_have_account', $current_lang); ?></a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo translate('register_button', $current_lang); ?>
                </button>
            </form>
        </div>
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
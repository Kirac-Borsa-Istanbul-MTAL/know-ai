<?php
require_once __DIR__ . '/../../utils/localization.php';

if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'tr')) {
    setcookie('preferred_language', $_GET['lang'], time() + (86400 * 30), "/");
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}

$current_lang = isset($_COOKIE['preferred_language']) ? $_COOKIE['preferred_language'] : 'tr';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">

<head>
    <meta charset="UTF-8">
    <title>Know AI - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="bg-gray-100 h-screen">
    <div class="absolute top-4 right-4">
        <div class="flex gap-2">
            <a href="?lang=tr" class="px-3 py-1 rounded <?php echo $current_lang === 'tr' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'; ?>">
                TR
            </a>
            <a href="?lang=en" class="px-3 py-1 rounded <?php echo $current_lang === 'en' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'; ?>">
                EN
            </a>
        </div>
    </div>

    <div class="h-full flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <div class="text-center mb-8 flex flex-col items-center">
                <img src="./assets/kirac-bist-logo.png" alt="Kıraç.ai Logo" class="h-16 mb-4 mx-auto">
                <h2 class="text-2xl font-bold text-gray-800"><?php echo translate('welcome', $current_lang); ?></h2>
                <p class="text-gray-600"><?php echo translate('login', $current_lang); ?></p>
            </div>

            <form class="space-y-6" action="modules/login/controller/login.php" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700"><?php echo translate('email', $current_lang); ?></label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700"><?php echo translate('password', $current_lang); ?></label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700"><?php echo translate('remember', $current_lang); ?></label>
                    </div>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500"><?php echo translate('dont_have_account', $current_lang); ?></a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <?php echo translate('login_button', $current_lang); ?>
                </button>
            </form>
        </div>

</html>
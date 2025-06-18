<?php
function renderNavbar($current_lang, $current_theme)
{
    $userName = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';
    $userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    
    $nameArray = explode(' ', $userName);
    $initials = '';
    if (count($nameArray) >= 2) {
        $initials = strtoupper(mb_substr($nameArray[0], 0, 1) . mb_substr($nameArray[count($nameArray)-1], 0, 1));
    } else {
        $initials = strtoupper(mb_substr($userName, 0, 2));
    }
?>
    <nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-10" src="./assets/know-ai.png" alt="Know AI">
                    </div>
                    <div class="ml-10 hidden md:block">
                        <div class="flex items-baseline space-x-4">
                            <a href="<?php echo url('/search'); ?>"
                                class="text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                                <?php echo translate('search', $current_lang); ?>
                            </a>
                            <a href="<?php echo url('/statistics'); ?>"
                                class="text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                                <?php echo translate('statistics', $current_lang); ?>
                            </a>
                            <a href="<?php echo url('/about-us'); ?>"
                                class="text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                                <?php echo translate('about_us', $current_lang); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                            <img class="h-8 w-8 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name=<?php echo urlencode($initials); ?>&background=random" alt="<?php echo htmlspecialchars($userName); ?>'s avatar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                            <div class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">
                                <div class="font-medium"><?php echo $userName; ?></div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs"><?php echo $userEmail; ?></div>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <a href="<?php echo url('/profile'); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <?php echo translate('profile', $current_lang); ?>
                            </a>
                            <a href="<?php echo url('/settings'); ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <?php echo translate('settings', $current_lang); ?>
                            </a>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            
                            <div class="px-4 py-2">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2"><?php echo translate('language', $current_lang); ?></div>
                                <div class="flex gap-2">
                                    <a href="?lang=tr" class="flex-1 text-center px-2 py-1 rounded text-sm <?php echo $current_lang === 'tr' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500'; ?>">
                                        TR
                                    </a>
                                    <a href="?lang=en" class="flex-1 text-center px-2 py-1 rounded text-sm <?php echo $current_lang === 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500'; ?>">
                                        EN
                                    </a>
                                </div>
                            </div>
                            
                            <div class="px-4 py-2">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2"><?php echo translate('theme', $current_lang); ?></div>
                                <button id="theme-toggle" class="w-full flex items-center justify-between px-2 py-1 text-sm text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-600 rounded hover:bg-gray-200 dark:hover:bg-gray-500">
                                    <span class="dark:hidden">Light Mode</span>
                                    <span class="hidden dark:inline">Dark Mode</span>
                                    <svg class="w-4 h-4 dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                            
                            <form action="<?php echo url('/logout'); ?>" method="POST" class="block">
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <?php echo translate('logout', $current_lang); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php /* Keeping mobile menu code commented out for future use
        <!-- Mobile menu -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="<?php echo url('/dashboard'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <?php echo translate('dashboard', $current_lang); ?>
                </a>
                <a href="<?php echo url('/profile'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <?php echo translate('profile', $current_lang); ?>
                </a>
                <a href="<?php echo url('/settings'); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <?php echo translate('settings', $current_lang); ?>
                </a>
                
                <div class="px-3 py-2 space-y-2">
                    <!-- Language Switcher -->
                    <div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2"><?php echo translate('language', $current_lang); ?></div>
                        <div class="flex gap-2">
                            <a href="?lang=tr" class="flex-1 text-center px-2 py-1 rounded text-sm <?php echo $current_lang === 'tr' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500'; ?>">
                                TR
                            </a>
                            <a href="?lang=en" class="flex-1 text-center px-2 py-1 rounded text-sm <?php echo $current_lang === 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500'; ?>">
                                EN
                            </a>
                        </div>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2"><?php echo translate('theme', $current_lang); ?></div>
                        <button id="mobile-theme-toggle" class="w-full flex items-center justify-between px-2 py-1 text-sm text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-600 rounded hover:bg-gray-200 dark:hover:bg-gray-500">
                            <span class="dark:hidden">Light Mode</span>
                            <span class="hidden dark:inline">Dark Mode</span>
                            <svg class="w-4 h-4 dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form action="<?php echo url('/logout'); ?>" method="POST" class="block">
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <?php echo translate('logout', $current_lang); ?>
                    </button>
                </form>
            </div>
        </div>
        */ ?>
    </nav>

    <script>
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        
        userMenuButton.addEventListener('click', function() {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });

        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            const theme = isDark ? 'dark' : 'light';
            document.cookie = `theme=${theme};path=${<?php echo json_encode(url('/')); ?>};max-age=${60 * 60 * 24 * 30}`;
        });
    </script>
<?php
}
?>
<?php
function renderSearch($current_lang)
{
?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="relative">
            <input type="text"
                class="w-full px-4 py-2 pr-10 sm:pr-60 text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="<?php echo htmlspecialchars(translate('search', $current_lang)); ?>">

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-2">
                <span class="text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap hidden sm:inline">
                    <?php echo htmlspecialchars(translate('change_to_your_own_style', $current_lang)); ?> →
                </span>
                <button id="search-settings-button" type="button" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none" aria-label="<?php echo htmlspecialchars(translate('search_settings', $current_lang)); ?>">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.532 1.532 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106A1.532 1.532 0 0111.49 3.17zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div id="search-settings-menu"
                class="hidden absolute right-0 mt-2 w-64 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 opacity-0 scale-95 transform transition-all duration-200 ease-out origin-top-right z-10">
                <div class="px-4 py-2">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Arama Seviyesi</h3>
                    <div class="mt-2 space-y-2">
                        <?php
                        $searchLevels = [
                            ['id' => 1, 'name' => 'Başlangıç'],
                            ['id' => 2, 'name' => 'Orta'],
                            ['id' => 3, 'name' => 'İleri'],
                            ['id' => 4, 'name' => 'Uzman'],
                            ['id' => 5, 'name' => 'Profesyonel']
                        ];
                        $currentLevel = $_COOKIE['searchLevel'] ?? 1;
                        foreach ($searchLevels as $level) {
                            $isChecked = $currentLevel == $level['id'] ? 'checked' : '';
                        ?>
                            <div class="flex items-center">
                                <input type="radio" id="level-<?php echo $level['id']; ?>" name="searchLevel" value="<?php echo $level['id']; ?>" <?php echo $isChecked; ?>
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                                <label for="level-<?php echo $level['id']; ?>" class="ml-2 text-sm text-gray-700 dark:text-gray-200">
                                    <?php echo htmlspecialchars($level['name']); ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchSettingsButton = document.getElementById('search-settings-button');
        const searchSettingsMenu = document.getElementById('search-settings-menu');
        let isSearchSettingsMenuOpen = false;

        if (searchSettingsButton && searchSettingsMenu) {
            const searchLevelRadios = document.querySelectorAll('input[name="searchLevel"]');
            searchLevelRadios.forEach(radio => {
                radio.addEventListener('change', function(event) {
                    const selectedLevel = event.target.value;
                    
                    fetch('<?php echo url("/home/controllers/search_settings.php"); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'searchLevel=' + selectedLevel
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error updating search level:', data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            searchSettingsButton.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleSearchSettingsMenu();
            });

            function toggleSearchSettingsMenu() {
                if (isSearchSettingsMenuOpen) {
                    closeSearchSettingsMenu();
                } else {
                    openSearchSettingsMenu();
                }
            }

            function openSearchSettingsMenu() {
                isSearchSettingsMenuOpen = true;
                searchSettingsMenu.classList.remove('hidden');
                void searchSettingsMenu.offsetWidth;
                searchSettingsMenu.classList.remove('opacity-0', 'scale-95');
                searchSettingsMenu.classList.add('opacity-100', 'scale-100');
            }

            function closeSearchSettingsMenu() {
                if (!isSearchSettingsMenuOpen) return;
                isSearchSettingsMenuOpen = false;
                searchSettingsMenu.classList.remove('opacity-100', 'scale-100');
                searchSettingsMenu.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    if (!isSearchSettingsMenuOpen) {
                        searchSettingsMenu.classList.add('hidden');
                    }
                }, 200);
            }

            document.addEventListener('click', function(event) {
                if (isSearchSettingsMenuOpen &&
                    searchSettingsButton && !searchSettingsButton.contains(event.target) &&
                    searchSettingsMenu && !searchSettingsMenu.contains(event.target)) {
                    closeSearchSettingsMenu();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && isSearchSettingsMenuOpen) {
                    closeSearchSettingsMenu();
                }
            });
        }
    </script>
<?php
}
?>
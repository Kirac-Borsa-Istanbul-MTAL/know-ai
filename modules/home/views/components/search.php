<?php
require_once __DIR__ . '/loading-spinner.php';
require_once __DIR__ . '/../../models/search.php';

function renderSearch($current_lang)
{
?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="relative">
            <input type="text" id="search-input"
                class="w-full px-4 py-2 pr-10 sm:pr-60 text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="<?php echo htmlspecialchars(translate('search', $current_lang)); ?>"
                autocomplete="off">

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
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo htmlspecialchars(translate('search_level', $current_lang)); ?></h3>
                    <div class="mt-2 space-y-2">
                        <?php
                        $searchLevels = [
                            ['id' => 1, 'name' => 'beginner'],
                            ['id' => 2, 'name' => 'intermediate'],
                            ['id' => 3, 'name' => 'advanced'],
                            ['id' => 4, 'name' => 'expert'],
                            ['id' => 5, 'name' => 'professional']
                        ];
                        $searchModel = new SearchModel();
                        $userId = $_SESSION['user_id'] ?? null;
                        $currentLevel = $_COOKIE['searchLevel'] ?? 1;

                        if ($userId) {
                            $userLevel = $searchModel->getUserSearchLevel($userId);
                            if ($userLevel['success'] && isset($userLevel['level'])) {
                                $currentLevel = $userLevel['level'];
                            }
                        }

                        foreach ($searchLevels as $level) {
                            $isChecked = $currentLevel == $level['id'] ? 'checked' : '';
                        ?>
                            <div class="flex items-center">
                                <input type="radio" id="level-<?php echo $level['id']; ?>" name="searchLevel" value="<?php echo $level['id']; ?>" <?php echo $isChecked; ?>
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600">
                                <label for="level-<?php echo $level['id']; ?>" class="ml-2 text-sm text-gray-700 dark:text-gray-200">
                                    <?php echo htmlspecialchars(translate($level['name'], $current_lang)); ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php renderLoadingSpinner(); ?>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        marked.setOptions({
            breaks: true,
            gfm: true,
            headerIds: false
        });
        
        const loadingSpinner = document.getElementById('loading-spinner');
        const searchInput = document.getElementById('search-input');
        const searchSettingsButton = document.getElementById('search-settings-button');
        const searchSettingsMenu = document.getElementById('search-settings-menu');
        let isSearchSettingsMenuOpen = false;

        if (searchInput) {
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const searchQuery = searchInput.value.trim();

                    if (searchQuery) {
                        searchInput.blur();
                        
                        loadingSpinner.classList.remove('hidden');

                        fetch('<?php echo url("/services/gemini/api.php"); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'search=' + encodeURIComponent(searchQuery)
                            })
                            .then(response => response.json())
                            .then(data => {
                                loadingSpinner.classList.add('hidden');
                                const text = data.data.candidates[0].content.parts[0].text;
                                const prefixLength = "```json\n".length;
                                const suffixLength = "\n```".length;

                                if (text.startsWith("```json\n") && text.endsWith("\n```")) {
                                    let jsonString = text.substring(prefixLength, text.length - suffixLength);

                                    try {
                                        const parsedJson = JSON.parse(jsonString);
                                        console.log('Parsed JSON object:', parsedJson);
                                        updateCardContent(parsedJson);
                                    } catch (e) {
                                        console.error('Failed to parse JSON:', e);
                                        console.error('Problematic string was:', jsonString);
                                    }
                                } else {
                                    console.warn("The string does not have the expected ```json prefix and ``` suffix with newlines.");
                                }
                            })
                            .catch(error => {
                                loadingSpinner.classList.add('hidden');
                                console.error('Error:', error);
                            });
                    }
                }
            });
        }

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

        function updateCardContent(data) {
            const initialContent = document.getElementById('initial-content');
            const searchResult = document.getElementById('search-result');
            const contentHeader = document.getElementById('content-header');
            const contentDetail = document.getElementById('content-detail');
            const contentSources = document.getElementById('content-sources');
            const contentQuestions = document.getElementById('content-questions');

            document.addEventListener('submit', function(e) {
                e.preventDefault();
                return false;
            });

            const showNewContent = () => {
                searchResult.classList.remove('hidden');
                searchResult.classList.add('scale-95', 'opacity-0');
                
                void searchResult.offsetWidth;
                
                requestAnimationFrame(() => {
                    searchResult.classList.remove('scale-95', 'opacity-0');
                });

                contentHeader.textContent = data.results.content.header;
                contentDetail.innerHTML = marked.parse(data.results.content.detail);

                if (data.results.content.sources && data.results.content.sources.length > 0) {
                    contentSources.classList.remove('hidden');
                    const sourcesList = contentSources.querySelector('ul');
                    sourcesList.innerHTML = data.results.content.sources
                        .map(source => `<li><a href="${source}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200" target="_blank">${source}</a></li>`)
                        .join('');
                } else {
                    contentSources.classList.add('hidden');
                }

                if (data.results.content.questions && Object.keys(data.results.content.questions).length > 0) {
                    contentQuestions.classList.remove('hidden');
                    const questionsContainer = contentQuestions.querySelector('.space-y-4');
                    questionsContainer.innerHTML = '';

                    Object.values(data.results.content.questions).forEach((q, index) => {
                        const questionDiv = document.createElement('div');
                        questionDiv.className = 'bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 transition-all duration-300 ease-in-out transform opacity-0 -translate-y-4';
                        
                        if (q.answers) {
                            questionDiv.innerHTML = `
                                <p class="font-medium text-gray-900 dark:text-white mb-3">${index + 1}. ${q.question}</p>
                                <div class="space-y-2">
                                    ${Object.entries(q.answers).map(([key, value]) => `
                                        <div class="flex items-center">
                                            <input type="radio" id="q${index}_${key}" name="q${index}" value="${key}"
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-50 dark:focus:ring-offset-gray-700 border-gray-300 dark:border-gray-600">
                                            <label for="q${index}_${key}" class="ml-2 text-gray-700 dark:text-gray-200">
                                                ${value}
                                            </label>
                                        </div>
                                    `).join('')}
                                </div>
                                <button onclick="checkAnswer(${index}, ${q.correctAnswer})" 
                                    class="mt-3 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 
                                    text-white rounded transition-colors duration-200 
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700">
                                    <?php echo htmlspecialchars(translate('check_answer', $current_lang)); ?>
                                </button>
                            `;
                        } else {
                            questionDiv.innerHTML = `
                                <p class="font-medium text-gray-900 dark:text-white mb-3">${index + 1}. ${q.question}</p>
                                <div class="mt-2">
                                    <input type="text" id="q${index}_answer" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 
                                        text-gray-900 dark:text-white bg-white dark:bg-gray-700 
                                        rounded-md shadow-sm placeholder-gray-400 dark:placeholder-gray-500
                                        focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 
                                        focus:border-indigo-500 dark:focus:border-indigo-400"
                                        onkeypress="return event.key != 'Enter';">
                                </div>
                                <button onclick="checkFillInBlank(${index}, '${q.answer}')" 
                                    class="mt-3 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 
                                    text-white rounded transition-colors duration-200 
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700">
                                    <?php echo htmlspecialchars(translate('check_answer', $current_lang)); ?>
                                </button>
                            `;
                        }

                        questionsContainer.appendChild(questionDiv);
                        
                        requestAnimationFrame(() => {
                            setTimeout(() => {
                                questionDiv.classList.remove('opacity-0', '-translate-y-4');
                            }, 300 + (index * 100));
                        });
                    });
                } else {
                    contentQuestions.classList.add('hidden');
                }
            };

            if (!searchResult.classList.contains('hidden')) {
                searchResult.classList.add('scale-95', 'opacity-0');
                setTimeout(showNewContent, 300);
            } else {
                initialContent.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    initialContent.classList.add('hidden');
                    showNewContent();
                }, 300);
            }
        }

        function checkAnswer(questionIndex, correctAnswer) {
            const selectedAnswer = document.querySelector(`input[name="q${questionIndex}"]:checked`);
            if (!selectedAnswer) {
                showNotification(false, '<?php echo htmlspecialchars(translate('please_select_an_answer', $current_lang)); ?>');
                return;
            }

            const isCorrect = parseInt(selectedAnswer.value) === correctAnswer;
            showNotification(isCorrect);
        }

        function checkFillInBlank(questionIndex, correctAnswer) {
            const userAnswer = document.getElementById(`q${questionIndex}_answer`).value.trim();
            if (userAnswer == '') {
                showNotification(false, '<?php echo htmlspecialchars(translate('please_select_an_answer', $current_lang)); ?>');
                return;
            }
            const isCorrect = userAnswer.toLowerCase() === correctAnswer.toLowerCase();
            showNotification(isCorrect);
        }

        function showNotification(isCorrect, notificationMessage) {
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg ${
                isCorrect 
                    ? 'bg-green-100 dark:bg-green-800 text-green-900 dark:text-green-100' 
                    : 'bg-red-100 dark:bg-red-800 text-red-900 dark:text-red-100'
            } transform transition-all duration-300 ease-out opacity-0 translate-y-2`;
            
            if(notificationMessage) {
                notification.textContent = notificationMessage;
            } else {
                notification.textContent = isCorrect 
                    ? '<?php echo htmlspecialchars(translate('true', $current_lang)); ?>' 
                    : '<?php echo htmlspecialchars(translate('false', $current_lang)); ?>';
            }

            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('opacity-0', 'translate-y-2');
            }, 10);
            
            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }
    </script>
<?php
}
?>
<?php
    function renderCard($current_lang) {
        ?>
        <div class="max-w-4xl mx-auto mt-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="space-y-4">
                    <div id="initial-content" class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg transition-all duration-300 ease-in-out transform hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <div class="flex-shrink-0 animate-bounce">
                                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                    <?php echo translate('new_question', $current_lang); ?>
                                </h3>
                                <p class="text-md text-gray-600 dark:text-gray-300">
                                    <?php echo translate('ask_anything', $current_lang); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="search-result" class="hidden transition-all duration-500 ease-in-out transform scale-95 opacity-0">
                        <div class="mb-6">
                            <h2 id="content-header" class="text-2xl font-bold text-gray-900 dark:text-white mb-4"></h2>
                            <div id="content-detail" class="text-md text-gray-800 dark:text-white"></div>
                        </div>

                        <div id="content-sources" class="mb-6 hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"><?php echo htmlspecialchars(translate('sources', $current_lang)); ?></h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300"></ul>
                        </div>

                        <div id="content-questions" class="space-y-4 hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2"><?php echo htmlspecialchars(translate('questions', $current_lang)); ?></h3>
                            <div class="space-y-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
}
?>
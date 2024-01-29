<div class="flex items-center p-4 my-2 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
    <x-bxs-error-circle  class="w-6 h-6 inline mr-3" />
    <span class="sr-only">Ошибка</span>
    <div>
        {{ $message }}
    </div>
</div>

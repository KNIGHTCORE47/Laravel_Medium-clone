@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-sm text-gray-300 dark:text-gray-400 border border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 hover:bg-gray-300 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 file:mr-4 file:py-3 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-medium file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 file:transition-colors file:duration-200 shadow-sm']) }}>

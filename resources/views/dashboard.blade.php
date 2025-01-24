<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Показване на името на потребителя -->
                    <p>{{ __('Добре дошли, :name!', ['name' => Auth::user()->name]) }}</p>

                    <!-- Възможност за навигация към други секции -->
                    <p>{{ __('Вижте вашата') }} <a href="{{ route('profile.show') }}" class="text-blue-600 hover:underline">{{ __('профилна страница') }}</a></p>

                    <p>{{ __("You're logged in!") }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

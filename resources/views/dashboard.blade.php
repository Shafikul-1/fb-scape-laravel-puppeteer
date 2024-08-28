<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<ul class="flex gap-6 capitalize">
    <li><a href="{{ route('home') }}" class="dark:text-white text-3xl font-bold">Home</a></li>
    <li><a href="{{ route('link.create') }}" class="dark:text-white text-3xl font-bold">Set Link</a></li>
    <li><a href="" class="dark:text-white text-3xl font-bold">Other</a></li>
    <li><a href="" class="dark:text-white text-3xl font-bold"></a></li>
    <li><a href="" class="dark:text-white text-3xl font-bold"></a></li>
</ul>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

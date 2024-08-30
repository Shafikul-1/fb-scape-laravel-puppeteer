<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FB Data Collect</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-_-JQNiN3.css') }}"> --}}
</head>
<body>
    <ul class="flex gap-6 capitalize dark:bg-gray-700">
        <li><a href="{{ route('home') }}" class="dark:text-white text-3xl font-bold">Home</a></li>
        <li><a href="{{ route('link.create') }}" class="dark:text-white text-3xl font-bold">Set Link</a></li>
        <li><a href="" class="dark:text-white text-3xl font-bold">Other</a></li>
        <li><a href="{{ route('allData') }}" class="dark:text-white text-3xl font-bold">All Data</a></li>
        <li><a href="" class="dark:text-white text-3xl font-bold"></a></li>
    </ul>

    {{ $slot }}

    {{-- <div class="fixed bottom-2 right-4 z-50">
        <p class="font-bold text-5xl text-red-600">Check</p>
    </div> --}}

    <script src="https://kit.fontawesome.com/ed5a9b6893.js" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="relative flex flex-col items-center justify-center selection:bg-[#19196c] selection:text-white">
        <div class="relative w-full max-w-xl px-6 lg:max-w-7xl">
            <main class="flex flex-col items-center justify-center min-h-[calc(100vh)] py-8">
                <form action="{{ route('suggestions.index') }}" method="POST" class="w-full max-w-lg">
                    @csrf

                    <div class="button-list">
                        <a href="{{ route('welcome') }}"
                            class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                        <button type="submit"
                            class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Create
                        </button>
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-8 mb-2">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
                                for="title">
                                Title
                            </label>
                            <input
                                class="appearance-none block w-full bg-white text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('title') is-invalid @enderror"
                                id="title" name="title" type="text" required>
                        </div>
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2"
                                for="description">
                                Description
                            </label>
                            <textarea
                                class="appearance-none block w-full bg-white text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('description') is-invalid @enderror"
                                id="description" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Create
                    </button>
                </form>
            </main>
        </div>
    </div>

</body>

</html>

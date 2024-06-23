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
                <form action="{{ route('suggestion.change-status', $suggestion->id) }}" method="POST" class="w-full max-w-lg">
                    @csrf

                    @method('PUT')

                    <div class="button-list">
                        <a
                            href="{{ route('welcome') }}"
                            class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        >
                            Back
                        </a>
                        <button
                            type="submit"
                            class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        >
                            Update
                        </button>
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-8">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold"
                                for="title">
                                Status
                            </label>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-6"
                                name="status"
                                required
                            >
                                <option value="">Select an option</option>

                                @foreach (App\Enums\SuggestionStatus::cases() as $status)
                                    <option value="{{ $status->value }}" @selected($suggestion->status === $status)>{{ strtoupper($status->value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold"
                                for="title">
                                Author
                            </label>
                            <p class="py-3 mb-6">{{ $suggestion->author_name }}</p>
                        </div>
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold"
                                for="title">
                                Created at
                            </label>
                            <p class="py-3 mb-6">{{ $suggestion->created_at }}</p>
                        </div>
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold"
                                for="title">
                                Title
                            </label>
                            <p class="py-3 mb-6">{{ $suggestion->title }}</p>
                        </div>
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-white text-xs font-bold"
                                for="description">
                                Description
                            </label>
                            <p class="py-3 mb-6">{{ $suggestion->description }}</p>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                    >
                        Update
                    </button>
                </form>
            </main>
        </div>
    </div>

</body>

</html>

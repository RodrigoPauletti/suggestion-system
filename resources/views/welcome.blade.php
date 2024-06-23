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

<body class="font-sans antialiased {{-- dark:bg-black dark:text-white/50 --}}">
    <div
        class="relative {{-- min-h-screen --}} flex flex-col items-center justify-center selection:bg-[#19196c] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            @if (Route::has('login'))
                <header class="flex flex-1 justify-end py-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:bg-[#19196C] focus:outline-none focus-visible:ring-[#19196c] {{-- dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white --}}">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:bg-[#19196C] focus:outline-none focus-visible:ring-[#19196c] {{-- dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white --}}">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:bg-[#19196C] focus:outline-none focus-visible:ring-[#19196c] {{-- dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white --}}">
                                Register
                            </a>
                        @endif
                    @endauth
                </header>
            @endif

            <main class="flex flex-col justify-center min-h-[calc(100vh-122px)] py-8">
                <ul role="list" class="suggestions-list" x-data="loadSuggestions()" x-init="getData()">
                    <template x-for="suggestion in suggestions" :key="suggestion.id">
                        <template x-if="suggestion">
                            <li class="suggestion-item" :class="suggestion.isVoted ? 'voted' : ''">
                                <button class="suggestion-vote"
                                    x-on:click="!suggestion.isVoted && vote(suggestion.id)" x-data="voteForSuggestion()">
                                    <template x-if="suggestion.isVoted">
                                        <i class="fas fa-thumbs-up"></i>
                                    </template>
                                    <template x-if="!suggestion.isVoted">
                                        <i class="fas fa-chevron-up"></i>
                                    </template>
                                    <span class="suggestion-vote-count" x-text="suggestion.votes"></span>
                                </button>
                                <div class="suggestion-infos">
                                    <p class="suggestion-title" x-text="suggestion.title"></p>
                                    <p class="suggestion-description" x-text="suggestion.description"></p>
                                    <div class="suggestion-additional-infos">
                                        <span class="badge" x-text="suggestion.status"
                                            :class="{
                                                'badge-pending': (suggestion.status === 'pending'),
                                                'badge-approved': (suggestion.status === 'approved'),
                                                'badge-rejected': (suggestion.status === 'rejected'),
                                                'badge-under-development': (suggestion.status === 'under development'),
                                            }"></span>
                                        <div class="suggestion-additional-texts">
                                            <p class="suggestion-additional-text"
                                                x-text="'Suggested by: ' + suggestion.author?.name"></p>
                                            <i class="fas fa-circle"></i>
                                            <p class="suggestion-additional-text">
                                                <time :datetime="suggestion.created_at_datetime"
                                                    x-text="suggestion.created_at"></time>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </template>
                    </template>
                    <!-- Pagination -->
                    <template x-if="actualPage && totalPages">
                        <nav class="pagination">
                            <a :href="actualPage > 1 ? '{{ route('welcome') }}?page=' + (actualPage - 1) : '#'" :class="{ 'disabled': actualPage <= 1 }">
                                <i class="fas fa-chevron-left"></i>
                                <span aria-hidden="true" class="hidden">Previous</span>
                            </a>
                            <div class="pagination-infos">
                                <span x-text="actualPage"></span>
                                <span>of</span>
                                <span x-text="totalPages"></span>
                            </div>
                            <a :href="actualPage < totalPages ? '{{ route('welcome') }}?page=' + (parseInt(actualPage) + 1) : '#'" :class="{ 'disabled': parseInt(actualPage) === parseInt(totalPages) }">
                                <span aria-hidden="true" class="hidden">Next</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </template>
                    <!-- End Pagination -->
                </ul>
            </main>

            <footer class="py-4 text-center text-sm text-white {{-- dark:text-white/70 --}}">
                Developed by <a href="https://github.com/RodrigoPauletti" target="_blank" class="underline">Rodrigo
                    Pauletti</a>
            </footer>
        </div>
    </div>

</body>

</html>

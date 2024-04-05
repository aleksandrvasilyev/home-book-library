<!doctype html>
<html lang="en" data-theme="nord">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>


<div class="min-h-screen dark:bg-gray-800 dark:text-gray-100">
    <div class="p-6 space-y-8">
        <header class="container flex items-center justify-between h-16 px-4 mx-auto rounded dark:bg-gray-900">
            <a rel="noopener noreferrer" href="/" aria-label="Homepage">
                <div class="flex items-center justify-center">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div class="ml-2 text-xl">Книги</div>
                </div>


            </a>
            <div class="items-center hidden space-x-8 lg:flex">
                <div class="space-x-4">
                    <a href="{{ route('genres') }}">Жанры</a>
                    <a href="{{ route('authors') }}">Авторы</a>
                    <a href="{{ route('series') }}">Серии</a>
                </div>
                <button class="px-4 py-2 rounded-md dark:bg-violet-400 dark:text-gray-900">Войти</button>
            </div>
            <button class="flex items-center justify-center p-2 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="w-6 h-6 dark:text-gray-50">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </header>
        <main>
            <div class="container mx-auto space-y-16">

                {{ $searchbox ?? '' }}

                <section>

                    {{ $slot }}

                </section>

            </div>
        </main>
        <footer>
            <div class="container flex justify-between p-6 mx-auto lg:p-8 dark:bg-gray-900">
                <a rel="noopener noreferrer" href="/" class="font-bold">Книги</a>
                <div class="flex space-x-2">
                    <a href="{{ route('genres') }}">Жанры</a>
                    <a href="{{ route('authors') }}">Авторы</a>
                    <a href="{{ route('series') }}">Серии</a>

                </div>
            </div>
        </footer>
    </div>
</div>


</body>
</html>

<!doctype html>
<html lang="en" data-theme="nord">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="google-site-verification" content="taQkUkWrLd_qrdoxXAGfqK2Zj7wItRMoAWaZ_uz_rLI" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
</head>
<body>


<div class="min-h-screen dark:bg-gray-800 dark:text-gray-100 bg-gray-200">
    <div class="p-6 space-y-8">
        <header x-data="{ show: false }"
                class="container flex items-center justify-between h-16 px-4 mx-auto rounded dark:bg-gray-900 bg-gray-100">
            <a rel="noopener noreferrer" href="{{ route('home') }}" aria-label="Homepage">
                <div class="flex items-center justify-center">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div class="ml-2 text-xl">BooksGo</div>
                </div>

            </a>
            <div class="items-center hidden space-x-4 lg:flex">
                <div class="space-x-4">
                    <a href="{{ route('genres') }}">Жанры</a>
                    <a href="{{ route('authors') }}">Авторы</a>
                    <a href="{{ route('series') }}">Серии</a>
                </div>

                @auth
                    <p>Привет, <a class="hover:underline" href="{{ route('dashboard') }}">{{ Auth::user()->name }}!</a>
                    </p>
                @endauth

                @guest
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-md bg-violet-400 dark:text-gray-900 text-gray-200">Регистрация</a>
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-md bg-violet-400 dark:text-gray-900 text-gray-200">Вход</a>
                @endguest


            </div>

            <div x-show="show" @click.away="show = false"
                 class="py-2 absolute dark:bg-gray-600 bg-gray-50 mt-8 rounded-xl z-50 overflow-auto w-1/2 top-44 left-2/3 transform -translate-x-1/2 -translate-y-1/2 lg:hidden"
                 style="display:none;max-height:300px; overflow:auto;">
                <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                   href="{{ route('genres') }}">
                    Жанры
                </a>
                <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                   href="{{ route('authors') }}">
                    Авторы
                </a>

                <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                   href="{{ route('series') }}">
                    Серии
                </a>

                @auth
                    <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                       href="{{ route('dashboard') }}">
                        {{ Auth::user()->name }}
                    </a>
                @endauth
                <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                   href="{{ route('register') }}">
                    Регистрация
                </a>
                <a class="block text-left px-3 py-2 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white"
                   href="{{ route('login') }}">
                    Вход
                </a>

            </div>

            <button @click="show = ! show" class="flex items-center justify-center p-2 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     class="w-6 h-6 dark:text-gray-50 text-gray-800">
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
            <div class="container flex justify-between p-6 mx-auto lg:p-8 dark:bg-gray-900 bg-gray-100">
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

@if(session('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
         @click="show = false"
         class="fixed bottom-3 right-3 bg-green-500 text-white py-2 px-4 rounded-lg cursor-pointer">
        {{ session('message') }}
    </div>
@endif

<div style="display:none;">
    <!--LiveInternet counter--> <img id="licntDBA5" width="88" height="31" style="border:0"
                                                       title="LiveInternet: показано число просмотров и посетителей за 24 часа"
                                                       src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7"
                                                       alt=""/><script>(function(d,s){d.getElementById("licntDBA5").src=
            "https://counter.yadro.ru/hit?t52.6;r"+escape(d.referrer)+
            ((typeof(s)=="undefined")?"":";s"+s.width+"*"+s.height+"*"+
                (s.colorDepth?s.colorDepth:s.pixelDepth))+";u"+escape(d.URL)+
            ";h"+escape(d.title.substring(0,150))+";"+Math.random()})
        (document,screen)</script><!--/LiveInternet-->


</div>
</body>
</html>

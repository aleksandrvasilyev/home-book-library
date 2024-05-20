<section class="grid gap-6 lg:grid-cols-2">
    <div class="p-8 space-y-4 rounded-md lg:col-span-full lg:py-12 dark:bg-gray-900 bg-gray-100">
        <h2 class="text-2xl font-bold dark:text-gray-50">Поиск</h2>


        <form method="GET" action="{{ route('search') }}" class="mx-auto">
            <div class="flex items-center mx-auto">
                <div class="relative">
                    <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Искать</label>
                    <select
                        id="searchArea"
                        class="appearance-none px-4 sm:px-6 flex-shrink-0 z-10 inline-flex items-center py-3 x-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                        name="area">
                        <option value="book" @if(request()->get('area') === 'book') selected @endif>Книги
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
                            </svg>
                        </option>
                        <option value="author" @if(request()->get('area') === 'author') selected @endif>Авторы</option>
                        <option value="series" @if(request()->get('area') === 'series') selected @endif>Серии</option>
                        <option value="genre" @if(request()->get('area') === 'genre') selected @endif>Жанры</option>
                    </select>

                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-100">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                        </svg>
                    </div>
                </div>


{{--                <div class="relative">--}}
{{--                    <select id="searchArea"--}}
{{--                            class="appearance-none px-6 py-3 w-full text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600">--}}
{{--                        <option value="book">Книги</option>--}}
{{--                        <!-- Другие элементы -->--}}
{{--                    </select>--}}
{{--                    <div--}}
{{--                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-100">--}}
{{--                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">--}}
{{--                            <path--}}
{{--                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                </div>--}}


                <div class="relative w-full">
                    <input  style="padding-right: 65px;" value="{{ request('search') }}" type="search" id="search-dropdown"
                           class="block p-2.5 py-3 z-20 w-full text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                           placeholder="Искать..." name="search"  required/>
                    <button type="submit"
                            class="absolute top-0 end-0 px-5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Искать</span>
                    </button>
                </div>
            </div>
        </form>


    </div>
</section>

@props(['comment', 'booktitle', 'bookid'])

<article
    {{ $attributes->merge(['class' => 'p-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 mb-4']) }}

    {{--    class="p-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-800 mb-4"--}}
>
    @if(isset($booktitle))
        <p class="mb-3 hover:underline" ><a href="{{ route('book', $bookid) }}">{{ $booktitle }}</a></p>
    @endif
    <footer class="flex justify-between items-center mb-2">

        <div class="flex items-center">

            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">

                {{--                                <img--}}
                {{--                                    class="mr-2 w-6 h-6 rounded-full"--}}
                {{--                                    src="https://flowbite.com/docs/images/people/profile-picture-4.jpg"--}}
                {{--                                    alt="Helene Engels">--}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>

                {{ $comment->Name }}</p>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                <time pubdate datetime="{{ $comment->Time }}"
                      title="{{ $comment->Time }}">
                    {{ $comment->Time }}
                </time>


            </p>
        </div>

        <div class="mt-8 md:mt-0 flex items-center">
            <div x-data="{ show: false }" @click.away="show = false" class="relative">

                <div @click="show = ! show">
                    <button id="dropdownComment4Button" data-dropdown-toggle="dropdownComment4"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-40 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 16 3">
                            <path
                                d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                        </svg>
                    </button>
                </div>


                <div x-show="show"
                     class="absolute mt-2 rounded-xl z-50 overflow-auto max-h-52 -ml-28"
                     style="display:none;max-height:300px; overflow:auto;">


                    <div id="dropdownComment4"
                         class="z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownMenuIconHorizontalButton">
                            @can('editComment', $comment->user_id ?? '')
                                {{--                                                <li>--}}
                                {{--                                                    <a href="#"--}}
                                {{--                                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Изменить</a>--}}
                                {{--                                                </li>--}}


                                <li>
                                    <div x-data="{ open: false, text: '' }">
                                        <!-- Кнопка для открытия модального окна -->
                                        <a @click="open = true; text = '{{ $comment->Text }}'"
                                           class="hover:cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Изменить
                                        </a>

                                        <!-- Модальное окно -->
                                        <div
                                            x-show="open"
                                            @click.away="open = false"
                                            style="background-color: rgba(0, 0, 0, 0.5);"
                                            class="fixed top-0 left-0 w-full h-full flex items-center justify-center"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0">

                                            <div
                                                class="dark:bg-gray-800 bg-gray-100 rounded-lg p-8 m-4 max-w-xl max-h-full overflow-auto">

                                                <div class="mb-4">
                                                    <p class="text-xl font-semibold">Изменить
                                                        комментарий</p>
                                                </div>
                                                <form
                                                    action="{{ route('comments.edit', $comment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="comment_id"
                                                           value="{{ $comment->id }}">

                                                    <textarea x-model="text" name="text" rows="4"
                                                              {{--                                                                              class="w-full p-2 border rounded focus:outline-none focus:ring"--}}
                                                              class="border-2 dark:border-gray-500 border-gray-200 px-2 py-2 w-full text-sm text-gray-900 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                                              placeholder="Введите новый текст комментария"></textarea>

                                                    <div class="mt-4 flex justify-end space-x-2">
                                                        <button type="button" @click="open = false"
                                                                class="px-4 py-2 border rounded">Отмена
                                                        </button>
                                                        <button type="submit"
                                                                class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">
                                                            Сохранить изменения
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>



                                <li>
                                    <div x-data="{ open: false }" @keydown.escape.window="open = false">
                                        <a @click="open = true"
                                           class="hover:cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Удалить</a>

                                        <div x-show="open" @click.away="open = false"
                                             class="fixed inset-0 bg-black bg-opacity-50 z-50"
                                             style="display: none;">
                                            <div class="flex items-center justify-center min-h-screen">
                                                <div class="dark:bg-gray-800 bg-gray-100 p-5 rounded-lg">
                                                    <p>Вы уверены, что хотите удалить этот
                                                        комментарий?</p>
                                                    <div class="flex justify-end space-x-2 mt-3">
                                                        <button @click="open = false"
                                                                class="hover:underline hover:text-gray-500">
                                                            Отмена
                                                        </button>
                                                        <button
                                                            @click="$refs.deleteForm.submit(); open = false;"
                                                            class="hover:underline hover:text-gray-500">
                                                            Подтвердить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form x-ref="deleteForm"
                                              action="{{ route('comments.destroy', $comment->id) }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </li>
                            @endcan

                            {{--                                            <li>--}}
                            {{--                                                <a href="#"--}}
                            {{--                                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Жалоба</a>--}}
                            {{--                                            </li>--}}

                            <li>
                                <div x-data="{ open: false }">
                                    <!-- Кнопка для открытия модального окна -->
                                    <a @click="open = true"
                                       class="hover:cursor-pointer block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Пожаловаться
                                    </a>

                                    <!-- Модальное окно -->
                                    <div
                                        x-show="open"
                                        @click.away="open = false"
                                        style="background-color: rgba(0, 0, 0, 0.5);"
                                        class="fixed top-0 left-0 w-full h-full flex items-center justify-center"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0">
                                        <div
                                            class="dark:bg-gray-800 bg-gray-100 rounded-lg p-8 m-4 max-w-xl max-h-full overflow-auto">
                                            <!-- Заголовок модального окна -->
                                            <div class="mb-4">
                                                <p class="text-xl font-semibold">Жалоба на
                                                    комментарий</p>
                                            </div>

                                            <!-- Форма жалобы -->
                                            <form action="{{ route('comments.abuse', $comment->id) }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="comment_id"
                                                       value="{{ $comment->id }}">
                                                <textarea name="complaint" rows="4"
                                                          required
                                                          {{--                                                                          class="w-full p-2 border rounded focus:outline-none focus:ring"--}}
                                                          class="border-2 dark:border-gray-500 border-gray-200 px-2 py-2 w-full text-sm text-gray-900 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                                          placeholder="Опишите вашу жалобу"></textarea>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" @click="open = false"
                                                            class="px-4 py-2 mr-2 border rounded">Отмена
                                                    </button>
                                                    <button type="submit"
                                                            class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-700">
                                                        Отправить жалобу
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{--                                    <form id="logout-form" method="POST" action="#" class="hidden">--}}
                    {{--                                        @csrf--}}
                    {{--                                    </form>--}}

                </div>
            </div>
        </div>

    </footer>


    <p class="text-gray-500 dark:text-gray-400">{{ $comment->Text }}</p>
    {{--                                        <div class="flex items-center mt-4 space-x-4">--}}
    {{--                                            <button type="button"--}}
    {{--                                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">--}}
    {{--                                                <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"--}}
    {{--                                                     fill="none" viewBox="0 0 20 18">--}}
    {{--                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"--}}
    {{--                                                          stroke-width="2"--}}
    {{--                                                          d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>--}}
    {{--                                                </svg>--}}
    {{--                                                Reply--}}
    {{--                                            </button>--}}
    {{--                                        </div>--}}
</article>

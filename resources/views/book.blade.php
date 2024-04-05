<x-layout>
{{--    SET @@group_concat_max_len = 50000; --}}

@if($book->RealId)
        <div class="text-2xl mb-5 font-bold text-orange-400">Эта страница устарела. Актуальный id -
            <a class="underline" href="/book/{{ $book->RealId  }}">
                {{ $book->RealId  }}
            </a>
        </div>
    @endif
    @php
        if($book->Authors) {
            $authors = [];
            foreach(explode(';',$book->Authors) as $author) {
                $element = explode(',', $author);
                    $authors[] = [
                        'firstName' => $element[0],
                        'lastName' => $element[1],
                        'middleName' => $element[2],
                        'id' => $element[3],
                        'image' => $element[4],
                    ];
            }
        } else {
            $authors = [];
        }


    @endphp
    <div>
        <div class="overflow-hidden rounded lg:flex dark:bg-gray-900">
            {{--            <img--}}
            {{--                    src="{{ $bookImg = ($book->BookImg === null) ? "https://via.placeholder.com/640x480.png/004455?text=книга" : "https://storagebk.com/flb/book/".$book->BookImg }}"--}}
            {{--                    alt="Книга {{ $book->Title }}"--}}
            {{--                    class="object-cover w-52 h-60  dark:bg-gray-500">--}}
            <div class="p-6 lg:p-8 md:flex md:flex-col w-full">
                <h2 class="text-3xl font-bold md:flex-1">{{ $book->Title }}</h2>

                @if($book->Title1)
                    <i class="text-gray-400 mt-0">{{ $book->Title1 }}</i>
                @endif

                <div class="flex items-center flex-wrap gap-2 dark:border-gray-400 mt-5">

                    @foreach($authors as $author)
                        <div class="flex flex-wrap items-center">
                            @if($author['image'])
                                <img src="https://storagebk.com/flb/author/{{ $author['image'] }}" alt=""
                                     class="w-7 h-7 bg-center bg-cover rounded-full dark:bg-gray-500 mr-3">
                            @endif

                            <a href="{{ route('author', $author['id']) }}"
                               class="hover:underline mr-5">
                                {{ $author['firstName'] }} {{ $author['middleName'] }} {{ $author['lastName'] }}
                            </a>
                        </div>
                    @endforeach


                </div>


                <div class="flow-root mt-10">
                    <dl class="-my-3 divide-y divide-gray-100 text-sm dark:divide-gray-700">
                        <div
                                class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                            <dt class="font-medium text-gray-900 dark:text-white pl-3">Раздел</dt>
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">{{ $book->GenreDesc }}</dd>
                        </div>

                        <div
                                class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                            <dt class="font-medium text-gray-900 dark:text-white pl-3">Жанр</dt>
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">{{ $book->GenreMeta }}</dd>
                        </div>

                        <div
                                class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                            <dt class="font-medium text-gray-900 dark:text-white pl-3">Год</dt>
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">{{ $book->BookYear }}</dd>
                        </div>
                        @if($book->BookRatingsTotal > 0)
                            <div
                                    class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                                <dt class="font-medium text-gray-900 dark:text-white pl-3">Количество оценок</dt>
                                <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">{{ $book->BookRatingsTotal }}</dd>
                            </div>
                        @endif
                        @if($book->Description)
                            <div
                                    class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                                <dt class="font-medium text-gray-900 dark:text-white pl-3">Описание</dt>
                                <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">
                                    {!! $book->Description ?? '' !!}
                                </dd>
                            </div>
                        @endif
                        <div
                                class="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4 even:dark:bg-gray-800">
                            <dt class="font-medium text-gray-900 dark:text-white pl-3">Добавлена</dt>
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3">
                                {{ $book->Time }}
                            </dd>
                        </div>
                    </dl>
                </div>


                <div class="mt-5">
                    <div class="flex flex-wrap py-6 gap-2 border-t border-dashed dark:border-gray-400 mt-3">
                        @if($book->FileType === 'fb2')
                            <a rel="noopener noreferrer" href="#"
                               class="px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">Читать</a>
                            <a rel="noopener noreferrer" href="#"
                               class="flex px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">
                                Скачать fb2</a>
                            <a rel="noopener noreferrer" href="#"
                               class=" flex px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">
                                Скачать epub</a>
                        @else
                            <a rel="noopener noreferrer" href="#"
                               class="flex px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">
                                Скачать {{ $book->FileType }}</a>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
        <div class="flex flex-col p-8 shadow-sm lg:p-12 dark:bg-gray-900 dark:text-gray-100 mt-5">
            <div class="flex flex-col">
                <h2 class="text-3xl font-semibold text-center">Оценки</h2>

                <div class="flex flex-wrap items-center mt-2 mb-1 space-x-2">


                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-6 h-6 dark:text-yellow-500">
                            <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>

                    </div>
                    <span class="dark:text-gray-400">{{ number_format($book->AverageRating, 2) }} из 5</span>
                </div>
                <p class="text-sm dark:text-gray-400">{{ $book->BookRatingsTotal }} голоса(ов)</p>
                @if($book->BookRatingsTotal === 0)
                    @php
                        $book->BookRatingsTotal = 1
                    @endphp
                @endif
                <div class="flex flex-col mt-4">
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-12 text-sm">5 star</span>

                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700">
                            <div class="dark:bg-orange-300 h-4"
                                 style="width: {{ intval(($book->BookRatings5/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings5/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-12 text-sm">4 star</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700">
                            <div class="dark:bg-orange-300 h-4"
                                 style="width: {{ intval(($book->BookRatings4/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings4/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-12 text-sm">3 star</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700">
                            <div class="dark:bg-orange-300 h-4"
                                 style="width: {{ intval(($book->BookRatings3/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings3/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-12 text-sm">2 star</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700">
                            <div class="dark:bg-orange-300 h-4"
                                 style="width: {{ intval(($book->BookRatings2/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings2/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-12 text-sm">1 star</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700">
                            <div class="dark:bg-orange-300 h-4"
                                 style="width: {{ intval(($book->BookRatings1/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings1/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col p-8 shadow-sm lg:p-12 dark:bg-gray-900 dark:text-gray-100 mt-5">
            <div class="flex flex-col">
                <h2 class="text-3xl font-semibold text-center">Серии</h2>
                <div class="items-center mt-2 mb-1">
                    @if($book->BookSeqAll)
                        @foreach(explode(';', $book->BookSeqAll) as $series)
                            @php $seriesElement = explode(',', $series) @endphp
                            <p class="mb-2">
                                <a class="text-violet-400 hover:text-violet-500"
                                   href="/series/{{ trim($seriesElement[0]) }}">{{ $seriesElement[4] }}</a>{{ $seriesElement[1] != 0 ? ' - '. $seriesElement[1]  : '' }}
                            </p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased mt-5">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Комментарии
                    ({{ count($comments) }})</h2>
            </div>
            <form class="mb-6">
                <div
                        class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="6"
                              class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                              placeholder="Оставьте комментарий..." required></textarea>
                </div>
                <button type="submit"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-violet-400 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Отправить
                </button>
            </form>
            @foreach($comments as $comment)

                <article class="p-6 text-base bg-white border-t border-gray-200 dark:border-gray-700 dark:bg-gray-900">
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
                                      title="{{ $comment->Time }}">{{ $comment->Time }}</time>
                            </p>
                        </div>
                        <button id="dropdownComment4Button" data-dropdown-toggle="dropdownComment4"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-40 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 16 3">
                                <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownComment4"
                             class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                </li>
                            </ul>
                        </div>
                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">{{ $comment->Text }}</p>
                    <div class="flex items-center mt-4 space-x-4">
                        <button type="button"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                            </svg>
                            Reply
                        </button>
                    </div>
                </article>
            @endforeach

        </div>
    </section>
</x-layout>

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
        <div class="overflow-hidden rounded lg:flex dark:bg-gray-900 bg-gray-100">
            {{--            <img--}}
            {{--                    src="{{ $bookImg = ($book->BookImg === null) ? "https://via.placeholder.com/640x480.png/004455?text=книга" : "https://storagebk.com/flb/book/".$book->BookImg }}"--}}
            {{--                    alt="Книга {{ $book->Title }}"--}}
            {{--                    class="object-cover w-52 h-60  dark:bg-gray-500">--}}
            <div class="p-6 lg:p-8 md:flex md:flex-col w-full">

                <div class="flex justify-between items-center mb-3">
                    <h1 class="text-3xl font-bold dark:text-gray-50">
                        {{ $book->Title }}
                    </h1>
                    <span class="text-base dark:text-gray-300 text-gray-300">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <a href="#" x-data="{}"
                                   @click.prevent="document.querySelector('#likebook-form').submit()"
                                ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                      stroke-width="1.5"
                                      stroke="currentColor"
                                      class="w-7 h-7
                                       @if($bookLiked) fill-red-500 text-red-500 @endif hover:cursor-pointer hover:text-red-700 hover:fill-red-700">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                    </svg></a></div>
                            <div><select x-data="{}"
                                         @change="function () {
                                    const selectedValue = document.querySelector('#bookStatus').value;
                                    document.querySelector('#statusInput').value = selectedValue;
                                    document.querySelector('#statusbook-form').submit();
                                }"
                                         id="bookStatus"
                                         class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 pl-3 hover:cursor-pointer"
                                         name="status">
                        <option @if(!isset($bookStatus->status)) selected @endif value="0">Статус книги</option>
                        <option @if(isset($bookStatus->status) && $bookStatus->status === 1) selected @endif value="1">Хочу прочитать 🤗</option>
                        <option @if(isset($bookStatus->status) && $bookStatus->status === 2) selected @endif value="2">Читаю сейчас 🤓</option>
                        <option @if(isset($bookStatus->status) && $bookStatus->status === 3) selected @endif value="3">Прочитал(a) 🥳</option>
                        <option @if(isset($bookStatus->status) && $bookStatus->status === 4) selected @endif value="4">Не дочитал(a) 😒</option>
                      </select>

                    <form id="statusbook-form" method="POST" action="{{ route('status', $book->BookId) }}"
                          class="hidden">
                        @csrf
                        <input type="hidden" name="status" id="statusInput">
                    </form>

                    <form id="likebook-form" method="POST" action="{{ route('like', $book->BookId) }}"
                          class="hidden">
                        @csrf
                    </form>

                            </div>
                        </div>





                    </span>

                </div>

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
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200 pl-3"><a class="underline hover:text-blue-400" href="{{ route('genre', $book->GenreId) }}">{{ $book->GenreDesc }}</a></dd>
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


                {{--                <div class="mt-5">--}}
                {{--                    --}}


                {{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">

        <div class="flex flex-col">
            <div class="flex flex-col">
                <div class="shadow-sm px-12 py-8 dark:text-gray-100 dark:bg-gray-900 bg-gray-100 mt-5"><h2
                        class="text-2xl font-semibold text-center">Скачать книгу</h2>
                    <div class=" ">
                        <div class="flex flex-wrap py-6 gap-2 justify-center">
                            {{--                            @dd($comments)--}}

                            @if($book->FileType === 'fb2')

                                @if(isset($book->BookFileNameReal2))
                                    <a rel="noopener noreferrer"
                                       href="{{ route('download', ['folder' => $book->BookFolderNameReal2, 'file' => $book->BookFileNameReal2, 'book_id' => $book->BookId]) }}"
                                       class="flex px-4 py-2 rounded-md text-sm bg-violet-400 dark:text-gray-900 text-gray-100 hover:bg-violet-500">
                                        Скачать {{ $book->FileType }}</a>
                                @else
                                    <div class="text-gray-400 justify-center">Файл книги не найден</div>
                                @endif
                                {{--                                <a rel="noopener noreferrer" href="#"--}}
                                {{--                                   class="px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">Читать</a>--}}
                                {{--                                <a rel="noopener noreferrer" href="#"--}}
                                {{--                                   class="flex px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">--}}
                                {{--                                    Скачать fb2</a>--}}


                                {{--                                <a rel="noopener noreferrer" href="#"--}}
                                {{--                                   class=" flex px-3 py-1 rounded-sm hover:underline dark:bg-sky-800 text-white-700">--}}
                                {{--                                    Скачать epub</a>--}}
                            @elseif(isset($book->BookFolderNameReal1))
                                <a rel="noopener noreferrer"
                                   href="{{ route('download', ['folder' => $book->BookFolderNameReal1, 'file' => $book->BookFileNameReal1, 'book_id' => $book->BookId]) }}"
                                   class="flex px-4 py-2 rounded-md dark:bg-violet-400 dark:text-gray-900 hover:bg-violet-500">
                                    Скачать {{ $book->FileType }}</a>
                            @else
                                <div class="text-gray-400 justify-center">Файл книги не найден</div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="shadow-sm px-12 py-8 dark:text-gray-100 dark:bg-gray-900 bg-gray-100 mt-5"><h2
                        class="text-2xl font-semibold text-center mb-3">
                        Ваша оценка</h2>

                    <div x-data="{ currentVal: {{ $stared->Rate ?? '0' }} }"
                         class="flex items-center gap-1 justify-center">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <label :for="'star' + star"
                                   class="cursor-pointer transition hover:scale-125 focus:scale-125">
                                <span class="sr-only" x-text="star + ' star'"></span>
                                <input :id="'star' + star" type="radio" class="sr-only" name="rating" :value="star"
                                       x-model="currentVal"
                                       @auth
                                           @change="rate(star)"
                                       @endauth

                                       @guest
                                           @change="showerror"
                                    @endguest
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 24 24"
                                     fill="currentColor"
                                     class="w-5 h-5"
                                     :class="currentVal >= star ? 'text-amber-500' : 'text-slate-700 dark:text-slate-300'">
                                    <path fill-rule="evenodd"
                                          d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </label>
                        </template>


                        <script>
                            function rate(star) {

                                // Получаем CSRF токен из мета-тега
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                // URL для отправки POST запроса
                                const url = "{{ route('star', $book->BookId) }}"; // Замените на ваш маршрут

                                fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        // Добавляем CSRF токен в заголовки запроса
                                        'X-CSRF-TOKEN': csrfToken,
                                    },
                                    body: JSON.stringify({
                                        rating: star,
                                        // Вы можете добавить другие данные, если это необходимо
                                    })
                                })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {

                                        // Обработка ответа от сервера
                                        // console.log(data); // Пример: вывод сообщения в консоль
                                        showAlert(data.message);
                                    })
                                    .catch(error => {
                                        console.error('There has been a problem with your fetch operation:', error);
                                    });
                            }

                            function showAlert(message) {

                                // Создаем элемент div для сообщения
                                let alertBox = document.createElement('div');
                                alertBox.textContent = message; // Устанавливаем текст сообщения
                                alertBox.className = 'fixed bottom-3 right-3 bg-green-500 text-white py-2 px-4 rounded-lg cursor-pointer'; // Добавляем стили
                                document.body.appendChild(alertBox); // Добавляем сообщение в тело документа

                                // Устанавливаем таймер для автоматического скрытия сообщения через 3 секунды
                                setTimeout(() => {
                                    alertBox.remove();
                                }, 3000);

                                // Добавляем обработчик клика для ручного скрытия сообщения
                                alertBox.addEventListener('click', () => {
                                    alertBox.remove();
                                });

                                @auth
                                document.getElementById('youStared').innerText = 'Вы проголосовали только что';
                                @endauth




                            }

                            function showerror() {
                                @guest
                                document.getElementById('youStared').innerText = 'Нужно авторизоваться';
                                showAlert('Нужно авторизоваться');
                                @endguest

                            }
                        </script>


                    </div>

                    <div id="youStared" class="flex mt-5 text-sm text-gray-400 justify-center">
                        @if(isset($stared->date))
                            Вы проголосовали {{ $stared->date->diffForHumans() }}
                        @endif

                    </div>
                </div>


            </div>
        </div>

        <div class="flex flex-col p-8 shadow-sm px-12 py-8 dark:bg-gray-900 dark:text-gray-100 bg-gray-100 mt-5">
            <div class="flex flex-col">
                <h2 class="text-2xl font-semibold text-center">Рейтинг</h2>


                <div class="flex flex-wrap items-center mt-2 mb-1 space-x-2">


                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="w-6 h-6 text-yellow-500">
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
                        <span class="flex-shrink-0 w-20 text-sm">5 звезд</span>

                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700 bg-gray-300">
                            <div class="dark:bg-yellow-300 bg-yellow-400 h-4"
                                 style="width: {{ intval(($book->BookRatings5/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings5/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-20 text-sm">4 звезды</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700 bg-gray-300">
                            <div class="dark:bg-yellow-300 bg-yellow-400 h-4"
                                 style="width: {{ intval(($book->BookRatings4/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings4/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-20 text-sm">3 звезды</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700 bg-gray-300">
                            <div class="dark:bg-yellow-300 bg-yellow-400 h-4"
                                 style="width: {{ intval(($book->BookRatings3/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings3/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-20 text-sm">2 звезды</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700 bg-gray-300">
                            <div class="dark:bg-yellow-300 bg-yellow-400 h-4"
                                 style="width: {{ intval(($book->BookRatings2/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings2/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="flex-shrink-0 w-20 text-sm">1 звезда</span>
                        <div class="flex-1 h-4 overflow-hidden rounded-sm dark:bg-gray-700 bg-gray-300">
                            <div class="dark:bg-yellow-300 bg-yellow-400 h-4"
                                 style="width: {{ intval(($book->BookRatings1/$book->BookRatingsTotal)*100) }}%"></div>
                        </div>
                        <span class="flex-shrink-0 w-12 text-sm text-right">{{ intval(($book->BookRatings1/$book->BookRatingsTotal)*100) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col p-8 shadow-sm px-12 py-8 dark:bg-gray-900 dark:text-gray-100 bg-gray-100 mt-5">
            <div class="flex flex-col">
                <h2 class="text-2xl font-semibold text-center">Серии</h2>
                <div class="items-center mt-2 mb-1">
                    @if($book->BookSeqAll)
                        @foreach(explode(';', $book->BookSeqAll) as $series)
                            @php $seriesElement = explode(',', $series) @endphp
                            <p class="mb-2">
                                <a class="text-violet-400 hover:text-violet-500"
                                   href="/series/{{ trim($seriesElement[0]) }}">{{ $seriesElement[4] }}</a>{{ $seriesElement[1] != 0 ? ' - '. $seriesElement[1]  : '' }}
                            </p>
                        @endforeach
                    @else
                        <h3 class="text-gray-400">Серий нет</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <section class="bg-gray-100 dark:bg-gray-900 py-8 lg:py-16 antialiased mt-5">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Комментарии
                    ({{ count($comments) }})</h2>
            </div>
            <form method="POST" action="{{ route('comment', $book->BookId) }}" class="mb-6">
                @csrf

                <div
                    class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" name="comment" rows="6"
                              class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                              placeholder="Оставьте комментарий..." required></textarea>
                </div>
                <button type="submit"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-violet-400 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Отправить
                </button>
            </form>
            @foreach($comments as $comment)
                <x-rowcomment :comment="$comment" class="dark:bg-gray-800"/>
            @endforeach

        </div>



    </section>


</x-layout>

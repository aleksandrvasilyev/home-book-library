<x-layout>
    {{-- нужно сделать подсчет количества книг в каждом жанре, делать подсчет раз в день или неделю и
    кешировать или сохранять результат --}}
    <div class="overflow-hidden rounded lg:flex dark:bg-gray-900 bg-gray-100 px-7 py-8">


        <ul class="space-y-4 text-white-500 list-disc list-inside dark:text-white-400">
            @foreach($genres as $genreMeta => $subGenres)
                <li>
                    {{ $genreMeta }} <!-- Название основного жанра -->
                    <ul class="ps-5 mt-2 space-y-1 list-disc list-inside">
                        @foreach($subGenres as $subGenre)
{{--                            @dd($subGenre)--}}
                            <li><a class="underline hover:text-blue-500" href="{{ route('genre', $subGenre->GenreId) }}">{{ $subGenre->GenreDesc }}</a>  <span
                                    class="ml-4 bg-blue-100 text-white-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-white-700">
                {{  $subGenre->count }}
            </span></li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

    </div>
</x-layout>

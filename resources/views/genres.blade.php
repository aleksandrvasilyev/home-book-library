<x-layout>
    {{-- нужно сделать подсчет количества книг в каждом жанре, делать подсчет раз в день или неделю и
    кешировать или сохранять результат --}}
    <div class="overflow-hidden rounded lg:flex dark:bg-gray-900 px-7 py-8">


        <ul class="space-y-4 text-white-500 list-disc list-inside dark:text-white-400">
            @foreach($genres as $genreMeta => $subGenres)
                <li>
                    {{ $genreMeta }} <!-- Название основного жанра -->
                    <ul class="ps-5 mt-2 space-y-1 list-disc list-inside">
                        @foreach($subGenres as $subGenre)
                            <li><a class="underline hover:text-blue-500" href="/genre/{{ $subGenre->GenreCode }}">{{ $subGenre->GenreDesc }}</a></li> <!-- Название поджанра -->
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

    </div>
</x-layout>

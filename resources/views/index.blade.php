<x-layout>
    <h2 class="text-2xl mb-4">Жанры книг</h2>
    <div class="grid lg:grid-cols-8 md:grid-cols-4 sm:grid-cols-2 mb-6 gap-6 text-center">

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 24 ) }}" >
                <img class="w-32 mb-2 text-center" src="https://storagebk.com/image/demo/1.webp" alt="Детектив">
                Детектив
            </a>
        </div>


        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 90 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/2.webp" alt="Публицистика">
                Публицистика
            </a>
        </div>

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 37 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/3.webp" alt="Любовные романы">
                Любовные романы
            </a>
        </div>

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 226 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/4.webp" alt="Фантастика">
                Фантастика
            </a>
        </div>

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 11 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/5.webp" alt="Фэнтези">
                Фэнтези
            </a>
        </div>

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 213 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/6.webp" alt="Самиздат">
                Самиздат
            </a>
        </div>

        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 25 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/7.webp" alt="Проза">
                Проза
            </a>
        </div>
        <div class="dark:bg-gray-900 bg-gray-100 p-6 flex justify-center items-center">
            <a href="{{ route('genre', 62 ) }}">
                <img class="w-32 mb-2" src="https://storagebk.com/image/demo/9.webp" alt="Психология">
                Психология
            </a>
        </div>
    </div>
    <h2 class="text-2xl mb-4">Последние книги</h2>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($books as $book)
            <x-rowbook :book="$book"/>
        @endforeach
    </div>

    <div class="mt-6">{{ $pagination->links() }}</div>

    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>

    <h2 class="text-2xl my-4">Случайные комментарии</h2>
    @foreach($comments as $comment)
        {{--       {{ $comment->Title }}--}}
        <x-rowcomment :comment="$comment" class="dark:bg-gray-900" :booktitle="$comment->Title"
                      :bookid="$comment->BookId"></x-rowcomment>
    @endforeach

</x-layout>



<x-layout>

    <div class="flex justify-between items-center mb-3">
        <h2 class="text-2xl font-bold dark:text-gray-50">
            Поиск книг по запросу "{{ request('search') }}"
        </h2>
        <span class="text-base dark:text-gray-300">
        Страница {{ $books->currentPage() }} из {{ $books->lastPage() }}
    </span>
    </div>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($books as $book)
            <x-rowbook :book="$book"/>
        @endforeach

    </div>
    <div class="mt-4">{{ $books->appends(['search' => request('search')])->links() }}</div>

    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>

</x-layout>

<x-layout>
    <div class="flex justify-between items-center mb-3">
        <h1 class="text-2xl font-bold dark:text-gray-50">
{{--            @dd($pagination)--}}
            {{ $title }}
            <span
                class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                {{  $pagination->total() }}
            </span>
        </h1>
        <span class="text-base dark:text-gray-300">
        Страница {{ $pagination->currentPage() }} из {{ $pagination->lastPage() }}
    </span>
    </div>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($books as $book)
{{--            @dd($book)--}}
            <x-rowbook :book="$book"/>
        @endforeach
    </div>
    <div class="mt-6">{{ $pagination->links() }}</div>


</x-layout>



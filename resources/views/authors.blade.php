<x-layout>

    <div class="flex justify-between items-center mb-3">
        <h2 class="text-2xl font-bold dark:text-gray-50">
            Авторы
        </h2>
        <span class="text-base dark:text-gray-300">
        Страница {{ $pagination->currentPage() }} из {{ $pagination->lastPage() }}
    </span>
    </div>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($authors as $author)
            <x-rowauthor :author="$author"/>
        @endforeach
    </div>

    <div class="mt-6">{{ $pagination->links() }}</div>

{{--    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>--}}

</x-layout>


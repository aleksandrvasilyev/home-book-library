<x-layout>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($books as $book)
            <x-rowbook :book="$book"/>
        @endforeach
    </div>

    <div class="mt-6">{{ $pagination->links() }}</div>

    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>

</x-layout>



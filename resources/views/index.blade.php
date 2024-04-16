<x-layout>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($books as $book)
            <x-rowbook :book="$book"/>
        @endforeach
    </div>

    <div class="mt-6">{{ $pagination->links() }}</div>

    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>

    <h2 class="text-xl justify-center flex my-4">Случайные комментарии</h2>
    @foreach($comments as $comment)
{{--       {{ $comment->Title }}--}}
        <x-rowcomment :comment="$comment" class="dark:bg-gray-900" :booktitle="$comment->Title" :bookid="$comment->BookId"></x-rowcomment>
    @endforeach

</x-layout>



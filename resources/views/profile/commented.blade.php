<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-3">
                        <h1 class="text-2xl">
                            Комментарии
                        </h1>
                        <span class="text-base dark:text-gray-300">
                            @if(isset($commentedBooksCount))
                                {{ $commentedBooksCount }}
                            @endif
                    </span>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-6 px-2 py-2">
                    @foreach($books as $book)
                        <x-rowbook :book="$book"/>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div class="mt-6 px-6 py-4">{{ $pagination->links() }}</div>




</x-app-layout>

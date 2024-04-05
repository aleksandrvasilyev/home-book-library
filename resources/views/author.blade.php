<x-layout>
    <div class="overflow-hidden rounded lg:flex dark:bg-gray-900">

        @if($author->File ?? '')
            <img src="https://storagebk.com/flb/author/{{ $author->File }}" alt=""
                 class="object-cover w-48 h-48 max-h-76 dark:bg-gray-500">
        @else
            <img src="https://storagebk.com/flb/author/user.jpeg" alt=""
                 class="object-cover w-48 h-48 max-h-76 dark:bg-gray-500">
        @endif


        <div class="p-6 lg:p-8 md:flex md:flex-col w-full">

            <div class="flex justify-between items-center mb-3">
                <h1 class="text-3xl font-bold dark:text-gray-50">
                    {{ $author->FirstName ?? '' }} {{ $author->MiddleName ?? '' }} {{ $author->LastName ?? '' }}
                </h1>
                <span class="text-base dark:text-gray-300">{{ $pagination->total() }} книг(а)</span>
            </div>


            <div class="flow-root mt-10">
                <dl class="-my-3 divide-y divide-gray-100 text-sm dark:divide-gray-700">


                    @if($author->Body ?? '')
                        <div>
{{--                            <dt class="font-medium text-gray-900 dark:text-white pl-3">{!! $author->Body !!}</dt>--}}
                            <dd class="text-gray-700 sm:col-span-2 dark:text-gray-200">
                                {!! $author->Body !!}
                            </dd>
                        </div>
                    @endif
                    @if($author->Homepage)
                        <div class="mt-4 pt-1">Домашняя страница: {{ $author->Homepage }}</div>
                    @endif

                </dl>
            </div>
        </div>
    </div>


    <div class="grid gap-6 lg:grid-cols-6 mt-6">
        @foreach($books as $book)
            <x-rowbook :book="$book"/>
        @endforeach
    </div>

    <div class="mt-6">{{ $pagination->links() }}</div>


</x-layout>

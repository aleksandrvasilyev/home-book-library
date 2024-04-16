<x-layout>


    @if(request()->get('area') === 'book')
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold dark:text-gray-50">
                Поиск книг по запросу "{{ request('search') }}"
                <span
                    class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{  $results->total() }}</span>

            </h2>
            <span class="text-base dark:text-gray-300">
                Страница {{ $results->currentPage() }} из {{ $results->lastPage() }}
            </span>
        </div>
        <div class="grid gap-6 lg:grid-cols-6">
            @foreach($results as $book)
                <x-rowbook :book="$book"/>
            @endforeach
        </div>
        <div class="mt-4">{{ $results->appends(['search' => request('search')])->links() }}</div>
    @elseif(request()->get('area') === 'author')

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold dark:text-gray-50">
                Поиск авторов по запросу "{{ request('search') }}"
                <span
                    class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{  $results->total() }}</span>

            </h2>
            <span class="text-base dark:text-gray-300">
                Страница {{ $results->currentPage() }} из {{ $results->lastPage() }}
            </span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Фамилия Имя Отчество
                    </th>
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Color--}}
                    {{--                    </th>--}}
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Category--}}
                    {{--                    </th>--}}

                </tr>
                </thead>
                <tbody>

                @foreach($results as $result)

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 ">
                            <a href="{{ route('author', $result->AvtorId ) }}"
                               class="hover:underline text-xl">{{ $result->LastName }} {{ $result->FirstName }} {{ $result->MiddleName }}</a>
                        </th>
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div
            class="mt-4">{{ $results->appends(['search' => request('search'), 'area' => request('area')])->links() }}</div>

    @elseif(request()->get('area') === 'series')

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold dark:text-gray-50">
                Поиск серии по запросу "{{ request('search') }}"
                <span
                    class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{  $results->total() }}</span>

            </h2>
            <span class="text-base dark:text-gray-300">
                Страница {{ $results->currentPage() }} из {{ $results->lastPage() }}
            </span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Серия
                    </th>
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Color--}}
                    {{--                    </th>--}}
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Category--}}
                    {{--                    </th>--}}

                </tr>
                </thead>
                <tbody>

                @foreach($results as $result)

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 ">
                            <a href="{{ route('oneSeries', $result->SeqId ) }}"
                               class="hover:underline text-xl">{{ $result->SeqName }}</a>

                        </th>
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div
            class="mt-4">{{ $results->appends(['search' => request('search'), 'area' => request('area')])->links() }}</div>

    @elseif(request()->get('area') === 'genre')

        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold dark:text-gray-50">
                Поиск жанра по запросу "{{ request('search') }}"
                <span
                    class="ml-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{  $results->total() }}</span>

            </h2>
            <span class="text-base dark:text-gray-300">
                Страница {{ $results->currentPage() }} из {{ $results->lastPage() }}
            </span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Жанр
                    </th>
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Color--}}
                    {{--                    </th>--}}
                    {{--                    <th scope="col" class="px-6 py-3">--}}
                    {{--                        Category--}}
                    {{--                    </th>--}}

                </tr>
                </thead>
                <tbody>

                @foreach($results as $result)

                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 ">
{{--                            @dd($result)--}}
                            <a href="{{ route('genre', $result->GenreId ) }}" class="hover:underline text-xl">{{ $result->GenreDesc }}</a>
                        </th>
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}
                        {{--                        <td class="px-6 py-4">--}}

                        {{--                        </td>--}}

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div
            class="mt-4">{{ $results->appends(['search' => request('search'), 'area' => request('area')])->links() }}</div>


    @endif


    <x-slot:searchbox>@include('components.searchbox')</x-slot:searchbox>

</x-layout>

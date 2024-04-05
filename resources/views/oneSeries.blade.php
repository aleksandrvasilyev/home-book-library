<x-layout>

{{--    @dd($series)--}}
    <div class="overflow-hidden rounded lg:flex dark:bg-gray-900">
        <div class="p-6 lg:p-8 md:flex md:flex-col w-full">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold dark:text-gray-50">
                    Серия {{ $thisSeries->SeqName }}
                </h1>
                <span class="text-base dark:text-gray-300"> {{ $series->count() }} книг(а)</span>
            </div>
        </div>
    </div>

    @foreach($series as $oneSeries)
        <div class="px-8 py-4 dark:bg-gray-900 mt-3">
           {{ $oneSeries->SeqNumb }} <a href="/book/{{ $oneSeries->BookId }}" class="hover:underline">{{ $oneSeries->Title }}</a>
        </div>
    @endforeach



</x-layout>

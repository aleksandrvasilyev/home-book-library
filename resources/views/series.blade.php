<x-layout>

    <div class="flex justify-between items-center mb-3">
        <h2 class="text-2xl font-bold dark:text-gray-50">
            Серии
        </h2>
        <span class="text-base dark:text-gray-300">
        Страница {{ $series->currentPage() }} из {{ $series->lastPage() }}
    </span>
    </div>

    <div class="grid gap-6 lg:grid-cols-6">
        @foreach($series as $oneSeries)
            <x-rowseries :series="$oneSeries"/>
        @endforeach
    </div>

{{--    <div class="mt-6">{{ $pagination->links() }}</div>--}}
    <div class="mt-6">{{ $series->links() }}</div>


</x-layout>


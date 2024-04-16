@props(['series'])

<div class="overflow-hidden rounded lg:flex lg:col-span-3 dark:bg-gray-900 bg-gray-100">


    <div class="p-6 space-y-6 lg:p-8 md:flex md:flex-col ">

        <h2 class="text-2xl font-bold hover:underline"><a
                href="/series/{{ $series->SeqId }}">{{ $series->SeqName }}</a>
        </h2>


    </div>
</div>

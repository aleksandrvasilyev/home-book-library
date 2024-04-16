@props(['book'])

<div class="overflow-hidden rounded lg:flex lg:col-span-3 dark:bg-gray-900 bg-gray-100">
    {{--    <img src="/img/book.webp" alt="" class="object-cover w-52 h-auto max-h-96 dark:bg-gray-500">--}}
    <div class="p-6 space-y-6 lg:p-8 md:flex md:flex-col ">

        <h2 class="text-2xl font-bold hover:underline"><a
                href="/book/{{ $book->BookId }}">{{ $book->Title }}</a>
        </h2>
        <p>{{ mb_substr(strip_tags($book->Body), 0, 200, 'utf-8') }}
        </p>
        <div>
                        <span
                            class="self-start px-3 py-1 text-sm rounded-sm dark:bg-slate-700 dark:text-white-900 bg-slate-200">{{ $book->FileType }}</span>
            <span
                class="self-start px-3 py-1 text-sm rounded-sm dark:bg-slate-700 dark:text-white-900 bg-slate-200 ">{{ $book->Lang }}</span>
            <span class="self-start px-3 py-1 text-sm rounded-sm dark:bg-slate-700 dark:text-white-900 bg-slate-200">{{ $book->Pages }} страниц</span>
            <span
                class="self-start px-3 py-1 text-sm rounded-sm dark:bg-slate-700 dark:text-white-900 bg-slate-200">{{ @explode(' ', $book->Modified)[0] }}</span>
        </div>
    </div>
</div>

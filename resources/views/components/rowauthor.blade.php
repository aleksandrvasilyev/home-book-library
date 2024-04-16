@props(['author'])

<div class="overflow-hidden rounded lg:flex lg:col-span-3 dark:bg-gray-900 bg-gray-100">
    @if($author->File)
        <img src="https://storagebk.com/flb/author/{{ $author->File }}" alt=""
             class="object-cover w-48 h-auto max-h-76 dark:bg-gray-500">
    @else
        <img src="https://storagebk.com/flb/author/user.jpeg" alt=""
             class="object-cover w-48 h-auto max-h-76 dark:bg-gray-500">
    @endif

    <div class="p-6 space-y-6 lg:p-8 md:flex md:flex-col ">

        <h2 class="text-2xl font-bold hover:underline"><a
                href="/author/{{ $author->AvtorId }}">{{ $author->FirstName }} {{ $author->MiddleName }} {{ $author->LastName }} </a>
        </h2>
        <p>{{ mb_substr(strip_tags($author->Body), 0, 200, 'utf-8') }}
        </p>

    </div>
</div>

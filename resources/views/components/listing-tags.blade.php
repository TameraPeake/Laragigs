@props(['tagsCsv'])

@php
    $tags = explode(',', $tagsCsv);
@endphp

<ul class="flex flex-wrap">

    @foreach ($tags as $tag )
        <li class="bg-black hover:bg-red-500 text-white rounded-xl px-3 py-1 mr-2 m-2">
            <a href="/?tag={{ $tag }}" >{{ $tag }}</a>
        </li>
    @endforeach

</ul>

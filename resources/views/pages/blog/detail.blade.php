@extends('layouts.app')

@section('title', 'Blog Detail')

@section('content')
    <div class="max-w-screen-md mx-auto pt-10">
        <div class="grid  grid-cols-2 md:grid-cols-3 gap-2 md:gap-0 place-content-center place-items-center ">
            <div class="col-span-1 flex items-center gap-x-2">
                <i class="fa-regular fa-calendar"></i><span
                    class="text-xs text-gray-400">{{ $post->created_at->format('d F Y') }}</span>
            </div>

            <div class="col-span-1 flex items-center gap-x-2">
                <img class="w-4 h-4 mx-auto rounded-full "
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="image-article">
                <p class="text-xs">author: {{ $post->user->name }}</p>
            </div>
            <div class="col-span-1">
                <p class="text-xs text-gray-400"><span class="badge badge-accent">{{ $post->category->name }}</span>
                </p>
            </div>
        </div>
        <div class=" text-xl md:text-3xl mt-12  text-center font-sans font-bold">{{ $post->title }}</div>
        <div class="mt-10">
            <figure class="aspect-video" style=" border: 2px solid rgb(219, 219, 219);">
                <img class="w-full h-full  rounded-lg object-contain"
                    src="{{ $post->getFirstMediaUrl('posts' . '-' . $post->uuid) }}" alt="{{ $post->title }}">
            </figure>
        </div>
        <div class="mt-10 text-xs md:text-sm text-justify leading-loose md:leading-8 text-gray-800">
            {!! $post->content !!}
        </div>
    </div>
@endsection

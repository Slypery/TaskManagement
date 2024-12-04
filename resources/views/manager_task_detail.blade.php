@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="flex flex-col w-full">
        <a href="{{ route('manager.task_list.index') }}" class="opacity-50 inline-flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-4xl font-bold capitalize">{{ $manager_task->title }}</h1>
        <p>From: {{ $manager_task->created_user->username }}</p>
        <div class="flex border-b border-black/50"></div>
        <div class="tiptap">
            {!! $manager_task->description !!}
        </div>
    </div>
    <div class="flex flex-col w-64 pl-6 gap-2">
        <h2>Attachment</h2>
        @if (!$manager_task->attachment)
            <p class="text-sm text-black/50">none</p>
        @endif
        @foreach ($manager_task->attachment as $index => $item)
            <div class="input-file flex col-span-6 px-2 py-1 border-black border-2 rounded-[5px]">
                <a href="{{ asset('storage/uploads/' . $item) }}" target="blank" class="flex max-w-full hover:underline hover:text-indigo-700 pt-1">
                    <div class="overflow-div text-nowrap max-w-64 overflow-hidden text-ellipsis">
                        {{ $item }}
                    </div>
                    <div class="overflow-peer hidden">
                        {{ substr($item, -8) }}
                    </div>
                </a>
            </div>
        @endforeach
        <script type="module">
            $(() => {
                $('.overflow-div').each(function() {
                    var item = $(this);
                    if (item[0].scrollWidth > item[0].clientWidth) {
                        console.log('tes');
                        item.closest('a').find('div.overflow-peer').removeClass('hidden');
                    }
                });
            });
        </script>
        <div class="my-2 border-t border-black"></div>
        <h2>Forwarded To</h2>
        <p class="text-sm text-black/50">none</p>
        <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
            <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white flex justify-center">
                Forward
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mt-[5px] ml-1">
                    <path d="M18.1716 6.99955H11C7.68629 6.99955 5 9.68584 5 12.9996C5 16.3133 7.68629 18.9996 11 18.9996H20V20.9996H11C6.58172 20.9996 3 17.4178 3 12.9996C3 8.58127 6.58172 4.99955 11 4.99955H18.1716L15.636 2.46402L17.0503 1.0498L22 5.99955L17.0503 10.9493L15.636 9.53509L18.1716 6.99955Z"></path>                </svg>
            </div>
        </button>
        <div class="my-2 border-t border-black"></div>
        <h2>Status</h2>
        <p class="text-sm text-black/50">{{ $manager_task->status }}</p>
    </div>
@endsection

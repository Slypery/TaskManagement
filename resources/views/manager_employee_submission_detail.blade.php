@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="flex flex-col w-full">
        <a href="{{ route('manager.task_list.detail', $task_origin->manager_task_id) }}" class="opacity-50 flex w-min">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        @if ($employee_submission)
            <h1 class="text-4xl font-bold capitalize">{{ $employee_submission->title }}</h1>
            <p>From: {{ $employee_submission->employee_task->assigned_user->username }}</p>
            <div class="flex border-b border-black/50"></div>
            <div class="tiptap">
                {!! $employee_submission->description !!}
            </div>
        @else
            <p class="text-sm text-black/50">no submission yet</p>
        @endif
    </div>
    <div class="flex flex-col w-72 pl-6 gap-2">
        <h2>Task Origin</h2>
        <div class="border-l-2 border-black pl-2">
            <h3 class="font-semibold text-xl flex hover:underline hover:text-indigo-800 cursor-pointer" data-modal-trigger="#TaskDetailView">
                {{ $task_origin->title }}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mt-[2px] ml-1">
                    <path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM13.529 14.4464C11.9951 15.3524 9.98633 15.1464 8.66839 13.8284C7.1063 12.2663 7.1063 9.73367 8.66839 8.17157C10.2305 6.60948 12.7631 6.60948 14.3252 8.17157C15.6432 9.48951 15.8492 11.4983 14.9432 13.0322L17.1537 15.2426L15.7395 16.6569L13.529 14.4464ZM12.911 12.4142C13.6921 11.6332 13.6921 10.3668 12.911 9.58579C12.13 8.80474 10.8637 8.80474 10.0826 9.58579C9.30156 10.3668 9.30156 11.6332 10.0826 12.4142C10.8637 13.1953 12.13 13.1953 12.911 12.4142Z"></path>
                </svg>
            </h3>
            <p class="text-sm">By: {{ $task_origin->created_user->username }} (you)</p>
        </div>
        @if ($employee_submission)
            <div class="my-2 border-t border-black"></div>
            <h2>Attachment</h2>
            @if (!$employee_submission->attachment)
                <p class="text-sm text-black/50">none</p>
            @endif
            @foreach ($employee_submission->attachment as $item)
                <div class="input-file flex px-2 py-1 border-black border-2 rounded-[5px]">
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
        @else
            <button data-modal-trigger="#ModalDelete" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-red-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-red-800 text-white flex justify-center">
                    Delete Assignment
                </div>
            </button>
        @endif
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
    </div>

    <x-modal id="TaskDetailView">
        <x-slot name="header">
            {{ $task_origin->title }}
            <p class="text-sm font-normal">Due: {{ $task_origin->due_date }}</p>
        </x-slot>
        <div class="tiptap min-w-[42rem] max-w-3xl">
            {!! $task_origin->description !!}
        </div>
        <div class="border-b-2 border-yellow-900/10"></div>
        Attachment
        @if (!$task_origin->attachment)
            <p class="text-sm text-black/50">none</p>
        @endif
        <div class="grid grid-cols-12 gap-2">
            @foreach ($task_origin->attachment as $item)
                <div class="input-file col-span-6 flex px-2 py-1 border-black border-2 rounded-[5px]">
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
        </div>
    </x-modal>
    <x-modal id="ModalDelete">
        <x-slot name="header">Delete Task Confirmation</x-slot>
        <div id="DeleteTitle"></div>
        <p class="text-sm w-96 text-red-500">*note that deleting task is permanent and can cause some missing data related to this task</p>
        <form action="{{ route('manager.task_list.destroy', [$task_origin->id, $task_origin->manager_task_id]) }}" method="post">
            @csrf
            @method('delete')
            <button id="DeleteTaskID" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Delete This Task
                </div>
            </button>
        </form>
    </x-modal>
@endsection

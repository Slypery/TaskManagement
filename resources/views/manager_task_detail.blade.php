@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="flex flex-col w-full">
        <a href="{{ route('manager.task_list.index') }}" class="opacity-50 flex w-min">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-4xl font-bold capitalize">{{ $manager_task->title }}</h1>
        <p>From: {{ $manager_task->created_user->username }}</p>
        <p class="text-sm opacity-80">Due: {{ $manager_task->due_date }}</p>
        <div class="flex border-b border-black/50"></div>
        <div class="tiptap">
            {!! $manager_task->description !!}
        </div>
    </div>
    <div class="flex flex-col w-72 pl-6 gap-2">
        <h2>Attachment</h2>
        @if (!$manager_task->attachment)
            <p class="text-sm text-black/50">none</p>
        @endif
        @foreach ($manager_task->attachment as $item)
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
        @if (!$employee_task_min->toArray())
            <p class="text-sm text-black/50">none</p>
        @endif
        @foreach ($employee_task_min as $item)
            <div class="border-l-2 border-black pl-2">
                @if ($item->status == 'not viewed')
                    <a href="{{ route('manager.forward_task.edit', $item->id) }}" class="font-semibold text-xl flex hover:underline hover:text-indigo-800 cursor-pointer" data-modal-trigger="#TaskDetailView">
                        {{ $item->assigned_user->username }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mt-[2px] ml-1">
                            <path d="M21 6.75736L19 8.75736V4H10V9H5V20H19V17.2426L21 15.2426V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9.00319 2H19.9978C20.5513 2 21 2.45531 21 2.9918V6.75736ZM21.7782 8.80761L23.1924 10.2218L15.4142 18L13.9979 17.9979L14 16.5858L21.7782 8.80761Z"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('manager.employee_submissions.detail', $item->id) }}" class="font-semibold text-xl flex hover:underline hover:text-indigo-800 cursor-pointer" data-modal-trigger="#TaskDetailView">
                        {{ $item->assigned_user->username }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mt-[2px] ml-1">
                            <path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM13.529 14.4464C11.9951 15.3524 9.98633 15.1464 8.66839 13.8284C7.1063 12.2663 7.1063 9.73367 8.66839 8.17157C10.2305 6.60948 12.7631 6.60948 14.3252 8.17157C15.6432 9.48951 15.8492 11.4983 14.9432 13.0322L17.1537 15.2426L15.7395 16.6569L13.529 14.4464ZM12.911 12.4142C13.6921 11.6332 13.6921 10.3668 12.911 9.58579C12.13 8.80474 10.8637 8.80474 10.0826 9.58579C9.30156 10.3668 9.30156 11.6332 10.0826 12.4142C10.8637 13.1953 12.13 13.1953 12.911 12.4142Z"></path>
                        </svg>
                    </a>
                @endif
                <p class="text-sm">Title: {{ $item->title }}</p>
                <p class="text-sm">Status: {{ $item->status }}</p>
            </div>
        @endforeach
        <a href="{{ route('manager.forward_task.index', $manager_task->id) }}" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
            <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white flex justify-center">
                Forward
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mt-[3px]">
                    <path d="M16.0037 9.41421L7.39712 18.0208L5.98291 16.6066L14.5895 8H7.00373V6H18.0037V17H16.0037V9.41421Z"></path>
                </svg>
            </div>
        </a>
        <div class="my-2 border-t border-black"></div>
        <h2>Status</h2>
        <p class="text-sm text-black/50">{{ $manager_task->status }}</p>
        @if ($manager_task->manager_submission)
            <a href="{{ route('manager.submissions.detail', $manager_task->manager_submission->id) }}">
                <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                    <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white flex justify-center">
                        View Your Submission
                    </div>
                </button>
            </a>
        @else
        <a href="{{ route('manager.submissions.create', $manager_task->id) }}">
            <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white flex justify-center">
                    Turn In
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mt-[3px]">
                        <path d="M13.9999 19.0001L5.00003 19.0002L5 17.0002L11.9999 17.0001L12 6.8283L8.05027 10.778L6.63606 9.36381L13 2.99985L19.364 9.36381L17.9498 10.778L14 6.82825L13.9999 19.0001Z"></path>
                    </svg>
                </div>
            </button>
        </a>
        @endif
    </div>
    @if (session('success'))
        <script type="module">
            $(() => {
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    customClass: {
                        popup: "bg-yellow-50 rounded-md",
                        confirmButton: "rounded-[7px] p-0 border-2 border-solid bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75"
                    },
                    didOpen: () => {
                        Swal.getConfirmButton().innerHTML = `<div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">ok</div>`;
                    }
                });
            })
        </script>
    @endif
@endsection

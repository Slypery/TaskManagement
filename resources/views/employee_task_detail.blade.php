@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="flex flex-col w-full">
        <a href="{{ route('employee.task_list.index') }}" class="opacity-50 flex w-min">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-4xl font-bold capitalize">{{ $employee_task->title }}</h1>
        <p>From: {{ $employee_task->created_user->username }}</p>
        <p class="text-sm opacity-80">Due: {{ $employee_task->due_date }}</p>
        <div class="flex border-b border-black/50"></div>
        <div class="tiptap">
            {!! $employee_task->description !!}
        </div>
    </div>
    <div class="flex flex-col w-72 pl-6 gap-2">
        <h2>Attachment</h2>
        @if (!$employee_task->attachment)
            <p class="text-sm text-black/50">none</p>
        @endif
        @foreach ($employee_task->attachment as $item)
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
        <h2>Status</h2>
        <p class="text-sm text-black/50">{{ $employee_task->status }}</p>
        @if ($employee_task->employee_submission)
            <a href="{{ route('employee.submissions.detail', $employee_task->employee_submission->id) }}">
                <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                    <div class="px-6 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white flex justify-center">
                        View Your Submission
                    </div>
                </button>
            </a>
        @else
            <a href="{{ route('employee.submissions.create', $employee_task->id) }}">
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

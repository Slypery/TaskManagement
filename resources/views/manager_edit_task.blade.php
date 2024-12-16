@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <form id="FormEdit" action="{{ route('manager.forward_task.update', $employee_task->id) }}" method="post" enctype="multipart/form-data" class="block w-full max-w-[1000px]">
        @csrf
        @method('put')
        <input type="hidden" name="manager_task_id" value="{{ $employee_task->manager_task_id }}">
        <a href="{{ route('manager.task_list.detail', $task_origin->id) }}" class="opacity-50 flex w-min">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-3xl font-semibold mb-2">Edit Forwarded Assignment</h1>
        <x-horizontal-input id="EditTitle" name="title" placeholder="Title" type="text" label="Title" value="{{ $employee_task->title }}" />
        <div class="grid grid-cols-12 gap-2 mt-2">
            <label for="AssignTo" class="col-span-3 content-center font-semibold text-nowrap">Assign To</label>
            <div class="col-span-9 min-h-[39px] border-black border-2 rounded-[7px]">
                <select style="width: 100%" name="assigned_to" id="AssignTo" class="select2" required data-placeholder="Employee">
                    <option value=""></option>
                    @foreach ($employee as $item)
                        <option value="{{ $item->id }}" @if ($item->id == $employee_task->assigned_to) selected @endif>{{ $item->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <x-horizontal-input id="EditDueDate" name="due_date" type="date" label="Due Date" value="{{ $employee_task->due_date }}" others="min={{ $employee_task->due_date }}" />
        <x-text-editor name="description" label="Decription" value="{!! $employee_task->description !!}" />
        <div class="font-semibold mt-3">Attachments</div>
        <div class="w-full grid grid-cols-12 gap-2 mt-2">
            @foreach ($employee_task->attachment as $index => $item)
                <div class="input-file flex col-span-6 p-2 border-black border-2 rounded-[5px]">
                    <a href="{{ asset('storage/uploads/' . $item) }}" target="blank" class="flex max-w-[calc(100%-24px)] hover:underline hover:text-indigo-700 pt-1">
                        <div class="overflow-div overflow-hidden text-nowrap text-ellipsis">
                            {{ $item }}
                        </div>
                        <div class="overflow-peer hidden peer">
                            {{ substr($item, -12) }}
                        </div>
                    </a>
                    <div class="ml-auto pt-[3px]">
                        <input type="checkbox" name="attachment_to_delete[]" value="{{ $item }}" id="file{{ $index }}" class="peer hidden">
                        <label for="file{{ $index }}" class="peer-checked peer-checked:text-red-500 text-red-300/90 cursor-pointer hover:text-red-400/90">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                <line class="line" x1="4" y1="20" x2="20" y2="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </label>
                    </div>
                </div>
            @endforeach
            <script type="module">
                $(() => {
                    function overflow_input_file(item) {
                        item.closest('a').find('div.overflow-peer').addClass('hidden');
                        if (item[0].scrollWidth > item[0].clientWidth) {
                            console.log('tes');
                            item.closest('a').find('div.overflow-peer').removeClass('hidden');
                        }
                        console.log('tes');
                    }
                    $('.overflow-div').each(function() {
                        overflow_input_file($(this));
                    });
                    $(window).resize(() => {
                        $('.overflow-div').each(function() {
                            overflow_input_file($(this));
                        });
                    })
                });
            </script>
            <div class="input-file hidden"></div>
            <div class="input-file flex col-span-6 p-2 border-black border-2 rounded-[5px]">
                <input type="file" name="attachment[]" id="" class="w-full">
                <button type="button" class="btn-remove-file ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
            </div>
            <div class="col-span-6 content-center">
                <button type="button" id="BtnAddMoreFiles" class="flex p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 mr-2 mt-[2.9px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add More Files
                </button>
            </div>
            <script type="module">
                $(() => {
                    $('#BtnAddMoreFiles').on('click', () => {
                        $($('.input-file').toArray().at(-1)).after(
                            `
                            <div class="input-file flex col-span-6 p-2 border-black border-2 rounded-[5px]">
                                <input type="file" name="attachment[]" id="" class="w-full">
                                <button type="button" class="btn-remove-file ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                    </svg>
                                </button>
                            </div>
                            `
                        );
                        $('.btn-remove-file').off('click').on('click', function() {
                            $(this).closest('div').remove();
                        })
                    })
                    $('.btn-remove-file').on('click', function() {
                        $(this).closest('div').remove();
                    })
                })
            </script>
        </div>
        <div class="flex gap-2">
            <button type="button" data-modal-trigger="#ModalDelete" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-red-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-red-800 text-white flex justify-center">
                    Delete Assignment
                </div>
            </button>
            <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Save Changes
                </div>
            </button>
        </div>
    </form>
    <div class="flex flex-col w-72 pl-6 gap-2">
        <h2>Task Origin</h2>
        <div class="border-l-2 border-black pl-2">
            <h3 class="font-semibold text-xl flex hover:underline hover:text-indigo-800 cursor-pointer" data-modal-trigger="#TaskDetailView">
                {{ $task_origin->title }}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mt-[2px] ml-1">
                    <path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM13.529 14.4464C11.9951 15.3524 9.98633 15.1464 8.66839 13.8284C7.1063 12.2663 7.1063 9.73367 8.66839 8.17157C10.2305 6.60948 12.7631 6.60948 14.3252 8.17157C15.6432 9.48951 15.8492 11.4983 14.9432 13.0322L17.1537 15.2426L15.7395 16.6569L13.529 14.4464ZM12.911 12.4142C13.6921 11.6332 13.6921 10.3668 12.911 9.58579C12.13 8.80474 10.8637 8.80474 10.0826 9.58579C9.30156 10.3668 9.30156 11.6332 10.0826 12.4142C10.8637 13.1953 12.13 13.1953 12.911 12.4142Z"></path>
                </svg>
            </h3>
            <p class="text-sm">By: {{ $task_origin->created_user->username }}</p>
        </div>
    </div>
    <script type="module">
        $(() => {
            $('.select2').select2();
        });
    </script>
    <x-modal id="TaskDetailView">
        <x-slot name="header">
            {{ $task_origin->title }}
            <p class="text-sm font-normal">Due: {{ $task_origin->due_date }}</p>
        </x-slot>
        <div class="tiptap max-w-3xl">
            {!! $task_origin->description !!}
        </div>
        <div class="border-b-2 border-yellow-900/10"></div>
        Attachment
        @if (!$task_origin->attachment)
            <p class="text-sm text-black/50">none</p>
        @endif
        <div class="grid grid-cols-12 gap-2">
            @foreach ($task_origin->attachment as $item)
                <div class="col-span-6 flex px-2 py-1 border-black border-2 rounded-[5px]">
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
        <form action="{{ route('manager.task_list.destroy', [$employee_task->id, $task_origin->id]) }}" method="post">
            @csrf
            @method('delete')
            <button id="DeleteTaskID" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Delete This Task
                </div>
            </button>
        </form>
    </x-modal>
    @if ($errors->any())
        <script type="module">
            $(() => {
                $(() => {
                    Swal.fire({
                        title: "Error!",
                        html: "@foreach ($errors->all() as $error){!! $error . '<br>' !!} @endforeach",
                        icon: "error",
                        customClass: {
                            popup: "bg-yellow-50 rounded-md",
                            confirmButton: "rounded-[7px] p-0 border-2 border-solid bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75"
                        },
                        didOpen: () => {
                            Swal.getConfirmButton().innerHTML = `<div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">ok</div>`;
                        }
                    });
                })
            })
        </script>
    @endif
@endsection

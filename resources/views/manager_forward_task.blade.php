@extends('layouts.app')
@section('sidebar')
    <x-manager-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <form id="FormAdd" action="{{ route('manager.forward_task.store') }}" method="post" enctype="multipart/form-data" class="block w-full max-w-[1000px]">
        @csrf
        <input type="hidden" name="manager_task_id" value="{{ $task_origin->id }}">
        <a href="{{ route('manager.task_list.detail', $task_origin->id) }}" class="opacity-50 flex w-min">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-3xl font-semibold mb-2">Forward Assignment</h1>
        <x-horizontal-input id="AddTitle" name="title" placeholder="Title" type="text" label="Title" />
        <div class="grid grid-cols-12 gap-2 mt-2">
            <label for="AssignTo" class="col-span-3 content-center font-semibold text-nowrap">Assign To</label>
            <div class="col-span-9 min-h-[39px] border-black border-2 rounded-[7px]">
                <select style="width: 100%" name="assigned_to" id="AssignTo" class="select2" required data-placeholder="Employee">
                    <option value=""></option>
                    @foreach ($employee as $array)
                        <option value="{{ $array->id }}">{{ $array->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <x-horizontal-input id="AddDueDate" name="due_date" type="date" label="Due Date" others="min={{ date('Y-m-d') }}" />
        <x-text-editor name="description" label="Decription" />
        <div class="font-semibold mt-3">Attachments</div>
        <div class="w-full grid grid-cols-12 gap-2">
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
                <button type="button" id="BtnAddMoreFiles" class=" flex p-2">
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
        <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
            <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                Add
            </div>
        </button>
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

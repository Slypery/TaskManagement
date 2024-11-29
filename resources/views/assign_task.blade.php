@extends('layouts.app')
@section('sidebar')
    <x-director-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <form id="FormAdd" action="{{ route('director.manager_task.store') }}" method="post" enctype="multipart/form-data" class="block w-full max-w-[1000px]">
        @csrf
        <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
        <input id="AddDescription" type="hidden" name="description" value="" required>
        <a href="{{ route('director.manager_task.index') }}" class="opacity-50 flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="size-4 mt-[6px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-lg">Back</span>
        </a>
        <h1 class="text-3xl font-semibold mb-2">Add Assignment</h1>
        <x-horizontal-input id="AddTitle" name="title" placeholder="Title" type="text" label="Title" />
        <div class="grid grid-cols-12 gap-2 mt-2">
            <label for="AssignTo" class="col-span-3 content-center font-semibold text-nowrap">Assign To</label>
            <div class="col-span-9 min-h-[39px] border-black border-2 rounded-[7px]">
                <select style="width: 100%" name="assigned_to" id="AssignTo" class="select2" required data-placeholder="Manager">
                    <option value=""></option>
                    @foreach ($manager as $array)
                        <option value="{{ $array->id }}">{{ $array->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <x-horizontal-input id="AddDueDate" name="due_date" type="date" label="Due Date" other="min={{ date('Y-m-d') }}" />
        <div class="mt-3">
            <label onclick="document.querySelector('#RichText div').focus()" class="font-semibold">Description</label>
            <div class="border-2 border-black rounded-[7px]">
                <div class="border-t-4 border-l-2 border-yellow-700/10 bg-yellow-700/5">
                    <div id="RichText"></div>
                </div>
            </div>
        </div>
        <div class="font-semibold mt-3">Attachments</div>
        <div class="w-full grid grid-cols-12 gap-2">
            <div class="input-file hidden"></div>
            <div class="input-file flex col-span-6 p-2 border-black border-2 rounded-[5px]">
                <input type="file" name="attachment[]" id="" class="w-52">
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
        </div>
        <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
            <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                Add
            </div>
        </button>
        <script type="module">
            $(() => {
                $('#BtnAddMoreFiles').on('click', () => {
                    $($('.input-file').toArray().at(-1)).after(
                        `
                        <div class="input-file flex col-span-6 p-2 border-black border-2 rounded-[5px]">
                            <input type="file" name="attachment[]" id="" class="w-52">
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
    </form>
    <script type="module">
        $(() => {
            const quill = new Quill('#RichText', {
                theme: 'snow'
            });
            $('.select2').select2();
            $('#FormAdd').on('submit', () => {
                $('#AddDescription').val(quill.root.innerHTML);
            })
        });
    </script>
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

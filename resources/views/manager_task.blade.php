@extends('layouts.app')
@section('sidebar')
    <x-director-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="block">
        <a href="{{ route('director.manager_task.create') }}">
            <button class="mt-2 col-span-12 rounded-[7px] h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Assign Task
                </div>
            </button>
        </a>

        <div class="table-style max-w-[calc(100vw-19rem)]">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th class="text-nowrap">Created By</th>
                        <th class="text-nowrap">Assigned To</th>
                        <th>Description</th>
                        <th class="text-nowrap">Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manager_task as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->created_user->username }}</td>
                            <td>{{ $item->assigned_user->username }}</td>
                            <td><div class="flex gap-1">{!! substr($item->description, 0, 50) . (strlen($item->description) > 53  ? '...' : '') !!}</div></td>
                            <td class="text-nowrap">{{ $item->due_date }}</td>
                            <td class="text-nowrap">{{ $item->status }}</td>
                            <td>
                                <div class="flex flex-nowrap">
                                    <a class="text-blue-600" href="{{ route('director.manager_task.edit', $item->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                    </a>
                                    <button class="text-red-500" data-modal-trigger="#ModalDelete" data-delete-id="{{ $item->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-modal id="ModalDelete">
        <x-slot name="header">Delete Task Confirmation</x-slot>
        <div id="DeleteTitle"></div>
        <p class="text-sm w-96 text-red-500">*note that deleting task is permanent and can cause some missing data related to this task</p>
        <form action="{{ route('director.manager_task.destroy') }}" method="post">
            @csrf
            @method('delete')
            <button id="DeleteTaskID" name="id" value="" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Delete This Task
                </div>
            </button>
        </form>
    </x-modal>
    {{-- delete form handler --}}
    <script type="module">
        $(() => {
            let DeleteTaskID = $('#DeleteTaskID');
            let DeleteTitle = $('#DeleteTitle');
            $('[data-delete-id]').on('click', function() {
                var tds = $(this).closest('tr').find('td');
                DeleteTaskID.val($(this).attr('data-delete-id'));
                DeleteTitle.html('Title: ' + tds[1].innerHTML);
            })
        })
    </script>
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

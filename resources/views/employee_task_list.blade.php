@extends('layouts.app')
@section('sidebar')
    <x-employee-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="block">
        <div class="table-style max-w-[calc(100vw-19rem)]">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th class="text-nowrap">Created By</th>
                        <th>Description</th>
                        <th class="text-nowrap">Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee_task as $index => $item)
                        <tr>
                            <td class="text-nowrap">{{ $index + 1 }}.</td>
                            <td class="text-nowrap">{{ $item->title }}</td>
                            <td class="text-nowrap">{{ $item->created_user->username }}</td>
                            <td>
                                <div class="text-ellipsis text-nowrap overflow-hidden max-w-64">{{ strip_tags($item->description) }}</div>
                            </td>
                            <td class="text-nowrap">{{ $item->due_date }}</td>
                            <td class="text-nowrap">{{ $item->status }}</td>
                            <td>
                                <div class="flex justify-center">
                                    <a class="text-blue-600" href="{{ route('employee.task_list.detail', $item->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path d="M15 4H5V20H19V8H15V4ZM3 2.9918C3 2.44405 3.44749 2 3.9985 2H16L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918ZM13.529 14.4464C11.9951 15.3524 9.98633 15.1464 8.66839 13.8284C7.1063 12.2663 7.1063 9.73367 8.66839 8.17157C10.2305 6.60948 12.7631 6.60948 14.3252 8.17157C15.6432 9.48951 15.8492 11.4983 14.9432 13.0322L17.1537 15.2426L15.7395 16.6569L13.529 14.4464ZM12.911 12.4142C13.6921 11.6332 13.6921 10.3668 12.911 9.58579C12.13 8.80474 10.8637 8.80474 10.0826 9.58579C9.30156 10.3668 9.30156 11.6332 10.0826 12.4142C10.8637 13.1953 12.13 13.1953 12.911 12.4142Z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

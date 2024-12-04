@extends('layouts.app')
@section('sidebar')
    <x-director-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    <div class="block">
        <button data-modal-trigger="#ModalCreate" class="mt-2 col-span-12 rounded-[7px] h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75 text-center">
            <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                Create User
            </div>
        </button>

        <div class="table-style">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_list as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="capitalize">{{ $item->role }}</td>
                            <td>
                                <div class="flex flex-nowrap">
                                    <button class="text-blue-600" data-modal-trigger="#ModalEdit" data-edit-id="{{ $item->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
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

    <x-modal id="ModalCreate">
        <x-slot name="header">Create User</x-slot>
        <form action="{{ route('director.user_list.store') }}" method="post" class="w-96">
            @csrf
            <x-horizontal-input id="CreateUsername" name="username" type="text" label="Username" placeholder="Username" other="minlength=4|maxlength=50" />
            <x-horizontal-input id="CreateEmail" name="email" type="email" label="Email" placeholder="someone@example.com" />
            <x-horizontal-input id="CreatePassword" name="password" type="password" label="Password" placeholder="8 characters minimal" other="minlength=8" />
            <x-horizontal-input-select id="CreateRole" name="role" label="Role">
                <option value="" disabled selected>--select role--</option>
                <option value="director">Director</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>
            </x-horizontal-input-select>
            <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Store
                </div>
            </button>
        </form>
    </x-modal>
    <x-modal id="ModalEdit">
        <x-slot name="header">Edit User</x-slot>
        <form action="{{ route('director.user_list.update') }}" method="post">
            @csrf
            @method('put')
            <x-horizontal-input id="EditUsername" name="username" type="text" label="Username" placeholder="Username" other="minlength=4|maxlength=50" />
            <x-horizontal-input id="EditEmail" name="email" type="email" label="Email" placeholder="someone@example.com" />
            <x-horizontal-input-select id="EditRole" name="role" label="Role">
                <option value="director">Director</option>
                <option value="manager">Manager</option>
                <option value="employee">Employee</option>
            </x-horizontal-input-select>
            <button id="EditUserID" name="id" value="" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Update
                </div>
            </button>
        </form>
    </x-modal>
    {{-- edit form handler --}}
    <script type="module">
        $(() => {
            let EditUserID = $('#EditUserID');
            let EditUsername = $('#EditUsername');
            let EditEmail = $('#EditEmail');
            let EditRoles = $('#EditRole').find('option');
            $('[data-edit-id]').on('click', function() {
                var tds = $(this).closest('tr').find('td');
                EditUserID.val($(this).attr('data-edit-id'))
                EditUsername.val(tds[1].innerHTML);
                EditEmail.val(tds[2].innerHTML);
                switch (tds[3].innerHTML) {
                    case 'director':
                        EditRoles[0].selected = true;
                        break;
                    case 'manager':
                        EditRoles[1].selected = true;
                        break;
                    case 'employee':
                        EditRoles[2].selected = true;
                        break;
                    default:
                        break;
                }
            })
        })
    </script>
    <x-modal id="ModalDelete">
        <x-slot name="header">Delete User Confirmation</x-slot>
        <div id="DeleteUsername"></div>
        <div id="DeleteEmail"></div>
        <p class="text-sm w-96 text-red-500">*note that deleting user is permanent and can cause some missing data related to this user</p>
        <form action="{{ route('director.user_list.destroy') }}" method="post">
            @csrf
            @method('delete')
            <button id="DeleteUserID" name="id" value="" class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Delete This User
                </div>
            </button>
        </form>
    </x-modal>
    {{-- delete form handler --}}
    <script type="module">
        $(() => {
            let DeleteUserID = $('#DeleteUserID');
            let DeleteUsername = $('#DeleteUsername');
            let DeleteEmail = $('#DeleteEmail');
            $('[data-delete-id]').on('click', function() {
                var tds = $(this).closest('tr').find('td');
                DeleteUserID.val($(this).attr('data-delete-id'));
                DeleteUsername.html('Username: ' + tds[1].innerHTML);
                DeleteEmail.html('Email: ' + tds[2].innerHTML);
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

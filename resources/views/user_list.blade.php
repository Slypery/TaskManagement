@extends('layouts.app')
@section('sidebar')
    <x-director_sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
    {{-- form add --}}
    <form action="{{ route('director.user_list.store') }}" method="post">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <select name="role" id="role" required>
            <option value="" disabled selected>--none--</option>
            <option value="director">Director</option>
            <option value="manager">Manager</option>
            <option value="employee">Employee</option>
        </select>
        <button type="submit">Save</button>
    </form>

    <div class="table-style">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_list as $item)
                    <tr>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>
                            {{-- button delete --}}
                            <form action="{{ route('director.user_list.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button style="color: red" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- form edit --}}
                    <form action="{{ route('director.user_list.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="text" id="username" name="username" placeholder="Username" value="{{ $item->username }}" required>
                        <input type="email" id="email" name="email" placeholder="Email" value="{{ $item->email }}" required>
                        <select name="role" id="role" required>
                            <option value="director" {{ $item->role == 'director' ? 'selected' : '' }}>Director</option>
                            <option value="manager" {{ $item->role == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="employee" {{ $item->role == 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                        <button type="submit">Save</button>
                    </form><br>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

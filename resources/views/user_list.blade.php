@extends('layouts.app')
@section('sidebar')
    <x-director-sidebar pageName="{{ $page_name }}" />
@endsection
@section('main')
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
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

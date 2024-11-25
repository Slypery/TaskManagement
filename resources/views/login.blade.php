@extends('layouts.plain')
@section('body')
    <body class="h-screen grid place-items-center bg-yellow-100/50">
        <div class="shadow-highlight p-5 border-2 border-yellow-900/10 rounded-md">
            <div class="text-2xl font-semibold border-b-2 border-yellow-900/10">
                Login
            </div>
            <form method="POST" action="{{ route('auth.login') }}" class="w-96 mt-2">
                @csrf
                @method('post')
                <x-horizontal-input id="LoginUsernameOrEmail" name="usernameOrEmail" type="text" label="Username" placeholder="Enter Username or Email" />
                <x-horizontal-input id="Password" name="password" type="password" label="Password" placeholder="Enter Password" />
                {{ $errors->first('auth_error') }}
                <button class="mt-2 col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                    <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                        Login
                    </div>
                </button>
            </form>
        </div>
    </body>
@endsection

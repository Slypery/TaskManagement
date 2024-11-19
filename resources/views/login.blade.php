<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen grid place-items-center bg-yellow-100/50">
    <div class="shadow-highlight p-5 border-2 border-yellow-900/10 rounded-md">
        <div class="text-2xl font-semibold border-b-2 border-yellow-900/10">
            Login
        </div>
        <form method="POST" action="{{}}" class="grid grid-cols-12 gap-2 w-96 mt-2">
            @csrf
            @method('post')
            <label for="EditUsername" class="col-span-3 content-center font-semibold text-nowrap">Username</label>
            <div class="col-span-9 border-2 border-black rounded-[7px] flex-grow">
                <input id="EditUsername" name="username" type="text" placeholder="Enter Username or Email" required class="w-full px-1 py-1 bg-yellow-700/5 rounded-[5px] border-l-2 border-t-4 border-yellow-700/10 placeholder:font-semibold placeholder:text-yellow-950/50 focus:placeholder:opacity-0 focus:placeholder:translate-x-12 placeholder:transition-all">
            </div>
            <label for="EditPassword" class="col-span-3 content-center font-semibold text-nowrap">Password</label>
            <div class="col-span-9 border-2 border-black rounded-[7px] flex-grow">
                <input id="EditPassword" name="password" type="text" placeholder="Enter Password" required class="w-full px-1 py-1 bg-yellow-700/5 rounded-[5px] border-l-2 border-t-4 border-yellow-700/10 placeholder:font-semibold placeholder:text-yellow-950/50 focus:placeholder:opacity-0 focus:placeholder:translate-x-12 placeholder:transition-all">
            </div>
            <button class="col-span-12 rounded-[7px] w-full h-fit border-2 bg-blue-600 border-black overflow-hidden focus-visible:bg-opacity-75">
                <div class="px-6 py-1 rounded-[5px] border-b-4 border-r-2 border-blue-800 text-white">
                    Login
                </div>
            </button>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page_name }}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    </style>
</head>

<body class="h-screen flex flex-col bg-yellow-50">
    <header class="flex items-center px-6 min-h-16 border-b-[1px] border-gray-300 text-2xl font-bold">
        <span class="bg-gradient-to-r from-purple-700 to-blue-700 bg-clip-text text-transparent">Apcon</span>&nbsp;
        <span>Template</span>
    </header>
    <div class="flex flex-1">
        <aside class="w-64 border-r-[1px] border-gray-300 px-6 pt-8">
            @yield('sidebar')
        </aside>
        <script>
            $(() => {
                $('main').removeClass('opacity-0');
            })
        </script>

        <main class="flex flex-1 items-start px-6 py-8 opacity-0 transition-opacity duration-500 max-h-[calc(100vh-64px)] overflow-auto">
            @yield('main')
        </main>
    </div>
    <div data-modal-container>
        {{-- don't put anything in here, put your modal anywhere but this div then js script will automatically put it in here --}}
    </div>
</body>

</html>

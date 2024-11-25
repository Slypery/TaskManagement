@extends('layouts.plain')
@section('body')

    <body class="bg-yellow-50">
        <select name="" id="" class="select2">
            <option value="">tes</option>
            <option value="">tes</option>
            <option value="">tes</option>
        </select>
        <div class="texteditor">
        </div>

        <script type="module">
            $(() => {
                const quill = new Quill('.texteditor', {
                    theme: 'snow'
                });
                $('.select2').select2();
            });
        </script>
    @endsection

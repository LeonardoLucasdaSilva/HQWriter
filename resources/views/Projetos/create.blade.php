@extends('layouts.navbar2')
@section('content')
    <!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.tiny.cloud/1/1kbpbk9iei8czaxs7wjb62vodhrsw67ccrac85lcy2rp5x4z/tinymce/5/tinymce.min.js'
            referrerpolicy="origin">
    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            language: 'pt_BR'
        });
    </script>
</head>

<body>
<div class="container">
    <form method="post">
    <textarea class="h-100" id="mytextarea" name="mytextarea" rows="35">
    </textarea>
    </form>
</div>
</body>
</html>
@endsection

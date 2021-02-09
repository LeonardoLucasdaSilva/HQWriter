@extends('layouts.navbar2')
@section('content')
    <!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <script>

        $(document).ready(function () {
            url = new URL(document.URL);
           pageNumber= url.searchParams.getAll("page");
            $('#page').attr('value',pageNumber);
        });
    </script>
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
    @foreach($pagina as $pag)
        <form action="{{route('projetos.updatePagina',$pag->id)}}" method="post">
            @csrf
            @method('PUT')
            <textarea class="h-100" id="mytextarea" name="conteudo" value="{{$pag->conteudo}}" rows="27">{{$pag->conteudo}}
    </textarea>
            <input type="hidden" id="page" name="page" value="">
            <button type="submit" class="btn btn-outline-success mt-2">Salvar</button>
        </form>
        <form action="{{route('projetos.novaPagina',$pag->roteiro->id)}}" method="POST">
            @CSRF
            <button type="submit" class="btn btn-outline-secondary mt-2"">Nova página</button>
        </form>
        <form action="{{route('projetos.apagarPagina',$pag->id)}}" method="POST">
            @CSRF
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger mt-2"">Apagar página</button>
        </form>
        {{$pagina->links()}}
    @endforeach
</div>
</body>
</html>
@endsection

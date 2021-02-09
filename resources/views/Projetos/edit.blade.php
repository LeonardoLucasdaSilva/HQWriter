@extends('layouts.navbar2')
@section('content')
    <div class="container">
    <form action="{{route('projetos.update',$roteiro->id)}}" method="POST">
        @csrf
        @method ('PUT')
        <div class="form-group w-25">
            <h5>Título: </h5><br>
            <input type="text" class="form-control" name="nome" value="{{$roteiro->nome}}" required><br>
        </div>
        <div class="form-group">
            <h5>Gêneros: </h5><br>
            @foreach($generos as $genero)
                <input type="checkbox" id="{{$genero->id}}" name="generos[]" value="{{$genero->id}}" {{$is_selected_generos[$genero->id]}}>
                <label for="{{$genero->id}}">{{$genero->nome}}</label><br>
            @endforeach
        </div>
        <div class="form-group">
            <h5>Tipo: </h5><br>
            <input type="radio" id="marvelway" name="tipo" value="marvelway" required {{$is_selected[2]}}>
            <label for="marvelway">Marvel way</label><br>
            <input type="radio" id="fullscript" name="tipo" value="fullscript" required {{$is_selected[3]}}>
            <label for="fullscript"><i>Full-script</i></label><br>
        </div>
        <div class="form-group">
            <h5>Visibilidade: </h5><br>
            <input type="radio" id="privado" name="visibilidade" value="privado" required {{$is_selected[1]}}>
            <label for="privado">Privado</label><br>
            <input type="radio" id="publico" name="visibilidade" value="publico" required {{$is_selected[0]}}>
            <label for="publico">Público</label><br>
        </div>
        <button type="submit" class="btn btn-outline-primary">Editar informações</button>
    </form>
    </div>
@endsection

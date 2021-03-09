@extends('layouts.navbar2')
@section('content')
    <div class="container">
<form action="{{route('projetos.novoPersonagem',$roteiro)}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="nome">Nome</label>
        <input class="form-control" id="nome" name="nome" placeholder="Nome do personagem" required>
    </div>
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição do personagem" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Criar personagem</button>
</form>
    </div>
@endsection

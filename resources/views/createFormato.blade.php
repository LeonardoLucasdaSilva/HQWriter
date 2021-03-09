@extends('layouts.navbar2')
@section('content')
    <div class="container">
        <h3>Selecione a formatação da página seguinte!</h3>
        <form action="{{route('projetos.novoFormato',$id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Linhas</label>
                <input class="form-control" type="number" id="linhas" name="linhas" required>
            </div>
            <div class="form-group">
                <label for="nome">Colunas</label>
                <input class="form-control" type="number" id="colunas" name="colunas" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar formato</button>
        </form>
    </div>
@endsection

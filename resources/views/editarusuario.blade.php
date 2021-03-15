@extends('layouts.navbar2')
@section('content')
    <div class="container">
        <form action="{{route('updateusuario',$user->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input class="form-control" id="nome" name="nome" placeholder="{{$user->nome}}" required>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="admin" name="admin" value="sim">
                    <label class="form-check-label" type="admin">
                        Tornar admin
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Editar</button>
        </form>
    </div>
@endsection

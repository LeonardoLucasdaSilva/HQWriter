@extends('layouts.navbar2')
@section('content')

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Quicksand:wght@300&display=swap"
      rel="stylesheet">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho+B1&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">


<style>
    h3 {
        font-family: Quicksand;
        font-size: 220%;
        margin-bottom: -0.5%;
        margin-top: 2%;
    }

    button {
        font-family: Quicksand;
        font-size: 220%;
    }
    th{
        font-family: 'Noto Sans KR', sans-serif;
    }

    a {
        text-decoration: none;
    }

    #closeModal {
        transform: rotate(45deg);
    }

    .projetos{
        font-family: 'Shippori Mincho B1', serif;
        font-weight: bold;
    }

</style>


<div class="m-auto w-100 container">
    <div class="row">
        <div class="col-sm">
            <h3 class="usuarios">
                Usuários ativos
            </h3>
        </div>

    </div>
    <hr>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">NOME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">ADMIN</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($ativos as $ativo)
            <tr>
                <th class="w-25" scope="row">{{$ativo->name}}</th>
                <td class="w-25">{{$ativo->email}}</td>
                @if($ativo->is_admin==true)
                <td class="w-25">Sim</td>
                @else
                    <td class="w-25">Não</td>
                @endif
                <td class="w-25">
                    <a class="d-inline" href="{{route('editarusuario',$ativo->id)}}">
                        <button type="button" class=" justify-content-center btn btn-outline-secondary">
                            Editar
                        </button>
                    </a>
                    <form class="d-inline" action="{{route('inativarusuario',$ativo->id)}}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Deseja realmente inativar o usuário {{$ativo->name}} ?')"
                                class=" justify-content-center btn btn-outline-danger">
                            Inativar
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3 class="usuarios">
        Usuários inativos
    </h3>
    <hr>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">NOME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">ADMIN</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($inativos as $inativo)
            <tr>
                <th class="w-25" scope="row">{{$inativo->name}}</th>
                <td class="w-25">{{$inativo->email}}</td>
                @if($inativo->is_admin==true)
                    <td class="w-25">Sim</td>
                @else
                    <td class="w-25">Não</td>
                @endif
                <td class="w-25"><a class="mr-auto" href="{{route('ativarusuario',$inativo->id)}}"><button class="btn btn-outline-success">Ativar</button></a>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    @endsection

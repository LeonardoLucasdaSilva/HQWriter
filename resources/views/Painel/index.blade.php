@extends('layouts.navbar2')
@section('content')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho+B1&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

    <style>

        h3 {
            font-family: Quicksand;
            font-size: 220%;
            margin-bottom: -0.5%;
        }

        h4 {
            font-family: 'Shippori Mincho B1', serif;
            font-weight: bold;
            color: #1b4b72;
        }

        .genero {
            display: inline;
            background-color: lightgray;
        }

        .mod {
            font-family: 'Noto Sans KR', sans-serif;
            font-size: 90%;
            font-weight: bold;
            color: #5a6268;
        }

        .generocontainer {
            border: 1px dashed black;
            text-align: center;
        }

    </style>
    <div class="container w-50">
        <hr>
        <div class="row">
            <a class="text-dark text-decoration-none w-10" href="{{route('painel.index')}}">
                <div class="col mr-1 ml-1 generocontainer" style="padding-left: 45px;padding-right: 45px">
                    Todos
                </div>
            </a>
            @foreach($generos as $genero)
                <a class="text-dark text-decoration-none w-10" href="{{route('visualizarGenero',$genero->id)}}">
                    <div class="col ml-1 mr-1 generocontainer" style="padding-left: 45px;padding-right: 45px">
                        {{$genero->nome}}
                    </div>
                </a>
            @endforeach
        </div>
        <hr>
        @if($publicos!=null)
            @foreach($publicos as $publico)
                <div class="m-auto w-100 container">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{route('projetos.visualizarRoteiro',$publico)}}">
                                <h4>{{$publico->nome}}</h4>
                            </a>
                            @foreach($publico->generos_selecionados as $genero)
                                <div class="genero pl-1 pr-1">{{$genero->nome}}</div>
                            @endforeach
                        </div>
                        <div class="col-sm">
                            <!-- <h5 class="mod">MODIFICADO EM: //$publico->updated_at->format('d/m/Y' )</h5> -->
                            <h5 class="mod">CRIADO EM: {{$publico->created_at->format('d/m/Y')}}</h5>
                        </div>
                        <div class="col-sm">
                            @if($publico->is_marvelway==true)
                                <h5 class="mod">MARVEL WAY</h5>
                            @else
                                <h5 class="mod">FULL SCRIPT</h5>
                            @endif
                            @if($publico->numpag==1)
                                <h5 class="mod">{{$publico->numpag}} QUADRINHO</h5>
                            @else
                                <h5 class="mod">{{$publico->numpag}} QUADRINHOS</h5>
                            @endif
                        </div>
                        <div class="col-sm">
                            <h5 class="mod">ESCRITO POR: "{{$publico->autor}}"</h5>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        @else
            <div class="m-auto w-100 container text-center">
                <h3>Nenhum resultado encontrado</h3>
            </div>
        @endif
    </div>
@endsection

@extends('layouts.imprimir')
@section('content')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho+B1&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Quicksand:wght@300&display=swap"
          rel="stylesheet">
    <head>
        <style>
            .titulo {
                font-family: 'Shippori Mincho B1', serif;
                font-weight: bold;
                color: #1b4b72;
                font-size: 300%;
                margin-bottom: 0.6%;
            }

            .subtitulo {
                font-family: 'Noto Sans KR', sans-serif;
                text-align: center;
                font-weight: bold;
            }

            .subtitulo2 {
                font-family: 'Noto Sans KR', sans-serif;
                font-weight: bold;
                text-align: justify;
            }

            .desc {
                font-family: 'Noto Sans KR', sans-serif;
                text-align: center;
            }

            .notas {
                font-family: 'Open Sans', Arial, sans-serif;
                text-align: justify;
            }

            .conteudo {
                font-family: 'Noto Sans KR', sans-serif;
            }

            .tipo {
                display: inline;
                background-color: lightgray;
            }

            #nomeFala {
                color: #4c110f;
            }

            .bordas {
                border: 0.5px solid black;
            }

            body {
                background-color: white;
            }


        </style>
    </head>
    <body>
    <div class="container">
        <h3 class="titulo">{{$roteiro->nome}}</h3>
        <h5 class="text-center mt-5 d-inline">por {{$autor}}</h5>
        <hr>
        @for($n=0;$n<count($paginas);$n++)
            <h2 class="subtitulo mt-4">Pagina {{$n+1}}</h2>
            <h5 class="subtitulo2"><i>Script</i></h5>
            <div class="conteudo mb-2">{!! html_entity_decode($paginas[$n]->conteudo) !!}</div>
        @endfor
    </div>
@endsection







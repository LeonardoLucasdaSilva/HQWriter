@extends('layouts.navbar2')
@section('content')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho+B1&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

    <style>
        .titulo{
            font-family: 'Shippori Mincho B1', serif;
            font-weight: bold;
            color: #1b4b72;
            font-size: 300%;
            margin-bottom: -0.5%;
            text-align:center;
        }
    </style>
    <body>
    <div class="container">
        <h3 class="titulo">{{$titulo}}</h3>
        <div class="mt-4">
            @for($x=0; $x<count($paginas);$x++)
                <h2>Página {{$x+1}}</h2>
                <tr>
                    <th class="w-25" scope="row">{!! html_entity_decode($paginas[$x]->conteudo) !!}</th>
                </tr>
            @endfor
        </div>
    </div>
    </body>
    <!--AAAA
    <th class="w-25" scope="row"></th>
    <td class="w-25"></td>
    <td class="w-25"></td>
    <td class="w-25"><a class="mr-auto" href="#"><button class="btn btn-secondary">Visualizar</button></a> -->
@endsection


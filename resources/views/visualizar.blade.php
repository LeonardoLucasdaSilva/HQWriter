@extends('layouts.navbar2')
@section('content')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho+B1&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Quicksand:wght@300&display=swap"
          rel="stylesheet">

    <style>
        .titulo {
            font-family: 'Shippori Mincho B1', serif;
            font-weight: bold;
            color: #1b4b72;
            font-size: 300%;
            margin-bottom: -0.5%;
            text-align: center;
        }

        .falas{
            border: 1px solid black;
            padding: 3%;
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


    </style>
    <body>
    <div class="container">
        <h3 class="titulo">{{$roteiro->nome}}</h3>
        <h5 class="text-center mt-2">por {{$autor}}</h5>
        <hr>
        @for($x=0; $x<count($paginas);$x++)
            <h2 class="subtitulo mt-4">Quadrinho {{$x+1}}</h2>
            @if($paginas[$x]->plano!="")
                <h4 class="desc">{{$paginas[$x]->plano}}, {{$paginas[$x]->angulo}}, {{$paginas[$x]->lado}}</h4>
            @endif
            <h5 class="subtitulo2"><i>Script</i></h5>
            <tr>
                <th class="w-25" scope="row">
                    <div class="conteudo">{!! html_entity_decode($paginas[$x]->conteudo) !!}</div>
                </th>
            </tr>
            <h5 class="subtitulo2 mb-4"><i>Falas</i></h5>
        <div class="falas">
                @if($paginas[$x]->falas)
                    @foreach($paginas[$x]->falas as $fala)
                    <h5 class="conteudo mt-3" id="nomeFala"><b>{{$fala->char->nome}}</b></h5>
                    <small class="conteudo mb-4">Tipo de balão: {{$fala->balao}}</small>
                    <h6 class="conteudo d-block mt-2">"{{$fala->conteudo}}"</h6>
                @endforeach
                @endif
        </div>

            @if($paginas[$x]->is_flashback||$paginas[$x]->is_subjetivo||$paginas[$x]->is_impacto||$paginas[$x]->is_off)
                <h5 class="subtitulo2 mt-4">Detalhes</h5>
            @endif
            <div class="container">
                <div class="row d-block justify-content-center">
                    @if($paginas[$x]->is_flashback)
                        <div class="tipo pl-1 pr-1 col">Flashback</div>
                    @endif
                    @if($paginas[$x]->is_subjetivo)
                        <div class="tipo pl-1 pr-1 col">Subjetivo</div>
                    @endif
                    @if($paginas[$x]->is_impacto)
                        <div class="tipo pl-1 pr-1 col">Impacto</div>
                    @endif
                    @if($paginas[$x]->is_off)
                        <div class="tipo pl-1 pr-1 col">Off</div>
                    @endif
                    @if($paginas[$x]->anotacoes)
                        <h5 class="subtitulo2 mt-3 mb-2">Notas</h5>
                        <tr>
                            <th class="w-25" scope="row">
                                <div class="notas">{{$paginas[$x]->anotacoes}}</div>
                            </th>
                        </tr>
                    @endif

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


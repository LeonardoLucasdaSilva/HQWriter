@extends('layouts.imprimir')
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
            border: 1px solid black;
        }

        body {
            background-color: white;
        }


    </style>
    <body>
    <div class="container">
        <h3 class="titulo">{{$roteiro->nome}}</h3>
        <h5 class="text-center mt-5 d-inline">por {{$autor}}</h5>
        <hr>
        @for($x=0; $x<count($paginas);$x++)
            <h2 class="subtitulo mt-4">Página {{$teste}} / Quadrinho {{$show+1}}</h2>
            @if($paginas[$x]->plano!="")
                <h4 class="desc">{{$paginas[$x]->plano}}, {{$paginas[$x]->angulo}}</h4>
            @endif
            <h5 class="subtitulo2"><i>Script</i></h5>
            <div class="w-25" scope="row">
                @if($paginas[$x]->conteudo=="")
                    <div class="conteudo mb-2">Script vazio</div>
                @else
                    <div class="conteudo mb-2">{!! html_entity_decode($paginas[$x]->conteudo) !!}</div>
                @endif
            </div>
            <div class="row">
                @if($x<$formatos[$cont]->quadrinhos)
                    @if($x+1 == $formatos[$cont]->quadrinhos)
                        @php
                            $show=-1;
                            $idquadrinho++;
                            $teste++;
                        @endphp
                    @endif
                @else
                    @php
                        $cont++;
                    @endphp
                    @if($formatos[$cont]->quadrinhos-$x==1)
                        @php
                            $idquadrinho++;
                                $teste++;
                        @endphp
                    @endif
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
                        <div class="w-25" scope="row">
                            <div class="notas">{{$paginas[$x]->anotacoes}}</div>
                        </div>
                    @endif



                    @php
                        if($x>=10){
                            $paginaid = strval($paginas[$x]->id).strval($x%$formatos[$cont-1]->quadrinhos);
                            }
                         else if($cont!=0){
                            $paginaid = intval((strval($paginas[$x]->id).strval($x))) - $formatos[$cont-1]->quadrinhos;
                            }

                    @endphp
                    @php
                        $idquadrinho=0;
                        $show++;
                    @endphp
                        <hr>
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







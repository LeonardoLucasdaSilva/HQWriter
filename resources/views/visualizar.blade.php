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
            <button type="button" class="btn btn-outline-dark float-right mb-3" data-toggle="modal" data-target="#downloads">Fazer download</button>
        <hr>
        @for($x=0; $x<count($paginas);$x++)
            <h2 class="subtitulo mt-4">Pagina {{$teste}} / Quadrinho {{$show+1}}</h2>
            @if($paginas[$x]->plano!="")
                <h4 class="desc">{{$paginas[$x]->plano}}, {{$paginas[$x]->angulo}}</h4>
            @endif
            <div class="container bordas mt-1 pt-1 pb-3 pr-4 pl-4 mb-1" style="height:350px;width:25%">

                @if($x<$formatos[$cont]->quadrinhos)
                    @for($y=0;$y<count($formatos[$cont]->rows);$y++)

                        <div class="row mt-1" style="height:{{$formatos[$cont]->rows[$y]->altura}}">
                            @for($z=0;$z<count($formatos[$cont]->rows[$y]->columns);$z++)
                                <div class="col bordas ml-1"
                                     id={{$paginas[$x]->id}}{{$idquadrinho}}></div>
                                @php
                                    $idquadrinho++;
                                @endphp
                            @endfor
                        </div>
                    @endfor
                    @if($x+1 == $formatos[$cont]->quadrinhos)
                        @php
                            $teste++;
                            $show=-1;
                        @endphp
                    @endif
                @else
                    @php

                        $cont++;
                    @endphp
                    @if($formatos[$cont]->quadrinhos-$x==1)
                        @php
                            $teste++;
                        @endphp
                    @endif
                    @for($y=0;$y<count($formatos[$cont]->rows);$y++)
                        <div class="row mt-1" style="height:{{$formatos[$cont]->rows[$y]->altura}}">
                            @for($z=0;$z<count($formatos[$cont]->rows[$y]->columns);$z++)
                                <div class="col bordas ml-1"
                                     id={{$paginas[$x]->id}}{{$idquadrinho}}></div>
                                @php
                                    $idquadrinho++;
                                @endphp
                            @endfor
                        </div>
                    @endfor
                @endif

            </div>
            <h5 class="subtitulo2"><i>Script</i></h5>
            <tr>
                <th class="w-25" scope="row">
                    @if($paginas[$x]->conteudo=="")
                        <div class="conteudo mb-2">Script vazio</div>
                    @else
                        <div class="conteudo mb-2">{!! html_entity_decode($paginas[$x]->conteudo) !!}</div>
                    @endif
                </th>
            </tr>
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
        </div>


        @php

            if($cont!=0 && $x<=($formatos[$cont-1]->quadrinhos-1)){
                    $paginaid = intval((strval($paginas[$x]->id).strval($x))) - $formatos[$cont-1]->quadrinhos;
                if($x>=$formatos[$cont-1]->quadrinhos){
                    $paginaid = strval($paginas[$x]->id).strval($x%$formatos[$cont-1]->quadrinhos);
                    }
            }
        @endphp
        <script>
            @if($cont!=0)
            var cor = document.getElementById('{{$paginas[$x]->id}}{{$x-$formatos[$cont-1]->quadrinhos}}');
            @else
                var cor = null;
                @endif
            if (cor != null) {
                cor.style.backgroundColor = 'red';
            } else {
                var cor = document.getElementById('{{$paginas[$x]->id}}{{$x}}');
                cor.style.backgroundColor = 'red';
                console.log(cor)
            }
        </script>
        @if($cont!=0)
        @endif
        @php
            $idquadrinho=0;
            $show++;
        @endphp
        <hr>
        @endfor
    </div>
    </div>
    <div class="modal fade" id="downloads" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Escolher forma de download</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <a href="{{route('projetos.baixarEco',$roteiro)}}"><button class="btn btn-secondary">Econômico</button></a>
                    <a href="{{route('projetos.baixar',$roteiro)}}"><button class="btn btn-secondary">Normal</button></a>
                </div>
            </div>
        </div>
    </div>

    </body>
    <!--AAAA
    <th class="w-25" scope="row"></th>
    <td class="w-25"></td>
    <td class="w-25"></td>
    <td class="w-25"><a class="mr-auto" href="#"><button class="btn btn-secondary">Visualizar</button></a> -->
@endsection


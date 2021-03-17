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

        .falas {
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
                <h4 class="desc">{{$paginas[$x]->plano}}, {{$paginas[$x]->angulo}}, {{$paginas[$x]->lado}}</h4>
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
                <h5 class="subtitulo2 mb-3 ml-3"><i>Falas</i></h5>
            </div>
            <div class="row">
                <div class="col bordas mt-1 p-3 pt-3 pl-4 mb-1 falas ml-3" style="width:100%">
                    @if($paginas[$x]->falas)
                        @foreach($paginas[$x]->falas as $fala)
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="conteudo mt-3" id="nomeFala"><b>{{$fala->char->nome}}</b></h5>
                                    <small class="conteudo mb-3">Tipo de balão: {{$fala->balao}}</small>
                                    @if($fala->conteudo=="")
                                        <h6 class="conteudo d-block">"Conteúdo vazio"</h6>
                                    @else
                                        <h6 class="conteudo d-block">"{{$fala->conteudo}}"</h6>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if(count($paginas[$x]->falas)==0)
                        <div>Não há falas a serem exibidas</div>
                    @endif

                </div>

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
                    <script>

                        var cor = document.getElementById('{{$paginaid}}');
                        cor.style.borderColor = 'red';
                    </script>
                    <script>

                        var cor = document.getElementById('{{$paginas[$x]->id}}{{$x}}');
                        cor.style.borderColor = 'red';
                    </script>
                    @php
                        $idquadrinho=0;
                        $show++;
                    @endphp
                        <footer style="page-break-after: always;"></footer>
                    @endfor
                </div>
            </div>
            <h3><i>Roteiro feito com HQWriter.</i></h3>
            <h4>ESPECIFICAÇÕES</h4>
            <h5>Nome: {{$roteiro->nome}}</h5>
            <h5>Autor: {{$autor}}</h5>
            <h5>Total de quadrinhos: {{$formatos[$cont]->quadrinhos}}</h5>
            <h5>Total de páginas: {{$teste}}</h5>
    </body>
    <!--AAAA
    <th class="w-25" scope="row"></th>
    <td class="w-25"></td>
    <td class="w-25"></td>
    <td class="w-25"><a class="mr-auto" href="#"><button class="btn btn-secondary">Visualizar</button></a> -->
@endsection







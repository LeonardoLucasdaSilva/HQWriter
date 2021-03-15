@extends('layouts.navbar2')
@section('content')
    <!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <script>

        $(document).ready(function () {
            url = new URL(document.URL);
            pageNumber = url.searchParams.getAll("page");
            $('#page').attr('value', pageNumber);
        });

        function disableAlert() {
            var divalert = document.getElementById('alertdanger')
            divalert.style.display = "none";
        }

        function disableAlert2() {
            var divalert2 = document.getElementById('alertsuccess')
            divalert2.style.display = "none";
        }

        function disableAlert3() {
            var divalert3 = document.getElementById('salvas')
            divalert3.style.display = "none";
        }

        function disableAlert4() {
            var divalert4 = document.getElementById('concluido')
            divalert4.style.display = "none";
        }


    </script>
    <script src='https://cdn.tiny.cloud/1/1kbpbk9iei8czaxs7wjb62vodhrsw67ccrac85lcy2rp5x4z/tinymce/5/tinymce.min.js'
            referrerpolicy="origin">

    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            language: 'pt_BR',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    </script>

    <style>
        a {
            text-decoration: none;
        }

        button {
            text-decoration: none;
        }

        textarea {
            resize: none;
        }

        .fechar {
            font-size: 100%;
            text-decoration: none;
            float: right;
            color: black;
            vertical-align: center;
        }

        .fechar:hover {
            text-decoration: none;
        }

        .dialogos {
            font-size: x-large;
            color: #1b4b72;
        }

    </style>
</head>


<body>
@if($roteiro->is_marvelway==false)
    <div class="container-fluid">
        @else
            <div class="container">
                @endif
                @foreach($pagina as $pag)
                    <form class ="d-inline formpag" action="{{route('projetos.updatePagina',$pag->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        @if($roteiro->is_marvelway==false)
                            <div class="row">
                                <div class="col" style="overflow-y:auto; height:760px;">
                                    <div class="form-group">
                                        @php
                                            $legenda=false;
                                            $fala = false;
                                                for($x=0;$x<count($falas);$x++){
                                                    if($falas[$x]->balao=='legenda'){
                                                        $legenda=true;
                                                    }
                                                    else{
                                                        $fala=true;
                                                    }

                                                }
                                        @endphp
                                        <h5 class="dialogos">Balões </h5>
                                        @if($fala==false)
                                            <h6>Nenhum balão adicionado</h6>
                                        @endif
                                        @for($x=0;$x<count($falas);$x++)
                                            @if($falas[$x]->balao!='legenda')
                                                <hr>
                                                <label
                                                    for="fala[{{$x}}][conteudo]"><b>{{$falas[$x]->char->nome}}</b></label>
                                                <a href="{{route('projetos.removerFala',$falas[$x]->id)}}">
                                                    <button type="button" class="btn float-right d-inline"
                                                            aria-label="Close">
                                                        &times;
                                                    </button>
                                                </a>
                                                <textarea class="form-control mb-2 d-block" rows="3"
                                                          class="conteudo"
                                                          id="fala[{{$x}}][conteudo]"
                                                          name="fala[{{$x}}][conteudo]">{{$falas[$x]->conteudo}}</textarea>
                                                <input type="hidden" id="fala[{{$x}}][id]"
                                                       name="fala[{{$x}}][id]"
                                                       value="{{$falas[$x]->id}}">
                                                <label
                                                    for="fala[{{$x}}][balao]" class="mr-1"><b>Tipo de fala</b></label>
                                                <select name="fala[{{$x}}][balao]" id="fala[{{$x}}][balao]"
                                                        class="form-select">
                                                    <option value="normal"
                                                            @if($falas[$x]->balao=="Normal") selected @endif>Normal
                                                    </option>
                                                    <option value="cochicho"
                                                            @if($falas[$x]->balao=="Cochicho") selected @endif>Cochicho
                                                    </option>
                                                    <option value="pensamento"
                                                            @if($falas[$x]->balao=="Pensamento") selected @endif>
                                                        Pensamento
                                                    </option>
                                                    <option value="grito"
                                                            @if($falas[$x]->balao=="Grito") selected @endif>Grito
                                                    </option>
                                                    <option value="triste"
                                                            @if($falas[$x]->balao=="Triste") selected @endif>Triste
                                                    </option>
                                                    <option value="medo" @if($falas[$x]->balao=="Medo") selected @endif>
                                                        Medo
                                                    </option>
                                                </select>
                                            @endif
                                        @endfor
                                        <hr>
                                        <h5 class="dialogos">Legendas</h5>
                                        @if($legenda==false)
                                            <h6>Nenhuma legenda adicionada</h6>
                                        @endif
                                        @for($x=0;$x<count($falas);$x++)
                                            @if($falas[$x]->balao=='legenda')
                                                <hr>
                                                <label
                                                    for="fala[{{$x}}][conteudo]"><b>{{$falas[$x]->char->nome}}</b></label>
                                                <a href="{{route('projetos.removerFala',$falas[$x]->id)}}">
                                                    <button type="button" class="btn float-right d-inline"
                                                            aria-label="Close">
                                                        &times;
                                                    </button>
                                                </a>
                                                <textarea class="form-control mb-2 d-block" rows="3"
                                                          id="fala[{{$x}}][conteudo]"
                                                          name="fala[{{$x}}][conteudo]">{{$falas[$x]->conteudo}}</textarea>
                                                <input type="hidden" id="fala[{{$x}}][id]"
                                                       name="fala[{{$x}}][id]"
                                                       value="{{$falas[$x]->id}}">
                                            @endif
                                        @endfor
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#criarPersonagem">
                                        <button type="button"
                                                class="mt-2 btn btn-outline-secondary">
                                            Adicionar fala
                                        </button>
                                    </a>
                                </div>
                                @endif
                                @if($roteiro->is_marvelway==false)
                                    <div class="col-8">
                                        @else
                                            <div>
                                                @endif
                                                @if(session('statusFala'))
                                                    @if(session('statusFala')=="Limite de cinco falas por quadrinho atingido!" || session('statusFala')=="Limite de cinco legendas por quadrinho atingido!")
                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                             id="alertdanger" role="alert">
                                                            {{session('statusFala')}}
                                                            <a class="fechar" type="button" onclick='disableAlert()'>
                                                                &times;
                                                            </a>
                                                        </div>
                                                    @elseif(session('statusFala')=="Fala adicionada!" || session('statusFala')=="Legenda adicionada!")
                                                        <div
                                                            class="alert alert-success alert-dismissible fade show"
                                                            id="alertsuccess"
                                                            role="alert">
                                                            {{session('statusFala')}}
                                                            <a class="fechar" type="button" onclick='disableAlert2()'>
                                                                &times;
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if(session('salvas'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                         id="salvas" role="alert">
                                                        {{session('salvas')}}
                                                        <a class="fechar" type="button" onclick='disableAlert3()'>
                                                            &times;
                                                        </a>
                                                    </div>
                                                @endif
                                                @if(session('concluido'))
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                         id="concluido" role="alert">
                                                        {{session('concluido')}}
                                                        <a class="fechar" type="button" onclick='disableAlert4()'>
                                                            &times;
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <textarea class="h-100" id="mytextarea" name="conteudo"
                                                              value="{{$pag->conteudo}}" rows="33">{{$pag->conteudo}}
                                                    </textarea>
                                                    <input type="hidden" id="page" name="page" value="">
                                                </div>
                                            </div>
                                            @if($roteiro->is_marvelway==false)
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="plano"><h5>Planos</h5></label>
                                                        <select class="form-control" id="plano"
                                                                name="plano">
                                                            <option value="panoramico"
                                                                    @if($pag->plano=="Plano panorâmico") selected @endif>
                                                                Plano
                                                                panorâmico
                                                            </option>
                                                            <option value="planogeral"
                                                                    @if($pag->plano=="Plano geral") selected @endif>
                                                                Plano geral
                                                            </option>
                                                            <option value="planoconjunto"
                                                                    @if($pag->plano=="Plano conjunto") selected @endif>
                                                                Plano
                                                                de conjunto
                                                            </option>
                                                            <option value="planomedio"
                                                                    @if($pag->plano=="Plano médio") selected @endif>
                                                                Plano médio
                                                            </option>
                                                            <option value="planoamericano"
                                                                    @if($pag->plano=="Plano americano") selected @endif>
                                                                Plano
                                                                americano
                                                            </option>
                                                            <option value="planomeio"
                                                                    @if($pag->plano=="Meio primeiro plano") selected @endif>
                                                                Meio
                                                                primeiro plano
                                                            </option>
                                                            <option value="primeiroplano"
                                                                    @if($pag->plano=="Primeiro plano") selected @endif>
                                                                Primeiro plano
                                                            </option>
                                                            <option value="primeirissimoplano"
                                                                    @if($pag->plano=="Primeiríssimo plano") selected @endif>
                                                                Primeiríssimo plano
                                                            </option>
                                                            <option value="planodetalhe"
                                                                    @if($pag->plano=="Plano detalhe") selected @endif>
                                                                Plano
                                                                detalhe
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="angulo"><h5>Ângulos</h5></label>
                                                        <select class="form-control" id="angulo"
                                                                name="angulo">
                                                            <option value="normal"
                                                                    @if($pag->angulo=="Normal") selected @endif>
                                                                Normal
                                                            </option>
                                                            <option value="alta"
                                                                    @if($pag->angulo=="Câmera alta (Plongée)") selected @endif>
                                                                Câmera
                                                                alta (Plongée)
                                                            </option>
                                                            <option value="baixa"
                                                                    @if($pag->angulo=="Câmera baixa (Contra-Plongée)") selected @endif>
                                                                Câmera baixa
                                                                (Contra-Plongée)
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <h5 class="mb-3">Extra: </h5>
                                                        <input type="checkbox" id="flashback"
                                                               name="flashback"
                                                               value="flashback"
                                                               @if($pag->is_flashback==true) checked @endif>
                                                        <label for="flashback">Flashback</label><br>
                                                        <input type="checkbox" id="subjetivo"
                                                               name="subjetivo"
                                                               value="subjetivo"
                                                               @if($pag->is_subjetivo==true) checked @endif>
                                                        <label for="subjetivo">Subjetivo</label><br>
                                                        <input type="checkbox" id="impacto" name="impacto"
                                                               value="impacto"
                                                               @if($pag->is_impacto==true) checked @endif>
                                                        <label for="impacto">Quadro de impacto</label><br>
                                                        <input type="checkbox" id="off" name="off"
                                                               value="off"
                                                               @if($pag->is_off==true) checked @endif>
                                                        <label for="off">Off</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="anotacoes"><h5>Anotações</h5></label>
                                                        <textarea class="form-control" rows="11"
                                                                  id="anotacoes"
                                                                  name="anotacoes">{{$pag->anotacoes}}</textarea>
                                                    </div>
                                                </div>
                                            @endif
                                    </div>

                            </div>
                            <button name="teste" value="salvar" type="submit" class="float-right btn btn-outline-success mt-2 d-inline mr-2">Salvar
                            </button>
                @if($numpags==$totalquadrinhos)
                    <button type="submit" name="teste" value="concluido" class="float-left btn btn-outline-success mt-2 d-inline ml-2">Definir como concluído</button>
                    @endif
                        <button type="submit" name="teste" value="novapagina" class="float-right btn btn-outline-secondary mt-2 d-inline mr-1 ml-1">Nova página</button>
                    </form>
                            <form class = "d-inline" action="{{route('projetos.apagarPagina',$pag->id)}}" method="POST">
                                @CSRF
                                @method('DELETE')
                                <button type="submit" class="float-right btn btn-outline-danger mt-2 d-inline mr-1">Apagar página</button>
                            </form>
                    <div class="w-100 text-center d-inline float-right">
                        {{$pagina->links()}}
                    </div>
                @endforeach
            </div>

            <div class="modal fade" id="criarPersonagem" aria-labelledby="criarPersonagemLabel"
                 tabindex="-1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Selecionar personagem</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach($personagens as $personagem)
                                <div class="d-block mb-3">
                                    <span>{{$personagem->nome}} - </span>
                                    <small>"{{$personagem->descricao}}"</small>
                                    <a href="{{route('projetos.removerPersonagem',$personagem->id)}}">
                                        <button type="button" class="btn-sm btn-danger float-right ">
                                            &times;
                                        </button>
                                    </a>
                                    <a href="{{route('projetos.lockFala',['personagem' => $personagem, 'pagina' => $pag, 'tipo' => 'fala'])}}">
                                        <button type="button" class="btn-sm btn-secondary float-right mr-1">Adicionar fala</button>
                                    </a>
                                    <a href="{{route('projetos.lockFala',['personagem' => $personagem, 'pagina' => $pag, 'tipo' => 'legenda'])}}">
                                        <button type="button" class="btn-sm btn-secondary float-right mr-1">Adicionar legenda</button>
                                    </a>
                                </div>
                            @endforeach
                            <a class="m-auto" href="{{route('projetos.criarPersonagem',$pag->roteiro)}}">
                                <button type="button" class="m-auto d-inline btn btn-success">Novo
                                    personagem
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

</body>
</html>
@endsection

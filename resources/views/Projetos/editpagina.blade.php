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

        .bordas {
            border: 0.8px solid black;
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
                    <form class="d-inline formpag" action="{{route('projetos.updatePagina',$pag->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @if($roteiro->is_marvelway==false)
                                <div class="col-2">
                                    <div class="w-75">
                                        <h5>Quadrinho {{$editando}} / Página {{$currentPage}}</h5>
                                        <div class="container w-100 bordas" style="height: 300px;">
                                            @for($y=0;$y<count($formato->rows);$y++)
                                                <div class="row"
                                                     style="height:{{$formato->rows[$y]->altura}}; margin-top: 2.5px;">
                                                    @for($z=0;$z<count($formato->rows[$y]->columns);$z++)
                                                        <div class="col bordas"
                                                             style="margin-left: 2px;
                                                             @if($z==count($formato->rows[$y]->columns)-1) margin-right: 2px;

                                                             @endif"
                                                             id={{$idquadrinho}}></div>
                                                        @php
                                                            $idquadrinho++;
                                                        @endphp
                                                    @endfor
                                                </div>
                                            @endfor
                                            <div class="row mt-2">
                                                <button class="btn btn-outline-dark" name="teste"
                                                        value="editarformatacoes" type="submit">Editar formatações
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    @else
                                        <div class="w-100">
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
                                                    <textarea class="form-control" rows="15"
                                                              id="anotacoes"
                                                              name="anotacoes">{{$pag->anotacoes}}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                </div>

                        </div>
                        @if($numpags==$totalquadrinhos)
                            <button type="submit" name="teste" value="concluido"
                                    class="float-right btn btn-outline-success mt-2 d-inline mr-1">Definir como
                                concluído
                            </button>
                        @endif
                        @if($roteiro->is_marvelway==true)
                            <button type="submit" name="teste" value="concluido"
                                    class="float-right btn btn-outline-success mt-2 d-inline mr-1">Definir como
                                concluído
                            </button>
                        @endif
                        <button name="teste" value="salvar" type="submit"
                                class="float-right btn btn-outline-success mt-2 d-inline mr-1">Salvar
                        </button>
                        <button type="submit" name="teste" value="novapagina"
                                class="float-right btn btn-outline-secondary mt-2 d-inline mr-1 ml-1">Novo quadrinho
                        </button>
                        <div class="d-inline container w-50 float-left" style="margin-left: 16%">
                            <h5 class="d-inline mr-1 mb-3">Quadrinhos</h5>
                            <div
                                style="height:60px;width:100%; overflow-x: auto;  white-space: nowrap; border: 1px solid gray; border-radius: 5px">
                                @for($x=0;$x<count($allpaginas);$x++)
                                    <span><button type="submit"
                                                  class="btn btn-outline-secondary d-inline ml-1 mt-2"
                                                  name="teste" id="{{$x+30}}" value="{{$x+1}}">{{$x+1}}</button></span>
                                @endfor
                            </div>
                        </div>
                    </form>
                    <form action="{{route('projetos.apagarPagina',$pag->id)}}" method="POST">
                        @CSRF
                        @method('DELETE')
                        <button type="submit" class="float-right btn btn-outline-danger mt-2">Apagar quadrinho
                        </button>
                    </form>
                    <div class="w-100 text-center d-inline float-right">
                        {{$pagina->links()}}
                    </div>
                @endforeach
            </div>

</body>
<script>
    var vermelho = document.getElementById('{{$editando}}');
    vermelho.style.backgroundColor = 'red';
    var teste = document.getElementById('{{$pagina->firstItem()+29}}');
    teste.classList.remove('btn-outline-secondary');
    teste.classList.add('btn-secondary');
    console.log(teste);
</script>
</html>
@endsection

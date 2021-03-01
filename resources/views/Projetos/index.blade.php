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
                <h3 class="projetos">
                    Projetos em aberto
                </h3>
            </div>
            <div class="col-sm">
                <a href="#" data-toggle="modal" data-target="#criarProjeto">
                    <button type="button" class="btn btn-outline-secondary float-right mt-2">Novo Projeto</button>
                </a>
            </div>
        </div>
        <hr>
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">NOME</th>
                <th scope="col">MODIFICADO EM</th>
                <th scope="col">QUADRINHOS</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($abertos as $aberto)
                <tr>
                    <th class="w-25" scope="row">{{$aberto->nome}}</th>
                    <td class="w-25">{{$aberto->updated_at->format('d/m/Y')}}</td>
                    <td class="w-25">{{$aberto->numpag}}</td>
                    <td class="w-25">
                        <a href="{{route('projetos.editPagina',$aberto->id)}}">
                            <button type="button" class=" justify-content-center btn btn-outline-success">
                                Editar
                            </button>
                        </a>
                        <a href="{{route('projetos.edit',$aberto->id)}}">
                            <button type="button" class="justify-content-center btn btn-outline-secondary">
                                Redefinir
                            </button>
                        </a>
                        <form action="{{route('projetos.destroy',$aberto->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Deseja realmente excluir o roteiro {{$aberto->nome}}?')"
                                    class=" justify-content-center btn btn-outline-danger">
                                Excluir
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <h3 class="projetos">
            Projetos finalizados
        </h3>
        <hr>
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">NOME</th>
                <th scope="col">MODIFICADO EM</th>
                <th scope="col">QUADRINHOS</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($concluidos as $concluido)
                <tr>
                    <th class="w-25" scope="row">{{$concluido->nome}}</th>
                    <td class="w-25">{{$concluido->updated_at->format('d/m/Y')}}</td>
                    <td class="w-25">{{$concluido->numpag}}</td>
                    <td class="w-25"><a class="mr-auto" href="{{route('projetos.visualizarRoteiro',$concluido)}}}"><button class="btn btn-secondary">Visualizar</button></a>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!--Modals-->
    <!--Modal Criar-->

    <div class="modal fade" id="criarProjeto" aria-labelledby="criarProjetoLabel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo roteiro</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">+
                    </button>
                </div>
                <form action="{{route('projetos.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h5>Título: </h5><br>
                            <input type="text" class="form-control" name="nome" placeholder="Digite o nome"
                                   required><br>
                        </div>
                        <div class="form-group">
                            <h5>Gêneros: </h5><br>
                            @foreach($generos as $genero)
                                <input type="checkbox" id="{{$genero->id}}" name="generos[]" value="{{$genero->id}}">
                                <label for="{{$genero->id}}">{{$genero->nome}}</label><br>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <h5>Tipo: </h5><br>
                            <input type="radio" id="marvelway" name="tipo" value="marvelway" required>
                            <label for="marvelway">Marvel way</label><br>
                            <input type="radio" id="fullscript" name="tipo" value="fullscript" required>
                            <label for="fullscript"><i>Full-script</i></label><br>
                        </div>
                        <div class="form-group">
                            <h5>Visibilidade: </h5><br>
                            <input type="radio" id="privado" name="visibilidade" value="privado" required>
                            <label for="privado">Privado</label><br>
                            <input type="radio" id="publico" name="visibilidade" value="publico" required>
                            <label for="publico">Público</label><br>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-primary">Criar roteiro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

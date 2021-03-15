@extends('layouts.navbar2')
@section('content')
    <h3 class="m-auto text-center">Formatação - Página {{$numformatos+1}}</h3>
    <!--<form action="" method="POST">
            arroba csrf
            <div class="form-group">
                <label for="nome">Linhas</label>
                <input class="form-control" type="number" id="linhas" name="linhas" required>
            </div>
            <div class="form-group">
                <label for="nome">Colunas</label>
                <input class="form-control" type="number" id="colunas" name="colunas" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar formato</button>
        </form>
    </div>
    -->
    <head>
        <style>
            .bordas {
                border: 1px solid black;
            }
        </style>
        <script>
            var linhas = [];
            var colunas = [];
            var botoes = [];
            var botoes2 = [];
            var rowsadicionar = [];
            var rowsremover = [];
            var format = [];
            function adicionarLinha() {
                if (linhas.length == 0) {
                    var canvas = document.getElementById('canvas');
                    var linha = document.createElement("div");
                    var coluna = document.createElement("div");
                    var botao = document.createElement("button");
                    var botao2 = document.createElement("button");
                    var colremover = document.getElementById('colremover');
                    var rowremover = document.createElement("div");
                    var coladicionar = document.getElementById('coladicionar');
                    var rowadicionar = document.createElement("div");
                    botoes[0] = botao;
                    botoes[0].setAttribute("onClick","adicionarQuadrinho(0)");
                    botoes[0].classList.add('btn');
                    botoes[0].classList.add('btn-outline-dark');
                    botoes[0].classList.add('m-auto');
                    botoes[0].style.height="50px";
                    botoes[0].style.width="100%";
                    botoes[0].style.verticalAlign = "center";
                    botoes[0].innerHTML = "Adicionar quadrinho";
                    botoes2[0] = botao2;
                    botoes2[0].setAttribute("onClick","removerQuadrinho(0)");
                    botoes2[0].classList.add('btn');
                    botoes2[0].classList.add('btn-outline-dark');
                    botoes2[0].classList.add('m-auto');
                    botoes2[0].style.height="50px";
                    botoes2[0].style.width="100%";
                    botoes2[0].style.verticalAlign = "center";
                    botoes2[0].innerHTML = "Remover quadrinho";
                    rowsadicionar[0] = rowadicionar;
                    rowsadicionar[0].classList.add('row');
                    rowsadicionar[0].style.height="100%";
                    rowsadicionar[0].appendChild(botao);
                    rowsadicionar[0].id = 'colunaadicionar1';
                    rowsremover[0] = rowremover;
                    rowsremover[0].classList.add('row');
                    rowsremover[0].style.height="100%";
                    rowsremover[0].appendChild(botao2);
                    rowsremover[0].id = 'colunaremover1';
                    colremover.appendChild(rowremover);
                    coladicionar.appendChild(rowadicionar);
                    linhas[0] = linha;
                    colunas[0] = coluna;
                    linhas[0].classList.add('row');
                    linhas[0].classList.add('mr-1');
                    linhas[0].classList.add('ml-1');
                    linhas[0].classList.add('mb-2');
                    linhas[0].style.height = "100%";
                    linhas[0].id = 'linha1';
                    colunas[0].classList.add('bordas');
                    colunas[0].classList.add('col');
                    colunas[0].classList.add('quadrinholinha0');
                    colunas[0].id = 'coluna1linha1';
                    format[1] = 1;
                    var formato = document.getElementById('format');
                    formato.value = format;
                    linha.appendChild(coluna);
                    canvas.appendChild(linha);
                }
                else if(linhas.length>0 && linhas.length<5) {
                    var canvas = document.getElementById('canvas');
                    var linha = document.createElement("div");
                    var coluna = document.createElement("div");
                    var botao = document.createElement("button");
                    var botao2 = document.createElement("button");
                    var colremover = document.getElementById('colremover');
                    var rowremover = document.createElement("div");
                    var coladicionar = document.getElementById('coladicionar');
                    var rowadicionar = document.createElement("div");
                    botoes[botoes.length] = botao;
                    botoes[botoes.length-1].setAttribute("onClick","adicionarQuadrinho("+(linhas.length)+")");
                    botoes[botoes.length-1].classList.add('btn');
                    botoes[botoes.length-1].classList.add('btn-outline-dark');
                    botoes[botoes.length-1].classList.add('m-auto');
                    botoes[botoes.length-1].style.height="50px";
                    botoes[botoes.length-1].style.width="100%";
                    botoes[botoes.length-1].style.verticalAlign = "center";
                    botoes[botoes.length-1].innerHTML = "Adicionar quadrinho";
                    botoes2[botoes2.length] = botao2;
                    botoes2[botoes2.length-1].setAttribute("onClick","removerQuadrinho("+(linhas.length)+")");
                    botoes2[botoes2.length-1].classList.add('btn');
                    botoes2[botoes2.length-1].classList.add('btn-outline-dark');
                    botoes2[botoes2.length-1].classList.add('m-auto');
                    botoes2[botoes2.length-1].style.height="50px";
                    botoes2[botoes2.length-1].style.width="100%";
                    botoes2[botoes2.length-1].style.verticalAlign = "center";
                    botoes2[botoes2.length-1].innerHTML = "Remover quadrinho";
                    rowsadicionar[rowsadicionar.length] = rowadicionar;
                    rowsadicionar[rowsadicionar.length - 1].classList.add('row');
                    rowsadicionar[rowsadicionar.length - 1].appendChild(botao);
                    rowsadicionar[rowsadicionar.length - 1].id = 'colunaadicionar'+rowsadicionar.length;
                    rowsremover[rowsremover.length] = rowremover;
                    rowsremover[rowsremover.length - 1].classList.add('row');
                    rowsremover[rowsremover.length - 1].appendChild(botao2);
                    rowsremover[rowsremover.length - 1].id = 'colunaremover'+rowsremover.length;
                    colremover.appendChild(rowremover);
                    coladicionar.appendChild(rowadicionar);
                    linhas[linhas.length] = linha;
                    format[linhas.length] = 1;
                    colunas[0] = coluna;
                    var altura = 100 / linhas.length - 1;
                    for (var z = 0; z < rowsremover.length; z++) {
                        rowsremover[z].style.height = altura +"%";
                    }
                    for (var y = 0; y < rowsadicionar.length; y++) {
                        rowsadicionar[y].style.height = altura +"%";
                    }
                    linhas[linhas.length - 1].classList.add('row');
                    linhas[linhas.length - 1].classList.add('mr-1');
                    linhas[linhas.length - 1].classList.add('ml-1');
                    linhas[linhas.length - 1].classList.add('mb-2');
                    colunas[colunas.length - 1].classList.add('bordas');
                    colunas[colunas.length - 1].classList.add('col');
                    colunas[colunas.length - 1].classList.add('quadrinholinha'+(linhas.length-1));
                    linhas[linhas.length - 1].id = 'linha' + linhas.length;
                    colunas[colunas.length - 1].id = 'coluna1linha' + linhas.length;
                    format[linhas.length] = 1;
                    var formato = document.getElementById('format');
                    formato.value = format;
                    for (var x = 0; x < linhas.length; x++) {
                        linhas[x].style.height = altura + "%";
                    }
                    linha.appendChild(coluna);
                    canvas.appendChild(linha);
                }
                else{
                    alert('Limite de 5 linhas atingido');
                }
            }

            function removerLinha() {
                var canvas = document.getElementById('canvas');
                var linhaRemovida = document.getElementById('linha' + linhas.length);
                var linhaBotao = document.getElementById('colunaadicionar' + linhas.length);
                var linhaBotao2 = document.getElementById('colunaremover' + linhas.length);
                var coladicionar = document.getElementById('coladicionar');
                var colremover = document.getElementById('colremover');
                coladicionar.removeChild(linhaBotao);
                colremover.removeChild(linhaBotao2);
                canvas.removeChild(linhaRemovida);
                rowsadicionar.pop();
                rowsremover.pop()
                linhas.pop();
                format.pop();
                var altura = 100 / linhas.length - 1;
                for (var z = 0; z < rowsremover.length; z++) {
                    rowsremover[z].style.height = altura +"%";
                }

                for (var y = 0; y < rowsadicionar.length; y++) {
                    rowsadicionar[y].style.height = altura +"%";
                }

                for (var x = 0; x < linhas.length; x++) {
                    linhas[x].style.height = altura + "%";
                }

            }
            function adicionarQuadrinho(linha){
                var tamanho = document.getElementsByClassName('quadrinholinha'+linha).length;
                if(tamanho<5) {
                    var linhaselecionada = document.getElementById('linha' + (linha + 1));
                    var quadrinho = document.createElement("div");
                    quadrinho.classList.add('bordas');
                    quadrinho.classList.add('col');
                    quadrinho.classList.add('quadrinholinha' + linha);
                    quadrinho.classList.add('ml-2');
                    linhaselecionada.appendChild(quadrinho);
                    format[linha+1]++;
                    var formato = document.getElementById('format');
                    formato.value = format;
                }
                else{
                    alert('Limite máximo de 5 quadrinhos por linha atingido');
                }
            }

            function removerQuadrinho(linha){
                var tamanho = document.getElementsByClassName('quadrinholinha'+linha).length;
                if(tamanho!=1) {
                    var linhaselecionada = document.getElementById('linha' + (linha + 1));
                    var l = linhaselecionada.lastChild;
                    linhaselecionada.removeChild(l);
                    format[linha+1]--;
                    var formato = document.getElementById('format');
                    formato.value = format;
                }
                else{
                    alert('Não é possível remover o último quadrinho da linha');
                }
            }
        </script>
    </head>
    <div class="container w-100 mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-2 mt-5" id="colremover" style="height: 730px">
            </div>
            <div class="col-7">
                <button class="btn btn-outline-dark m-auto d-flex justify-content-center mb-1" onclick="removerLinha()">
                    Remover
                    linha
                </button>
                <div id="canvas" class="container w-100 bordas p-3 pl-3 pr-3 mt-1 mb-1" style="height: 730px">
                </div>
                <button class="btn btn-outline-dark m-auto d-flex justify-content-center mt-1" onclick="adicionarLinha()">
                    Adicionar
                    linha
                </button>
            </div>


            <div class="col-2 mt-5" id="coladicionar" style="height: 730px">
            </div>
        </div>
    </div>
        <form action="{{route('projetos.novoFormato',$id)}}" method="POST">
            @csrf
        <input type="hidden" id="format" name="format" value="">
            <button class = "float-right text-center btn-sm btn-outline-dark d-inline mr-5" type="submit" >Salvar formato</button>
    </form>

@endsection

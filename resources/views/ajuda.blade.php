@extends('layouts.navbar2')
@section('content')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&family=Quicksand:wght@300&display=swap"
          rel="stylesheet">

    <style>
        h3 {
            font-family: Quicksand;
            font-size: 220%;
            margin-bottom: -0.5%;
        }
    </style>

    <div class="m-auto w-75">
        <h3>
            Como usar o sistema?
        </h3>
        <hr>
        <div>
            <h4>
                Como escrever um roteiro?
            </h4>
            <p>
                Para escrever um roteiro, vá a "Meus projetos"->"Novo Projeto", e informe as definições do seu roteiro!
                <br>
                Como início da sua história, você deve selecionar a formatação inicial do seu roteiro.
            </p>
            <h4>
                Formatações
            </h4>
            <p>
                Na tela de formatação, você pode controlar a quantidade de quadrinhos de sua página, usando dos botões
                adicionar linha, e adicionar quadrinhos correspondentes.
                <br>
                Além disso, você pode adicionar uma breve descrição à sua página, caso queira.
                <br>
                Para editá-las, você precisa ir a "Meus projetos"->"Editar"->"Editar formatações".
                <br>
                Após isso, basta configurar como desejar.
                <br>
                Para editá-lo, basta ir a "Meus projetos"->"Editar".
                <br>
                Dentro da tela de edição, é possível que você possa alterar as informações de cada quadrinho, criar
                novos
                quadrinhos e editar as formatações.
            </p>
            <h4>
                Como adicionar novos quadrinhos?
            </h4>
            <p>
                Para adicionar um novo quadrinho, você deve ir a "Meus projetos"->"Editar"->"Novo quadrinho".
                <br>
                O sistema direcionará você ao seu novo quadro, e você poderá editá-lo ali mesmo.
                <br>
                Aviso: Quando você atingir a quantidade de quadrinhos das suas formatações, você poderá concluí-lo.
            </p>
            <h4>
                Visualizando roteiros
            </h4>
            <p>
                Para visualizar os seus roteiros,"Meus projetos", e na aba "Projetos concluídos" -> Visualizar
                <br>
                Para visualizar projetos públicos, entre em "Painel de Roteiros", e selecione o gênero o qual você deseja ver
                <br>
                Dentro da visualização dos projetos, você também pode imprimí-los, clicando em "Fazer download", e selecionando a opção desejada.
            </p>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <html>
        <head>
            <!--Fonts -->
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">

            <style>
                .a{
                    display:table-cell;
                    text-align: center;
                    vertical-align: middle;
                }
                h1{
                    color: black;
                    font-family: 'Open Sans', sans-serif;
                    font-size: 600%;
                    opacity: 1;
                }
                h3{
                    display: block;
                    color: black;
                    font-family: 'Caveat', cursive;
                    font-size: 300%;
                    opacity: 1;
                }
                #sec1 {
                    background: url('https://media.discordapp.net/attachments/320612371334823938/821151990884859945/home.jpg?width=1199&height=681') no-repeat center center fixed;
                    display:table;
                    height: 100%;
                    position: relative;
                    width: 100%;
                    background-size: cover;
                    padding: 18vw;
                    margin-top:-25px;
                    opacity: 0.85;
                }
            </style>
        </head>
    <body>
        <div id="sec1">
            <div class="a">
                <h1>Crie. Escreva. Espalhe novas ideias.</h1>
                <h3 id="sub">Solte sua imaginação com o HQWriter</h3>
            </div>
        </div>
    </body>
    </html>
@endsection

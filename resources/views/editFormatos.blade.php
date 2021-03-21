@extends('layouts.navbar2')
@section('content')
    <head>
        <style>

            .bordas {
                border: 1px solid black;
            }

        </style>
    </head>
    <div class="container w-25">
        @if(count($formatos)==0)
            <h4 class="mt-5">Este roteiro não possui nenhum formato</h4>
        @endif
            @for($x=0;$x<count($formatos);$x++)
                <h4>Página {{$x+1}}</h4> <a href="{{route('projetos.selectformato',$formatos[$x]->id)}}"><button class="btn-sm btn-outline-dark mb-2">Editar</button></a><a href="{{route('projetos.excluirformato',$formatos[$x]->id)}}"><button class="btn-sm btn-outline-danger mb-2 ml-2">Excluir</button></a>
            <div class="col w-100 bordas" style="height: 600px">
                @for($y=0;$y<count($formatos[$x]->rows);$y++)
                    <div class="row mt-1" style="height:{{$formatos[$x]->rows[$y]->altura}}">
                        @for($z=0;$z<count($formatos[$x]->rows[$y]->columns);$z++)
                            <div class="col bordas ml-1 @if($z==count($formatos[$x]->rows[$y]->columns)-1)mr-1 @endif"></div>
                        @endfor
                    </div>
                @endfor
            </div>
                <hr>
            @endfor
    </div>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Genero_Roteiro;
use App\Models\Pagina;
use App\Models\Roteiro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PainelController extends Controller
{
    public function index()
    {
        $publicos = Roteiro::where('is_public', true)->where('is_concluido', true)->with('paginas')->get();
        foreach ($publicos as $publico) {
            $publico->numpag = $publico->paginas->count();
            $publico->generos_selecionados = $publico->generos;
            $publico->autor = $publico->user->name;

        }

        $generos = Genero::all();
        return view('Painel.index', compact('generos', 'publicos'));
    }

    public function visualizarGenero($id)
    {
        $publicosteste=null;
        $genero = Genero::where('id',$id)->first();
        for($x=0;$x<count($genero->roteiros);$x++){
            if($genero->roteiros[$x]->is_public==true && $genero->roteiros[$x]->is_concluido==true){
                $publicos[]=$genero->roteiros[$x];
                $publicosteste=1;
            }
        }

        if($publicosteste!=null) {
            foreach ($publicos as $publico) {
                $publico->numpag = $publico->paginas->count();
                $publico->generos_selecionados = $publico->generos;
                $publico->autor = $publico->user->name;
            }
        }
        else{
            $publicos=null;
        }
        $generos = Genero::all();
        return view('Painel.index', compact('generos', 'publicos'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

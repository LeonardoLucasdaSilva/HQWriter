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

class ProjetosController extends Controller
{
    public function index()
    {
        $concluidos = Roteiro::where('user_id', Auth::user()->id)->where('is_concluido', true)->with('paginas')->get();
        $abertos = Roteiro::where('user_id', Auth::user()->id)->where('is_concluido', false)->with('paginas')->get();
        foreach ($abertos as $aberto) {
            $aberto->numpag = $aberto->paginas->count();
        }
        foreach ($concluidos as $concluido) {
            $concluido->numpag = $concluido->paginas->count();
        }
        $generos = Genero::all();
        return view('projetos.index', compact('generos', 'concluidos', 'abertos'));
    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $roteiro = new Roteiro();
        $roteiro->nome = $request->nome;
        if ($request->tipo == "marvelway") {
            $is_marvelway = 1;
        } else {
            $is_marvelway = 0;
        }
        if ($request->visibilidade == "privado") {
            $is_public = 0;
        } else {
            $is_public = 1;
        }
        $roteiro->user_id = Auth::id();
        $roteiro = [
            'nome' => $request->nome,
            'is_marvelway' =>$is_marvelway,
            'is_public'=>$is_public,
            'is_concluido'=>0
        ];
        $pagina = [
            'conteudo'=> "",
        ];
        $roteiro = Auth::user()->roteiros()->create($roteiro);
        $roteiro->paginas()->create($pagina)->save();
        $roteiro->generos()->attach($request->generos);
        $roteiro->save();
        return redirect()->route('projetos.index');
    }

    public function novaPagina($id)
    {
        $roteiros = Roteiro::where('id', $id)
            ->get();
        $roteiro = $roteiros[0];
        $pagina = [
            'conteudo'=> "",
        ];
        $roteiro->paginas()->create($pagina)->save();
        $numpags = $roteiro->paginas()->count();
        return redirect('projetos/editar/'.$id.'?page='.$numpags);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $generos = Genero::all();
        $roteiros = Roteiro::where('id', $id)
            ->get();
        $roteiro = $roteiros[0];
        for ($x = 0; $x < 4; $x++) {
            $is_selected[$x] = "";
        }
        $generos_selecionados = Genero_Roteiro::where('roteiro_id', $id)
            ->get('genero_id');
        for ($x = 0; $x <= sizeof($generos); $x++) {
            $is_selected_generos[$x] = "";
        }
        for ($x = 0; $x < sizeof($generos_selecionados); $x++) {
            $is_selected_generos[$generos_selecionados[$x]->genero_id] = "checked";
        }
        for ($x = 0; $x < 4; $x++) {
            $is_selected[$x] = "";
        }
        if ($roteiro->is_public) {
            $is_selected[0] = "checked";
        } else {
            $is_selected[1] = "checked";
        }
        if ($roteiro->is_marvelway) {
            $is_selected[2] = "checked";
        } else {
            $is_selected[3] = "checked";
        }
        return view('projetos.edit', compact('generos', 'roteiro', 'is_selected', 'is_selected_generos'));
    }

    public function editPagina($id)
    {
        $roteiros = Roteiro::where('id', $id)
            ->get();
        $roteiro = $roteiros[0];
        $pagina = $roteiro->paginas()->paginate(1);
        return view('Projetos.editpagina',compact('pagina'));
    }

    public function updatePagina(Request $request, $id)
    {
        $pagina = Pagina::where('id', $id)->first();
        $pagina->conteudo = $request->conteudo;
        $pagina->save();
        return redirect('projetos/editar/'.$pagina->roteiro->id.'?page='.$request->page);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $roteiro_update)
    {
        $roteiro = Roteiro::where('id', $roteiro_update)->first();
        $roteiro->nome = $request->nome;
        if ($request->tipo == "marvelway") {
            $roteiro->is_marvelway = 1;
        } else {
            $roteiro->is_marvelway = 0;
        }
        if ($request->visibilidade == "privado") {
            $roteiro->is_public = 0;
        } else {
            $roteiro->is_public = 1;
        }
        $roteiro->user_id = Auth::id();
        $roteiro->is_concluido = 0;
        $roteiro->save();
        $roteiro->generos()->sync($request->generos);
        return redirect()->route('projetos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function apagarPagina($id)
    {
        $pagina = Pagina::findOrFail($id);
        $idroteiro = $pagina->roteiro->id;
        $numpags = $pagina->roteiro->paginas()->count();
        if($numpags>1) {
            $pagina->delete();
        }
        return redirect('projetos/editar/'.$idroteiro.'?page=1');
    }

    public function visualizarRoteiro(Roteiro $roteiro)
    {
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->get();
        $titulo = $roteiro->nome;
        return view('visualizar',compact('paginas','titulo'));
    }

    public function destroy($id)
    {
        $roteiro = Roteiro::findOrFail($id);
        $roteiro->delete();
        return redirect()->route('projetos.index');
    }
}

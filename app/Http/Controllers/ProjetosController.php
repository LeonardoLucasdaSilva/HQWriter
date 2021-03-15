<?php

namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Column;
use App\Models\Fala;
use App\Models\Format;
use App\Models\Genero;
use App\Models\Genero_Roteiro;
use App\Models\Pagina;
use App\Models\Roteiro;
use App\Models\Row;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
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
        return view('Projetos.index', compact('generos', 'concluidos', 'abertos'));
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
            'is_marvelway' => $is_marvelway,
            'is_public' => $is_public,
            'is_concluido' => 0
        ];
        $pagina = [
            'conteudo' => "",
            'plano' => "",
            'angulo' => "",
            'lado' => "",
            'anotacoes' => "",
            'is_flashback' => false,
            'is_subjetivo' => false,
            'is_impacto' => false,
            'is_off' => false,
        ];
        $roteiro = Auth::user()->roteiros()->create($roteiro);
        $roteiro->paginas()->create($pagina)->save();
        $roteiro->generos()->attach($request->generos);
        $roteiro->save();
        $id = $roteiro->id;
        return redirect()->action(
            [ProjetosController::class, 'editPagina'], ['pagina' => $id]
        );
    }

    public function novaPagina($id)
    {
        $roteiros = Roteiro::where('id', $id)
            ->get();
        $roteiro = $roteiros[0];
        $pagina = [
            'conteudo' => "",
            'plano' => "",
            'angulo' => "",
            'lado' => "",
            'anotacoes' => "",
            'is_flashback' => false,
            'is_subjetivo' => false,
            'is_impacto' => false,
            'is_off' => false,
        ];
        $roteiro->paginas()->create($pagina)->save();
        $numpags = $roteiro->paginas()->count();
        return redirect('projetos/editar/' . $id . '?page=' . $numpags);

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
        return view('Projetos.edit', compact('generos', 'roteiro', 'is_selected', 'is_selected_generos'));
    }

    public function editPagina($id)
    {
        $roteiros = Roteiro::where('id', $id)->get();
        $roteiro = $roteiros[0];
        $pagina = $roteiro->paginas()->orderBy('id')->paginate(1);
        $personagens = $roteiro->chars()->get();
        $falas = $pagina[0]->falas()->get();
        $numpags = $roteiro->paginas()->count();

        $formatos = $roteiro->formats()->get();
        $numformatos = count($formatos);
        if(count($roteiro->formats()->get())>0) {
            $totalquadrinhos = $formatos[count($roteiro->formats()->get())-1]->quadrinhos;
        }
        else{
            $totalquadrinhos = 0;
        }
        if ($roteiro->formats()->count() == 0 && $numpags == 1 || $totalquadrinhos < $numpags) {
            return view('createFormato', compact('id', 'numformatos'));
        }
        return view('Projetos.editpagina', compact('pagina', 'roteiro', 'personagens', 'falas','totalquadrinhos','numpags'));
    }

    public function updatePagina(Request $request, $id)
    {
        $pagina = Pagina::where('id', $id)->first();
        switch ($request->plano) {
            case "panoramico":
                $pagina->plano = "Plano panorâmico";
                break;
            case "planogeral":
                $pagina->plano = "Plano geral";
                break;
            case "planoconjunto":
                $pagina->plano = "Plano conjunto";
                break;
            case "planomedio":
                $pagina->plano = "Plano médio";
                break;
            case "planoamericano":
                $pagina->plano = "Plano americano";
                break;
            case "planomeio":
                $pagina->plano = "Meio primeiro plano";
                break;
            case "primeiroplano":
                $pagina->plano = "Primeiro plano";
                break;
            case "primeirissimoplano":
                $pagina->plano = "Primeiríssimo plano";
                break;
            case "planodetalhe":
                $pagina->plano = "Plano detalhe";
                break;
        }

        switch ($request->angulo) {
            case "normal":
                $pagina->angulo = "Normal";
                break;
            case "alta":
                $pagina->angulo = "Câmera alta (Plongée)";
                break;
            case "baixa":
                $pagina->angulo = "Câmera baixa (Contra-Plongée)";
                break;
        }

        switch ($request->lado) {
            case "frontal":
                $pagina->lado = "Frontal";
                break;
            case "tresquartos":
                $pagina->lado = "3/4";
                break;
            case "perfil":
                $pagina->lado = "Perfil";
                break;
            case "denuca":
                $pagina->lado = "De nuca";
                break;
        }

        if ($request->flashback) {
            if ($request->flashback == "flashback") {
                $pagina->is_flashback = true;
            }
        } else {
            $pagina->is_flashback = false;
        }


        if ($request->subjetivo) {
            if ($request->subjetivo == "subjetivo") {
                $pagina->is_subjetivo = true;
            }
        } else {
            $pagina->is_subjetivo = false;
        }

        if ($request->impacto) {
            if ($request->impacto == "impacto") {
                $pagina->is_impacto = true;
            }
        } else {
            $pagina->is_impacto = false;
        }

        if ($request->off) {
            if ($request->off == "off") {
                $pagina->is_off = true;
            }
        } else {
            $pagina->is_off = false;
        }

        if ($request->conteudo) {
            $pagina->conteudo = $request->conteudo;
        } else {
            $pagina->anotacoes = "";
        }
        if ($request->anotacoes) {
            $pagina->anotacoes = $request->anotacoes;
        } else {
            $pagina->anotacoes = "";
        }
        if ($request->fala) {
            foreach ($request->fala as $fala) {
                $newFala = Fala::where('id', $fala['id'])->first();
                if ($fala['conteudo'] != null) {
                    $newFala->conteudo = $fala['conteudo'];
                } else {
                    $newFala->conteudo = "";
                }

                switch ($fala['balao']) {
                    case "normal":
                        $newFala->balao = "Normal";
                        break;
                    case "cochicho":
                        $newFala->balao = "Cochicho";
                        break;
                    case "grito":
                        $newFala->balao = "Grito";
                        break;
                    case "triste":
                        $newFala->balao = "Triste";
                        break;
                    case "pensamento":
                        $newFala->balao = "Pensamento";
                        break;
                    case "medo":
                        $newFala->balao = "Medo";
                        break;
                }

                $newFala->save();
            }
        }
        $pagina->save();
        switch($request->teste){
            case "salvar":
                return redirect()->back();
            case "novapagina":
                return redirect()->route('Projetos.novaPagina',$pagina->roteiro->id);
            case "concluido":
                return redirect()->route('Projetos.concluir',$pagina->roteiro->id);
        }

        return redirect()->back()->with('salvas', 'Alterações salvas com sucesso!');
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
        return redirect()->route('Projetos.index');
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
        if ($numpags > 1) {
            $pagina->delete();
        }
        return redirect('projetos/editar/' . $idroteiro . '?page=1');
    }

    public function visualizarRoteiro(Roteiro $roteiro)
    {
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->get();
        $queryautor = User::where('id', $roteiro->user_id)->get();
        $autor = $queryautor[0]->name;
        foreach ($paginas as $pagina) {
            $pagina->falas = $pagina->falas()->get();
        }
        $formatos = $roteiro->formats()->get();
        $cont = 0;
        $idquadrinho = 0;
        $paginaid = 0;
        $teste = 1;
        $a = 0;
        $show = 0;
        return view('visualizar', compact('paginas', 'roteiro', 'autor', 'formatos', 'cont','idquadrinho','paginaid','teste','a','show'));
    }

    public function criarPersonagem(Roteiro $roteiro)
    {
        return view('personagem', compact('roteiro'));
    }

    public function novoPersonagem(Request $request, $roteiro)
    {
        $personagem = new Char();
        $personagem->nome = $request->nome;
        $personagem->descricao = $request->descricao;
        $personagem->roteiro_id = $roteiro;
        $personagem->save();
        return redirect('projetos/editar/' . $roteiro . '?page=1');
    }

    public function novoFormato(Request $request, $roteiro)
    {
        $roteiro = Roteiro::where('id',$roteiro)->first();
        $formato = new Format();
        $formato->roteiro_id = $roteiro->id;
        $formato->quadrinhos = 0;
        $formato->save();
        $linhas = explode(',', $request->format);
        for ($x = 1; $x < count($linhas); $x++) {
            $linha = new Row();
            $linha->format_id = $formato->id;
            $altura = (100 / (count($linhas) - 1)) - 1;
            $linha->altura = $altura . '%';
            $linha->save();
            for ($y = 0; $y < $linhas[$x]; $y++) {
                $coluna = new Column();
                $coluna->row_id = $linha->id;
                $coluna->save();
                $formato->quadrinhos++;
            }
        }
        if (count($roteiro->formats()->get()) > 1) {
            $formatobase = Format::where('roteiro_id', $roteiro->id)->get();
            $formato->quadrinhos += $formatobase[count($formatobase)-2]->quadrinhos;
        }


        $formato->save();
        return redirect()->back();

    }

    public function lockFala($personagem, $pagina, $tipo)
    {
        $paginas = Pagina::where('id', $pagina)->first();
        if ($tipo == 'fala') {
            if ($paginas->falas()->count() >= 5) {
                return redirect()->back()->with('statusFala', 'Limite de cinco falas por quadrinho atingido!');
            } else {
                $fala = new Fala();
                $fala->conteudo = '';
                $fala->balao = '';
                $fala->char_id = $personagem;
                $fala->pagina_id = $pagina;
                $fala->save();
                return redirect()->back()->with('statusFala', 'Fala adicionada!');
            }
        } else {
            if ($paginas->falas()->where('balao', 'legenda')->count() >= 5) {
                return redirect()->back()->with('statusFala', 'Limite de cinco legendas por quadrinho atingido!');
            } else {
                $fala = new Fala();
                $fala->conteudo = '';
                $fala->balao = 'legenda';
                $fala->char_id = $personagem;
                $fala->pagina_id = $pagina;
                $fala->save();
                return redirect()->back()->with('statusFala', 'Legenda adicionada!');
            }
        }
    }

    public function removerPersonagem($personagem)
    {
        $personagem = Char::where('id', $personagem)->first();
        $personagem->delete();
        return redirect()->back();
    }

    public function removerFala($fala)
    {
        $fala = Fala::where('id', $fala)->first();
        $fala->delete();
        return redirect()->back();
    }


    public function destroy($id)
    {
        $roteiro = Roteiro::findOrFail($id);
        $roteiro->delete();
        return redirect()->route('Projetos.index');
    }

    public function concluir($id)
    {

        $roteiro = Roteiro::where('id',$id)->first();
        $totalquadrinhos = $roteiro->formats()->get();
        $totalquadrinhos = $totalquadrinhos[count($totalquadrinhos)-1];
        if(count($roteiro->paginas)==$totalquadrinhos->quadrinhos){
            $roteiro->is_concluido=1;
            $roteiro->save();
            return redirect()->action(
                [ProjetosController::class, 'index'],
            );
        }
        else{
            return redirect()->back()->with('concluido', 'Falha ao concluir roteiro, quadrinhos e formatos não conferem');
        }
    }

    public function baixar(Roteiro $roteiro){
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->get();
        $queryautor = User::where('id', $roteiro->user_id)->get();
        $autor = $queryautor[0]->name;
        foreach ($paginas as $pagina) {
            $pagina->falas = $pagina->falas()->get();
        }
        $formatos = $roteiro->formats()->get();
        $cont = 0;
        $idquadrinho = 0;
        $paginaid = 0;
        $teste = 1;
        $a = 0;
        $show = 0;
        $pdf = \PDF::loadView('baixar', compact('paginas', 'roteiro', 'autor', 'formatos', 'cont','idquadrinho','paginaid','teste','a','show'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('roteiro.pdf');
    }
}

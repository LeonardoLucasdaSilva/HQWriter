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
        $concluidos = Roteiro::where('user_id', Auth::user()->id)->where('is_concluido', true)->orderby('created_at', 'desc')->with('paginas')->get();
        $abertos = Roteiro::where('user_id', Auth::user()->id)->where('is_concluido', false)->orderby('created_at', 'desc')->with('paginas')->get();
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
        $roteiro = Roteiro::where('id', $id)->first();
        $allpaginas = Pagina::where('roteiro_id', $id)->orderby('id')->get();
        $pagina = $roteiro->paginas()->orderBy('id')->paginate(1);
        $pag = $roteiro->paginas()->orderBy('id');
        $personagens = $roteiro->chars()->get();
        $numpags = $roteiro->paginas()->count();
        $formatos = $roteiro->formats()->get();
        $numformatos = count($formatos);
        $idquadrinho = 1;
        if (count($roteiro->formats()->get()) > 0) {
            $totalquadrinhos = $formatos[count($roteiro->formats()->get()) - 1]->quadrinhos;
        } else {
            $totalquadrinhos = 0;
        }
        if($roteiro->is_marvelway==false) {
            if ($roteiro->formats()->count() == 0 && $numpags == 1 || $totalquadrinhos < $numpags) {
                return view('createFormato', compact('id', 'numformatos'));
            }
        }
        $formato = Format::where('roteiro_id', $roteiro->id)->where('quadrinhos', '>=', $pagina->currentPage())->first();
        $f = Format::where('roteiro_id', $roteiro->id)->where('quadrinhos', '<', $pagina->currentPage())->get();
        $todos = Format::where('roteiro_id', $roteiro->id)->get();
        if (count($f) == 0) {
            $f = 0;
            $currentPage = 1;
        } else {
            $f = $f[count($f) - 1];
            for ($z = 0; $z < count($todos); $z++) {
                if ($todos[$z]->id == $f->id) {
                    $currentPage = $z + 2;
                }
            }
            $f = $f->quadrinhos;
        }
        $editando = $pagina->currentPage() - $f;
        return view('Projetos.editpagina', compact('pagina', 'roteiro', 'personagens', 'totalquadrinhos', 'numpags', 'formato', 'idquadrinho', 'editando', 'currentPage', 'allpaginas'));
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
            switch ($request->teste) {
                case "salvar":
                    return redirect()->back();
                case "novapagina":
                    return redirect()->route('projetos.novaPagina', $pagina->roteiro->id);
                case "concluido":
                    return redirect()->route('projetos.concluir', $pagina->roteiro->id);
                case "editarformatacoes":
                    return redirect()->route('projetos.editFormatos', $pagina->roteiro->id);
                default:
                    return redirect('projetos/editar/' . $pagina->roteiro->id . '?page=' . $request->teste);
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
        if ($numpags > 1) {
            $pagina->delete();
        }
        $numpags = $pagina->roteiro->paginas()->count();
        return redirect('projetos/editar/' . $idroteiro . '?page=' .$numpags);
    }

    public function visualizarRoteiro($roteiro)
    {
        $roteiro = Roteiro::where('id', $roteiro)->first();
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->orderby('id')->get();
        $queryautor = User::where('id', $roteiro->user_id)->get();
        $autor = $queryautor[0]->name;
        $formatos = $roteiro->formats()->get();
        $cont = 0;
        $idquadrinho = 0;
        $paginaid = 0;
        $teste = 1;
        $a = 0;
        $show = 0;
        return view('visualizar', compact('paginas', 'roteiro', 'autor', 'formatos', 'cont', 'idquadrinho', 'paginaid', 'teste', 'a', 'show'));
    }

    public function criarPersonagem(Roteiro $roteiro)
    {
        return view('personagem', compact('roteiro'));
    }

    public function novoFormato(Request $request, $roteiro)
    {
        $roteiro = Roteiro::where('id', $roteiro)->first();
        if($roteiro->is_marvelway==false) {
            $formato = new Format();
            $formato->roteiro_id = $roteiro->id;
            if ($request->descricao) {
                $formato->descricao = $request->descricao;
            } else {
                $formato->descricao = "";
            }
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
                $formato->quadrinhos += $formatobase[count($formatobase) - 2]->quadrinhos;
            }


            $formato->save();
        }
        return redirect()->back();

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
        return redirect()->route('projetos.index');
    }

    public function concluir($id)
    {

        $roteiro = Roteiro::where('id', $id)->first();
        if($roteiro->is_marvelway==false) {
            $totalquadrinhos = $roteiro->formats()->get();
            $totalquadrinhos = $totalquadrinhos[count($totalquadrinhos) - 1];
            if (count($roteiro->paginas) == $totalquadrinhos->quadrinhos) {
                $roteiro->is_concluido = 1;
                $roteiro->save();
                return redirect()->action(
                    [ProjetosController::class, 'index'],
                );
            } else {
                return redirect()->back()->with('concluido', 'Falha ao concluir roteiro, quadrinhos e formatos não conferem');
            }
        }
        else{
            $roteiro->is_concluido =1;
            $roteiro->save();
            return redirect()->action(
                [ProjetosController::class, 'index'],
            );
        }
    }

    public function abrir($id)
    {
        $roteiro = Roteiro::where('id', $id)->first();
        $roteiro->is_concluido = false;
        $roteiro->save();
        return redirect()->back();
    }

    public function baixar(Roteiro $roteiro)
    {
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->get();
        $queryautor = User::where('id', $roteiro->user_id)->get();
        $autor = $queryautor[0]->name;
        $formatos = $roteiro->formats()->get();
        $cont = 0;
        $idquadrinho = 0;
        $paginaid = 0;
        $teste = 1;
        $a = 0;
        $show = 0;
        if($roteiro->is_marvelway==false) {
            $pdf = \PDF::loadView('baixar', compact('paginas', 'roteiro', 'autor', 'formatos', 'cont', 'idquadrinho', 'paginaid', 'teste', 'a', 'show'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->stream('roteiro.pdf');
        }
        else{
            $pdf = \PDF::loadView('baixarmarvel', compact('paginas', 'roteiro', 'autor'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->stream('roteiro.pdf');
        }

    }

    public function baixarEco(Roteiro $roteiro)
    {
        $paginas = Pagina::where('roteiro_id', $roteiro->id)->get();
        $queryautor = User::where('id', $roteiro->user_id)->get();
        $autor = $queryautor[0]->name;
        $formatos = $roteiro->formats()->get();
        $cont = 0;
        $idquadrinho = 0;
        $paginaid = 0;
        $teste = 1;
        $a = 0;
        $show = 0;
        $pdf = \PDF::loadView('baixareco', compact('paginas', 'roteiro', 'autor', 'formatos', 'cont', 'idquadrinho', 'paginaid', 'teste', 'a', 'show'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('roteiro.pdf');
    }

    public function editFormatos($roteiro)
    {
        $formatos = Format::where('roteiro_id', $roteiro)->orderby('id')->get();
        return view('editFormatos', compact('formatos'));
    }

    public function selectFormato($formato)
    {
        $formato = Format::where('id', $formato)->first();
        $todos = Format::where('roteiro_id', $formato->roteiro_id)->orderby('id')->get();
        for ($x = 0; $x < count($todos); $x++) {
            if ($todos[$x]->id == $formato->id) {
                $editando = $x;
            }
        }
        return view('updateFormato', compact('formato', 'editando'));
    }

    public function updateFormato(Request $request, $formato)
    {
        $formato = Format::where('id', $formato)->first();
        $numquadros = $formato->quadrinhos;
        for ($x = 0; $x < count($formato->rows); $x++) {
            $formato->rows[$x]->delete();
        }
        $roteiro = Roteiro::where('id', $formato->roteiro_id)->first();
        $formato->roteiro_id = $roteiro->id;
        if ($request->descricao) {
            $formato->descricao = $request->descricao;
        } else {
            $formato->descricao = "";
        }
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

        $todos = Format::where('roteiro_id', $formato->roteiro_id)->orderby('id')->get();
        for ($x = 0; $x < count($todos); $x++) {
            if ($todos[$x]->id == $formato->id) {
                $numid = $x;
            }
        }

        if (count($roteiro->formats()->get()) > 1 && $numid != 0) {
            $formatobase = Format::where('roteiro_id', $roteiro->id)->get();
            $formato->quadrinhos += $formatobase[count($formatobase) - 2]->quadrinhos;
        }

        if ($numid != 0) {
            $numquadros -= $formato->quadrinhos;
        } else {
            $formatosseguintes = Format::where('id', '>', $formato->id)->orderby('id')->get();
            for ($z = 0; $z < count($formatosseguintes); $z++) {
                $formatosseguintes[$z]->quadrinhos += $formato->quadrinhos;
                $formatosseguintes[$z]->save();
            }

        }
        $formatosseguintes = Format::where('id', '>', $formato->id)->orderby('id')->get();
        for ($z = 0; $z < count($formatosseguintes); $z++) {
            $formatosseguintes[$z]->quadrinhos -= $numquadros;
            $formatosseguintes[$z]->save();
        }

        $formato->save();

        return redirect()->action(
            [ProjetosController::class, 'editFormatos'], ['roteiro' => $formato->roteiro_id]
        );
        /* $formatoantigo = Format::where('id',$formato)->first();
         $numlinhas = 0;
         $linhas = explode(',', $request->format);
         if ($request->descricao) {
             $formatoantigo->descricao = $request->descricao;
         } else {
             $formatoantigo->descricao = "";
         }
         $formatoantigo->quadrinhos = 0;
         $formatoantigo->save();

         for ($x = 1; $x < count($linhas); $x++) {
             if ($linhas[$x] > 0) {
                 $numlinhas++;
             }
         }
         if (count($formatoantigo->rows) > $numlinhas) {
             do {
                 $formatoantigo->rows[(count($formatoantigo->rows) - 1)]->delete();
                 $formatoantigo->save();
                 $teste = Row::where('format_id',$formatoantigo->id)->get();
             } while (count($teste) > $numlinhas);
         } else {
             do {

                 $linha = new Row();
                 $linha->format_id = $formatoantigo->id;
                 $altura = (100 / (count($linhas) - 1)) - 1;
                 $linha->altura = $altura . '%';
                 $linha->save();
                 $formatoantigo->save();
                 $teste = Row::where('format_id',$formatoantigo->id)->get();
             } while (count($teste) < $numlinhas);
         }

         for ($y = 0; $y < count($formatoantigo->rows); $y++) {
             if (count($formatoantigo->rows[$y]->columns) < $linhas[$y+1]) {
                 do {
                     $coluna = new Column();
                     $coluna->row_id = $formatoantigo->rows[$y]->id;
                     $coluna->save();
                     $formatoantigo->save();
                     $teste = Column::where('row_id',$formatoantigo->rows[$y]->id)->get();
                 } while (count($teste) < $linhas[$y+1]);
             }
             else{
                 do {
                     if(count($formatoantigo->rows[$y]->columns)!=0) {
                         $formatoantigo->rows[$y]->columns[(count($formatoantigo->rows[$y]->columns) - 1)]->delete();
                         $formatoantigo->save();
                         $teste = Column::where('row_id',$formatoantigo->rows[$y]->id)->get();
                     }
                 } while (count($teste) > $linhas[$y+1]);
             }
         }
         $formatoantigo->save();*/
    }

    public function excluirFormato($formato)
    {
        $formato = Format::where('id', $formato)->first();

        $allformats = Format::where('id', '>', $formato->id)->orderby('id')->get();

        $todos = Format::where('roteiro_id', $formato->roteiro_id)->orderby('id')->get();
        for ($x = 0; $x < count($todos); $x++) {
            if ($todos[$x]->id == $formato->id) {
                $numid = $x;
            }
        }
        for ($z = count($allformats); $z > $numid; $z--) {
            $allformats[$z - 1]->quadrinhos = $allformats[$z - 1]->quadrinhos - $formato->quadrinhos;
            $allformats[$z - 1]->save();
        }

        $formato->delete();
        return redirect()->back();
    }
}

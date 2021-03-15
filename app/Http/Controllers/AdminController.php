<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ativos = User::where('is_ativo', true)->get();
        $inativos = User::where('is_ativo', false)->get();
        return view('gerenciarusuarios', compact('ativos', 'inativos'));
    }

    public function editar($user)
    {
        $user=User::where('id',$user)->first();
        return view ('editarusuario',compact('user'));
    }

    public function updateUsuario(Request $request, $user)
    {
        $user=User::where('id',$user)->first();
        $user->name = $request->nome;
        if($request->admin=="sim"){
            $user->is_admin=true;
        }
        $user->save();
        return redirect()->action(
            [AdminController::class, 'index']
        );
    }

    public function inativarUsuario($user)
    {
        $user=User::where('id',$user)->first();
        $user->is_ativo=false;
        $user->save();
        return redirect()->action(
            [AdminController::class, 'index']
        );
    }

    public function ativarUsuario($user)
    {
        $user=User::where('id',$user)->first();
        $user->is_ativo=true;
        $user->save();
        return redirect()->action(
            [AdminController::class, 'index']
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function usuarios()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Instituciones;
use Tecnovitalmedica\User;
use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class UsuarioContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->ajax()){
            $user = new User;
            $user->name = $request['nombre_contacto'];
            $user->email = $request['email_contacto'];
            $user->tipo_cuenta = 2;
            $user->id_ciudad = $request['ciudad_contacto'];
            $user->id_institucion = $request['id_institucion'];
            $user->celular = $request['celular_contacto'];
            $user->telefono = $request['telefono_contacto'];
            $user->avatar = 'default-avatar.png';
            $user->password = $request['password_contacto'];
            $user->save();
            
            $id_institucion = $request['id_institucion'];
            
            $instituciones = Instituciones::find($id_institucion);
            $instituciones->fill([
              'id_contacto_usuario' => $user->id,
            ]);
            $instituciones->save();
            
            return response()->json([
                'mensaje' => 'Contacto creado correctamente'
            ]);
        }
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
      $usu_conctacto = User::find($id);
      return response()->json(
        $usu_conctacto->toArray()
      );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      if($request->ajax()){
        $iduser = $request['id_usercon2'];
        $usrcontacto = User::find($iduser);
        if($request['password_contacto'] != ''){
          $password = $request['password_contacto'];
          $usrcontacto->fill([
            'name' => $request['nombre_contacto'],
            'email' => $request['email_contacto'],
            'id_ciudad' => $request['ciudad_contacto'],
            'celular' => $request['celular_contacto'],
            'telefono' => $request['telefono_contacto'],
            'password'=>$password,
          ]);
        }else{
          $usrcontacto->fill([
            'name' => $request['nombre_contacto'],
            'email' => $request['email_contacto'],
            'id_ciudad' => $request['ciudad_contacto'],
            'celular' => $request['celular_contacto'],
            'telefono' => $request['telefono_contacto'],
          ]);
        }
        $usrcontacto->save();

        return response()->json([
            'mensaje' => 'Contacto actualizado correctamente'
        ]);
      }
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

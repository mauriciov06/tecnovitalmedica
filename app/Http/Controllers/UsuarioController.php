<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Ciudad;
use Tecnovitalmedica\User;
use Tecnovitalmedica\Instituciones;
use Tecnovitalmedica\Tipo_cuenta;
use Tecnovitalmedica\Permisos_users;

use Redirect;
use Session;

use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Requests\UserCreateRequest;
use Tecnovitalmedica\Http\Requests\UserUpdateRequest;
use Tecnovitalmedica\Http\Controllers\Controller;

class UsuarioController extends Controller
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
    public function index(Request $request)
    {
      $users = User::busquedausuario($request->get('nombre_usuario'),$request->get('correo_usuario'),$request->get('ciudad_usuario'))->orderBy('id','DESC')->paginate(10);
      $ciudades = Ciudad::lists('nombre_ciudad','id');
      return view('usuarios.index', compact('users','ciudades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $ciudad = Ciudad::lists('nombre_ciudad','id');
      $tipoCuentas = Tipo_cuenta::lists('nombre_tipo_cuenta','id');
      $instituciones = Instituciones::lists('nombre_instituciones','id');
      return view('usuarios.create', compact('ciudad', 'tipoCuentas', 'instituciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $users = User::create($request->all());
        if($users){
            if($request->permisos != ''){
                $permisosUsers = new Permisos_users();
                $permisosUsers->id_users = $users->id;
                $permisosUsers->ids_permisos = $request->permisos;
                $permisosUsers->save();
            }
        }
        return redirect('/usuarios')->with('message','Usuario creado correctamente');
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
        $user = User::find($id);
        $permisosUsers = Permisos_users::where('id_users', $id)->select('ids_permisos')->first();
        $ciudad = Ciudad::lists('nombre_ciudad','id');
        $tipoCuentas = Tipo_cuenta::lists('nombre_tipo_cuenta','id');
        $instituciones = Instituciones::lists('nombre_instituciones','id');
        return view('usuarios.edit', ['user'=>$user, 'ciudad'=>$ciudad, 'instituciones'=>$instituciones, 'tipoCuentas'=>$tipoCuentas,'permisosUsers'=>$permisosUsers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id, UserUpdateRequest $request)
    {
        $user = User::find($id);
        $user->fill($request->all());
        if($user->save()){
           if($request->permisos != ''){
                $permisosUsers = Permisos_users::where('id_users', $id)->first();
                if(isset($permisosUsers)){
                    $permisosUsers->ids_permisos = $request->permisos;
                    $permisosUsers->update();
                }else{
                    $permisosCreaUsers = new Permisos_users();
                    $permisosCreaUsers->id_users = $id;
                    $permisosCreaUsers->ids_permisos = $request->permisos;
                    $permisosCreaUsers->save();
                }
                
            } 
        }

        Session::flash('message', 'Usuario editado correctamente');
        return Redirect::to('/usuarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if($user->tipo_cuenta == 2){
            Instituciones::where('id_contacto_usuario','=',$user->id)->update(array('id_contacto_usuario'=>0));
        }
        $user->delete();
        return response()->json(['borrado'=>true,'mensaje'=>'Usuario eliminado correctamente.']);
    }

    public static function getUserInstitucion($idInstitucion)
    {
        $nombreInsitucion = Instituciones::where('id', $idInstitucion)
                            ->select('nombre_instituciones')->get()->toArray();
        
        if(count($nombreInsitucion) > 0){
            return $nombreInsitucion[0]['nombre_instituciones'];
        }else{
            return 'N/A';
        }
    }
    
    public static function getUserTipoCuenta($idTipoCuenta)
    {
        $nombreTipoCuenta = Tipo_cuenta::where('id', $idTipoCuenta)
                            ->select('nombre_tipo_cuenta')->get()->toArray();
        if($idTipoCuenta == 1){
            $labelColor = 'label-success';
        }elseif($idTipoCuenta == 2){
            $labelColor = 'label-primary';
        }elseif($idTipoCuenta == 3){
            $labelColor = 'label-warning';
        }else{
            $labelColor = 'label-default';
        }
        
        if(count($nombreTipoCuenta) > 0){
            return '<span class="label '.$labelColor.'">'.$nombreTipoCuenta[0]['nombre_tipo_cuenta'].'</span>';
        }else{
            return 'N/A';
        }
    }
    
    public static function getPermisos($idUser, $idPermiso)
    {
        $permisosUsers = Permisos_users::where('id_users', $idUser)->first();
        $valid = false;
        
        if(isset($permisosUsers)){
            $arrayPermisosUser = explode(",", $permisosUsers->ids_permisos);
            if(in_array($idPermiso, $arrayPermisosUser)){
                $valid = true;
            }
        }
        
        return $valid;
        
    }
    
}

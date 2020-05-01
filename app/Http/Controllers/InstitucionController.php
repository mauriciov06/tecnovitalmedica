<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Ciudad;
use Tecnovitalmedica\Instituciones;
use Tecnovitalmedica\Equipos_medicos;
use Tecnovitalmedica\File_manager;
use Tecnovitalmedica\User;

use Redirect;
use Session;
use Auth;

use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Requests\InstitucionCreateRequest;
use Tecnovitalmedica\Http\Requests\InstitucionUpdateRequest;
use Tecnovitalmedica\Http\Controllers\Controller;

class InstitucionController extends Controller
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
      if(Auth::user()->tipo_cuenta == 1){
        $instituciones = Instituciones::busquedainstitucion($request->get('nombre_institucion'),$request->get('correo_institucion'),$request->get('ciudad_institucion'))->orderBy('id','DESC')->paginate(10);
      }else{
        $instituciones = Instituciones::busquedainstitucion($request->get('nombre_institucion'),$request->get('correo_institucion'),$request->get('ciudad_institucion'))->orderBy('id','DESC')->where('id_contacto_usuario', Auth::id())->paginate(10);
      }
      $ciudades = Ciudad::lists('nombre_ciudad','id');
      return view('instituciones.index', compact('instituciones','ciudades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ciudad = Ciudad::lists('nombre_ciudad','id');
        return view('instituciones.create', compact('ciudad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitucionCreateRequest $request)
    {
        $institucion = new Instituciones;
        $institucion->nombre_instituciones = $request->nombre_instituciones;
        $institucion->email_instituciones = $request->email_instituciones;
        $institucion->id_ciudad = $request->id_ciudad;
        $institucion->celular_instituciones = $request->celular_instituciones;
        $institucion->telefono_instituciones = $request->telefono_instituciones;
        $institucion->direccion_instituciones = $request->direccion_instituciones;
        $institucion->avatar_instituciones = $request->avatar_instituciones;
        $institucion->nombre_carpeta_institucion = $request->nombre_carpeta_institucion;
        
        $directorio = public_path().'/listado_instituciones/'.$institucion->nombre_carpeta_institucion;
        if (!file_exists($directorio)) {
            if($institucion->save()){
                $this->validarCarpetasInstitucion($directorio);
                return redirect('/instituciones')->with('message','Institución creado correctamente');
            }
        }else{
            return redirect('/instituciones/create')->with('message','El nombre del archivo ya existe no fue posible crear la institución, cambie el nombre de la carpeta y creala de nuevo.');
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
        $institucion = Instituciones::find($id);
        $ciudad = Ciudad::lists('nombre_ciudad','id');
        return view('instituciones.edit', ['institucion'=>$institucion, 'ciudad'=>$ciudad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstitucionUpdateRequest $request, $id)
    {
        $institucion = Instituciones::find($id);
        
        if($institucion->nombre_carpeta_institucion != ''){
            $directorio = public_path().'/listado_instituciones/'.$institucion->nombre_carpeta_institucion;
        }else{
            if($request->nombre_carpeta_institucion != ''){
                $directorio = public_path().'/listado_instituciones/'.$request->nombre_carpeta_institucion;
                $this->validarCarpetasInstitucion($directorio);
            }
        }
        
        $institucion->fill($request->all());
        $institucion->save();

        Session::flash('message', 'Institución editada correctamente');
        return Redirect::to('/instituciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $institucion = Instituciones::find($request->id);
        if($institucion->id_contacto_usuario != 0){
            $usuario_contacto = User::find($institucion->id_contacto_usuario);
            $usuario_contacto->delete();   
        }
        
        $equiposMedicos = Equipos_medicos::where('id_instituciones', $request->id)->get();
        if(count($equiposMedicos) > 0){
            foreach($equiposMedicos as $equipoMedico){
                $equipoMedico->delete();
            }   
        }
        
        $registrosFileManager = File_manager::where('id_instituciones', $request->id)->get();
        if(count($registrosFileManager) > 0){
            foreach($registrosFileManager as $registroFileManager){
                $registroFileManager->delete();
            }   
        }
        
        $directorio = public_path().'/listado_instituciones/'.$institucion->nombre_carpeta_institucion;
        
        if(file_exists($directorio)){
            foreach(glob($directorio . "/*") as $archivos_carpeta){ 
                if (is_dir($archivos_carpeta)){
                    $this->eliminarFicherosDirectorios($archivos_carpeta);
                } else {
                    unlink($archivos_carpeta);
                }
            }
            rmdir($directorio);
            
            $institucion->delete();
            return response()->json(['borrado'=>true,'mensaje'=>'Institución eliminada correctamente.']);
        }else{
            $institucion->delete();
            return response()->json(['borrado'=>true,'mensaje'=>'Institución eliminada correctamente.']);
        }
            
    }
    
    protected function eliminarFicherosDirectorios($carpeta){
      foreach(glob($carpeta . "/*") as $archivos_carpeta){             
        if (is_dir($archivos_carpeta)){
          $this->eliminarFicherosDirectorios($archivos_carpeta);
        } else {
            unlink($archivos_carpeta);
        }
      }
      rmdir($carpeta);
    }
    
    protected function validarCarpetasInstitucion($directorio){
        if(!file_exists($directorio.'/Procesos')){
            mkdir($directorio.'/Procesos', 0777, true);
        }
        if(!file_exists($directorio.'/Hoja de vida')){
            mkdir($directorio.'/Hoja de vida', 0777, true);
        }
        if(!file_exists($directorio.'/Mantenimiento Preventivo')){
            mkdir($directorio.'/Mantenimiento Preventivo', 0777, true);
        }
        if(!file_exists($directorio.'/Mantenimiento Correctivo')){
            mkdir($directorio.'/Mantenimiento Correctivo', 0777, true);
        }
        if(!file_exists($directorio.'/Calibraciones')){
            mkdir($directorio.'/Calibraciones', 0777, true);
        }
        if(!file_exists($directorio.'/Guias')){
            mkdir($directorio.'/Guias', 0777, true);
        }
        if(!file_exists($directorio.'/Manuales')){
            mkdir($directorio.'/Manuales', 0777, true);
        }
        if(!file_exists($directorio.'/Otros')){
            mkdir($directorio.'/Otros', 0777, true);
        }
    }
    
    public function getProcesos($id)
    {
      $procesos = File_manager::where('id_instituciones', $id)->where('id_equipo_medico', 0)->where('tipo_archivo', 7)
          ->join('instituciones','instituciones.id','=','file_managers.id_instituciones')->select('file_managers.*','instituciones.nombre_carpeta_institucion')->get();
      return view('instituciones.procesos', compact('procesos', 'id'));
    }
}

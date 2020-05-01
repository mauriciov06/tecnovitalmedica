<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Instituciones;
use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Controllers\Controller;
use Tecnovitalmedica\Http\Requests\EquipoCreateRequest;
use Tecnovitalmedica\Http\Requests\EquipoActualizacionRequest;
use Tecnovitalmedica\Equipos_medicos;
use Tecnovitalmedica\File_manager;
use Redirect;
use Session;
use Auth;
use Carbon\Carbon;

class EquipoMedicoController extends Controller
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
        $equipos = Equipos_medicos::busquedaequipo($request->get('nombre_equipo'),$request->get('ubicacion_equipo'),$request->get('serie_equipo'),$request->get('institucion'))->orderBy('id','DESC')->paginate(10);
      }else{
        $institucion = Instituciones::where('id_contacto_usuario', Auth::id())->get();
        $id_insti = 0;
        foreach ($institucion as $inst) {
          $id_insti = $inst->id;
        }
        $equipos = Equipos_medicos::busquedaequipo($request->get('nombre_equipo'),$request->get('ubicacion_equipo'),$request->get('serie_equipo'),$request->get('institucion'))->orderBy('id','DESC')->where('id_instituciones', $id_insti)->paginate(10);
      }
      $instituciones = Instituciones::lists('nombre_instituciones','id');
      return view('equipos-medicos.index', compact('equipos', 'instituciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $instituciones = Instituciones::lists('nombre_instituciones','id');
      return view('equipos-medicos.create', compact('instituciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipoCreateRequest $request)
    {
      Equipos_medicos::create($request->all());
      return redirect('/equipos')->with('message','Equipo creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $equipo = Equipos_medicos::where('equipos_medicos.id', $id)
                    ->join('instituciones', 'instituciones.id', '=', 'equipos_medicos.id_instituciones')
                    ->select('instituciones.nombre_carpeta_institucion', 'equipos_medicos.*')
                    ->first();

      $instituciones = Instituciones::lists('nombre_instituciones','id');

      $manager_institucion = File_manager::where('id_instituciones', $equipo->id_instituciones)->where('id_equipo_medico', $equipo->id)
        ->join('instituciones', 'instituciones.id', '=', 'file_managers.id_instituciones')
        ->select('instituciones.nombre_carpeta_institucion', 'file_managers.*')
        ->orderBy('fecha_realizacion','ASC')
        ->get();
      return view('equipos-medicos.show', ['equipo'=>$equipo, 'instituciones'=>$instituciones], compact('manager_institucion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $equipo = Equipos_medicos::find($id);
      $instituciones = Instituciones::lists('nombre_instituciones','id');
      return view('equipos-medicos.edit', ['equipo'=>$equipo, 'instituciones'=>$instituciones]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EquipoActualizacionRequest $request, $id)
    {
      $equipo = Equipos_medicos::find($id);
      $equipo->fill($request->all());
      $equipo->save();

      Session::flash('message', 'Equipo editado correctamente');
      return Redirect::to('/equipos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $equipo = Equipos_medicos::find($request->id);
      $institucionInfo = Instituciones::find($equipo->id_instituciones);
      
      $directorio = public_path().'/listado_instituciones/'.$institucionInfo->nombre_carpeta_institucion;
      
      $registrosEquipoManagers = File_manager::where('id_instituciones',$equipo->id_instituciones)->where('id_equipo_medico', $request->id)->get();
      
      if(count($registrosEquipoManagers) > 0){
        if(file_exists($directorio)){
            foreach($registrosEquipoManagers as $registroEquipoManager){
                if($registroEquipoManager->tipo_archivo == 1){
                    $urlArchivo = $directorio.'/Hoja de vida/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 2){
                    $urlArchivo = $directorio.'/Mantenimiento Preventivo/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 3){
                    $urlArchivo = $directorio.'/Mantenimiento Correctivo/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 4){
                    $urlArchivo = $directorio.'/Calibraciones/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 5){
                    $urlArchivo = $directorio.'/Guias/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 6){
                    $urlArchivo = $directorio.'/Manuales/'.$registroEquipoManager->nombre_archivo;
                }elseif($registroEquipoManager->tipo_archivo == 8){
                    $urlArchivo = $directorio.'/Otros/'.$registroEquipoManager->nombre_archivo;
                }
                unlink($urlArchivo);
                $registroEquipoManager->delete();
            }
        }
      }
      
      $equipo->delete();
      return response()->json(['borrado'=>true,'mensaje'=>'Equipo medico eliminado correctamente.']);
    }
    
    public function busquedaArchivos(Request $request){
        $fechaInicial = '';
        $fechaFinal = '';
        
        //Cuando se ingresa fecha de inicio y fecha final.
        if($request->fechaInicio != '' && $request->fechaFinal != ''){
            $fechaInicial = $request->fechaInicio;
            $fechaFinal = $request->fechaFinal;
        }
        //Cuando se ingresa la fecha de inicio pero no la final, este busca hasta la fecha actual.
        elseif($request->fechaInicio != '' && $request->fechaFinal == ''){
            $fechaInicial = $request->fechaInicio;
            
            $hastaLaFecha = Carbon::now();
            $hastaLaFecha->subDay(1);
            $fechaFinal = $hastaLaFecha->toDateString();
        }
        //Cuando no hay fecha de incio pero si fecha final, se toma la menor fecha de creacion que este registrada
        elseif($request->fechaInicio == '' && $request->fechaFinal != ''){
            $fechaMenorCreacion = File_manager::min('fecha_realizacion');
            $fechaInicial = $fechaMenorCreacion;
            
            $fechaFinal = $request->fechaFinal;
        }
        //Cuando no hay fecha de incio ni fecha final, trae todos los contenidos teniendo en cuenta la menor fecha de creacion hasta la mayor.
        else{
            $fechaInicial = File_manager::min('fecha_realizacion');
            $fechaFinal = File_manager::max('fecha_realizacion'); 
        }
        
        $fileManager = File_manager::where('id_instituciones', $request->idInstitucion)
                        ->where('id_equipo_medico', $request->idEquipo)
                        ->where('tipo_archivo', $request->tipoArchivo)
                        ->whereBetween('fecha_realizacion', [$fechaInicial, $fechaFinal])
                        ->orderBy('fecha_realizacion','ASC')
                        ->get()->toArray();
        
        if(count($fileManager) > 0){
            return response()->json(['data'=>$fileManager]);
        }else{
            return response()->json(['data'=> 0]);
        }                
                        
    }
}

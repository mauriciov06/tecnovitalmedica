<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Instituciones;
use Tecnovitalmedica\Equipos_medicos;
use Tecnovitalmedica\File_manager;
use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Controllers\Controller;
use Tecnovitalmedica\Http\Requests\FileManagerCreateRequest;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Session;
use Auth;

class FileManagerController extends Controller
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

    public function getEquipos(Request $request, $id){
        if($request->ajax()){
            $equimedicos = Equipos_medicos::equiposmedicos($id);
            return response()->json($equimedicos);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
      if(Auth::user()->tipo_cuenta == 1){
        $instituciones = Instituciones::lists('nombre_instituciones','id');
      }else{
        $instituciones = Instituciones::where('id_contacto_usuario', Auth::id())->lists('nombre_instituciones','id');
      }
      $equipos_medicos = Equipos_medicos::lists('nombre_equipo_medico','id');
      return view('file-manager.create', compact('instituciones', 'equipos_medicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileManagerCreateRequest $request)
    {
      File_manager::create($request->all());
      return redirect('/filemanager/create')->with('message','Se ha cargado el archivo correctamente');
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
        $proceso = File_manager::find($id);
        if(\File::exists(public_path('avatares/'.$proceso->url_archivo))){
            \File::delete(public_path('avatares/'.$proceso->url_archivo));
            $proceso->delete();
            Session::flash('message', 'Proceso eliminado correctamente');
            return Redirect::to('/instituciones');
        }else{
            $proceso->delete();
            Session::flash('message', 'Proceso eliminado correctamente');
            return Redirect::to('/instituciones');
        }
    }
    
    public function destroydocument(Request $request)
    {
        $urlArchivo = '';
        $nombreArchivoFile = File_manager::find($request->idarchivo);
        
        $directorio = public_path().'/listado_instituciones/'.$request->nombrecarpeta;
        
        if($request->tipoArchivo == 1){
            $urlArchivo = $directorio.'/Hoja de vida/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 2){
            $urlArchivo = $directorio.'/Mantenimiento Preventivo/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 3){
            $urlArchivo = $directorio.'/Mantenimiento Correctivo/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 4){
            $urlArchivo = $directorio.'/Calibraciones/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 5){
            $urlArchivo = $directorio.'/Guias/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 6){
            $urlArchivo = $directorio.'/Manuales/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 7){
            $urlArchivo = $directorio.'/Procesos/'.$nombreArchivoFile->nombre_archivo;
        }elseif($request->tipoArchivo == 8){
            $urlArchivo = $directorio.'/Otros/'.$nombreArchivoFile->nombre_archivo;
        }
        
        
        if(file_exists($urlArchivo)){
            unlink($urlArchivo);
            $nombreArchivoFile->delete();
            return response()->json(['estado'=>true, 'mensaje'=>'El archivo fue eliminado correctamente']);
        }else{
            return response()->json(['estado'=>false, 'mensaje'=>'El archivo no pudo ser eliminado correctamente']);
        }
        
    }
    
    protected function moveFile($nombreArchivoNuevo,$rutaDirectorio,$file){
        $save = false;
        if(!file_exists($rutaDirectorio.$nombreArchivoNuevo)){
            $file->move($rutaDirectorio, $nombreArchivoNuevo);   
            $save = true;
        }
        return $save;
    }
    
    public function saveFile(Request $request){
        $nombreArchivo = $request->nombre_archivo;
        $file = $request->file('archivo_file_manager');
        $idEquipo = $request->id_equipo;
        $idInstitucion = $request->id_institu;
        
        if($nombreArchivo != '' && $file != null){
            $fechaRealizacion = $request->fecha_realizacion;
            $tipoArchivo = $request->tipo_archivo;
        
            $extencion = $file->getClientOriginalExtension();
            $nombreArchivoNuevo = '';
        
            if($extencion == 'pdf'){
                /*Capturamos la carpeta de la institución*/
                $directorioInsti = Instituciones::find($idInstitucion);
                $nombreCarpeta = '';
                
                if($tipoArchivo == 1){
                    $nombreCarpeta = '/Hoja de vida/';
                }elseif($tipoArchivo == 2){
                    $nombreCarpeta = '/Mantenimiento Preventivo/';
                }elseif($tipoArchivo == 3){
                    $nombreCarpeta = '/Mantenimiento Correctivo/';
                }elseif($tipoArchivo == 4){
                    $nombreCarpeta = '/Calibraciones/';
                }elseif($tipoArchivo == 5){
                    $nombreCarpeta = '/Guias/';
                }elseif($tipoArchivo == 6){
                    $nombreCarpeta = '/Manuales/';
                }elseif($tipoArchivo == 7){
                    $nombreCarpeta = '/Procesos/';
                }elseif($tipoArchivo == 8){
                    $nombreCarpeta = '/Otros/';
                }
                
                $rutaDirectorio = public_path().'/listado_instituciones/'.$directorioInsti->nombre_carpeta_institucion.$nombreCarpeta;
                
                if(file_exists($rutaDirectorio)){
                    $result = false;
                    if($tipoArchivo == 1){
                        $nombreArchivoNuevo = 'HV-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 2){
                        $nombreArchivoNuevo = 'RMP-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 3){
                        $nombreArchivoNuevo = 'RMC-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 4){
                        $nombreArchivoNuevo = $nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 5){
                        $unix = strtotime(date("Y-m-d H:i:s"));
                        $nombreArchivoNuevo = $unix.'-GM-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 6){
                        $unix = strtotime(date("Y-m-d H:i:s"));
                        $nombreArchivoNuevo = $unix.'-MANUAL-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 7){
                        $nombreArchivoNuevo = $nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }elseif($tipoArchivo == 8){
                        $unix = strtotime(date("Y-m-d H:i:s"));
                        $nombreArchivoNuevo = $unix.'-'.$nombreArchivo.'.'.$extencion;
                        $result = $this->moveFile($nombreArchivoNuevo,$rutaDirectorio,$file);
                    }
                    
                    if($result == true){
                        $fileManaager = new File_manager();
                        $fileManaager->id_instituciones = $idInstitucion;
                        $fileManaager->id_equipo_medico = $idEquipo;
                        $fileManaager->tipo_archivo = $tipoArchivo;
                        $fileManaager->nombre_archivo = $nombreArchivoNuevo;
                        $fileManaager->fecha_realizacion = $fechaRealizacion;
                        if($fileManaager->save()){
                            Session::flash('message', 'Se ha cargado el archivo correctamente');
                            if($idEquipo != 0){
                                return Redirect::to('/equipos/'.$idEquipo);
                            }else{
                                return Redirect::to('/instituciones/procesos/'.$idInstitucion);
                            }
                        }
                    }else{
                        Session::flash('message-error', 'El nombre del archivo ya se encuentra registrado, por favor cambiarlo.');
                        if($idEquipo != 0){
                            return Redirect::to('/equipos/'.$idEquipo);
                        }else{
                            return Redirect::to('/instituciones/procesos/'.$idInstitucion);
                        }
                    }
                }else{
                    Session::flash('message-error', 'Se debe crear primero la carpeta de la institución para poder subir los archivos.');
                    if($idEquipo != 0){
                        return Redirect::to('/equipos/'.$idEquipo);
                    }else{
                        return Redirect::to('/instituciones/procesos/'.$idInstitucion);
                    }
                }
            
            }else{
                Session::flash('message-error', 'Solo se permiten archivos en pdf');
                if($idEquipo != 0){
                    return Redirect::to('/equipos/'.$idEquipo);
                }else{
                    return Redirect::to('/instituciones/procesos/'.$idInstitucion);
                }
            }
        }else{
            Session::flash('message-error', 'El nombre del archivo y archivo son obligatorios.');
            if($idEquipo != 0){
                return Redirect::to('/equipos/'.$idEquipo);
            }else{
                return Redirect::to('/instituciones/procesos/'.$idInstitucion);
            }
        }
        
    }
    
    
}

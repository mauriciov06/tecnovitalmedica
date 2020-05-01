<?php

namespace Tecnovitalmedica\Http\Controllers;

use Illuminate\Http\Request;
use Tecnovitalmedica\Ciudad;

use Redirect;
use Session;

use Tecnovitalmedica\Http\Requests;
use Tecnovitalmedica\Http\Controllers\Controller;

class CiudadController extends Controller
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
      $ciudades = Ciudad::paginate(10);
      return view('ciudades.index', compact('ciudades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
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
            $ciudad = new Ciudad;
            $ciudad->nombre_ciudad = $request['nombre_ciudad'];
            $ciudad->save();
            
            return response()->json([
                'mensaje' => 'Ciudad creada correctamente'
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
        $ciudad = Ciudad::find($id);
        return response()->json(
            $ciudad->toArray()
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
            $idCiudad = $request->id;
            $ciudad = Ciudad::find($idCiudad);
            $ciudad->fill([
                'nombre_ciudad' => $request->nombre_ciudad
            ]);
            $ciudad->save();
            
            return response()->json([
                'mensaje' => 'Ciudad actualizada correctamente'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ciudad = Ciudad::find($request->id);
        $ciudad->delete();
        return response()->json(['borrado'=>true,'mensaje'=>'Ciudad eliminada correctamente.']);
    }
    
    public static function getCiudades(){
        return $ciudades = Ciudad::lists('nombre_ciudad','id');
    }
}

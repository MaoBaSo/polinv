<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\InvBodega;
use Illuminate\Http\Request;

use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametro;
use Illuminate\Support\Facades\Validator;

class BodegaController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 6;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $bodegas = InvBodega::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('nombre')
                        ->paginate(15);

        return view('inventario.bodegas.index', compact('bodegas')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga la lista de ciudades basados en el pais del usuario
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');

        //Carga vista de Formulario de CREACION de Roles 
        return view('inventario.bodegas.create', compact('ciudades'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos de la bodega
        //Crea registro en la tabla de Bodegas 
        //Retorna a Index

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:200',
            'ciudad_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = InvBodega::where('nombre', $request->nombre)->exists();
        if($exists){
            return back()->withInput()->withErrors("Bodega ya Existe");
        }

        //CARGA dato en la tabla
        $bodega = new InvBodega;
            $bodega->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $bodega->direccion = $request->direccion;
            $bodega->referencia_direccion = $request->referencia_direccion;
            $bodega->notas = $request->notas;
            $bodega->creado_por = Auth::id();
            $bodega->pais_id = Auth::user()->pais_id;
            $bodega->ciudad_id = $request->ciudad_id;
        $bodega->save();

        return redirect()->route('inventario-bodegas.index')
                        ->with('info', 'Bodega creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvBodega  $invBodega
     * @return \Illuminate\Http\Response
     */
    public function show(InvBodega $invBodega)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvBodega  $invBodega
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga la lista de ciudades basados en el pais del usuario
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');


        //Carga una Bodega en especifico para ser mostrada  
        $bodega = InvBodega::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.bodegas.edit', compact('bodega', 'ciudades')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvBodega  $invBodega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Valida datos
         $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:200|unique:inv_bodegas,nombre,'. $id,
            'nombre' => 'required|max:125',
            'caracteristicas' => 'max:1000',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 
        
        //CARGA dato en la tabla
        $bodega = InvBodega::find($id);

            $bodega->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $bodega->direccion = $request->direccion;
            $bodega->referencia_direccion = $request->referencia_direccion;
            $bodega->notas = $request->notas;
            $bodega->pais_id = Auth::user()->pais_id;
            $bodega->ciudad_id = $request->ciudad_id;

        $bodega->save();

        return redirect()->route('inventario-bodegas.index')
                        ->with('info', 'Bodega editada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvBodega  $invBodega
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $linea = InvBodega::findOrFail($id);
        $linea->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Bodega ID= '. $id;
        Miscellany::store_log("GESTION BODEGAS", "ELIMINA", $message);

        return redirect()->route('inventario-bodegas.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

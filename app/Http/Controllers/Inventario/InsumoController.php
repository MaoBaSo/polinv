<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InvInsumos;
use App\Models\InvProducto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Validator;

class InsumoController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 7;
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
     * carga ventanas de creacion de transferencia basados en el Id relacion
     * de producto bodega.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createWithId($id)
    {
         //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //**RETORNA DATOS AL FORMULARIO */
        //Pluck de Productos
        $productos = InvProducto::pluck('nombre','id');
        //Retorna id de servicio
        $servicio_id = $id;

        //Trae los insumos cargados para el servicio elejido
        //$InvInsumos = InvInsumos::where('sevicio_id', $id);
        $InvInsumos = DB::table('inv_insumos')
                    ->select(DB::raw(
                        '
                        inv_insumos.id,
                        inv_productos.nombre,
                        inv_insumos.cantidad,
                        conf_parametros.variable_1 as presentacion,
                        inv_insumos.costo_neto,
                        inv_insumos.nota
                        '
                    ))
                    ->Join('inv_productos', 'inv_insumos.producto_id', '=', 'inv_productos.id')
                    ->Join('conf_parametros', 'inv_insumos.presentacion_id', '=', 'conf_parametros.id')
                    ->where('inv_insumos.sevicio_id', $id)
                    ->where('inv_insumos.deleted_at', null)
                    ->get();

    
        return view('inventario.servicios.insumos.create', compact('productos', 'servicio_id', 'InvInsumos'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valida datos
        $Validate = Validator::make($request->all(), [
            'producto_id' => 'required',
            'cantidad' => 'required|numeric',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = InvInsumos::where('sevicio_id', $request->servicio_id)
                        ->where('producto_id', $request->producto_id)                    
                        ->exists();
        if($exists){
            return back()->withInput()->withErrors("Insumo ya existe para este servicio");
        }

        //carga el roducto elejido
        $producto = InvProducto::find($request->producto_id);

        //CARGA dato en la tabla
        $InvInsumo = new InvInsumos;
            $InvInsumo->sevicio_id = $request->servicio_id;
            $InvInsumo->producto_id = $request->producto_id;
            $InvInsumo->cantidad = $request->cantidad;
            $InvInsumo->presentacion_id = $producto->presentacion_id;
            $InvInsumo->costo_neto = $request->costo_neto;
            $InvInsumo->nota = $request->notas;
            $InvInsumo->creado_por = Auth::id();
        $InvInsumo->save();


        return redirect()->route('inventario-servicios.index')
                        ->with('info', 'Insumo cargado exitosamente');
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
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $insumo = InvInsumos::findOrFail($id);
        $insumo->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Insumo ID= '. $id;
        Miscellany::store_log("GESTION INSUMOS", "ELIMINA", $message);

        return redirect()->route('inventario-servicios.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }

}

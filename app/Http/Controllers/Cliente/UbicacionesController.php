<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CliPatios;
use App\Models\CliUbicacionBodega;
use Illuminate\Support\Facades\DB;
use App\Models\InvBodega;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Facades\App\Classes\Miscellany;


class UbicacionesController extends Controller
{

    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        //EL MISMO DE GESTION DEL CLIENTE
        $this->caso_uso = 12;
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
     * Muestra listado de ubicaciones por ID de cliente.

     */
    public function listUbicaciones($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga vista listado de ubicaciones
        /**
        * $ubicaciones = CliPatios::where('cliente_id', $id)
        *                ->orderBy('nombre')
        *                ->paginate(15);
        */
        //Carga la Bodega que tiene asignada el Cliente, esta preparada para aceptar multiples bodegas a una ubicación
        $ubicaciones = DB::table('cli_patios')
            ->join('cli_ubicacion_bodega', 'cli_patios.id', '=', 'cli_ubicacion_bodega.patio_id')
            ->join('inv_bodegas', 'inv_bodegas.id', '=', 'cli_ubicacion_bodega.bodega_id')
            ->select(DB::raw('
                cli_patios.id as patios_id,
                cli_patios.created_at as fecha_creacion_patio,
                cli_patios.nombre as nombre_patio,
                cli_patios.direccion,
                inv_bodegas.nombre as nombre_bodega,
                cli_ubicacion_bodega.id as ubicacion_bodega_id
            '))
            ->where('cli_patios.cliente_id', $id)
            ->where('cli_patios.deleted_at', null)
            ->where('cli_ubicacion_bodega.deleted_at', null)
            ->get();  
        
        //Carga lista de bodegas disponibles    
        $bodegas = InvBodega::pluck('nombre','id');            
        //Envia cliente_id
        $cliente_id = $id;

        return view('clientes.ubicaciones.gestion', compact('ubicaciones', 'bodegas', 'cliente_id')); 

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
        try {
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'cliente_id' => 'required',
                'nombre_ubicacion' => 'required|max:249',
                'direccion' => 'required|max:99',
                'bodega_id' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            } 

            DB::beginTransaction();
                //CARGA dato en la tabla de Patios
                $patio = new CliPatios;
                    $patio->cliente_id = $request->cliente_id;
                    $patio->nombre = $request->nombre_ubicacion;
                    $patio->direccion = $request->direccion; 
                $patio->save();
                //Carga dato en la tabla de Patios VS Bodegas
                $ubicacion_bodega = new CliUbicacionBodega;
                    $ubicacion_bodega->patio_id = $patio->id;
                    $ubicacion_bodega->bodega_id = $request->bodega_id; 
                    $ubicacion_bodega->nota = "";
                    $ubicacion_bodega->creado_por = Auth::id();
                $ubicacion_bodega->save();            
            DB::commit();

        //********************** */
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('clientes.index')
                        ->with('info', 'Ubicación creada exitosamente');
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

        $patios = CliPatios::findOrFail($id);
        $patios->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Ubicacion ID= '. $id;
        Miscellany::store_log("GESTION UBICACION", "ELIMINA", $message);

        return redirect()->route('clientes.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

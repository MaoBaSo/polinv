<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmpEmpleado;
use Illuminate\Support\Facades\DB;
use App\Models\OprAsignaServicio;
use App\Classes\UpdateStateServ;
use App\Classes\DescuentoInsumo;
use App\Models\CliUbicacionBodega;

use App\Models\SerItemServicio;
use App\Models\InvServicio;
use App\Models\InvInsumos;


class DashboardOperacionController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 25;
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga lista de empleados
        $list_empleados = EmpEmpleado::all();

        return view('operacion.etapas-tecnicas.index', compact('list_empleados')); 
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id de empleado
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina    

        //Carga empleado
        $empleado = EmpEmpleado::find($id);

        //Carga servicios en estado 1 y 2 de un empleado en especifico
        $list_items_asignados = DB::table('ope_item_servicio_empledo')
                    ->select(DB::raw(
                        '
                        ope_item_servicio_empledo.id,
                        ope_item_servicio_empledo.token,
                        ope_item_servicio_empledo.estado,
                        serv_servicios.movil,
                        serv_servicios.placa,
                        serv_servicios.numero_orden_trabajo,
                        serv_servicios.fecha_servicio,
                        serv_servicios_items.accion,
                        inv_servicios.sku,
                        inv_servicios.tipo_vehiculo
                        '
                    ))
                    ->Join('serv_servicios', 'serv_servicios.id', '=', 'ope_item_servicio_empledo.servicio_id')
                    ->Join('serv_servicios_items', 'serv_servicios_items.id', '=', 'ope_item_servicio_empledo.item_id')
                    ->Join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
                    ->where('ope_item_servicio_empledo.empleado_id', $id)
                    ->whereIn('ope_item_servicio_empledo.estado', [1, 2])
                    ->where('ope_item_servicio_empledo.deleted_at', null)
                    ->where('serv_servicios.deleted_at', null)
                    ->get();

        return view('operacion.etapas-tecnicas.show', compact('list_items_asignados', 'empleado'));
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
     * Update the specified resource in storage.
     * @param  int  $id, Ítem
     *
     */
    public function updateStateOP($token)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina  
        //VARIABLES
        $mensaje = "";

        //Trae la asignacion del item EMPLEADO VS ITEM ASIGNADO
        $OprAsignaServicio = OprAsignaServicio::where('token', $token)->first();
        //Trae los datos del empleado
        $empleado = EmpEmpleado::find($OprAsignaServicio->empleado_id);
        //Trae los datos de bodega basado en datos de empleado
        $cli_ubicacion_bodega = CliUbicacionBodega::where('patio_id', $empleado->patio_id)->first();

        //Evalua el estado del ITEM Si es 1 lo sube a 2, si es 2 lo sube a 3
        //1=Asignado, 2=Recibido, 3=Terminado, 4=Lista Pago, 5=Cancelado, incia con valor 1
        if($OprAsignaServicio->estado == 1){
            //***************************************************************************** */
            //AQUI VA EVALUACION Y DEBITO DE EXISTENCIA DE LOS INSUMOS DEL SERVICIO
            //Se debe dirigir a clase especilista, "DEBITA" la cantidad de insumos requeridos
            //Implementa clase: PARAM $bodega_id, $servicio_id    
            //***************************************************************************** */ 
            $insumo_requerido = new DescuentoInsumo($cli_ubicacion_bodega->bodega_id, $OprAsignaServicio->servicio_id); 
            //Valida si proceso termino EXITOSAMENTE
            if($insumo_requerido->getTermino()){
                $mensaje = $insumo_requerido->getMessaje();
                OprAsignaServicio::where('token', $token)
                    ->update(['estado' => 2]);
            }else{
                return back()->withInput()->withErrors($insumo_requerido->getMessaje());
            }

        }elseif($OprAsignaServicio->estado == 2){
            OprAsignaServicio::where('token', $token)
                    ->update(['estado' => 3]);

        }else{
            return back()->withInput()->withErrors("Estado de asignación inconsistente.");
        }

        //Evalua si todos los ítems estan cerrados, si true, cambia estado del servicio y lo
        //ENVIA A CALIDAD Y BAJA INSUMOS EN INVENTARIO
        if(!OprAsignaServicio::where('servicio_id', $OprAsignaServicio->servicio_id)->whereIn('ope_item_servicio_empledo.estado', [1, 2])->exists()){
            //Instancia y Corre Clase cambiadora de estados
                                            //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
            $estado = new UpdateStateServ(4, $OprAsignaServicio->servicio_id, '', "Enviado a calidad desde operaciones"); 
            $estado->actualizaEstado(); //Genera la actualización
        }
        
        return redirect()->route('dashboard-operaciones.show', $OprAsignaServicio->empleado_id)
                        ->with('info', $mensaje);
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

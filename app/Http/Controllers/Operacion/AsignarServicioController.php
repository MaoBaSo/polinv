<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use App\Models\OprAsignaServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\UpdateStateServ;

use App\Models\EmpEmpleado;
use App\Models\SerItemServicio;
use App\Models\InvServicio;
use App\Models\SerServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Facades\App\Classes\Miscellany;


use Illuminate\Support\MessageBag;



class AsignarServicioController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 24;
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
     * Carga servicio con items para eleccion de tecnico
     * Recibe $id , id de servicio
     * @return Vista create
     */
    public function createWithId($id){

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga datos de servicio
        $servicio =  SerServicio::find($id);
        //Carga datos de items de servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $id)->get();

        return view('operacion.asignacion.create', compact('servicio', 'items_servicio')); 
    }

    /**
     * Carga items para eleccion de tecnico
     * Recibe $id , id de item
     * @return Vista create
     */
    public function createAsignacion($id){

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Datos de empleado tipo PLUCK
        $empleados = DB::table('emp_empleados')
                ->selectRaw('id, CONCAT(primer_nombre ," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) as nombre')
                ->pluck('nombre', 'id');
        //Carga datos de items de servicio
        $item_servicio = SerItemServicio::with('invServicio')->where('id', $id)->first();
        //Carga asignaciones del item
        $asigaciones_actuales = OprAsignaServicio::where('item_id',$id)->get();

        return view('operacion.asignacion.asigna', compact( 'empleados', 'item_servicio', 'asigaciones_actuales')); 
    }  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //VALIDA DATOS
        $Validate = Validator::make($request->all(), [
            'servicio_id' => 'required',
            'item_id' => 'required',
            'valor_comision' => 'required|numeric|min:1',
            'empleado_id' => 'required',
            'porcentaje' => 'required|numeric|min:1|max:100',
            'nota' => 'max:1000',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 
        //VERIFICA DATOS
        //Que el porcentaje no exceda acumulado el 100%
        $porcentaje_actual =  getCostoItem($request->item_id) + $request->porcentaje;
        if($porcentaje_actual > 100){
            return back()->withInput()->withErrors("Porcentaje acumulado superior al 100%");
        }

        //Gestiona valor de comison para empleado
        $valor_pagar = (($request->valor_comision * $request->porcentaje) / 100);

        //CARGA dato en la tabla
        $asignacion = new OprAsignaServicio;
            $asignacion->token = uniqid();
            $asignacion->servicio_id = $request->servicio_id;
            $asignacion->item_id = $request->item_id;
            $asignacion->empleado_id = $request->empleado_id;
            $asignacion->valor_comision = $request->valor_comision; 
            $asignacion->porcentaje = $request->porcentaje;
            $asignacion->valor_pagar = $valor_pagar;
            $asignacion->estado = 1;
            $asignacion->nota = $request->nota;
            $asignacion->creado_por = Auth::id();
        $asignacion->save();

        return redirect()->route('operacion-asignacion.createwid', $request->servicio_id)
                        ->with('info', 'Asignacion creada exitosamente');

    }

    /**
     * Cambia el estado del servicio a en proceso
     * Recibe $id, id de servicio
     */
    public function updateServicio($id){
        
        //Carga datos para validación
        $items_servicio = SerItemServicio::where('serv_servicios_id', $id)->get();
        $asigaciones_actuales = OprAsignaServicio::where('servicio_id',$id)->get();
        $asigaciones_actuales_count = DB::table('ope_item_servicio_empledo')
                                        ->select('item_id')
                                        ->where('servicio_id',$id)
                                        ->groupBy('item_id')
                                        ->get();

        //VERIFICA DATOS
        //Abre errores
        $messageBag = new MessageBag;     
        //Verifica Que los ítems esten completos $items_servicio vs $asigaciones_actuales
        if($items_servicio->count() !=  $asigaciones_actuales_count->count()){
            $messageBag->add('error', 'Inconsistencia en ítems de servicio VS asignaciones.');
        }
        //REVISAR QUE LOS ITEMS ESTEN ASIGNADOS EN SU TOTALIDAD
        //Trae cuanto deberia ser el porcentaje a alcanzar
        $porcentaje_objetivo = $items_servicio->count() * 100;
        //Gestiona el porcentaje actual
        $porcentaje_actual = 0;
        foreach ($asigaciones_actuales as $item) {
            $porcentaje_actual += $item->porcentaje;              
        }
        //Compara
        if($porcentaje_actual != $porcentaje_objetivo){
            $messageBag->add('error', 'Falta porcentaje por asigar.');
        }
        //Si hay errores aborta proceso
        if($messageBag->count() > 0){
            $erMessages = $messageBag->getMessages();
            return back()->withInput()->withErrors($erMessages); 
        }

        //Instancia y Corre Clase cambiadora de estados
                                        //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
        $estado = new UpdateStateServ(3, $id, '', 'Asignacion a técnicos'); 
        $estado->actualizaEstado(); //Genera la actualización   

        //Redirige al Controller de creacion de Ítems de servicio
        return redirect()->route('servicio.edit', $id)
                    ->with('info', "Servicio asignado con exito.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OprAsignaServicio  $oprAsignaServicio
     * @return \Illuminate\Http\Response
     */
    public function show(OprAsignaServicio $oprAsignaServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OprAsignaServicio  $oprAsignaServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(OprAsignaServicio $oprAsignaServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OprAsignaServicio  $oprAsignaServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OprAsignaServicio $oprAsignaServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OprAsignaServicio  $oprAsignaServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $itemServicio = OprAsignaServicio::findOrFail($id);
            $servicio_id = $itemServicio->servicio_id;
        $itemServicio->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Item ID= '. $id;
        Miscellany::store_log("ASIGNAR ITEMS A TECNICOS", "ELIMINA", $message);

        return redirect()->route('operacion-asignacion.createwid', $servicio_id)
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

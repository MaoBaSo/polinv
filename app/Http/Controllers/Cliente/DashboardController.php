<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SerServicio;
use App\Models\SerItemServicio;
use App\Models\InvServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use Facades\App\Classes\Cerbero;
use App\Models\OprRevisaServicio;
use Carbon\Carbon;

class DashboardController extends Controller
{

    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 21;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina
        
        //Carga contadores de servicios POR AUTORIZAR, POR RECIBIR y TOTALES
        $count_autorizar = SerServicio::where('tipo', 'Valoración')->where('estado', 1)->where('cliente_id',Auth::user()->company_id)->count();
        $count_recibir = SerServicio::where('tipo', 'Orden Trabajo')->where('estado', 3)->where('cliente_id',Auth::user()->company_id)->count();
        
        //Carga lista de servicios del cliente incluidos unicamente POR AUTORIZAR y POR RECIBIR
        //Versión 1 unicamente servicios POR AUTORIZAR
        //->orWhere('tipo', 'Orden Trabajo')->where('estado', 3)
        $servicios = SerServicio::where('tipo', 'Valoración')->where('estado', 1)
                                ->orWhere('tipo', 'Orden Trabajo')->where('estado', 3)
                                ->where('cliente_id',Auth::user()->company_id)->get();

        return view('dashboardCliente', compact('count_autorizar', 'count_recibir', 'servicios'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$id)->first();
        //Items que componen el servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $id)->get();

        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $id)
            ->where('serv_servicios_items.deleted_at', null)
            ->first();

        //Carga porcetnaje de IVA
        $iva = Miscellany::getParameterKey("IVA");
        //Carga valores con descuentos para sacar el iva despues
        $valMenDesc =  Miscellany::getValServicio($id);
        //Gestiona valor de IVA
        $val_iva = (($valMenDesc * (int)$iva[0]->variable_1) /100);

        //Usuario
        $user_creator = Cerbero::getUserId($servicio->creado_por);


        return view('dashboardCliente.servicios.show', compact('servicio', 'items_servicio', 'tipo_vehiculo', 'val_iva', 'user_creator')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCalidad($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        //$this->caso_uso = 17;
        //$this->cerbero('crea');//lee, crea, edita, elimina

        //VALIDACION, Tiene calidad asociada
        if(!OprRevisaServicio::where('serv_servicios_id', $id)->exists()){
            return back()->withInput()->withErrors("Proceso de Calidad No Existe");
        }

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$id)->first();

        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $id)
            ->first();

        //Trae los datos de los ítems joineados
        $items_servicio = DB::table('serv_servicios_items')
            ->join('ope_calidad', 'ope_calidad.item_id', '=', 'serv_servicios_items.id')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->join('serv_servicios', 'serv_servicios.id', '=', 'serv_servicios_items.serv_servicios_id')
            ->select(DB::raw('serv_servicios_items.id, ope_calidad.nota, ope_calidad.creado_por, ope_calidad.cant_img, inv_servicios.nombre, inv_servicios.sku, serv_servicios_items.valor, serv_servicios.movil, serv_servicios_items.accion'))
            ->where('serv_servicios_items.serv_servicios_id', $id)
            ->where('serv_servicios_items.deleted_at', '=', null)
            ->where('ope_calidad.deleted_at', '=', null)
            ->where('inv_servicios.deleted_at', '=', null)
            ->get();

        
        //Trae fecha y hora de Inicio y Fin de proceso DATO MUY IMPORTANTE DEBE SER AFINADO
        //Fecha de inicio, se toma la hora de la toma del ultimo ítem
        $tiempo_inicio = DB::table('serv_servicios_items')
            ->select(DB::raw('max(created_at) as tiempo_inicio'))
            ->where('serv_servicios_id', $id)
            ->where('deleted_at', '=', null)
            ->first();

        //Fecha de fin, se toma la hora de la toma del primer ítem revisado
        $tiempo_fin = DB::table('ope_calidad')
            ->select(DB::raw('min(created_at) as tiempo_fin'))
            ->where('serv_servicios_id', $id)
            ->where('deleted_at', '=', null)
            ->first();


        $date = Carbon::now(); 
        $impresion = $date->toDateTimeString();    
        


        return view('dashboardCliente.calidad.show', compact('servicio', 'tipo_vehiculo', 'items_servicio', 'tiempo_inicio', 'tiempo_fin', 'impresion', 'date'));


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
        //
    }
}

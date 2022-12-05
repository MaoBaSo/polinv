<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SerServicio;
use App\Models\SerItemServicio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use Facades\App\Classes\Cerbero;
use App\Models\SegFirma;

class BusquedaContoller extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 30;
    }    
    
    /**
     * Gestion de busqueda de servicios
     */
    public function filtroBuscar(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina 

        //Retorna filtro de busqueda
        return view('reporte.vista.busqueda.filtro'); 
    }

    public function buscarServicios(Request $request){
        //Trae y gestiona los parametros y realiza la busqueda
        //pasa a index busqueda 

        if(!is_null($request->fecha_desde) &&  !is_null($request->fecha_hasta)){
            //Agrega un dia a la busqueda para optimizar el rango
            $date = Carbon::parse($request->fecha_hasta);
            $hasta_fecha = $date->addDay();
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::whereBetween('fecha_servicio', [$request->fecha_desde, $hasta_fecha])
                ->where('cliente_id', Auth::user()->company_id)->get();
        
        }elseif(!is_null($request->numero_cotizacion)){
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::where('id', $request->numero_cotizacion)
                ->where('cliente_id', Auth::user()->company_id)->get();

        }elseif(!is_null($request->numero_orden_trabajo)){
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::where('numero_orden_trabajo', $request->numero_orden_trabajo)
                ->where('cliente_id', Auth::user()->company_id)->get();

        }elseif(!is_null($request->numero_orden_compra)){
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::where('numero_orden_compra', $request->numero_orden_compra)
                ->where('cliente_id', Auth::user()->company_id)->get();

        }elseif(!is_null($request->numero_movil)){
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::where('movil', $request->numero_movil)
                ->where('cliente_id', Auth::user()->company_id)->get();
                
        }elseif(!is_null($request->numero_placa)){
            //Carga un servicio en especifico para ser mostrado  
            $servicios = SerServicio::where('placa', $request->numero_placa)
                ->where('cliente_id', Auth::user()->company_id)->get();

        }else{
            return back()->withInput()->withErrors("Elija un filtro para la busqueda");
        } 
        
        return view('reporte.vista.busqueda.index', compact('servicios'));
    }

    public function showServicio($id){

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
        //Creado POR:
        $creado_por = Cerbero::getUserId($servicio->creado_por);
        //FIRMA y autorizado POR
        $firma = SegFirma::where('servicio_id', $servicio->id)->first();
        if(!is_null($firma)){
            $autorizado_por = Cerbero::getUserId($firma->creado_por);
        }else{
            $autorizado_por = null;
        }

         return view('reporte.vista.busqueda.show', compact('servicio', 'items_servicio', 'tipo_vehiculo', 'val_iva', 'creado_por', 'firma', 'autorizado_por'   )); 

    }


}

<?php
/**
 * Clase General para soporte de lectura sobre bases de datos
 * Author: Mauricio Baquero Soto
 * Enero de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\Parametro;
use App\Models\SerServicio;
use App\Models\SerItemServicio;
use App\Models\Log;
use App\Models\OprAsignaServicio;
use App\Models\InvBodega;
use App\Models\SerIndiceImagenes;
use App\Models\InvProducto;
use App\Models\CliPatios;

/**
 * Clases miscelaneas de soporte para el aplicativo 
 */

class Miscellany{

    /*
    *TABLA PARAMETROS******************************************************************************
    */
    
    public function getParameterKey($key){
        //Trae todos los Datos del parametro de la tabla sin formato, con filtro de KEY
        $parametros = Parametro::where('key', $key)->get();

        return $parametros;
    }

    public function getParameterId($id){
        //Trae todos los Datos del parametro de la tabla sin formato, con filtro de KEY
        $parametros = Parametro::find($id);

        return $parametros;
    }

    public function pluck_parameters($key){
        //Trae parametros tipo pluck cargar selects, con filtro de KEY
        $parametros = Parametro::where('key', $key)
                        ->pluck('variable_1', 'id');

        return $parametros;
    }

    public function find_parameter($key, $variable_1){
        //Trae parametros con filtro de KEY y DESCRIPCION_1
        $parametros = Parametro::where('key', $key)
                                ->where('variable_1', $variable_1)->first();
        return $parametros;
    }
    /**
     * TABLA LOG***********************************************************************************
     */
    public function store_log($m_procedencia, $m_tipo, $m_descripcion){
        //CARGA dato en la tabla LOGEAR
        $log = new Log;
            $log->procedencia = $m_procedencia;
            $log->tipo = $m_tipo;
            $log->descripcion = $m_descripcion;
        $log->save();        

    }
    
    /**
     * TABLAS IMPLICITAS (DATOS HARD DEL APLICATIVO)***********************************************
     */

    //Devuelve el estado de servicio  
    public function getEstadoServicio($estado){
        //1=Abierto, 2=En Proceso, 3=Control Calidad(JPEX), 4=Cerrado(Aceptado Cliente), 5=Cancelado
        switch ($estado) {
            case 1:
                $resp = "Abierto";
                break;
            case 2:
                $resp = "En Proceso";
                break;
            case 3:
                $resp = "Control Calidad";
                break;
            case 4:
                $resp = "Cerrado";
                break;                
            case 5:
                $resp = "Cancelado";
                break;                
        }

        return $resp;
    }

    /**
     * Soporte de dashboard de Técnico************************************************************
     */
    //Servicios por recibir segun id de empleado
     public function getCantServRecibir($id){
        //1=Asignado, 2=Recibido, 3=Terminado, 4=Lista Pago, 5=Cancelado, incia con valor 1 
        $cantidad = OprAsignaServicio::where('empleado_id', $id)
                                ->where('estado', 1)
                                ->count();
        return $cantidad;

     }
    //Servicios por cerrar segun id de empleado
    public function getCantServCerrar($id){

        //1=Asignado, 2=Recibido, 3=Terminado, 4=Lista Pago, 5=Cancelado, incia con valor 1 
        $cantidad = OprAsignaServicio::where('empleado_id', $id)
                                ->where('estado', 2)
                                ->count();
        return $cantidad;

    }
    //Servicio más antiguo por gestionar segun id de empleado
    public function getServAntiguo($id){

        $mas_antiguo = OprAsignaServicio::where('empleado_id', $id)
                                ->whereIn('estado', [1, 2])
                                ->orderBy('created_at')
                                ->first();

        if(!is_null($mas_antiguo)){
            $servicio = SerServicio::find($mas_antiguo->servicio_id);
        }else{
            $servicio = null;
        }

        return $servicio;

    }

    /**
     * Consultas GENERALES*************************************************************************
     */

    public function getSubLineasWithPais(){
        //Retorna PLUCK de sublineas por le pais de el usuario conectado
        $sublineas = DB::table('inv_sub_linea')
            ->select('inv_sub_linea.id', 'inv_sub_linea.nombre')
            ->Join('inv_linea', 'inv_sub_linea.linea_id', '=', 'inv_linea.id')
            ->where('inv_linea.pais_id', Auth::user()->pais_id)
            ->where('inv_linea.deleted_at', '=', null) 
            ->pluck('nombre', 'id');        

            return $sublineas;
    }
    
    //Trae el nombre de la bodega por su numero de ID
    public function getNameBodega($id){
        //Retorna nombre de la bodega

        if(!is_null($id)){
            $bodega = InvBodega::find($id);
            $respuesta = $bodega->nombre;
        }else{
            $respuesta = null;
        }

        return $respuesta;
    }

    //Opera los valores del servicio y del item del servicio con descuentos************************
    public function getValServicio($id){

        //Carga datos de servicio
        $servicio = SerServicio::find($id);
        //Trae datos de valores de servicio y de descuento
        $valor = SerItemServicio::where('serv_servicios_id', $servicio->id)->sum('valor');
        $descuento = SerItemServicio::where('serv_servicios_id', $servicio->id)->sum('descuento');
        //Opera cifras
        $val = ($valor - $descuento);

        return $val;
    }

    public function getDescServicio($id){

        //Carga datos de servicio
        $servicio = SerServicio::find($id);
        //Trae datos de valoresde descuento
        $descuento = SerItemServicio::where('serv_servicios_id', $servicio->id)->sum('descuento');

        return $descuento;
    }

    public function getValItem($id){
        
        //Trae datos de valores de servicio y de descuento
        $valor = SerItemServicio::where('id', $id)->sum('valor');
        $descuento = SerItemServicio::where('id', $id)->sum('descuento');
        //Opera cifras
        $val = ($valor - $descuento);

        return $val;
        
    }

    public function getCostoItem($id){
        //$id = id item 
        //Trae el porcentaje asignado a técnico
        $porcentaje_asignado =  OprAsignaServicio::where('item_id', $id)->sum('porcentaje');
        return $porcentaje_asignado;
    }

    //Castea una fecha de string a date y la formatea Año Mes Dia    
    public function castFechaYMD($fecha){

        return Carbon::parse($fecha)->format('Y-m-d');
    }

    //Carga listado de imagenes de un item SERVICIO
    public function getListImgItem($item_id){
        $images = SerIndiceImagenes::where('item_id',$item_id)
                        ->where('origen', 1)    
                        ->get();
        return $images ;
    }

    //Carga listado de imagenes de un item CALIDAD
    public function getListImgQA($item_id){
        $images = SerIndiceImagenes::where('item_id',$item_id)
                        ->where('origen', 2)    
                        ->get();
        return $images ;
    }

    //Carga un producto
    public function getProducto($producto_id){
        $producto = InvProducto::find($producto_id);
        return $producto ;
    }

    //Carga datos del patio/ubicacion a taves del ID
    public function getPatio($patio_id){
        $patio = CliPatios::find($patio_id);
        return $patio ;
    }

    
}
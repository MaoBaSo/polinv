<?php
/**
 * Clase General para soporte de CONSTRAINTS de aplicativo
 * Author: Mauricio Baquero Soto
 * Mayo de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\SerServicio;

class Constraints{
    
    //Número de Orden de Trabajo UNICA
    public static function CNS_001($paso, $orden_trabajo){
            /**
             * Restricción solicitada para Colombia
             * 20 Mayo 2.022
             * IMPLEMENTACIONES
             * ServicioController -> updateState
             * FirmaController -> store
             */
            $return = false;        
            //Unicamente se evalua si el paso del servicio es 2
            if($paso == 2){
                //Evalua el pais en el cual se esta solicitando la transacción
                if(Auth::user()->pais_id == 1){
                    //Si orden existe
                    $return = SerServicio::where('numero_orden_trabajo', $orden_trabajo)->exists();
                }
            }
        return $return;
    }


}
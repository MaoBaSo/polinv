<?php
/**
 * Clase General helpers
 * Author: Mauricio Baquero Soto
 * Marzo de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

    use Facades\App\Classes\Miscellany;
    use Facades\App\Classes\Crypto;
    use Facades\App\Classes\Cerbero;

    //Devuelve el estado de servicio  
    function getEstadoServicio($estado){
        //1=Abierto, 2=En Proceso, 3=Control Calidad(JPEX), 4=Cerrado(Aceptado Cliente), 5=Cancelado
        return Miscellany::getEstadoServicio($estado);
    }

    function getParameterId($id){
        //Trae todos los Datos del parametro de la tabla sin formato, con filtro de KEY
        return Miscellany::getParameterId($id);
    }

    function getValServicio($id){
        //Carga valor de servicio con descuento
        return Miscellany::getValServicio($id);
    }
    
    function getDescServicio($id){

        //Carga datos de servicio
        return Miscellany::getDescServicio($id);
    }

    function getValItem($id){
        //carga valor de ítem con descuento
        return Miscellany::getValItem($id);
    } 
    
    //Retorna usuario por su id
    function getUserId($id){
        return Cerbero::getUserId($id);
    
    }    

    function getCostoItem($id){
        //$id = id item 
        //Trae el porcentaje asignado a técnico
        $porcentaje_asignado =  Miscellany::getCostoItem($id);
        return $porcentaje_asignado;
    }

    //Retorna empleado por su id
    function getEmpleado($id){
        return Cerbero::getEmpleado($id);
    }

    //Servicios por recibir segun id de empleado
    function getCantServRecibir($id){
        return Miscellany::getCantServRecibir($id);
     }

    //Servicios por recibir segun id de empleado
    function getCantServCerrar($id){
        return Miscellany::getCantServCerrar($id);
     }

    //Servicio más antiguo por gestionar segun id de empleado
    function getServAntiguo($id){
        return Miscellany::getServAntiguo($id);
    }

    //Retorna NOMBRE usuario por su id
    function getUserName($id){
        return Cerbero::getUserName($id);
    }

    //Retorna nombre de la bodega  
    function getNameBodega($id){          
        return Miscellany::getNameBodega($id);
    }

    //Castea una fecha de string a date y la formatea Año Mes Dia
    function castFechaYMD($fecha){
        return Miscellany::castFechaYMD($fecha);
    }
    
    //Carga listado de imagenes de un item SERVICIO
    function getListImgItem($item_id){
        return Miscellany::getListImgItem($item_id);
    }

    //Carga listado de imagenes de un item CALIDAD
    function getListImgQA($item_id){
        return Miscellany::getListImgQA($item_id);
    }

    //Carga datos del patio/ubicacion a taves del ID
    function getPatio($patio_id){
        return Miscellany::getPatio($patio_id);
    }






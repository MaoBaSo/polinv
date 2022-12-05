<?php
/**
 * Clase General para soporte de seguridad basado en Roles y permisos. 
 * Author: Mauricio Baquero Soto
 * Enero de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permiso;
use App\Models\User;
use App\Models\EmpEmpleado;

use Illuminate\Http\Request;


class Cerbero{
    /**
     * Clases soporte de seguridad, evalua tipos de rol del usurio conectado
     * contra la opcion que quiere ejecutar
     */
    
    //Consulta si el usuario esta autorizado para efectuar la operación solicitada 
    public function porter($casoUso, $operacion){
        //Rol-> El id de rol de la tabla de usuarios
        //casoUso-> nombre del caso que esta utilizando
        //Operacion-> Lectura, Edicion, Creacion, Eliminacion
        //Auth::id()
        $answer = Permiso::where('rol_id', Auth::user()->rol_id)
                            ->where('caso_id', $casoUso)
                            ->where($operacion, 1)
                            ->exists();
        return $answer;  
    }

    //Retorna objeto usuario Nombre + id 
    public function get_user(){
        //Trae Usuaarios tipo pluck cargar selects.
        $answer = User::where('deleted_at', '=' , null)
                        ->pluck('id','name');

        return $answer;  
    }
    
    //Retorna la IP del equipo que se conecta
    public function getIP(){

        return $_SERVER['REMOTE_ADDR'];
        
    }
    
    //Retorna usuario por su id
    public function getUserId($id){
        return User::find($id);
    }
    
    //Retorna empleado por su id
    public function getEmpleado($id){
        return EmpEmpleado::find($id);
    }

    //Retorna NOMBRE usuario por su id
    public function getUserName($id){

        return User::find($id)->name;
    
    }

}
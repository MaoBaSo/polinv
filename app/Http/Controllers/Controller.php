<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Facades\App\Classes\Cerbero;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cerbero($operacion)
    {
        //GESTION DE SEGURIDAD DIPONIBLE PARA IMPLEMENTAR DESDE TOSOS LOS CONTROLLERS
        //                       ID_CasoUso, Operacion
        if(!Cerbero::porter($this->caso_uso, $operacion)){
            abort(401);
        }//lee, crea, edita, elimina
    
    }

}

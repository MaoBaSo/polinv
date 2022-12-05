<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\V_Productos;

class HomeController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 9;
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

        //Trae la lista de productos con sus cantidades
        $productos = V_Productos::where('pais_id', Auth::user()->pais_id)                        
                                    ->paginate(15);

        //Retorna vista general de inventario VISTA EN BASE DE DATOS
        //Desde la vista se gestiona BodegaRproducto y Kardex

        return view('inventario.home.index', compact('productos')); 
    }

}

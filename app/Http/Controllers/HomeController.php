<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Efectua la redirección del dashboard correspondiente
        //Según el dato de users->tipo_id
        switch (Auth::user()->tipo_id) {
            case 9:
                return view('dashboardAdmin');
                break;
            case 10:
                return redirect()->route('gestion-operativa.index');
                break; 
            case 98:
                return view('dashboardLab');
                break;
            case 0:
                $messaje = "No Autorizado";
                abort('403', $messaje);
                break;
            default:
                $messaje = "No Autorizado";
                abort('403', $messaje);
            }
        
    }

}

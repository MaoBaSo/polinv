<?php
/**
 * Facade de informes exportados a XLSX. 
 * Author: Mauricio Baquero Soto
 * Abril de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */
namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Exports\Servicios;
use App\Exports\ServiciosBase;
use Carbon\Carbon;

class ReportesXLSXController extends Controller
{
    /**
     * Informe de servicios e ítems, se generan tantas columnas como ítems haya por servicio
     */
    public function filtroServicios(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 18;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna ventana de solicitud de rango de fechas
        return view('reporte.xlsx.servicios.create'); 
    }
    
    public function getServicios(Request $request){

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'fecha_desde' => 'required',
            'fecha_hasta' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 

        return Excel::download(new Servicios($request->fecha_desde, $request->fecha_hasta), 'Item_Servicios.xlsx');

    }

    /**
     * Informe de servicios, se genera unicamente la linea del servicio
     */
    public function filtroServiciosBase(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 18;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna ventana de solicitud de rango de fechas
        return view('reporte.xlsx.servicios.filter-service'); 
    }
    
    public function getServiciosBase(Request $request){

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'fecha_desde' => 'required',
            'fecha_hasta' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 

        return Excel::download(new ServiciosBase($request->fecha_desde, $request->fecha_hasta), 'Servicios-base.xlsx');

    }







}

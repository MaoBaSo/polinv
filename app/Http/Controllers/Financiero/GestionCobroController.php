<?php

namespace App\Http\Controllers\Financiero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CobroServicios;
use App\Models\SerServicio;

class GestionCobroController extends Controller
{

    public function __construct(){
        //ID Unico de caso de Uso
        //$this->caso_uso = 28;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reporte.xlsx.cobro-servicios.create'); 
    }

    /**
     * Genera Archivo de Excel
     *
     */
    public function showInfo()
    {
        //Gestión de seguridad heredada desde la base del Controller
        //$this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna el informe de servicios a pagar
       return Excel::download(new CobroServicios, 'Reporte_Cobro.xlsx');
    }

    /**
     * Cierra periodo
     *
     */
    public function closePeriod()
    {

        //Gestión de seguridad heredada desde la base del Controller
        //$this->cerbero('elimina');//lee, crea, edita, elimina

        //Cambia estado de servicio de 4 a 5
        SerServicio::where('tipo', 'Orden Compra')
                    ->where('estado', 4)
                    ->update(['estado' => 5]);

        return redirect()->route('cobros.index')
                        ->with('info', 'Proceso cerrado exitosamente');
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
        //
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

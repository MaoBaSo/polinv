<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagoComision;
use App\Models\OprAsignaServicio;

class PagoComisionController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 28;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Retorna el informe de servicios a pagar
       // return Excel::download(new PagoComision, 'Pago_comision.xlsx');

       return view('reporte.xlsx.liq-nomina.create'); 
    }

    /**
     * Genera Archivo de Excel
     *
     */
    public function showInfo()
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna el informe de servicios a pagar
       return Excel::download(new PagoComision, 'Pago_comision.xlsx');
    }

    /**
     * Cierra periodo
     *
     */
    public function closePeriod()
    {

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        //Cambia estado de servicio de 3 a 4
        //1=Asignado, 2=Recibido, 3=Terminado, 4=Lista Pago, 5=Cancelado, incia con valor 1 
        OprAsignaServicio::where('estado', 3)
            ->update(['estado' => 4]);

        return redirect()->route('empleado-pago.index')
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

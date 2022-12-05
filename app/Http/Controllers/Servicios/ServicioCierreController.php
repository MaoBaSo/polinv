<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SerServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\OprAsignaServicio;
use App\Classes\UpdateStateServ;

class ServicioCierreController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 29;
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

        //Carga los servicios que esten cerrados para realizar proceso de finalización
        $servicios = SerServicio::with('patio')->where('pais_id', '=' , Auth::user()->pais_id)
                ->where('tipo', 'Orden Trabajo')
                ->where('estado', 4)
                ->get();

        return view('servicio.cierre-servicio.index', compact('servicios')); 
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
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina 

        //Valida la existencia de datos requeridos
        $Validate = Validator::make($request->all(), [
            'paso_id' => 'required',
            'servicio_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }
        
        //Verifica que no este siendo procesado por técnicos
        $servicio_bloqueado = OprAsignaServicio::where('servicio_id', $request->servicio_id)
                                        ->where('estado','<' , 3)
                                        ->exists();
        if($servicio_bloqueado){
            return back()->withInput()->withErrors("Servicio esta siendo procesado por los técnicos.");
        }

        //Instancia y Corre Clase cambiadora de estados
                                        //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
        $estado = new UpdateStateServ($request->paso_id, $request->servicio_id, $request->numero_documento, $request->nota); 
        $estado->actualizaEstado(); //Genera la actualización        

        //Redirige al Controller de creacion de Ítems de servicio
        return redirect()->route('servicio-cerrar.index')
                    ->with('info', "Servicio Finalizado");

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

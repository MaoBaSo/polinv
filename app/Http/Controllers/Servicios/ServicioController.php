<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Models\SerServicio;
use Illuminate\Http\Request;

use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use App\Models\CliPatios;
use App\Models\CliCliente;
use App\Models\SerItemServicio;
use App\Models\InvServicio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\SerAdmTiempo;
use Exception;
use App\Models\OprAsignaServicio;

use App\Classes\UpdateStateServ;
use App\Classes\Constraints;

class ServicioController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 14;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Revisa si tiene patio_id, de lo contrario filtra por pais del usuario y estado,
        //Solo aparecen estados abierto, en proceso y control de calidad
        if(!is_null(Auth::user()->patio_id)){
            $servicios = SerServicio::with('patio')->where('patio_id', '=' , Auth::user()->patio_id)
            ->whereIn('estado', [1, 2, 3])
            ->get();
            $conPatio = "S";
        }else{
            $servicios = SerServicio::with('patio')->where('pais_id', '=' , Auth::user()->pais_id)
            ->whereIn('estado', [1, 2, 3])
            ->get();
            $conPatio = "N";
        }

        return view('servicio.index', compact('servicios', 'conPatio')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Cliente
        $cliente = CliCliente::find(Auth::user()->company_id);
        //Patio de cliente
        $patio_cliente = CliPatios::find(Auth::user()->patio_id);
        //Si usurio no tiene datos de cliente o patio aborta
        if(is_null($cliente) || is_null($patio_cliente)){
            abort('403', "Usuario no parametrizado en Cliente o patio del Cliente");
        }

        //Tipo de registro
        $tipo_registro = "Valoración";
        //Valor procedimiento
        $valor_procedimiento = 0;
        //Creado Por
        $creado_por = Auth::user()->name;

        //Carga vista de Formulario de CREACION de Roles 
        return view('servicio.create', compact('cliente', 'patio_cliente', 'tipo_registro', 'valor_procedimiento', 'creado_por'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos del servicio
        //Crea registro en la tabla de Servicios
        //Retorna a edicion para crear items del servicio
        //CARGA dato en la tabla

        /** OT: 260522-012
         * El campo PLACA no se utiliza, se pone el campo placa como nulleable en base de datos
         */

        //Valida datos
        $Validate = Validator::make($request->all(), [
            // OT: 260522-012 'placa' => 'required|max:10',
            'movil' => 'required|max:20',
            'fecha_servicio' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }

        $servicio = new SerServicio;
            $servicio->patio_id = Auth::user()->patio_id;
            $servicio->cliente_id = Auth::user()->company_id;
            $servicio->pais_id = Auth::user()->pais_id;
            $servicio->nota_servicio = $request->notas;
            // OT: 260522-012 $servicio->placa = strtoupper(mb_convert_encoding(mb_convert_case($request->placa, MB_CASE_UPPER), "UTF-8"));
            $servicio->movil = strtoupper(mb_convert_encoding(mb_convert_case($request->movil, MB_CASE_UPPER), "UTF-8"));
            $servicio->tipo = "Valoración";//Valoracion -> Orden Trabajo -> Orden Compra
            $servicio->estado = 1; //Carga automaticamente 1 | 1=Abierto, 2=En Proceso, 3=Control Calidad(JPEX), 4=Cerrado(Aceptado Cliente), 5=Cancelado
            $servicio->valor_bruto_procedimiento  = 0;
            $servicio->creado_por = Auth::id();
            $servicio->fecha_servicio = $request->fecha_servicio;
        $servicio->save();

        //Redirige al Controller de creacion de Ítems de servicio
        return redirect()->route('servicio.edit', $servicio->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerServicio  $serServicio
     * @return \Illuminate\Http\Response
     */
    public function show(SerServicio $serServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SerServicio  $serServicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$id)->first();
        //Items que componen el servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $id)->get();
        //Carga tipos de servicios
        $tipoServicios = InvServicio::pluck('nombre', 'id');

        //Carga vista de Formulario de EDICION de Líneas 
        return view('servicio.edit', compact('servicio', 'items_servicio', 'tipoServicios')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerServicio  $serServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerServicio $serServicio)
    {
        //
    }

    //Actualiza el estado de un servicio
    public function updateState(Request $request)
    {       
        //VALIDA datos requeridos
        $Validate = Validator::make($request->all(), [
            'paso_id' => 'required',
            'servicio_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }
        //VERIFICA CONSTRAINTS
        if(Constraints::CNS_001($request->paso_id, $request->numero_documento)){
            return back()->withInput()->withErrors("CNS001 - Orden de Trabajo ya Existe.");
        }

        //VERIFICA que no este siendo procesado por técnicos
        if(OprAsignaServicio::where('servicio_id', $request->servicio_id)->whereIn('estado', [1, 2])->exists()){
            return back()->withInput()->withErrors("Servicio esta siendo procesado por los técnicos.");
        }


        //Instancia y Corre Clase cambiadora de estados
                                        //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
        $estado = new UpdateStateServ($request->paso_id, $request->servicio_id, $request->numero_documento, $request->nota); 
        $estado->actualizaEstado(); //Genera la actualización        

        //Redirige al Controller de creacion de Ítems de servicio
        return redirect()->route('servicio.edit', $request->servicio_id)
                    ->with('info', $estado->getMessaje());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerServicio  $serServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //Gestión de seguridad heredada desde la base del Controller
            $this->cerbero('elimina');//lee, crea, edita, elimina

            DB::beginTransaction();

                //Elimina servicio
                $servicio = SerServicio::findOrFail($id);
                $servicio->delete();
                //Elimina ítem
                $item = SerItemServicio::where('serv_servicios_id', $id);
                $item->delete();
                //CARGA dato en la tabla LOGEAR
                $message = 'Usuario='. Auth::id() .' Servicio ID= '. $id;
                Miscellany::store_log("GESTION SERVICIOS", "ELIMINA", $message);

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.index');

    }

    /**
     * Deletea Orden de Trabajo
     * Siempre y cuando NO tenga Orden de compra
     */
    public function deleteOT(Request $request)
    {
        try {
            //Gestión de seguridad heredada desde la base del Controller
            $this->cerbero('elimina');//lee, crea, edita, elimina

            //Valida datos
            $Validate = Validator::make($request->all(), [
                'orden_trabajo' => 'required|max:50',
                'motivo' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }
            //Carga el servicio por su orden de trabajo
            $servicio_find = SerServicio::where('numero_orden_trabajo', $request->orden_trabajo)->first();
            //EVALUACIONES
            if(!is_null($servicio_find)){
                if(!is_null($servicio_find->numero_orden_compra)){
                    return back()->withInput()->withErrors("Servicio tiene Orden de Compra asociada");
                }
            }else{
                return back()->withInput()->withErrors("Numero de OT sin datos en el sistema");
            }

            DB::beginTransaction();

                //Elimina servicio
                $servicio = SerServicio::findOrFail($servicio_find->id);
                $servicio->delete();
                //Elimina ítem
                $item = SerItemServicio::where('serv_servicios_id', $servicio_find->id);
                $item->delete();
                //CARGA dato en la tabla LOGEAR
                $message = 'Usuario='. Auth::id() .' Servicio ID= '. $servicio_find->id;
                Miscellany::store_log("GESTION SERVICIOS", "ELIMINA", $message);
                //Crea registro de movimiento
                SerAdmTiempo::create([
                    'serv_servicios_id' => $servicio_find->id,
                    'nuevo_tipo' => $servicio_find->tipo,
                    'nuevo_estado' => $servicio_find->estado,
                    'nota' => "Servicio Eliminado : " .  $request->motivo,
                    'creado_por' => Auth::id(),
                ]);

            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.index');

    }


}

<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvServicio;
use App\Models\InvSubLinea;

use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametro;
use App\Models\InvInsumos;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 7;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $servicios = InvServicio::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('nombre')
                        ->get();

        return view('inventario.servicios.index', compact('servicios')); 
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

        //Carga listado de Sub lineas para conbobox
        $tipo_vehiculo = Miscellany::pluck_parameters("TIPO_VEHICULO");
        
        //Carga vista de Formulario de CREACION de Roles 
        return view('inventario.servicios.create', compact('tipo_vehiculo'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Valida datos GENERALES
        $Validate = Validator::make($request->all(), [
            //'nombre' => 'required|max:200|unique:inv_servicios,nombre',
            //'sku' => 'required|max:100|unique:inv_servicios,sku',
            'nombre' => 'required|max:200',
            'tipo_vehiculo' => 'required|max:50',
            'codigo_servicio' => 'required|max:50',
            'valor_reparar_pintar' => 'required|numeric', 
            'valor_cambiar_pintar' => 'required|numeric',
            'valor_cambiar_reparar' => 'required|numeric',
            'valor_fabricar' => 'required|numeric',            
            'valor_base_hora' => 'required|numeric|min:1',
            'tiempo_estandar' => 'required|numeric|min:1',

        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        //Validar que el SKU que es un dato compuesto no exista
        $sku = "sku = '" . $request->tipo_vehiculo . '-'  . $request->codigo_servicio . "'";
        $exists =  DB::table('inv_servicios')
                ->whereRaw($sku)
                ->exists();
        if($exists){
            return back()->withInput()->withErrors("SKU ya existe en la base de datos.");
        }
        //Validar que al menos 1 dato venga con valor
        $valor = $request->valor_reparar_pintar +  $request->valor_cambiar_pintar +  $request->valor_cambiar_reparar +  $request->valor_fabricar; 
        if($valor <= 0){
            return back()->withInput()->withErrors("El valor del servicio NO puede ser 0.");
        }

        //CARGA dato en la tabla
        $InvServicio = new InvServicio;
            $InvServicio->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $InvServicio->sku = strtoupper(mb_convert_encoding(mb_convert_case($request->tipo_vehiculo . '-'  . $request->codigo_servicio , MB_CASE_UPPER), "UTF-8"));
            $InvServicio->tipo_vehiculo = $request->tipo_vehiculo;
            $InvServicio->codigo_servicio = $request->codigo_servicio;
            $InvServicio->valor_reparar_pintar = $request->valor_reparar_pintar;
            $InvServicio->valor_cambiar_pintar = $request->valor_cambiar_pintar;
            $InvServicio->valor_cambiar_reparar = $request->valor_cambiar_reparar;
            $InvServicio->valor_fabricar = $request->valor_fabricar;
            $InvServicio->valor_base_hora = $request->valor_base_hora;
            $InvServicio->tiempo_estandar = $request->tiempo_estandar;
            $InvServicio->caracteristicas = $request->caracteristicas;
            $InvServicio->pais_id = Auth::user()->pais_id;
        $InvServicio->save();

        return redirect()->route('inventario-servicios.index')
                        ->with('info', 'Servicio creado exitosamente');
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
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga listado de Sub lineas para conbobox
        $tipo_vehiculo = Miscellany::pluck_parameters("TIPO_VEHICULO");
        //Carga una servicio en especifico para ser mostrado  
        $servicio = InvServicio::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.servicios.edit', compact('tipo_vehiculo', 'servicio'));     
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
         //Valida datos
         $Validate = Validator::make($request->all(), [

            //'nombre' => [
            //    'required',
            //    'max:200',
            //    Rule::unique('inv_servicios')->ignore($request->nombre, 'nombre')
            //],

            //'sku' => [
            //    'required',
            //    'max:100',
            //    Rule::unique('inv_servicios')->ignore($request->sku, 'sku')
            //],

            'nombre' => 'required|max:200',
            'tipo_vehiculo' => 'required|max:50',
            'codigo_servicio' => 'required|max:50',
            'valor_reparar_pintar' => 'required|numeric', 
            'valor_cambiar_pintar' => 'required|numeric',
            'valor_cambiar_reparar' => 'required|numeric',
            'valor_fabricar' => 'required|numeric',            
            'valor_base_hora' => 'required|numeric|min:1',
            'tiempo_estandar' => 'required|numeric|min:1',

        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }     
        
        //Validar que el SKU que es un dato compuesto no exista
        $sku = "sku = '" . $request->tipo_vehiculo . '-'  . $request->codigo_servicio . "' AND id <> " . $id;
        $exists =  DB::table('inv_servicios')
                ->whereRaw($sku)
                ->exists();
        if($exists){
            return back()->withInput()->withErrors("SKU ya existe en la base de datos.");
        }
        //Validar que al menos 1 dato venga con valor
        $valor = $request->valor_reparar_pintar +  $request->valor_cambiar_pintar +  $request->valor_cambiar_reparar +  $request->valor_fabricar; 
        if($valor <= 0){
            return back()->withInput()->withErrors("El valor del servicio NO puede ser 0.");
        }        

        //CARGA dato en la tabla
        $InvServicio = InvServicio::find($id);
            $InvServicio->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $InvServicio->sku = strtoupper(mb_convert_encoding(mb_convert_case($request->tipo_vehiculo . '-'  . $request->codigo_servicio , MB_CASE_UPPER), "UTF-8"));
            $InvServicio->tipo_vehiculo = $request->tipo_vehiculo;
            $InvServicio->codigo_servicio = $request->codigo_servicio;
            $InvServicio->valor_reparar_pintar = $request->valor_reparar_pintar;
            $InvServicio->valor_cambiar_pintar = $request->valor_cambiar_pintar;
            $InvServicio->valor_cambiar_reparar = $request->valor_cambiar_reparar;
            $InvServicio->valor_fabricar = $request->valor_fabricar;
            $InvServicio->valor_base_hora = $request->valor_base_hora;
            $InvServicio->tiempo_estandar = $request->tiempo_estandar;
            $InvServicio->caracteristicas = $request->caracteristicas;
            //$InvServicio->pais_id = Auth::user()->pais_id;

        $InvServicio->save();

        return redirect()->route('inventario-servicios.index')
                        ->with('info', 'Servicio editado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        //Elimina el servicio
        $linea = InvServicio::findOrFail($id);
        $linea->delete();
        //Elimina insumos si los tiene
        InvInsumos::where('sevicio_id', $id)->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Servicio ID= '. $id;
        Miscellany::store_log("GESTION SERVICIOS", "ELIMINA", $message);

        return redirect()->route('inventario-servicios.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

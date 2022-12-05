<?php

namespace App\Http\Controllers\Flota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Validator;
use Facades\App\Classes\SupportImages;
use Illuminate\Support\Facades\File;

use App\Models\CliCliente;
use App\Models\Parametro;
use App\Models\Vehiculo;
use App\Models\CliPatios;
use App\Models\FltIndiceImagenes;

class VehiculoController extends Controller
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
        //Carga vista Index del controller
        $vehiculos = Vehiculo::where('cliente_id', '=' , Auth::user()->company_id)
                        ->get();

        return view('flota.vehiculo.index', compact('vehiculos')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Gestión de seguridad heredada desde la base del Controller
        //$this->cerbero('crea');//lee, crea, edita, elimina

        //Carga la readers de parámetros
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');

        $tipo_vehiculo = Miscellany::pluck_parameters("TIPO_VEHICULO");
        $tipo_combustible = Miscellany::pluck_parameters("TIPO_COMBUSTIBLE");
        $tipo_servicio = Miscellany::pluck_parameters("TIPO_SERVICIO");
        $clientes = CliCliente::pluck('nombre', 'id');

        //Carga vista de Formulario de CREACION de Roles 
        return view('flota.vehiculo.create', compact('ciudades', 'tipo_vehiculo', 'tipo_combustible', 'tipo_servicio', 'clientes'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Valida datos
        $Validate = Validator::make($request->all(), [
            'placa'=> 'required|max:10|unique:flt_vehiculo,placa',
            'cliente_id' => 'required',
            'patio_id' => 'required',
            'tipo_vehiculo' => 'required',
            'tipo_combustible' => 'required',
            'tipo_servicio' => 'required',
            'vencimiento_impuesto' => 'required',
            'vencimiento_tm' => 'required',
            'vencimiento_soat' => 'required',

        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        //Crear token de vehículo
        $token = $request->placa .'~' . $request->cliente_id . '~' . config('appconf.KEY_COMPANY');

        //CARGA dato en la tabla
        $vehiculo = new Vehiculo;
            $vehiculo->token = $token;
            $vehiculo->placa = $request->placa;
            $vehiculo->cliente_id = $request->cliente_id;
            $vehiculo->patio_id = $request->patio_id;
            //DATOS IDENTIDAD
            $vehiculo->numero_motor = $request->numero_motor;
            $vehiculo->numero_chasis = $request->numero_chasis;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->tipo_vehiculo = $request->tipo_vehiculo;
            $vehiculo->cilindrada = $request->cilindrada;
            //DATOS DISTINTIVOS
            $vehiculo->capacidad_toneladas = $request->capacidad_toneladas;
            $vehiculo->cantidad_ejes = $request->cantidad_ejes;
            $vehiculo->capacidad_pasajeros = $request->capacidad_pasajeros;
            $vehiculo->tipo_combustible = $request->tipo_combustible;
            $vehiculo->tipo_servicio = $request->tipo_servicio;
            $vehiculo->color = $request->color;
            $vehiculo->movil = $request->movil;
            //DATOS LEGALES
            $vehiculo->ciudad_matricula = $request->ciudad_matricula;
            $vehiculo->ciudad_rodamiento = $request->ciudad_rodamiento;
            $vehiculo->vencimiento_impuesto = $request->vencimiento_impuesto;
            $vehiculo->vencimiento_tm = $request->vencimiento_tm;
            $vehiculo->vencimiento_soat = $request->vencimiento_soat;
            $vehiculo->vencimiento_seguro_1 = $request->vencimiento_seguro_1;
            $vehiculo->vencimiento_seguro_2 = $request->vencimiento_seguro_2;
            $vehiculo->vencimiento_seguro_3 = $request->vencimiento_seguro_3;
            //DATOS FINANCIEROS
            $vehiculo->valor_inventario = $request->valor_inventario;
            //DATOS OPERATIVOS DE VENCIMIENTO DE REVISIONES
            //Se operan en forma de edición desde punto de menu propio
            //$vehiculo->km_actual 
            //$vehiculo->horas_prox_servicio 
            //$vehiculo->fecha_prox_servicio 
            //$vehiculo->actualizacion_vencimiento 
            $vehiculo->nota = $request->notas;

        $vehiculo->save();

        //CARGA imagenes
        if($request->file('files')){
            SupportImages::imageflotaup($request->file('files'), $vehiculo->id, $request->cliente_id, "inventario");
        }

        return redirect()->route('flota.index')
                        ->with('info', 'Vehículo creado exitosamente');

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
        //$this->cerbero('edita');//lee, crea, edita, elimina

        //Carga el vehiculo a editar
        $vehiculo = Vehiculo::find($id);

        //Carga la readers de parámetros
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');

        $tipo_vehiculo = Miscellany::pluck_parameters("TIPO_VEHICULO");
        $tipo_combustible = Miscellany::pluck_parameters("TIPO_COMBUSTIBLE");
        $tipo_servicio = Miscellany::pluck_parameters("TIPO_SERVICIO");
        $clientes = CliCliente::pluck('nombre', 'id');
        $patios = CliPatios::find($vehiculo->patio_id)
                            ->pluck('nombre', 'id');

        $imagenes =  FltIndiceImagenes::where('vehiculo_id',$id)->get();                           

        //Carga vista de Formulario de CREACION de Roles 
        return view('flota.vehiculo.edit', compact('vehiculo', 'ciudades', 'tipo_vehiculo', 'tipo_combustible', 'tipo_servicio', 'clientes', 'patios', 'imagenes')); 

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
     * Elimnina una imagen de un vehículo
     */
    public function destroyImage($id_image, $id_vehiculo){
        //variables
        $message = "Imagen eliminada correctamente";
        //Carga datos de la imagen desde la tabla
        $imagen = FltIndiceImagenes::findOrFail($id_image);

        if($imagen->count() > 1){
            //Borra imagen del ítem del servidor
            File::delete(public_path() .'/'. $imagen->url . $imagen->nombre_archivo);
            //Borra Imagen de la tabla
            $imagen->delete();
            //CARGA dato en la tabla LOGEAR
            $message = 'Usuario='. Auth::id() .' Imagen ID= '. $id_image;
            Miscellany::store_log("GESTION FLOTAS IMAGEN ITEM", "ELIMINA", $message);
        }else{
            $message = "El vehículo debe tener almenos 1 imagen, no se puede realizar esta operación.";
        }
        
        return redirect()->route('flota.edit', $id_vehiculo)
                        ->with('info', $message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd("borra");
    }
}

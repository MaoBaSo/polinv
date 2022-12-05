<?php

namespace App\Http\Controllers\Empleado;

use App\Http\Controllers\Controller;
use App\Models\EmpEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametro;
use App\Models\CliCliente;
use Illuminate\Support\Facades\Validator;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{

    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 23;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $empleados = EmpEmpleado::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('id')->get();

        return view('empleado.gestion.index', compact('empleados')); 
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

        //Carga la lista de ciudades basados en el pais del usuario
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');
        //Carga la lista de especialidades basados en el pais del usuario
        $especialidad = Parametro::where('key', 'ESPECIALIDAD')
                        ->pluck('variable_1', 'id');
        //Carga la lista de clientes
        $clientes = CliCliente::all()->pluck('nombre', 'id');                        

        //Carga vista de Formulario de CREACION de Roles 
        return view('empleado.gestion.create', compact('ciudades', 'especialidad', 'clientes')); 


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
            'identificacion'=> 'required|max:50|unique:emp_empleados,identificacion',
            'primer_nombre' => 'required|max:100',
            'segundo_nombre' => 'max:100',
            'primer_apellido' => 'required|max:100',
            'segundo_apellido' => 'max:100',
            'ciudad_id' => 'required',
            'direccion' => 'max:200',
            'telefono_1' => 'max:50',
            'telefono_2' => 'max:50',
            'especialidad_id' => 'required',
            'cliente_id' => 'required',
            'patio_id' => 'required',

        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        //Verifica Datos

        //CARGA dato en la tabla
        $empleado = new EmpEmpleado;
            $empleado->identificacion = $request->identificacion;
            $empleado->primer_nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->primer_nombre, MB_CASE_UPPER), "UTF-8"));
            $empleado->segundo_nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->segundo_nombre, MB_CASE_UPPER), "UTF-8"));
            $empleado->primer_apellido = strtoupper(mb_convert_encoding(mb_convert_case($request->primer_apellido, MB_CASE_UPPER), "UTF-8"));
            $empleado->segundo_apellido = strtoupper(mb_convert_encoding(mb_convert_case($request->segundo_apellido, MB_CASE_UPPER), "UTF-8"));
            $empleado->pais_id = Auth::user()->pais_id;
            $empleado->ciudad_id = $request->ciudad_id;
            $empleado->direccion = $request->direccion;
            $empleado->cliente_id = $request->cliente_id;
            $empleado->patio_id = $request->patio_id;
            $empleado->especialidad_id = $request->especialidad_id;
            $empleado->direccion = $request->direccion;
            $empleado->telefono_1 = $request->telefono_1;
            $empleado->telefono_2 = $request->telefono_2;
            $empleado->valor_hora = $request->valor_hora;
            $empleado->porcentaje_hora = $request->porcentaje_hora;
            $empleado->creado_por = Auth::id();
        $empleado->save();

        return redirect()->route('empleado.index')
                        ->with('info', 'Empleado creado exitosamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmpEmpleado  $empEmpleado
     * @return \Illuminate\Http\Response
     */
    public function show(EmpEmpleado $empEmpleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmpEmpleado  $empEmpleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina

        //Carga la lista de ciudades basados en el pais del usuario
        $ciudades = Parametro::where('key', 'CIUDAD')
                        ->where('relacion', Auth::user()->pais_id)
                        ->pluck('variable_1', 'id');
        //Carga la lista de especialidades basados en el pais del usuario
        $especialidad = Parametro::where('key', 'ESPECIALIDAD')
                        ->pluck('variable_1', 'id');
        //Carga la lista de clientes
        $clientes = CliCliente::all()->pluck('nombre', 'id');
        //Carga datos del empleado a subir
        $empleado = EmpEmpleado::find($id);

        //Consulta patios
        $patios = DB::table('cli_patios')
            ->join('cli_clientes', 'cli_clientes.id', '=', 'cli_patios.cliente_id')
            ->select(DB::raw('cli_patios.id, cli_patios.nombre as patio'))
            ->where('cliente_id', $empleado->cliente_id)
            ->where('cli_patios.deleted_at', '=', null)
            ->pluck('patio', 'id');

        //Carga vista de Formulario de CREACION de Roles 
        return view('empleado.gestion.edit', compact('ciudades', 'especialidad', 'clientes', 'empleado', 'patios')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmpEmpleado  $empEmpleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Valida datos
         $Validate = Validator::make($request->all(), [
            'identificacion'=> 'required|unique:emp_empleados,identificacion,'. $id,
            'primer_nombre' => 'required|max:100',
            'segundo_nombre' => 'max:100',
            'primer_apellido' => 'required|max:100',
            'segundo_apellido' => 'max:100',
            'ciudad_id' => 'required',
            'direccion' => 'max:200',
            'telefono_1' => 'max:50',
            'telefono_2' => 'max:50',
            'especialidad_id' => 'required',
            'cliente_id' => 'required',
            'patio_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 
        
        //CARGA dato en la tabla
        $empleado = EmpEmpleado::find($id);
            $empleado->identificacion = $request->identificacion;
            $empleado->primer_nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->primer_nombre, MB_CASE_UPPER), "UTF-8"));
            $empleado->segundo_nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->segundo_nombre, MB_CASE_UPPER), "UTF-8"));
            $empleado->primer_apellido = strtoupper(mb_convert_encoding(mb_convert_case($request->primer_apellido, MB_CASE_UPPER), "UTF-8"));
            $empleado->segundo_apellido = strtoupper(mb_convert_encoding(mb_convert_case($request->segundo_apellido, MB_CASE_UPPER), "UTF-8"));
            //$empleado->pais_id = Auth::user()->pais_id;
            $empleado->ciudad_id = $request->ciudad_id;
            $empleado->direccion = $request->direccion;
            $empleado->cliente_id = $request->cliente_id;
            $empleado->patio_id = $request->patio_id;
            $empleado->especialidad_id = $request->especialidad_id;
            $empleado->direccion = $request->direccion;
            $empleado->telefono_1 = $request->telefono_1;
            $empleado->telefono_2 = $request->telefono_2;
            $empleado->valor_hora = $request->valor_hora;
            $empleado->porcentaje_hora = $request->porcentaje_hora;
            //$empleado->creado_por = Auth::id();
        $empleado->save();

        return redirect()->route('empleado.index')
                        ->with('info', 'Empleado editado exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmpEmpleado  $empEmpleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $linea = EmpEmpleado::findOrFail($id);
        $linea->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Empleado ID= '. $id;
        Miscellany::store_log("GESTION EMPLEADOS", "ELIMINA", $message);

        return redirect()->route('empleado.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

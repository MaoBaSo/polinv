<?php
/**
 * Controller Gestión de clientes.
 * CRUD de Cliente 
 * Author: Mauricio Baquero Soto
 * Enero de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\CliCliente;
use Illuminate\Http\Request;
use Facades\App\Classes\Miscellany;
use App\Models\Parametro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CliPatios;

class ClienteController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 12;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $clientes = CliCliente::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('nombre')
                        ->paginate(15);

        return view('clientes.ingreso.index', compact('clientes')); 
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

        //Carga vista de Formulario de CREACION de Roles 
        return view('clientes.ingreso.create', compact('ciudades'));  
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
            'nombre' => 'required|max:200|unique:cli_clientes,nombre',
            'nit' => 'required|max:20|unique:cli_clientes,nit',
            'direccion' => 'required|max:100',
            'email' => 'email|max:100',
            'telefono_1' => 'required|max:50',
            'telefono_2' => 'max:50',
            'contacto' => 'required|max:100',
            'telefono_contacto' => 'max:50',
            'ciudad_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        //CARGA dato en la tabla
        $cliente = new CliCliente;
            $cliente->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $cliente->nit = $request->nit;
            $cliente->direccion = $request->direccion;
            $cliente->email = $request->email;
            $cliente->telefono_1 = $request->telefono_1;
            $cliente->telefono_2 = $request->telefono_2;
            $cliente->contacto = $request->contacto;
            $cliente->telefono_contacto = $request->telefono_contacto;
            $cliente->notas = $request->notas;
            $cliente->pais_id = Auth::user()->pais_id;
            $cliente->ciudad_id = $request->ciudad_id;            
            $cliente->creado_por = Auth::id();
        $cliente->save();


        return redirect()->route('clientes.index')
                        ->with('info', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CliCliente  $cliCliente
     * @return \Illuminate\Http\Response
     */
    public function show(CliCliente $cliCliente)
    {
        //
    }

    /**
     * Carga listado de patios segun el cliente
    */
    public function getPatios(Request $request, $id)
    {
        //Se debe pasar el id del Cliente
        if($request->ajax()){
            $patios = CliPatios::listPatios($id); 
            return response()->json($patios);
        }
        
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CliCliente  $cliCliente
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
        //Carga un cliente especifico para ser mostrado  
        $cliente = CliCliente::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('clientes.ingreso.edit', compact('cliente', 'ciudades'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CliCliente  $cliCliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Valida datos
        $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:200|unique:cli_clientes,nombre,'. $id,
            'nit' => 'required|max:20|unique:cli_clientes,nit,'. $id,
            'direccion' => 'required|max:100',
            'email' => 'email|max:100',
            'telefono_1' => 'required|max:50',
            'telefono_2' => 'max:50',
            'contacto' => 'required|max:100',
            'telefono_contacto' => 'max:50',
            'ciudad_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 

        //CARGA dato en la tabla
        $cliente = CliCliente::find($id);
            $cliente->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $cliente->nit = $request->nit;
            $cliente->direccion = $request->direccion;
            $cliente->email = $request->email;
            $cliente->telefono_1 = $request->telefono_1;
            $cliente->telefono_2 = $request->telefono_2;
            $cliente->contacto = $request->contacto;
            $cliente->telefono_contacto = $request->telefono_contacto;
            $cliente->notas = $request->notas;
            $cliente->pais_id = Auth::user()->pais_id;
            $cliente->ciudad_id = $request->ciudad_id;            
        $cliente->save();

        return redirect()->route('clientes.index')
                        ->with('info', 'Cliente editado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CliCliente  $cliCliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $cliente = CliCliente::findOrFail($id);
        $cliente->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Cliente ID= '. $id;
        Miscellany::store_log("GESTION CLIENTES", "ELIMINA", $message);

        return redirect()->route('clientes.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

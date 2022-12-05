<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthIP;
use Illuminate\Http\Request;
use App\Models\CliCliente;
use Illuminate\Support\Facades\Auth;
use Validator;
use Facades\App\Classes\Miscellany;

class AuthenticatedIPController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 13;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $ips = AuthIP::paginate(15);

        return view('auth.ip-auth.index', compact('ips')); 
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
        //Carga pluck de clientes
        $clientes = CliCliente::where('pais_id', '=' , Auth::user()->pais_id)->pluck('nombre', 'id');

        //Carga vista de Formulario de CREACION de Lista blanca 
        return view('auth.ip-auth.create', compact('clientes'));  
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
            'ip' => 'required|max:20|unique:seg_white_list,ip',
            'cliente_id' => 'required',
            'origen' => 'required|max:250',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        //CARGA dato en la tabla
        $newIp = new AuthIP;
            $newIp->ip = $request->ip;
            $newIp->cliente_id  = $request->cliente_id;
            $newIp->origen = strtoupper(mb_convert_encoding(mb_convert_case($request->origen, MB_CASE_UPPER), "UTF-8"));
            $newIp->email_report = $request->email_report;
            $newIp->creado_por = Auth::id();            
        $newIp->save();

        return redirect()->route('gestion-lista-blanca.index')
                        ->with('info', 'IP creada exitosamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthIP  $authIP
     * @return \Illuminate\Http\Response
     */
    public function show(AuthIP $authIP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuthIP  $authIP
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthIP $authIP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuthIP  $authIP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthIP $authIP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthIP  $authIP
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $ip = AuthIP::findOrFail($id);
        $ip->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' IP ID= '. $id;
        Miscellany::store_log("GESTION IPS", "ELIMINA", $message);

        return redirect()->route('gestion-lista-blanca.index')
                        ->with('info', 'Dato eliminado Correctamente');

    }
}

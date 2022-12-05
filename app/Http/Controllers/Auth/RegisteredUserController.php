<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use App\Models\Rol;
use App\Models\CliPatios;
use App\Models\CliCliente;
use App\Models\SegToken;

class RegisteredUserController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 1;
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        //Muestra listado de los diferentes usuarios creados, con botones Ver, editar, eliminar.
        //Muestra opcion de Crear nuevos usuarios
        //No puede haber Email duplicados

        //Carga datos basicos de los Usuarios
        $usuarios = User::all();

        return view('auth.index-user', compact('usuarios'));        
    }    
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Consulta la tabla de Roles y los carga tipo pluck para ser cargados en SelectBox
        $roles = Rol::all()->pluck('id', 'nombre');        
        //Consulta los tipos de Usuarios
        $tipos_usuarios = Miscellany::pluck_parameters("USR_tipo");
        //Consulta tabla de paises
        $paises = Miscellany::pluck_parameters("PAIS");

        //Consulta compañias
        $clientes = CliCliente::pluck('nombre', 'id');

        //return view('auth.register'); //Vista Original de rtegistro de Usuarios
        return view('auth.create-user', compact('roles', 'tipos_usuarios', 'paises', 'clientes'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'tipo_id' => 'required',
            'rol_id' => 'required',
            'pais_id' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_id' => $request->tipo_id,
            'rol_id' => $request->rol_id,
            'pais_id' => $request->pais_id,
            'patio_id' => $request->patio_id,
            'company_id' => $request->company_id,
        ]);

        //event(new Registered($user));
        //Auth::login($user);
        //return redirect(RouteServiceProvider::HOME);
        
        return redirect()->route('gestion-usuarios.index')
                        ->with('info', 'Usuario creado exitosamente');
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

        //Consulta la tabla de Roles y los carga tipo pluck para ser cargados en SelectBox
        $roles = Rol::all()->pluck('id', 'nombre');        
        //Consulta los tipos de Usuarios
        $tipos_usuarios = Miscellany::pluck_parameters("USR_tipo");
        //Consulta tabla de paises
        $paises = Miscellany::pluck_parameters("PAIS");
        //Consulta compañias
        $clientes = CliCliente::pluck('nombre', 'id');        
        //Revisa si tiene token asociado 
        $tiene_token = SegToken::where('user_id', $id)->exists();
        //Carga un permiso en especifico para ser mostrado  
        $usuario = User::find($id);
        //Consulta patios
        $patios = DB::table('cli_patios')
            ->join('cli_clientes', 'cli_clientes.id', '=', 'cli_patios.cliente_id')
            ->select(DB::raw('cli_patios.id, cli_patios.nombre as patio'))
            ->where('cliente_id', $usuario->company_id)
            ->where('cli_patios.deleted_at', '=', null)
            ->pluck('patio', 'id');

        //Carga vista de Formulario de EDICION de Permisos 
        return view('auth.edit-user', compact('roles', 'tipos_usuarios' , 'usuario', 'paises', 'clientes', 'patios', 'tiene_token'));         
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
        //VARIABLES
        $cambia_password = false;
        $mensaje = "X6";

        //VALIDA DATOS
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email, '. $id,
            'rol_id' => 'required',
        ]);
        //VERIFICA SI ESTA CAMBIANDO PASSWORD
        if(!is_null($request->password)){
            if($request->password == $request->password_confirmation){
                $cambia_password = true;
            }else{
                return back()->withInput()->withErrors("Passwords Diferentes");
            }
        }
        //CARGA y edita dato
        $user = User::find($id);
            if($user->name != $request->name ){
                $mensaje = 'Usuario='. Auth::id() .' Usuario ID='. $id . ' Nombre Original : ' . $user->name  . ' Nombre Nuevo : ' . $request->name . ' | ';
            }
            if($user->email != $request->email ){
                $mensaje .= 'Usuario='. Auth::id() .' Usuario ID='. $id . ' Email Original : ' . $user->email  . ' Email Nuevo : ' . $request->email . ' | ';
            }
            if($user->rol_id != $request->rol_id ){
                $mensaje .= 'Usuario='. Auth::id() .' Usuario ID='. $id . ' Rol Original : ' . $user->rol_id  . ' Rol Nuevo : ' . $request->rol_id . ' | ';
            }

            $user->name  = $request->name;
            $user->email  = $request->email;
            if($cambia_password){
                $user->password  =  Hash::make($request->password);
            }
            $user->rol_id  = $request->rol_id;
        $user->save();

        //CARGA dato en la tabla LOGEAR
        if($mensaje != "X6"){
            Miscellany::store_log("USUARIOS", "EDICION", $mensaje);
        }    

        return redirect()->route('gestion-usuarios.index')
                        ->with('info', "Usuario editado exitosamente");

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
        //Busca y elimina el registro solicitado
        //Retorna a Index

        //Carga de registro y le elimina
        $usuario = User::find($id);
        $usuario->delete();

        //Loguea Eliminación
        $mensaje = "Usuario=" . Auth::id() .' Usuario ID='. $id ;
        Miscellany::store_log("USUARIOS", "ELIMINA", $mensaje);

        return redirect()->route('gestion-usuarios.index')
                        ->with('info', 'USUARIO eliminado exitosamente');
    }



}

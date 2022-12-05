<?php
/**
 * Controller Gestión de Permisos. 
 * Author: Mauricio Baquero Soto
 * Enero de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facades\App\Classes\Cerbero;
use Illuminate\Support\Str;
use App\Models\Caso_uso;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\V_Permisos;
use Illuminate\Support\Facades\Validator;


class GestionPermisosController extends Controller
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
        //Carga datos basicos de los Roles
        $permisos = V_Permisos::all();
        //Carga vista Index del controller
        //Muestra listado de los diferentes roles ycasos de uso creados, con botones Ver, editar, eliminar.
        //Muestra opcion de Crear nuevos permisos
        //No puede haber Rol X Caso de uso iguales

        return view('admin.permisos.index', compact('permisos'));  
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

        //Consulta la tabla de casos_uso y los carga tipo pluck para ser cargados en SelectBox
        $casos_uso = Caso_uso::all()->pluck('id', 'caso_uso');

        //Consulta la tabla de Roles y los carga tipo pluck para ser cargados en SelectBox
        $roles = Rol::all()->pluck('id', 'nombre');

        //Carga vista de Formulario de CREACION de Roles 
        return view('admin.permisos.create', compact('casos_uso', 'roles'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae el id del Rol, el id del caso de uso y los valores de leer, crear, editar, eliminar
        //Crea registro en la tabla de Permisos
        //Retorna a Index

        $lee = 0;
        $crea = 0;
        $edita = 0;
        $elimina = 0;

        //Valida que vengan los datos requeridos
        $Validate = Validator::make($request->all(), [
            'rol_id' => 'required|max:125',
            'caso_id' => 'required|max:125',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = Permiso::where('rol_id', $request->rol_id)
                    ->where('caso_id', $request->caso_id)
                    ->exists();
        if($exists){
            return back()->withInput()->withErrors("Rol VS Caso Uso ya Existen");
        }

        //Valida los datos de los checks y pone en 1 los elegidos
        if($request->lee){$lee = 1;}
        if($request->crea){$crea = 1;}
        if($request->edita){$edita = 1;}
        if($request->elimina){$elimina = 1;}

        //CARGA dato en la tabla
        $permiso = new Permiso;
            $permiso->rol_id = $request->rol_id;
            $permiso->caso_id = $request->caso_id;
            $permiso->lee = $lee;
            $permiso->crea = $crea;
            $permiso->edita = $edita;
            $permiso->elimina = $elimina;
        $permiso->save();

        return redirect()->route('gestion-permisos.index')
                        ->with('info', 'Permiso creado exitosamente');
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

        //Consulta la tabla de casos_uso y los carga tipo pluck para ser cargados en SelectBox
        $casos_uso = Caso_uso::all()->pluck('id', 'caso_uso');

        //Consulta la tabla de Roles y los carga tipo pluck para ser cargados en SelectBox
        $roles = Rol::all()->pluck('id', 'nombre');

        //Carga un permiso en especifico para ser mostrado  
        $permisos = Permiso::find($id);

        //Carga vista de Formulario de EDICION de Permisos 
        return view('admin.permisos.edit', compact('casos_uso', 'roles' ,'permisos'));  
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
        //Carga nuevos datos editados en el registro actual.
        //Afecta las tablas de permisos
        //Retorna a Index
        $lee = 0;
        $crea = 0;
        $edita = 0;
        $elimina = 0;
        //Valida los datos de los checks y pone en 1 los elegidos
        if($request->lee){$lee = 1;}
        if($request->crea){$crea = 1;}
        if($request->edita){$edita = 1;}
        if($request->elimina){$elimina = 1;}        

        $permiso = Permiso::find($id);
            $permiso->lee = $lee;
            $permiso->crea = $crea;
            $permiso->edita = $edita;
            $permiso->elimina = $elimina;
        $permiso->save();

        return redirect()->route('gestion-permisos.index')
                        ->with('info', 'Permiso editado exitosamente');
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
        $permiso = Permiso::find($id);
        $permiso->delete();

        return redirect()->route('gestion-permisos.index')
                        ->with('info', 'PERMISO eliminado exitosamente');
    }
}

<?php
/**
 * Controller Gestión de Roles. 
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


class GestionRolesController extends Controller
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
        //$roles = V_Roles::all();

        $roles = Rol::all();
        //Carga vista Index del controller
        //Muestra listado de los diferentes roles creados, cada uno con boton Ver, editar, eliminar.
        //Muestra opcion de Crear nuevo rol
        //return view('admin.index-admon', compact('cant_anuncios', 'cant_anuncios_gratis'));
        return view('admin.roles.index', compact('roles'));
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
        return view('admin.roles.create', compact('casos_uso', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae el Nombre del Rol, el id del caso de uso y los valores de leer, crear, editar, eliminar
        //Crea registro en la tablaa de Roles y Permisos
        //Retorna a Index
        //Actualiza registro a la tabla
        $rol = new Rol;
            $rol->nombre = $request->nombre;
            $rol->slug =  Str::slug($request->nombre, '-');
            $rol->nota = $request->nota;
        $rol->save();

        return redirect()->route('gestion-roles.index')
                        ->with('info', 'Rol creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina

        //Carga un rol en especifico para ser mostrado  
        $roles = Rol::find($id);
        
        //Despliega la ventana de Show
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
        
        //Carga un rol en especifico para ser mostrado  
        $roles = Rol::find($id);

        //Carga vista de Formulario de EDICION de Roles 
        return view('admin.roles.edit', compact('roles'));  
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
        //Afecta las tablas de Roles y permisos
        //Retorna a Index
        $rol = Rol::find($id);
            $rol->nombre = $request->nombre;
            $rol->slug =  Str::slug($request->nombre, '-');
            $rol->nota = $request->nota;
        $rol->save();

        return redirect()->route('gestion-roles.index')
                        ->with('info', 'Rol editado exitosamente');
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
        $rol = rol::find($id);
        $rol->delete();

        return redirect()->route('gestion-roles.index')
                        ->with('info', 'Rol eliminado exitosamente');
    }
}

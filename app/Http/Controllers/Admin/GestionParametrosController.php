<?php
/**
 * Controller Gestión de Parámetros. 
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
use App\Models\Parametro;
use App\Models\V_Permisos;
use Illuminate\Support\Facades\Validator;

class GestionParametrosController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 2;
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        //Muestra listado de los diferentes parametros creados, con botones Ver, editar, eliminar.
        //Muestra opcion de Crear nuevos parametros
        //No puede haber parametros iguales en los campos KEY + Variable_1
        //Se paginan de a 15 resultados
        $parametros = Parametro::where('deleted_at', '=' , null)
                        ->orderByDesc('key')
                        ->paginate(15);

        return view('admin.parametros.index', compact('parametros'));  
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

        //Carga vista de Formulario de CREACION de Roles 
        return view('admin.parametros.create');  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos de parámetro
        //Crea registro en la tabla de Parametro
        //Retorna a Index
        //Carga datos basicos de los Roles
        $permisos = V_Permisos::all();

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'key' => 'required|max:125',
            'descripcion' => 'required|max:100',
            'modulos' => 'max:100',
            'relacion' => 'max:100',
            'variable_1' => 'required|max:100',
            'variable_2' => 'max:100',
            'variable_3' => 'max:100',
            'variable_4' => 'max:100',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = Parametro::where('key', $request->key)
                    ->where('variable_1', $request->variable_1)
                    ->exists();
        if($exists){
            return back()->withInput()->withErrors("Parametro ya Existe");
        }

        //CARGA dato en la tabla
        $parametro = new Parametro;
            $parametro->key = $request->key;
            $parametro->descripcion = $request->descripcion;
            $parametro->modulos = $request->modulos;
            $parametro->relacion = $request->relacion;
            $parametro->variable_1 = $request->variable_1;
            $parametro->variable_2 = $request->variable_2;
            $parametro->variable_3 = $request->variable_3;
            $parametro->variable_4 = $request->variable_4;
            $parametro->script = $request->script;
        $parametro->save();

        return redirect()->route('gestion-parametros.index')
                        ->with('info', 'Parámetro creado exitosamente');
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

        //Carga un parámetro especifico para ser mostrado  
        $parametro = Parametro::find($id);

        //Carga vista de Formulario de EDICION de Parámetros 
        return view('admin.parametros.edit', compact('parametro'));  
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
            'key' => 'required|max:125',
            'descripcion' => 'required|max:100',
            'modulos' => 'max:100',
            'relacion' => 'max:100',
            'variable_1' => 'required|max:100',
            'variable_2' => 'max:100',
            'variable_3' => 'max:100',
            'variable_4' => 'max:100',
        ]);
        //CARGA dato en la tabla
        $parametro = Parametro::find($id);

            if($parametro->de_sistema){
                return back()->withInput()->withErrors("Parámetro de sistema, NO editable");
            }
            $parametro->key = $request->key;
            $parametro->descripcion = $request->descripcion;
            $parametro->modulos = $request->modulos;
            $parametro->relacion = $request->relacion;
            $parametro->variable_1 = $request->variable_1;
            $parametro->variable_2 = $request->variable_2;
            $parametro->variable_3 = $request->variable_3;
            $parametro->variable_4 = $request->variable_4;
            $parametro->script = $request->script;
        $parametro->save();

        return redirect()->route('gestion-parametros.index')
                        ->with('info', 'Parámetro editado exitosamente');
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
        $parametro = Parametro::find($id);
        if($parametro->de_sistema){
            return back()->withInput()->withErrors("Parámetro de sistema, NO eliminable");
        }
        $parametro->delete();

        return redirect()->route('gestion-parametros.index')
                        ->with('info', 'Parámetro eliminado exitosamente');
    }
}

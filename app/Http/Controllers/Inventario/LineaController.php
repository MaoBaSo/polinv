<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\InvLinea;
use Illuminate\Http\Request;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LineaController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 5;
    }     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $lineas = InvLinea::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('nombre')
                        ->paginate(15);

        return view('inventario.lineas.index', compact('lineas'));  
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

        //Carga listado de paises
        $paises = Miscellany::pluck_parameters('PAIS');

        //Carga vista de Formulario de CREACION de Roles 
        return view('inventario.lineas.create', compact('paises'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos de Línea
        //Crea registro en la tabla de Lineas
        //Retorna a Index

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:125',
            'caracteristicas' => 'max:1000',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = InvLinea::where('nombre', $request->nombre)->exists();
        if($exists){
            return back()->withInput()->withErrors("Línea ya Existe");
        }

        //CARGA dato en la tabla
        $linea = new InvLinea;
            $linea->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $linea->caracteristicas = $request->caracteristicas;
            $linea->pais_id = Auth::user()->pais_id;
        $linea->save();

        return redirect()->route('inventario-lineas.index')
                        ->with('info', 'Línea creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvLinea  $invLinea
     * @return \Illuminate\Http\Response
     */
    public function show(InvLinea $invLinea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvLinea  $invLinea
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga una Línea especifico para ser mostrado  
        $linea = InvLinea::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.lineas.edit', compact('linea'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvLinea  $invLinea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Valida datos
         $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:125|unique:inv_linea,nombre,'. $id,
            'caracteristicas' => 'max:1000',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 
                
        //CARGA dato en la tabla
        $linea = InvLinea::find($id);
            $linea->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $linea->caracteristicas = $request->caracteristicas;
        $linea->save();

        return redirect()->route('inventario-lineas.index')
                        ->with('info', 'Línea editada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvLinea  $invLinea
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $linea = InvLinea::findOrFail($id);
        $linea->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Linea ID= '. $id;
        Miscellany::store_log("GESTION LINEAS", "ELIMINA", $message);

        return redirect()->route('inventario-lineas.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

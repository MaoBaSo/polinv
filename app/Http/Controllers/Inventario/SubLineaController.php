<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\InvSubLinea;
use Illuminate\Http\Request;

use Facades\App\Classes\Miscellany;
use App\Models\InvLinea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubLineaController extends Controller
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
        $sublineas = InvSubLinea::with('linea')
                        ->orderBy('nombre')
                        ->paginate(15);

        return view('inventario.lineas.sublinea.index', compact('sublineas'));  
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

        //Carga listado de lineas para conbobox
        $lineas = InvLinea::pluck('nombre', 'id');

        //Carga vista de Formulario de CREACION de Roles 
        return view('inventario.lineas.sublinea.create', compact('lineas'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos de Sub Línea
        //Crea registro en la tabla de Sub - Lineas
        //Retorna a Index

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'linea_id' => 'required',
            'nombre' => 'required|max:125',
            'caracteristicas' => 'max:1000',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = InvSubLinea::where('nombre', $request->nombre)->exists();
        if($exists){
            return back()->withInput()->withErrors("Sub-Línea ya Existe");
        }

        //CARGA dato en la tabla
        $InvSubLinea = new InvSubLinea;
            $InvSubLinea->linea_id = $request->linea_id;
            $InvSubLinea->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $InvSubLinea->caracteristicas = $request->caracteristicas;
        $InvSubLinea->save();

        return redirect()->route('inventario-sublineas.index')
                        ->with('info', 'Sub-Línea creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvSubLinea  $invSubLinea
     * @return \Illuminate\Http\Response
     */
    public function show(InvSubLinea $invSubLinea)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvSubLinea  $invSubLinea
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga listado de lineas para conbobox
        $lineas = InvLinea::pluck('nombre', 'id');
        //Carga una Línea especifico para ser mostrado  
        $sublinea = InvSubLinea::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.lineas.sublinea.edit', compact('sublinea', 'lineas'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvSubLinea  $invSubLinea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Valida datos
         $Validate = Validator::make($request->all(), [
            'linea_id' => 'required',
            'nombre' => 'required|max:125|unique:inv_sub_linea,nombre,'. $id,
            'caracteristicas' => 'max:1000',
        ]);

        //CARGA dato en la tabla
        $InvSubLinea = InvSubLinea::find($id);
            $InvSubLinea->linea_id = $request->linea_id;
            $InvSubLinea->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $InvSubLinea->caracteristicas = $request->caracteristicas;
        $InvSubLinea->save();

        return redirect()->route('inventario-sublineas.index')
                        ->with('info', 'Sub-Línea editada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvSubLinea  $invSubLinea
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $sublinea = InvSubLinea::findOrFail($id);
        $sublinea->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Sub-Linea ID= '. $id;
        Miscellany::store_log("GESTION SUB-LINEAS", "ELIMINA", $message);

        return redirect()->route('inventario-sublineas.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

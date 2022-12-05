<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\InvProducto;
use Illuminate\Http\Request;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Parametro;
use App\Models\InvSubLinea;
use App\Models\InvLinea;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{

    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 8;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Carga vista Index del controller
        $productos = InvProducto::where('pais_id', '=' , Auth::user()->pais_id)
                        ->orderBy('nombre')
                        ->paginate(15);

        return view('inventario.productos.index', compact('productos'));  
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

        //Carga lista de Presentaciones
        $presentacion = Parametro::where('key', 'PRESENTACION')
                        ->pluck('variable_1', 'id');

        //Pluck de sublineas por pais del usuario conectado 
        $sublinea_pluck = Miscellany::getSubLineasWithPais();                        

        //Fabricante
        //POR IMPLEMENTAR

        //Carga vista de Formulario de CREACION de Roles 
        return view('inventario.productos.create', compact('presentacion', 'sublinea_pluck'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Desde formulario trae los datos del producto
        //Crea registro en la tabla de Productos 
        //Retorna a Index

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:200',
            'sku' => 'required|max:100',
            'numero_parte' => 'max:200',
            'oem' => 'max:200',
            'presentacion_id' => 'required',
            'sublinea_id' => 'required',
            'keywords' => 'max:150',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        
        $exists = InvProducto::where('nombre', $request->nombre)->exists();
        if($exists){
            return back()->withInput()->withErrors("Producto ya Existe");
        }

        //CARGA dato en la tabla
        $producto = new InvProducto;
            $producto->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $producto->sku = $request->sku;
            $producto->numero_parte = $request->numero_parte;
            $producto->oem = $request->oem;
            $producto->presentacion_id = $request->presentacion_id;
            $producto->fabricante_id  = $request->fabricante_id;
            $producto->sublinea_id  = $request->sublinea_id;
            $producto->factor_maximo = $request->factor_maximo;
            $producto->factor_minimo = $request->factor_minimo;
            $producto->caracteristicas = $request->caracteristicas;
            $producto->keywords = $request->keywords;
            $producto->creado_por = Auth::id();
            $producto->pais_id = Auth::user()->pais_id;
        $producto->save();

        return redirect()->route('inventario-productos.index')
                        ->with('info', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvProducto  $invProducto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina        

        //Carga lista de Presentaciones
        $presentacion = Parametro::where('key', 'PRESENTACION')
                        ->pluck('variable_1', 'id');

        //Pluck de sublineas por pais del usuario conectado 
        $sublinea_pluck = Miscellany::getSubLineasWithPais();                        

        //Fabricante
        //POR IMPLEMENTAR

        //Carga una Bodega en especifico para ser mostrada  
        $producto = InvProducto::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.productos.show', compact('producto', 'presentacion', 'sublinea_pluck')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvProducto  $invProducto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga lista de Presentaciones
        $presentacion = Parametro::where('key', 'PRESENTACION')
                        ->pluck('variable_1', 'id');

        //Pluck de sublineas por pais del usuario conectado 
        $sublinea_pluck = Miscellany::getSubLineasWithPais();                        

        //Fabricante
        //POR IMPLEMENTAR

        //Carga una Bodega en especifico para ser mostrada  
        $producto = InvProducto::find($id);

        //Carga vista de Formulario de EDICION de Líneas 
        return view('inventario.productos.edit', compact('producto', 'presentacion', 'sublinea_pluck')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvProducto  $invProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         //Valida datos
         $Validate = Validator::make($request->all(), [
            'nombre' => 'required|max:200|unique:inv_productos,nombre,'. $id,
            'sku' => 'required|max:100',
            'numero_parte' => 'max:200',
            'oem' => 'max:200',
            'presentacion_id' => 'required',
            'sublinea_id' => 'required',
            'keywords' => 'max:150',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        

        //CARGA dato en la tabla
        $producto = InvProducto::find($id);
            $producto->nombre = strtoupper(mb_convert_encoding(mb_convert_case($request->nombre, MB_CASE_UPPER), "UTF-8"));
            $producto->sku = $request->sku;
            $producto->numero_parte = $request->numero_parte;
            $producto->oem = $request->oem;
            $producto->presentacion_id = $request->presentacion_id;
            $producto->fabricante_id  = $request->fabricante_id;
            $producto->sublinea_id  = $request->sublinea_id;
            $producto->factor_maximo = $request->factor_maximo;
            $producto->factor_minimo = $request->factor_minimo;
            $producto->caracteristicas = $request->caracteristicas;
            $producto->keywords = $request->keywords;
            $producto->creado_por = Auth::id();
            $producto->pais_id = Auth::user()->pais_id;
        $producto->save();

        return redirect()->route('inventario-productos.index')
                        ->with('info', 'Producto editado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvProducto  $invProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('elimina');//lee, crea, edita, elimina

        $producto = InvProducto::findOrFail($id);
        $producto->delete();

        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Bodega ID= '. $id;
        Miscellany::store_log("GESTION PRODUCTO", "ELIMINA", $message);

        return redirect()->route('inventario-productos.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
}

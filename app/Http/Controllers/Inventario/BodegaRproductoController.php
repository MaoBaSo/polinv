<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\InvBodegaRproducto;
use App\Models\InvProducto;
use App\Models\InvBodega;
use App\Models\InvKardex;

class BodegaRproductoController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 9;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        //**RETORNA DATOS AL FORMULARIO */
        //Pluck de Productos
        $productos = InvProducto::pluck('nombre','id');
        //Pluck de Bodegas
        $bodegas = InvBodega::pluck('nombre','id');
        //Pluck de proveedores
        //Por implementar**************

        return view('inventario.ingreso.create', compact('productos', 'bodegas'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**REALIZA PROCEDIMIENTOS */
        //Carga la relacion Bodega producto si no existe, de existir actualiza valores.
        //Ingresa linea de movimiento a Kardex

        //Desde formulario trae los datos de la bodega
        //Crea registro en la tabla de Bodegas 
        //Retorna a Index

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'producto_id' => 'required',
            'bodega_id' => 'required',
            'cantidad' => 'required|numeric',
            'documento_referencia' => 'max:10',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        

        //Carga la relacion Bodega producto si no existe, de existir actualiza valores.
        $invrel = InvBodegaRproducto::where('producto_id', $request->producto_id)
                                    ->where('bodega_id',$request->bodega_id)
                                    ->first();

        if($invrel){
            //CARGA dato en la tabla
            $update = InvBodegaRproducto::find($invrel->id);
                $newcantidad = ($update->cantidad_actual + $request->cantidad);
                $update->cantidad_actual = $newcantidad;
            $update->save();            

        }else{

            //CREA dato en la tabla de  BodRelProducto
            $update = new InvBodegaRproducto;
                $update->producto_id = $request->producto_id;
                $update->bodega_id = $request->bodega_id;
                $update->cantidad_actual = $request->cantidad;
                $update->creado_por = Auth::id();
            $update->save();

        }

        //Crea dato en la tabla de kardex
        $kardex = new InvKardex;
            $kardex->producto_id = $request->producto_id;
            $kardex->tipo_movimiento = "INGRESO";
            $kardex->proveedor_id = $request->proveedor_id;
            $kardex->documento_referencia = $request->documento_referencia;
            $kardex->vencimiento_garantia = $request->vence_garantia;
            //$kardex->bodega_procedencia =
            $kardex->bodega_destino = $request->bodega_id; 
            $kardex->cantidad_movimiento = $request->cantidad;
            $kardex->costo_bruto = $request->costo_bruto;
            $kardex->iva = $request->costo_impuesto;
            $kardex->costo_neto = ($request->costo_bruto + $request->costo_impuesto);
            $kardex->creado_por = Auth::id();
        $kardex->save();

        return redirect()->route('inventario.home')
                        ->with('info', 'Movimiento realizado');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

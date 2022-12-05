<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvBodegaRproducto;
use App\Models\V_Productos;
use App\Models\InvKardex;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AjusteController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 11;
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
        //
    }
    /**
     * carga ventanas de creacion de transferencia basados en elñ Id relacion
     * de producto bodega.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createWithId($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //**RETORNA DATOS AL FORMULARIO */
        //Carga vista de producto para los datos
        $vistaProductos = V_Productos::find($id);

        return view('inventario.ajustes.create', compact('vistaProductos'));  
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
            'documento_referencia' => 'required',
            'tipo_movimiento' => 'required',
            'cantidad_ajustar' => 'required|numeric|min:1',
            'descripcion' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        

        try {
            DB::beginTransaction();

            //Carga la relacion Bodega ORIGEN
            $invrel = InvBodegaRproducto::find($request->id_relacion);

            //Evalua y realiza el tipo de operacion solicitado
            if($request->tipo_movimiento == '+'){
                $newcantidad = ($invrel->cantidad_actual + $request->cantidad_ajustar);
                $movimiento = "AJUSTE (+)";
            }else{
                $newcantidad = ($invrel->cantidad_actual - $request->cantidad_ajustar);
                $movimiento = "AJUSTE (-)";
            }

            //Opera dato en bodega (+/-)
            $destino = InvBodegaRproducto::find($invrel->id);
                $destino->cantidad_actual = $newcantidad;
            $destino->save();    

            //Crea dato en la tabla de kardex
            $kardex = new InvKardex;
                $kardex->producto_id = $invrel->producto_id;
                $kardex->tipo_movimiento = $movimiento;
                //$kardex->proveedor_id = $request->proveedor_id;
                $kardex->documento_referencia = $request->documento_referencia; 
                //$kardex->vencimiento_garantia = $request->vence_garantia;
                //$kardex->bodega_procedencia = $invrel->bodega_id;
                $kardex->bodega_destino = $invrel->bodega_id; 
                $kardex->cantidad_movimiento = $request->cantidad_ajustar;
                //$kardex->costo_bruto = $request->costo_bruto;
                //$kardex->iva = $request->costo_impuesto;
                //$kardex->costo_neto = ($request->costo_bruto + $request->costo_impuesto);
                $kardex->nota = $request->descripcion;
                $kardex->creado_por = Auth::id();
            $kardex->save(); 
                
            DB::commit();

        //********************** */
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

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

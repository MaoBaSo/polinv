<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\InvBodegaRproducto;
use App\Models\V_Productos;
use App\Models\InvBodega;
use App\Models\InvKardex;
use Illuminate\Support\Facades\Validator;
use Exception;

use Illuminate\Support\Facades\DB;

class TransferenciaController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 10;
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
     * carga ventanas de creacion de transferencia basados en el Id relacion
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
        //Pluck de Bodegas
        $bodegas = InvBodega::pluck('nombre','id');

        return view('inventario.transferencia.create', compact('vistaProductos', 'bodegas'));  
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
            'bodega_destino' => 'required',
            'cantidad_transferir' => 'required|numeric',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }        

        //Que no se traslade producto a la misma bodega *******************************

        try {
            DB::beginTransaction();

            //Carga la relacion Bodega ORIGEN
            $invrelORIGEN = InvBodegaRproducto::find($request->id_relacion);
            //Carga la relacion Bodega DESTINO
            $invrelDESTINO = InvBodegaRproducto::where('producto_id', $invrelORIGEN->producto_id)
                                        ->where('bodega_id',$request->bodega_destino)
                                        ->first();

            if($invrelDESTINO){
                //Opera dato bodega DESTINO (+)
                $destino = InvBodegaRproducto::find($invrelDESTINO->id);
                    $newcantidad = ($destino->cantidad_actual + $request->cantidad_transferir);
                    $destino->cantidad_actual = $newcantidad;
                $destino->save();           
                //Opera dato bodega ORIGEN (-)
                $origen = InvBodegaRproducto::find($invrelORIGEN->id);
                    $newcantidad = ($origen->cantidad_actual - $request->cantidad_transferir);
                    $origen->cantidad_actual = $newcantidad;
                $origen->save();

            }else{

                //Opera dato bodega DESTINO (+)
                $update = new InvBodegaRproducto;
                    $update->producto_id = $invrelORIGEN->producto_id;
                    $update->bodega_id = $request->bodega_destino;
                    $update->cantidad_actual = $request->cantidad_transferir;
                    $update->creado_por = Auth::id();
                $update->save();
                //Opera dato bodega ORIGEN (-)
                $origen = InvBodegaRproducto::find($invrelORIGEN->id);
                    $newcantidad = ($origen->cantidad_actual - $request->cantidad_transferir);
                    $origen->cantidad_actual = $newcantidad;
                $origen->save(); 

            }

                //Crea dato en la tabla de kardex
                $kardex = new InvKardex;
                    $kardex->producto_id = $invrelORIGEN->producto_id;
                    $kardex->tipo_movimiento = "TRANSFERENCIA";
                    //$kardex->proveedor_id = $request->proveedor_id;
                    $kardex->documento_referencia = $request->documento_referencia; 
                    //$kardex->vencimiento_garantia = $request->vence_garantia;
                    $kardex->bodega_procedencia = $invrelORIGEN->bodega_id;
                    $kardex->bodega_destino = $request->bodega_destino; 
                    $kardex->cantidad_movimiento = $request->cantidad_transferir;
                    //$kardex->costo_bruto = $request->costo_bruto;
                    //$kardex->iva = $request->costo_impuesto;
                    //$kardex->costo_neto = ($request->costo_bruto + $request->costo_impuesto);
                    $kardex->nota = $request->notas;
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

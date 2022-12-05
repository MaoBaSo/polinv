<?php
/**
 * Clase encargada de gestionar los gastos de productos generados por un servicio
 * Author: Mauricio Baquero Soto
 * Junio de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SerAdmTiempo;
use App\Models\SerServicio;
use App\Models\InvBodegaRproducto;
use Exception;
use App\Models\InvKardex;
use Facades\App\Classes\Miscellany;

/**
 * PASOS
 * 1. Carga los insumos requeridos por un servicio.
 * 2. Carga existencia de los insumos en la bodega asignada al patio. 
 * 3. De existir insumos LOS RESERVA, para que otro servicio no lo utilice.
 * 4. De NO existir o ser insuficientes los insumos, se genera una pantalla donde se elige PROSEGIR o CANCELAR.
 * 5. Para insumo INSUFICIENTE, al dar PROSEGIR, RESERVA la cantidad de insumo existente.
 * 
 * Los datos de evaluacion se cargan de usuario y del registro de asignacion de servicios.
 * Para crear orden de trabajo debe el servicio tener un valor superior a 0
 * 
 * Para utilizar:
 *          use App\Classes\UpdateStateServ;
 * 
 *                                         //Paso,servicio_id, Orden de trabajo u Orden de compra, Nota
 *          $estado = new UpdateStateServ($request->paso_id, $request->servicio_id, $request->numero_documento, "Nota"); 
 *          $estado->actualizaEstado(); //Genera la actualización  
 * 
 */

class DescuentoInsumo{

    protected $servicio_id;
    protected $bodega_id;
    protected $opera_sin_existencia;
    protected $termino;

    public function __construct($bodega_id, $servicio_id){

        //Carga y evalua si hay insumos requeridos para efectuar el servicio.
        $this->servicio_id = $servicio_id;
        $this->bodega_id = $bodega_id;
        //Carga parametro de operar sin existencia        
        $this->opera_sin_existencia = config('appconf.OPERA_SIN_EXISTENCIAS');
        //Corre funcion principal
        $this->evalua();

    }
    
    private function evalua(){
        try {
            //Carga los insumos que requiere el servicio
            $insumos_requeridos = $this->insumosRequeridos();
            //dd($insumos_requeridos);
            //dd($this->servicio_id . ' ' . $this->bodega_id);

            //EVALUA si existen insumos asociadopps al servicio y lo evalua contra configuración de operar sin existencia.
            //Si no esta permitido operer sin existencia y no tiene parametrizado insumos
            if($this->opera_sin_existencia == false && $insumos_requeridos->count() == 0){
                $this->setMessaje("Servicio no tiene parametrizados insumos.");
                $this->setTermino(false);
                return;
            }
            //Si insumos en 0, pero esta autorizado a facturar sin existencias
            if($insumos_requeridos->count() == 0){
                $this->setMessaje("ATENCION - Operando sin existencias.");
                $this->setTermino(true);
                return;
            }

            //INICIA TRANSACCIONES en caso de tener insumos rerqueridos
            DB::beginTransaction();

                foreach ($insumos_requeridos as $insumo){

                    //Carga insumo requerido
                    $bodega_cantidad = DB::table('inv_productorbodega')
                                    ->where('producto_id', $insumo->producto_id)
                                    ->where('bodega_id', $this->bodega_id)
                                    ->lockForUpdate()
                                    ->first();

                    //Revisa que exista Bodega para hacer debito
                    if(is_null($bodega_cantidad)){
                        DB::rollback();
                        $this->setMessaje("Problemas en bodega de insumos, bodega: " . Miscellany::getNameBodega($this->bodega_id) . ' producto: ' . Miscellany::getProducto($insumo->producto_id)->nombre);
                        $this->setTermino(false);
                        return;
                    }
                    
                    //Opera nueva cantidad
                    $nueva_cantidad = ($bodega_cantidad->cantidad_actual - $insumo->cant_requerida);
                    $cantidad_descontada = $insumo->cant_requerida;

                    //EVALUA si existen insumos asociados a la bodega y lo evalua contra configuración de operar sin existencia.
                    //Si no esta permitido operer sin existencia y no tiene insumo en la bodega
                    if($this->opera_sin_existencia == false){
                        if($nueva_cantidad <= 0){
                            DB::rollback();
                            $this->setMessaje("Stock insuficiente para operación, producto: " . Miscellany::getProducto($insumo->producto_id)->nombre);
                            $this->setTermino(false);
                            return;
                        }
                    }

                    //Si insumo en 0, pero esta autorizado a facturar sin existencias
                    if(!is_null($bodega_cantidad)){

                        //En caso tal de operar sin existencias hay que grantizar que no haya numeros negativos en la BD
                        if($nueva_cantidad < 0){
                            $nueva_cantidad = 0;
                            $cantidad_descontada = $bodega_cantidad->cantidad_actual;
                        }

                        //Sube nueva cantidad
                        InvBodegaRproducto::where('id', $bodega_cantidad->id)
                            ->update(['cantidad_actual' => $nueva_cantidad]);

                        //Crea dato en la tabla de kardex
                        $kardex = new InvKardex;
                            $kardex->producto_id = $insumo->producto_id;
                            $kardex->tipo_movimiento = "GASTO SERVICIO (-)";
                            //$kardex->proveedor_id = $request->proveedor_id;
                            $kardex->documento_referencia = $this->servicio_id; 
                            //$kardex->vencimiento_garantia = $request->vence_garantia;
                            //$kardex->bodega_procedencia = $invrel->bodega_id;
                            //$kardex->bodega_destino = $invrel->bodega_id; 
                            $kardex->cantidad_movimiento = $cantidad_descontada;
                            //$kardex->costo_bruto = $request->costo_bruto;
                            //$kardex->iva = $request->costo_impuesto;
                            //$kardex->costo_neto = ($request->costo_bruto + $request->costo_impuesto);
                            $kardex->nota = "GASTO SERVICIO " . $this->servicio_id . " | ITEM " . $insumo->item_id;
                            $kardex->creado_por = Auth::id();
                        $kardex->save(); 

                    }                               
                    
                }

            DB::commit();

            //Si todo va bien
            $this->setMessaje("Servicio debitó existencias de inventario correctamente.");
            $this->setTermino(true);
            return;

        //********************** */
        } catch (Exception $e) {
            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

    }

    private function insumosRequeridos(){
        //Carga los insumos que requiere un servicio
        //Se requiere el servicio_id, $this->servicio_id
        /*
        Trae lista de insumos requeridos por cada ítem del servicio
        Si retorna NULL es porque no tiene asociado ningun insumo
        BUSQUEDA A TRAVES DE ID DE SERVICIO
        */
        $insumos_requeridos = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->join('inv_insumos', 'inv_insumos.sevicio_id', '=', 'inv_servicios.id')
            ->select(DB::raw('
                    serv_servicios_items.id as item_id,
                    inv_insumos.producto_id as producto_id,
                    inv_insumos.cantidad as cant_requerida,
                    inv_insumos.presentacion_id
            '))
            ->where('serv_servicios_items.serv_servicios_id', $this->servicio_id)
            ->where('serv_servicios_items.deleted_at', null)
            ->where('inv_servicios.deleted_at', null)
            ->where('inv_insumos.deleted_at', null)
            ->get(); 

        return $insumos_requeridos;
    } 

    //Getters and Setters
    public function setMessaje($messaje){
        $this->messaje = $messaje;
    }
    public function getMessaje(){
        return $this->messaje;
    }

    //Getters and Setters
    public function setTermino($termino){
        $this->termino = $termino;
    }
    public function getTermino(){
        return $this->termino;
    }




}
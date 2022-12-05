<?php
/**
 * Clase General para soporte de cambio de estado del servicio
 * Author: Mauricio Baquero Soto
 * Marzo de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SerAdmTiempo;
use App\Models\SerServicio;
use Exception;

/**
 * Clase cambia los estados del servicio
 * Tipo = Valoración -> Orden Trabajo -> Orden Compra
 * Estado = 1->Abierto, 2->En Proceso, 3->Control Calidad(JPEX), 4->Cerrado(Aceptado Cliente)
 * 
 * PASOS
 * 1. Tipo Valoración -> Estado 1 (Abierto) = Inicio de proceso interviene solo personal JPEX, secarga con la creacion de servicio.
 * 2. Tipo Orden Trabajo -> Estado 1 (Abierto) = Personal de cliente acepta o JPEX autoriza la valoración.
 * 3. Tipo Orden Trabajo -> Estado 2 (En Proceso) = Personal de JPEX tiene asignado el servicio.
 * 4. Tipo Orden trabajo -> Estado 3 (Control Calidad(JPEX)) = Supervisor JPEX realizó control de calidad.
 * 5. Tipo Orden Trabajo -> Estado 4 (Cerrado) = Personal de Cliente acepta el trabajo.
 * 6. Tipo Orden Compra -> Estado 4 (Cerrado) = Personal JPEX indica el numero de Orden de compra para realizar el cierre definitivo
 * 
 * Solo se puden eliminar servicios en paso 1
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

class UpdateStateServ{

    protected $servicio_id;
    protected $paso;
    protected $messaje;
    protected $documento;
    protected $servicio;
    protected $datos;

    protected $nota;

    public function __construct($paso, $servicio_id, $documento, $nota){

        $this->servicio_id = $servicio_id;
        $this->paso = $paso;
        $this->documento = $documento;
        $this->servicio = SerServicio::find($servicio_id);
        $this->cargaDatos();
        $this->nota = $nota;
    }
    
    public function actualizaEstado(){
        //Funcion principal

        try {

            if($this->validaDatos()){
                DB::beginTransaction();

                    //Cambio de estado 
                    SerServicio::where('id', $this->servicio_id)
                        ->update(['tipo' => $this->datos["Tipo"], 'estado' => $this->datos["estado"]]);
        
                    if($this->paso == 2){
                        //Autorizaciónes de proceso Orden de Trabajo u Orden de compra
                        SerServicio::where('id', $this->servicio_id)
                            ->update(['numero_orden_trabajo' => $this->documento]);  
                    }elseif($this->paso == 6){
                        //Autorizaciónes de proceso Orden de Trabajo u Orden de compra
                        SerServicio::where('id', $this->servicio_id)
                            ->update(['numero_orden_compra' => $this->documento]);  
                    }                    

                    //Crea registro de movimiento
                    SerAdmTiempo::create([
                        'serv_servicios_id' => (int)$this->servicio_id,
                        'nuevo_tipo' => $this->datos["Tipo"],
                        'nuevo_estado' => $this->datos["estado"],
                        'nota' => $this->getNota(),
                        'creado_por' => Auth::id(),
                    ]);
    
                DB::commit();

                $this->setMessaje("El registro se actualizo correctamente");
                return true;

            }else{
                return $this->getMessaje();
            }
            
        } catch (Exception $e) {

            DB::rollback();
            $this->setMessaje($e->getMessage());
            return false;
        }

        
    }

    //getters and setters
    public function setMessaje($messaje){
        $this->messaje = $messaje;
    }
    public function getMessaje(){
        return $this->messaje;
    }

    public function setNota($nota){
        $this->nota = $nota;
    }
    public function getNota(){
        return $this->nota;
    }


    private function validaDatos(){
        //Valida que el paso enviado exista
        if($this->paso >= 1 && $this->paso <= 6){
            //Si el paso es 2 o 6 debe traer numero de documento
            if(($this->paso == 2 || $this->paso == 6) && empty($this->documento)){
                $this->setMessaje("Para este movimiento se requiere un numero de documento");
                return false;
            }
            //No permite devolverse en el orden de los pasos
            if( $this->datos["estado"] < $this->servicio->estado){
                $this->setMessaje("No es posible operar estados inferiores al actual");
                return false;                
            }
            //No permite servicios en valor 0
            if( $this->servicio->valor_bruto_procedimiento <= 0){
                $this->setMessaje("No es posible operar servicios en valor 0");
                return false;                
            }

            return true;

        }else{
            $this->setMessaje("Movimiento no pertenece al rango");
            return false;
        }
    }    

    private function cargaDatos(){
        //Carga datos de estados y tipos según el numero de paso
        switch ($this->paso) {
            case 1:
                $this->datos = array("Tipo"=>"Valoración", "estado"=>1);
                break;
            case 2:
                $this->datos = array("Tipo"=>"Orden Trabajo", "estado"=>1);
                break;
            case 3:
                $this->datos = array("Tipo"=>"Orden Trabajo", "estado"=>2);
                break;
            case 4:
                $this->datos = array("Tipo"=>"Orden Trabajo", "estado"=>3);
                break;
            case 5:
                $this->datos = array("Tipo"=>"Orden Trabajo", "estado"=>4);
                break;
            case 6:
                $this->datos = array("Tipo"=>"Orden Compra", "estado"=>4);
                break;                
        }

    }

}
<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Models\SerItemServicio;
use Illuminate\Http\Request;

use Facades\App\Classes\SupportImages;
use Illuminate\Support\Facades\Auth;
use App\Models\InvServicio;
use App\Models\SerServicio;
use App\Models\SerDescuento;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use App\Models\SerIndiceImagenes;
use Illuminate\Support\Facades\File;

class ServicioItemController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 14;
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

        //Carga los tipos de servicio en inventario
        $tipoServicios = DB::table('inv_servicios')
            ->select(DB::raw("id, CONCAT(sku, ' (', nombre, ')') as sku"))
            ->where('deleted_at', '=', null)
            ->pluck('sku', 'id');

        //Carga el numero de servicio padre del item
        $servicio_id = $id;

        //Carga vista de Formulario de EDICION de Líneas 
        return view('servicio.item-servicio.create', compact('tipoServicios', 'servicio_id'));  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            //Desde formulario trae los datos del servicio
            //Crea registro en la tabla de items 
            //Retorna a Index
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'serv_servicio_id' => 'required',
                'inv_servicio_id' => 'required',
                'accion' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }    

            //Carga datos del procedimiento
            $InvServicio =  InvServicio::find($request->inv_servicio_id);
            $SerServicio =  SerServicio::find($request->serv_servicio_id);
            //Gestiona la acción del item
            $accion = "";

            //Carga el valor del servicio segun la acción
            switch ($request->accion) {
                case "valor_reparar_pintar":
                    $valor_accion = $InvServicio->valor_reparar_pintar;
                    $accion ="Reparar y Pintar";
                    break;
                case "valor_cambiar_pintar":
                    $valor_accion = $InvServicio->valor_cambiar_pintar;
                    $accion ="Cambiar y Pintar";
                    break;
                case "valor_cambiar_reparar":
                    $valor_accion = $InvServicio->valor_cambiar_reparar;
                    $accion ="Cambiar";
                    break;
                case "fabricar":
                    $valor_accion = $InvServicio->valor_fabricar;
                    $accion ="Fabricar";
                    break;
                default: 
                    $valor_accion =  0;                    
            }          

            DB::beginTransaction();
                //CARGA dato en la tabla
                $item = new SerItemServicio;
                    $item->serv_servicios_id = $request->serv_servicio_id;
                    $item->inv_servicios_id =  $request->inv_servicio_id;
                    $item->valor = $valor_accion;
                    $item->accion = $accion;
                    $item->nota_item = $request->notas;
                $item->save();

                //Valor de servicio global
                $valor_servicio = SerItemServicio::where('serv_servicios_id',$request->serv_servicio_id)->sum('valor');
                //Edita valor global de servicio
                SerServicio::where('id', $request->serv_servicio_id)
                            ->update(['valor_bruto_procedimiento' => $valor_servicio]);                

                //CARGA imagenes
                if($request->file('files')){
                    SupportImages::imagearrayup($request->file('files'), $item->id, $SerServicio->cliente_id, "cotizacion");
                }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.edit', $request->serv_servicio_id)
                        ->with('info', 'Ítem creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerItemServicio  $serItemServicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina        

        //Carga los tipos de servicio en inventario
        $tipoServicios = InvServicio::pluck('nombre', 'id');
        //Carga los ítems de un servicio  
        $itemServicio = SerItemServicio::find($id);
        //carga Servicio
        $servicio = SerServicio::find($itemServicio->serv_servicios_id);
        //Carga las imagenes del servicio
        $imagenes = SerIndiceImagenes::where('item_id', $id)
                                    ->where('origen', 1)
                                    ->get();

        //Carga vista de Formulario de EDICION de Líneas 
        return view('servicio.item-servicio.show', compact('itemServicio', 'tipoServicios', 'servicio', 'imagenes')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SerItemServicio  $serItemServicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina        

        //Carga los tipos de servicio en inventario
        $tipoServicios = InvServicio::pluck('nombre', 'id');
        //Carga los ítems de un servicio  
        $itemServicio = SerItemServicio::find($id);
        //carga Servicio
        $servicio = SerServicio::find($itemServicio->serv_servicios_id);
        //Carga las imagenes del servicio
        $imagenes = SerIndiceImagenes::where('item_id', $id)
                                    ->where('origen', 1)
                                    ->get();

        //Carga vista de Formulario de EDICION de Líneas 
        return view('servicio.item-servicio.edit', compact('itemServicio', 'tipoServicios', 'servicio', 'imagenes')); 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerItemServicio  $serItemServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //Desde formulario trae los datos del servicio
            //Crea registro en la tabla de items 
            //Retorna a Index
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'serv_servicio_id' => 'required',
                'inv_servicio_id' => 'required',
                'accion' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }    

            //Carga datos del procedimiento
            $InvServicio =  InvServicio::find($request->inv_servicio_id);
            $SerServicio =  SerServicio::find($request->serv_servicio_id);

            //Carga el valor del servicio segun la acción
            switch ($request->accion) {
                case "valor_reparar_pintar":
                    $valor_accion = $InvServicio->valor_reparar_pintar;
                    $accion ="Reparar y Pintar";
                    break;
                case "valor_cambiar_pintar":
                    $valor_accion = $InvServicio->valor_cambiar_pintar;
                    $accion ="Cambiar y Pintar";
                    break;
                case "valor_cambiar_reparar":
                    $valor_accion = $InvServicio->valor_cambiar_reparar;
                    $accion ="Cambiar";
                    break;
                case "fabricar":
                    $valor_accion = $InvServicio->valor_fabricar;
                    $accion ="Fabricar";
                    break;
                default: 
                    $valor_accion =  0;                    
            }          

            DB::beginTransaction();
                //CARGA dato en la tabla
                $item = SerItemServicio::find($id);
                    $item->serv_servicios_id = $request->serv_servicio_id;
                    $item->inv_servicios_id =  $request->inv_servicio_id;
                    $item->valor = $valor_accion;
                    $item->accion = $accion;
                    $item->nota_item = $request->notas;
                $item->save();

                //Valor de servicio global
                $valor_servicio = SerItemServicio::where('serv_servicios_id',$request->serv_servicio_id)->sum('valor');
                //Edita valor global de servicio
                SerServicio::where('id', $request->serv_servicio_id)
                            ->update(['valor_bruto_procedimiento' => $valor_servicio]);                

                //CARGA imagenes
                if($request->file('files')){
                    SupportImages::imagearrayup($request->file('files'), $item->id, $SerServicio->cliente_id, "cotizacion");
                }
            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.edit', $request->serv_servicio_id)
                        ->with('info', 'Ítem editado exitosamente');
    }

    /**
     * Elimnina una imagen de una valorización
     */
    public function destroyImage($id_image, $id_item){
        
        //Borra la imagen de la tabla
        $imagen = SerIndiceImagenes::findOrFail($id_image);
            //Borra imagen del ítem del servidor
            File::delete(public_path() .'/'. $imagen->url . $imagen->nombre_archivo);
            //unlink(public_path() .'/'. $imagen->url . $imagen->nombre_archivo);

        $imagen->delete();
        
        //CARGA dato en la tabla LOGEAR
        $message = 'Usuario='. Auth::id() .' Imagen ID= '. $id_image;
        Miscellany::store_log("GESTION SERVICIOS IMAGEN ITEM", "ELIMINA", $message);          

        return redirect()->route('servicio-item.edit', $id_item)
                        ->with('info', 'Imagen eliminada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerItemServicio  $serItemServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
     
            //Gestión de seguridad heredada desde la base del Controller
            $this->cerbero('elimina');//lee, crea, edita, elimina

            DB::beginTransaction();
                //Borra item de servicio
                $item = SerItemServicio::findOrFail($id);
                $item->delete();
                //Busca servicio para actualiar valor_bruto
                $servicio = SerServicio::find($item->serv_servicios_id);
                //Valor de servicio global
                $nuevo_valor = SerItemServicio::where('serv_servicios_id',$item->serv_servicios_id)->sum('valor');    
                //Sube nuevo valor
                $servicio->update(['valor_bruto_procedimiento' => $nuevo_valor]);
                //CARGA dato en la tabla LOGEAR
                $message = 'Usuario='. Auth::id() .' Item ID= '. $id;
                Miscellany::store_log("GESTION SERVICIOS ITEM", "ELIMINA", $message);  

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.index')
                        ->with('info', 'Dato eliminado Correctamente');
    }
    /**
     * carga la ventana de descuentos
     */
    public function createDiscountWithId($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 19;
        $this->cerbero('crea');//lee, crea, edita, elimina        

        //carga datos de ítem servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('id', $id)->first();

        //Carga vista de Formulario de EDICION de Líneas 
        return view('financiero.descuento.create', compact('items_servicio'));  
    }

    /**
     * Store a newly discount.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDiscount(Request $request)
    {
        try {
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'id_item' => 'required',
                'valor' => 'required|numeric|min:0',
                'motivo' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }    

            //Carga datos actuales de servicio e ítem
            $itemDatos = SerItemServicio::find($request->id_item);
            $servicioDatos = SerServicio::find($itemDatos->serv_servicios_id);

            //Validar que el valor del descuento sea menor o igual que el valor del ítem
            if($request->valor > $itemDatos->valor){
                return back()->withInput()->withErrors("Valor descuento es superior a valor ítem");
            }

            DB::beginTransaction();
                //Sube nuevo valor a item
                SerItemServicio::where('id', $request->id_item)
                            ->update(['descuento' => $request->valor]);
                //Update motivo y log a tabla de descuentos
                    $descuento = new SerDescuento;
                        $descuento->serv_servicios_id = $servicioDatos->id;
                        $descuento->item_servicios_id = $itemDatos->id;	
                        $descuento->valor = $request->valor;
                        $descuento->nota_descuento = $request->motivo;
                        $descuento->creado_por = Auth::id();
                    $descuento->save();
            DB::commit();

        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return redirect()->route('servicio.edit', $servicioDatos->id)
                        ->with('info', 'Descuento creado exitosamente');

    }

}

<?php

namespace App\Http\Controllers\Operacion;

use App\Http\Controllers\Controller;
use App\Models\OprRevisaServicio;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\InvServicio;
use App\Models\SerServicio;
use App\Models\SerItemServicio;
use App\Models\SerAdmTiempo;
use App\Classes\UpdateStateServ;
use Facades\App\Classes\SupportImages;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\OprAsignaServicio;
use App\Models\SerIndiceImagenes;
use Illuminate\Support\Facades\File;
use Facades\App\Classes\Miscellany;


class RevisionServicioController extends Controller
{
    protected $caso_uso;

    public function __construct(){
        //ID Unico de caso de Uso
        $this->caso_uso = 15;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createWithId($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga datos del servicio y sus ítems        
        $item = SerItemServicio::with('invServicio')->where('id', $id)->first();
        
        /**VALIDA QUE EL ITEM NO HAYA SIDO CERRADO YA
         * Cuando se tiene el servicio abierto en diferentes ventanas se podia cerrar
         * varias veces, se realiza el cambio para evitar duplicidad. 
         * */       
        if(OprRevisaServicio::where('serv_servicios_id', $item->serv_servicios_id)->where('item_id', $item->id)->exists()){
            //Redirige al Controller de Idex de servicio
            return redirect()->route('operacion-revision.show', $item->serv_servicios_id)
                        ->with('info', 'ATENCION: Ítem con proceso existente.');
        }

        //Carga vista de Formulario de CREACION de Roles 
        return view('operacion.revision-final.create', compact('item'));  

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
                //Valida la informacion que viene del formulario
                $Validate = Validator::make($request->all(), [
                    'notas' => 'required',
                    'servicio_id' => 'required',
                    'item_id' => 'required',
                ]);
                if ($Validate->fails()) {
                    return back()->withInput()->withErrors($Validate);
                } 
                
                /**VALIDA QUE EL ITEM NO HAYA SIDO CERRADO YA
                 * Cuando se tiene el servicio abierto en diferentes ventanas se podia cerrar
                 * varias veces, se realiza el cambio para evitar duplicidad. 
                 * */       
                if(OprRevisaServicio::where('serv_servicios_id', $request->servicio_id)->where('item_id', $request->item_id)->exists()){
                    //Redirige al Controller de Idex de servicio
                    return redirect()->route('operacion-revision.show', $request->servicio_id)
                                ->with('info', 'ATENCION: Ítem con proceso existente.');
                }

                //CARGA imagenes
                if(!$request->file('files')){
                    return back()->withInput()->withErrors("Debe subir al menos 1 foto");
                }

                //QUEDA PARA POSTERIOR PROGRAMACION
                //Si esta rechazado NO cambia de estado y escribe nota en tabla serv_administrativo_tiempos

                //Si esta aprobado sube registro a la tabla de calidad y gestiona cambio de estado            
                DB::beginTransaction();
    
                    //Carga datos del servicio
                    $SerServicio =  SerServicio::find($request->servicio_id);
                    //CARGA dato en la tabla ope_calidad
                    $calidad = new OprRevisaServicio;
                        $calidad->serv_servicios_id = $request->servicio_id;
                        $calidad->item_id = $request->item_id;
                        $calidad->cant_img = 0;
                        $calidad->creado_por = Auth::id();
                        $calidad->nota = $request->notas;
                        $calidad->estado_revision = 1;           
                    $calidad->save();
                    //CARGA imagenes
                    if($request->file('files')){
                        SupportImages::imagearrayup($request->file('files'), $request->item_id, $SerServicio->cliente_id, "calidad");
                    }
                    //Cambia revisado OK de la tabla de serv_servicios_items
                    SerItemServicio::where('id', $request->item_id)
                                    ->update(['ok_revisado' => 1]);

                DB::commit();
    
            //********************** */
            } catch (Exception $e) {
    
                DB::rollback();
                $messaje = $e->getMessage();
                abort('403', $messaje);
            }

        //Redirige al Controller de Idex de servicio
        return redirect()->route('operacion-revision.show', $request->servicio_id)
                    ->with('info', 'Proceso de calidad aceptado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OprRevisaServicio  $oprRevisaServicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('lee');//lee, crea, edita, elimina

        //Carga datos del servicio y sus ítems
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$id)->first();
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $id)->get();
        
        //carga cantidad de servicios abiertos para autorizar el cierre, si hay alguno abierto no lo permite
        $cant_items_abiertos = SerItemServicio::where('serv_servicios_id', $id)
                                                ->where('ok_revisado', 0)
                                                ->count();


        //Carga vista de Formulario de CREACION de Roles 
        return view('operacion.revision-final.show', compact('servicio', 'items_servicio', 'cant_items_abiertos'));  

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OprRevisaServicio  $oprRevisaServicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        //Gestión de seguridad heredada desde la base del Controller
        $this->cerbero('edita');//lee, crea, edita, elimina

        //Carga el registro de calidad actual de la taba de registros
        $ope_calidad = OprRevisaServicio::where('item_id', $id)->first();
        //Carga datos del servicio y sus ítems        
        $item = SerItemServicio::with('invServicio')->where('id', $id)->first();
        //carga Servicio
        $servicio = SerServicio::find($item->serv_servicios_id);
        //Carga las imagenes del servicio
        $imagenes = SerIndiceImagenes::where('item_id', $id)
                                    ->where('origen', 2)
                                    ->get();

        //Carga vista de Formulario de CREACION de Roles 
        return view('operacion.revision-final.edit', compact('item', 'ope_calidad', 'imagenes', 'servicio'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OprRevisaServicio  $oprRevisaServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //Valida la informacion que viene del formulario
            $Validate = Validator::make($request->all(), [
                'notas' => 'required',
                'servicio_id' => 'required',
                'item_id' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            } 
            
            //QUEDA PARA POSTERIOR PROGRAMACION
            //Si esta rechazado NO cambia de estado y escribe nota en tabla serv_administrativo_tiempos

            //Si esta aprobado sube registro a la tabla de calidad y gestiona cambio de estado            
            DB::beginTransaction();

                //Carga datos del servicio
                $SerServicio =  SerServicio::find($request->servicio_id);
                //CARGA dato en la tabla ope_calidad
                $calidad = OprRevisaServicio::find($id);
                    //$calidad->serv_servicios_id = $request->servicio_id;
                    //$calidad->item_id = $request->item_id;
                    //$calidad->cant_img = 0;
                    //$calidad->creado_por = Auth::id();
                    $calidad->nota = $request->notas;
                    //$calidad->estado_revision = 1;           
                $calidad->save();
                //CARGA imagenes
                if($request->file('files')){
                    SupportImages::imagearrayup($request->file('files'), $request->item_id, $SerServicio->cliente_id, "calidad");
                }
                //Cambia revisado OK de la tabla de serv_servicios_items
                //SerItemServicio::where('id', $request->item_id)
                //                ->update(['ok_revisado' => 1]);

            DB::commit();

        //********************** */
        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

    //Redirige al Controller de Idex de servicio
    return redirect()->route('operacion-revision.show', $request->servicio_id)
                ->with('info', 'Proceso de calidad aceptado');

    }

    //Actualiza el estado de un servicio
    public function updateState(Request $request)
    {   
        //VALIDA datos requeridos
        $Validate = Validator::make($request->all(), [
            'paso_id' => 'required',
            'servicio_id' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        }

        //VERIFICA que no este siendo procesado por técnicos
        if(OprAsignaServicio::where('servicio_id', $request->servicio_id)->whereIn('estado', [1, 2])->exists()){
            return back()->withInput()->withErrors("Servicio esta siendo procesado por los técnicos.");
        }

        //Instancia y Corre Clase cambiadora de estados
                                        //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
        $estado = new UpdateStateServ($request->paso_id, $request->servicio_id, $request->numero_documento, $request->nota); 
        $estado->actualizaEstado(); //Genera la actualización        

        //Redirige al Controller de creacion de Ítems de servicio
        return redirect()->route('servicio.index')
                    ->with('info', $estado->getMessaje());

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

        return redirect()->route('operacion-revision.edit', $id_item)
                        ->with('info', 'Imagen eliminada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OprRevisaServicio  $oprRevisaServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(OprRevisaServicio $oprRevisaServicio)
    {
        //
    }
}

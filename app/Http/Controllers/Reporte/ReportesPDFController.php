<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\SerServicio;
use App\Models\SerItemServicio;
use App\Models\OprRevisaServicio;
use Illuminate\Support\Facades\DB;
use Facades\App\Classes\Miscellany;
use Illuminate\Support\Facades\Validator;
use Facades\App\Classes\Cerbero;
use App\Models\SegFirma;
use App\Models\V_Productos;
use App\Models\InvProducto;
use App\Models\InvKardex;
use App\Models\SerIndiceImagenes;

use Illuminate\Support\Facades\Storage;


class ReportesPDFController extends Controller
{

    protected $caso_uso;
    protected $date;
    protected $fecha;
    protected $impresion;

    public function __construct(){

        //Carga datos para informe
        $this->date = Carbon::now();
        $this->fecha = $this->date->format('d-m-Y');
        $this->impresion = $this->date->toDateTimeString();
    }

    /**
     * https://github.com/barryvdh/laravel-dompdf
     * https://www.youtube.com/watch?v=n04ic-ALRvw
     * 
     * Para generar los informes se requiere permiso de CREACION 
     * en el caso de uso especifico de cada PDF
     */

    /**
     * Genera reporte de Cotizacion (Valorización) de servicios
     * Diseño para impresión y autorización 
     * */ 
    public function getValorizacion(Request $request){
        
        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 16;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$request->servicio_id)->first();
        //Items que componen el servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $request->servicio_id)->get();
        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $request->servicio_id)
            ->where('serv_servicios_items.deleted_at', null)
            ->first();
        //Carga porcetnaje de IVA
        $iva = Miscellany::getParameterKey("IVA");
        //Carga valores con descuentos para sacar el iva despues
        $valMenDesc =  Miscellany::getValServicio($request->servicio_id);
        //Gestiona valor de IVA
        $val_iva = (($valMenDesc * (int)$iva[0]->variable_1) /100);
        
        //FIRMA y autorizado POR
        //Creado POR:
        $creado_por = Cerbero::getUserId($servicio->creado_por);
        $firma = SegFirma::where('servicio_id', $servicio->id)
                ->where('proceso', 'Firma Electrónica Orden Trabajo')
                ->first();

        if(!is_null($firma)){
            $autorizado_por = Cerbero::getUserId($firma->creado_por);
        }else{
            $autorizado_por = null;
        }

        //Carga las imagenes del servicio
        /*
        $imagenes = DB::table('serv_servicios_items')
            ->join('serv_indice_imagenes', 'serv_indice_imagenes.item_id', '=', 'serv_servicios_items.id')
            ->select(DB::raw('serv_indice_imagenes.item_id, serv_indice_imagenes.nombre_archivo, serv_indice_imagenes.url'))
            ->where('serv_servicios_items.serv_servicios_id', $request->servicio_id)
            ->where('serv_indice_imagenes.origen', 1)
            ->where('serv_servicios_items.deleted_at', null)
            ->where('serv_indice_imagenes.deleted_at', null)
            ->get();
        */
        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.cotizacion', ['servicio'=>$servicio, 'items_servicio'=>$items_servicio, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'tipo_vehiculo'=>$tipo_vehiculo, 'val_iva'=>$val_iva, 'firma'=>$firma, 'autorizado_por'=>$autorizado_por, 'creado_por'=>$creado_por])->setPaper('letter', 'portrait');
        return $pdf->stream('Valorizacion_' . $servicio->id . '.pdf'); 

        //$fecha = $this->fecha; 
        //$impresion = $this->impresion;

        //return view('reporte.pdf.cotizacion', compact('servicio', 'items_servicio', 'fecha', 'impresion', 'tipo_vehiculo', 'val_iva'));

    }

    /**
     * Genera reporte de revision de calidad
     * Diseño para impresión y autorización
     */
    public function getRevisionCalidad(Request $request){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 17;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //VALIDACION, Tiene calidad asociada
        if(!OprRevisaServicio::where('serv_servicios_id', $request->servicio_id)->exists()){
            return back()->withInput()->withErrors("Proceso de Calidad No Existe");
        }

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('id',$request->servicio_id)->first();
        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $request->servicio_id)
            ->where('serv_servicios_items.deleted_at', null)
            ->first();
        //Trae los datos de los ítems joineados
        $items_servicio = DB::table('serv_servicios_items')
            ->join('ope_calidad', 'ope_calidad.item_id', '=', 'serv_servicios_items.id')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->join('serv_servicios', 'serv_servicios.id', '=', 'serv_servicios_items.serv_servicios_id')
            ->select(DB::raw('serv_servicios_items.id, ope_calidad.nota, ope_calidad.creado_por, ope_calidad.cant_img, inv_servicios.nombre, inv_servicios.sku, serv_servicios_items.valor, serv_servicios.movil, serv_servicios_items.accion'))
            ->where('serv_servicios_items.serv_servicios_id', $request->servicio_id)
            ->where('serv_servicios_items.deleted_at', '=', null)
            ->where('ope_calidad.deleted_at', '=', null)
            ->where('inv_servicios.deleted_at', '=', null)
            ->get();
        //Trae fecha y hora de Inicio y Fin de proceso DATO MUY IMPORTANTE DEBE SER AFINADO
        //Fecha de inicio, se toma la hora de la toma del ultimo ítem
        $tiempo_inicio = DB::table('serv_servicios_items')
            ->select(DB::raw('max(created_at) as tiempo_inicio'))
            ->where('serv_servicios_id', $request->servicio_id)
            ->where('deleted_at', '=', null)
            ->first();
        //Fecha de fin, se toma la hora de la toma del primer ítem revisado
        $tiempo_fin = DB::table('ope_calidad')
            ->select(DB::raw('min(created_at) as tiempo_fin'))
            ->where('serv_servicios_id', $request->servicio_id)
            ->where('deleted_at', '=', null)
            ->first();

        //FIRMA y autorizado POR
        //Creado POR:
        $creado_por = Cerbero::getUserId($servicio->creado_por);
        $firma = SegFirma::where('servicio_id', $servicio->id)
                ->where('proceso', 'Autorizacion Calidad')
                ->first();

        if(!is_null($firma)){
            $autorizado_por = Cerbero::getUserId($firma->creado_por);
        }else{
            $autorizado_por = null;
        }

        /*Carga las imagenes de la Calidad
        $imagenes = DB::table('ope_calidad')
            ->join('serv_indice_imagenes', 'serv_indice_imagenes.item_id', '=', 'ope_calidad.item_id')
            ->select(DB::raw('serv_indice_imagenes.item_id, serv_indice_imagenes.nombre_archivo, serv_indice_imagenes.url'))
            ->where('ope_calidad.serv_servicios_id', $request->servicio_id)
            ->where('serv_indice_imagenes.origen', 2)
            ->where('ope_calidad.deleted_at', null)
            ->where('serv_indice_imagenes.deleted_at', null)
            ->get();
        */
        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.rcalidad', ['servicio'=>$servicio, 'items_servicio'=>$items_servicio, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'tipo_vehiculo'=>$tipo_vehiculo, 'tiempo_inicio'=>$tiempo_inicio, 'tiempo_fin'=>$tiempo_fin, 'creado_por'=>$creado_por, 'firma'=>$firma, 'autorizado_por'=>$autorizado_por])->setPaper('letter', 'portrait');
        return $pdf->stream('Calidad_servicio_' . $servicio->id . '.pdf'); 

        //$fecha = $this->fecha; 
        //$impresion = $this->impresion;
        //return view('reporte.pdf.rcalidad', compact('servicio', 'items_servicio', 'fecha', 'impresion', 'tipo_vehiculo', 'tiempo_inicio', 'tiempo_fin'));

    }
    /**
     * Genera Orden de trabajo del sistema
     * Documento FIRMADO
     */
    public function filtroOrdentrabajo(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 20;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna ventana de solicitud de rango de fechas
        return view('reporte.pdf.orden-trabajo.create'); 
    }    
    public function getOrdenTrabajo(Request $request){
        //Valida datos
        $Validate = Validator::make($request->all(), [
            'orden_trabajo' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('numero_orden_trabajo',$request->orden_trabajo)->first();

        //Revisa si la orden de trabajo existe
        if(is_null($servicio)){
            return back()->withInput()->withErrors("Numero Orden Trabajo no existe");
        }
        
        //Items que componen el servicio
        $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $servicio->id)->get();

        //VALIDACIONES
        //Que este firmada electronicamente
        if(!SegFirma::where('servicio_id', $servicio->id)->where('proceso', 'Firma Electrónica Orden Trabajo')->exists()){
            return back()->withInput()->withErrors("Documento NO firmado para este proceso");
        }

        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $servicio->id)
            ->where('serv_servicios_items.deleted_at', null)
            ->first();
        //Carga porcetnaje de IVA
        $iva = Miscellany::getParameterKey("IVA");
        //Carga valores con descuentos para sacar el iva despues
        $valMenDesc =  Miscellany::getValServicio($servicio->id);
        //Gestiona valor de IVA
        $val_iva = (($valMenDesc * (int)$iva[0]->variable_1) /100);
        //Creado POR:
        $creado_por = Cerbero::getUserId($servicio->creado_por);
        //FIRMA y autorizado POR
        $firma = SegFirma::where('servicio_id', $servicio->id)->where('proceso', 'Firma Electrónica Orden Trabajo')->first();
        $autorizado_por = Cerbero::getUserId($firma->creado_por);

        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.orden-trabajo.orden-trabajo', ['servicio'=>$servicio, 'items_servicio'=>$items_servicio, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'tipo_vehiculo'=>$tipo_vehiculo, 'val_iva'=>$val_iva, 'firma'=>$firma, 'creado_por'=>$creado_por, 'autorizado_por'=>$autorizado_por])->setPaper('letter', 'portrait');
        return $pdf->stream('Orden_trabajo_' . $request->orden_trabajo . '.pdf'); 

    }
    /**
     * Genera documento de recepción del sistema
     * Documento FIRMADO
     */
    public function filtroRecepcion(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 22;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Retorna ventana de solicitud de rango de fechas
        return view('reporte.pdf.recepcion-calidad.create'); 
    }    
    public function getRecepcion(Request $request){

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'orden_trabajo' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 

        //Carga un servicio en especifico para ser mostrado  
        $servicio = SerServicio::with('patio', 'cliente')->where('numero_orden_trabajo',$request->orden_trabajo)->first();
        //Revisa si la orden de trabajo existe
        if(is_null($servicio)){
            return back()->withInput()->withErrors("Numero Orden Trabajo no existe");
        }
        //VERIFICACIONES
        //Tiene calidad asociada
        if(!OprRevisaServicio::where('serv_servicios_id', $servicio->id)->exists()){
            return back()->withInput()->withErrors("Proceso de Calidad No Existe");
        }
        //Que este firmada electronicamente
        if(!SegFirma::where('servicio_id', $servicio->id)->where('proceso', 'Autorizacion Calidad')->exists()){
            return back()->withInput()->withErrors("Documento NO firmado para este proceso");
        }

        //Carga tipo de vehiculo
        $tipo_vehiculo = DB::table('serv_servicios_items')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->select(DB::raw('inv_servicios.tipo_vehiculo'))
            ->where('serv_servicios_items.serv_servicios_id', $servicio->id)
            ->where('serv_servicios_items.deleted_at', null)
            ->first();

        //Trae los datos de los ítems joineados
        $items_servicio = DB::table('serv_servicios_items')
            ->join('ope_calidad', 'ope_calidad.item_id', '=', 'serv_servicios_items.id')
            ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
            ->join('serv_servicios', 'serv_servicios.id', '=', 'serv_servicios_items.serv_servicios_id')
            ->select(DB::raw('serv_servicios_items.id, ope_calidad.nota, ope_calidad.creado_por, ope_calidad.cant_img, inv_servicios.nombre, inv_servicios.sku, serv_servicios_items.valor, serv_servicios.movil, serv_servicios_items.accion'))
            ->where('serv_servicios_items.serv_servicios_id', $servicio->id)
            ->where('serv_servicios_items.deleted_at', '=', null)
            ->where('ope_calidad.deleted_at', '=', null)
            ->where('inv_servicios.deleted_at', '=', null)
            ->get();

        //Trae fecha y hora de Inicio y Fin de proceso DATO MUY IMPORTANTE DEBE SER AFINADO
        //Fecha de inicio, se toma la hora de la toma del ultimo ítem
        $tiempo_inicio = DB::table('serv_servicios_items')
            ->select(DB::raw('max(created_at) as tiempo_inicio'))
            ->where('serv_servicios_id', $servicio->id)
            ->where('deleted_at', '=', null)
            ->first();

        //Fecha de fin, se toma la hora de la toma del primer ítem revisado
        $tiempo_fin = DB::table('ope_calidad')
            ->select(DB::raw('min(created_at) as tiempo_fin'))
            ->where('serv_servicios_id', $servicio->id)
            ->where('deleted_at', '=', null)
            ->first();

        //Creado POR:
        $creado_por = Cerbero::getUserId($servicio->creado_por);
        //FIRMA y autorizado POR
        $firma = SegFirma::where('servicio_id', $servicio->id)->where('proceso', 'Autorizacion Calidad')->first();
        $autorizado_por = Cerbero::getUserId($firma->creado_por);


        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.recepcion-calidad.recepcion', ['servicio'=>$servicio, 'items_servicio'=>$items_servicio, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'tipo_vehiculo'=>$tipo_vehiculo, 'tiempo_inicio'=>$tiempo_inicio, 'tiempo_fin'=>$tiempo_fin, 'creado_por'=>$creado_por, 'firma'=>$firma, 'autorizado_por'=>$autorizado_por])->setPaper('letter', 'portrait');
        return $pdf->stream('Recepcion_servicio_' . $servicio->id . '.pdf'); 

    }

    /**
     * Genera reporte de Cotizacion (Valorización) de servicios
     * getiona lotes de documentos
     * */ 
    public function getValorizacionBatch(){

        //Gestión de seguridad heredada desde la base del Controller
        //$this->caso_uso = 16;
        //$this->cerbero('crea');//lee, crea, edita, elimina

        $lisServicios = SerServicio::whereBetween('fecha_servicio', ['2022-03-02 00:00:00', '2022-04-01 23:59:59'])->get();

        foreach ($lisServicios as $servicio) {
     
            //Carga un servicio en especifico para ser mostrado  
            $servicio = SerServicio::with('patio', 'cliente')->where('id', $servicio->id)->first();
            //Items que componen el servicio
            $items_servicio = SerItemServicio::with('invServicio')->where('serv_servicios_id', $servicio->id)->get();
            //Carga tipo de vehiculo
            $tipo_vehiculo = DB::table('serv_servicios_items')
                ->join('inv_servicios', 'inv_servicios.id', '=', 'serv_servicios_items.inv_servicios_id')
                ->select(DB::raw('inv_servicios.tipo_vehiculo'))
                ->where('serv_servicios_items.serv_servicios_id',$servicio->id)
                ->first();
            //Carga porcetnaje de IVA
            $iva = Miscellany::getParameterKey("IVA");
            //Carga valores con descuentos para sacar el iva despues
            $valMenDesc =  Miscellany::getValServicio($servicio->id);
            //Gestiona valor de IVA
            $val_iva = (($valMenDesc * (int)$iva[0]->variable_1) /100);

            //CREA EL ARCHIVO
            $pdf = Pdf::loadView('reporte.pdf.cotizacion', ['servicio'=>$servicio, 'items_servicio'=>$items_servicio, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'tipo_vehiculo'=>$tipo_vehiculo, 'val_iva'=>$val_iva])->setPaper('letter', 'portrait');
            //Nombra Archivo
            $fileName =  $servicio->id . '.' . 'pdf' ;
            //Lo almacena en ruta especificada
            Storage::disk('public')->put($fileName, $pdf->output());

        }

        $files = Storage::disk('local')->allFiles('public');

        dd($files);

    }

    /**
     * Genera reporte inventario con existencias actuales
     * */ 
    public function getInventario(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 27;
        $this->cerbero('crea');//lee, crea, edita, elimina
        
        //Carga Inventario para ser mostrado
        $inventario = V_Productos::all();

        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.inventario', ['inventario'=>$inventario, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion])->setPaper('letter', 'portrait');
        return $pdf->stream('Inventario.pdf'); 
        //return $pdf->download('Inventario.pdf');

        //return view('reporte.pdf.inventario', compact('inventario', 'fecha', 'impresion'));

    }

    /**
     * Genera documento de recepción del sistema
     * Documento FIRMADO
     */
    public function filtroKardex(){

        //Gestión de seguridad heredada desde la base del Controller
        $this->caso_uso = 26;
        $this->cerbero('crea');//lee, crea, edita, elimina

        //Carga lista de productos, en formato pluck
        $productos = InvProducto::all()->pluck('nombre', 'id');;

        //Retorna ventana de solicitud de rango de fechas
        return view('reporte.pdf.kardex-producto.create', compact('productos')); 
    }    
    public function getKardex(Request $request){

        //Valida datos
        $Validate = Validator::make($request->all(), [
            'producto_id' => 'required',
            'fecha_desde' => 'required',
            'fecha_hasta' => 'required',
        ]);
        if ($Validate->fails()) {
            return back()->withInput()->withErrors($Validate);
        } 
        
        //Carga datos del producto
        $producto = InvProducto::find($request->producto_id);

        //Gestiona fechas para el rango
        $fecha_desde = $request->fecha_desde . " 00:00:00";
        $fecha_hasta = $request->fecha_hasta . " 23:59:59";

        //Trae los kardex a mostrar
        $kardex = InvKardex::where('producto_id', $request->producto_id)
                            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])->get();

        //CREA EL ARCHIVO
        $pdf = Pdf::loadView('reporte.pdf.kardex-producto.kardex', ['kardex'=>$kardex, 'fecha'=>$this->fecha, 'impresion'=>$this->impresion, 'producto'=>$producto])->setPaper('letter', 'portrait');
        return $pdf->stream('Kardex_Producto' . '.pdf'); 

    }

}

<?php
/**
 * Clase General para soporte de la gestion de imagenes
 * Author: Mauricio Baquero Soto
 * Marzo de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;

use Intervention\Image\Facades\Image as Image;
use App\Models\SerItemServicio;
use App\Models\OprRevisaServicio;
use App\Models\SerIndiceImagenes;
use App\Models\FltIndiceImagenes;


class SupportImages{

    //Sube un array de fotos y las escribe en tabla auxiliar
    public function imagearrayup($files, $item_id, $company_id, $proceso){

        /**Las fotografias se almacenan en la siguiente ruta
         * PUBLIC
         * ├──imgservices
         * │   └── Carpeta Código Ciente
         * │       └── [Código Ítem - Numero de imagen]
         * │       └──── Carpeta Calidad //Aqui se ponen la imagenes de proceso de calidad
         * │            └── [Código Ítem - Numero de imagen]
         */
        
        //Gestiona la ruta de donde se guardan las imagenes
         switch ($proceso) {
            case "cotizacion":
                $destinationPath = public_path(). '/imgservices/' . $company_id;
                $url= 'imgservices/' . $company_id . '/';
                $origen = 1;
                break;
            case "calidad":
                $destinationPath = public_path(). '/imgservices/' . $company_id . '/calidad';
                $url = 'imgservices/' . $company_id . '/calidad/';
                $origen = 2;
                break;
        }

        //Contador para nombre de imagen   
        $cont = 0; 
        //Crea el folder si no existe
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        //Recorre el array de fotos
        foreach($files as $file) {
            $cont++;

            //Renombra la imagen
            $extencion = strtolower($file->getClientOriginalExtension());
            //$extencion = "jpeg";
            $filename = $item_id . '-' . uniqid();
            $filename.= '.' . $extencion;

            //Trae las dimensiones de las imagenes
            $alto = Image::make($file)->height();
            $ancho = Image::make($file)->width();

            //Evalua si imagen es horizontal o vertical y carga la foto
            if($alto < $ancho){ //Horizontal
                $img = Image::make($file)->widen(800, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($destinationPath . '/' . $filename);

            }else{ //vertical
                $img = Image::make($file)->widen(400, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($destinationPath . '/' . $filename);
            }

            //Carga la referencia de la imagen en la base de datos. OT:090722-003 ************
            $imagen = new SerIndiceImagenes;
                $imagen->item_id = $item_id;
                $imagen->origen = $origen;//Origen de la imagen 1=Valorización, 2=Calidad
                $imagen->nombre_archivo = $filename;
                $imagen->url = $url; 
            $imagen->save();
            //******************************************************************************** */

        }

        //Edita cantidad de imagenes cargadas en la tabla de item
        //Despues se recuperan con un do while
        // SE PONE A CARGAR IMAGENES EN 0, PARA REALIZAR LECTURA DESDE LA NUEVA TABLA OT:090722-003
        // Se carga automaticamente desde la tabla
        /*
            if($proceso == "cotizacion"){
                SerItemServicio::where('id', $item_id)
                    ->update(['cant_img' => $cont]);
            }elseif($proceso == "calidad"){
                OprRevisaServicio::where('item_id', $item_id)
                ->update(['cant_img' => $cont]);
            }
        */
        
        //Retorna cantidad de imagenes cargadas
        return $cont;
    }

    //Sube un array de fotos y las escribe en tabla auxiliar para FLOTAS
    public function imageflotaup($files, $vehiculo_id, $company_id, $proceso){

        /**Las fotografias se almacenan en la siguiente ruta
         * PUBLIC
         * ├──imgservices
         * │   └── Carpeta Código Ciente
         * │       └──── Carpeta Flota //Aqui se ponen la imagenes del vehículo para gestión de flotas
         * │            └── [Código Vehículo - Nombre imagen]
         */
        
        //Gestiona la ruta de donde se guardan las imagenes
         switch ($proceso) {
            case "inventario":
                $destinationPath = public_path(). '/imgservices/' . $company_id . '/inventario';
                $url = 'imgservices/' . $company_id . '/inventario/';
                $origen = 1;
                break;
        }

        //Crea el folder si no existe
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        //Recorre el array de fotos
        foreach($files as $file) {

            //Renombra la imagen
            $extencion = strtolower($file->getClientOriginalExtension());
            $filename = $vehiculo_id . '-' . uniqid();
            $filename.= '.' . $extencion;

            //Trae las dimensiones de las imagenes
            $alto = Image::make($file)->height();
            $ancho = Image::make($file)->width();

            //Evalua si imagen es horizontal o vertical y carga la foto
            if($alto < $ancho){ //Horizontal
                $img = Image::make($file)->widen(800, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($destinationPath . '/' . $filename);

            }else{ //vertical
                $img = Image::make($file)->widen(400, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($destinationPath . '/' . $filename);
            }

            $imagen = new FltIndiceImagenes;
                $imagen->vehiculo_id = $vehiculo_id;
                $imagen->origen = $origen;//Origen de la imagen 1=Inventario
                $imagen->nombre_archivo = $filename;
                $imagen->url = $url; 
            $imagen->save();

        }
        //Retorna id de registro de 
        return "OK";
    }


}

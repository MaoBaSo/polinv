<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SegToken;
use App\Models\SegFirma;
use App\Models\SerServicio;
use Facades\App\Classes\Crypto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Classes\UpdateStateServ;
use App\Classes\Constraints;

class FirmaController extends Controller
{
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
     * FIRMA ORDEN DE TRABAJO*********************************************************
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        try {
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'servicio_id' => 'required',
                'numero_orden_trabajo' => 'required',
                'token' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }    

            //VERIFICA CONSTRAINTS
            if(Constraints::CNS_001(2, $request->numero_orden_trabajo)){
                return back()->withInput()->withErrors("CNS001 - Orden de Trabajo ya Existe.");
            }

            //Prepara datos para la operación
            $tokenStore = SegToken::where('user_id', Auth::user()->id)->first();
            $tokenPublic = Crypto::get_encrypt_64($tokenStore->token_public);
            $tokenPrivate = Crypto::get_encrypt_64($tokenStore->token_private);
            $proceso = "Firma Electrónica Orden Trabajo";
            $numero_documento =  $request->numero_orden_trabajo;

            //Revisa estado del proceso para firmar, SI esta disponible para firma?
            if(!SerServicio::where('tipo', 'Valoración')->where('estado', 1)->where('id', $request->servicio_id)->exists()){
                return back()->withInput()->withErrors("Documento NO disponible para Autorización");
            }
            //Revisar que usuario este autorizado para firmar
            if(!SegToken::where('user_id', Auth::user()->id)->exists()){
                return back()->withInput()->withErrors("Usuario sin TOKEN de firma");
            }
            //Revisar validez de token publico
            if($request->token != $tokenPublic){
                return back()->withInput()->withErrors("TOKEN invalido");
            }
            //Generar llave de firma 
            //FECHA_SERVICIO + FECHA_FIRMA + NUMERO_ SERVICIO + MOVIL + #DOCUMENTO + VALOR_BRUTO + USUARIO FIRMANTE : set_encrypt_128()
            //Separador | esta reservado no se puede utilizar
            $time = Carbon::now()->toDateTimeString();
            $trama = $request->fecha_servicio . '|' . $time . '|' . $request->servicio_id  . '|' .  $request->movil  . '|' .  $numero_documento . '|' . $request->valor_bruto_procedimiento  . '|' .  Auth::user()->id;
            $llave = Crypto::set_llave_firma($trama, $tokenPrivate);

            //CARGA dato en la tablas garantizando integridad de transacciones
            DB::beginTransaction();

                //Subir a tabla firmas
                $firma = new SegFirma;
                    $firma->servicio_id = $request->servicio_id;
                    $firma->token_id = $tokenStore->id;
                    $firma->proceso = $proceso;
                    $firma->firma = $llave;
                    $firma->creado_por = Auth::id();
                $firma->save();
                //Instancia y Corre Clase cambiadora de estados
                //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
                $estado = new UpdateStateServ(2, $request->servicio_id, $numero_documento, $proceso); 
                $estado->actualizaEstado(); //Genera la actualización                    
            
            DB::commit();

            //Enviar correo de soporte de transaccion V.2 del proceso

        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return view('miscellany.checkoutSignature', compact('llave', 'time', 'proceso', 'numero_documento'));   

    }

    /**
     * FIRMA RECEPCION DE TRABAJO ****************************************************
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRecepcion(Request $request)
    { 
        try {
            //Valida datos
            $Validate = Validator::make($request->all(), [
                'servicio_id' => 'required',
                'token' => 'required',
            ]);
            if ($Validate->fails()) {
                return back()->withInput()->withErrors($Validate);
            }    

            $tokenStore = SegToken::where('user_id', Auth::user()->id)->first();
            $tokenPublic = Crypto::get_encrypt_64($tokenStore->token_public);
            $tokenPrivate = Crypto::get_encrypt_64($tokenStore->token_private);
            $proceso = "Autorizacion Calidad";
            $numero_documento = $request->servicio_id;

            //Revisa estado del proceso para firmar, SI esta disponible para firma?
            if(!SerServicio::where('tipo', 'Orden Trabajo')->where('estado', 3)->where('id', $request->servicio_id)->exists()){
                return back()->withInput()->withErrors("Documento NO disponible para recepción");
            }
            //Revisar que usuario este autorizado para firmar
            if(!SegToken::where('user_id', Auth::user()->id)->exists()){
                return back()->withInput()->withErrors("Usuario sin TOKEN de firma");
            }
            //Revisar validez de token publico
            if($request->token != $tokenPublic){
                return back()->withInput()->withErrors("TOKEN invalido");
            }
            //Generar llave de firma 
            //SERVICIO + FECHA:HORA FIRMA + USUARIO FIRMANTE : set_encrypt_128()
            //Separador | esta reservado no se puede utilizar
            $time = Carbon::now()->toDateTimeString();
            $trama = $request->servicio_id . '|' . $time . '|' . Auth::user()->id;
            $llave = Crypto::set_llave_firma($trama, $tokenPrivate);

            //CARGA dato en la tablas garantizando integridad de transacciones
            DB::beginTransaction();

                //Subir a tabla firmas
                $firma = new SegFirma;
                    $firma->servicio_id = $request->servicio_id;
                    $firma->token_id = $tokenStore->id;
                    $firma->proceso = $proceso;
                    $firma->firma = $llave;
                    $firma->creado_por = Auth::id();
                $firma->save();
                //Instancia y Corre Clase cambiadora de estados
                //Paso, servicio_id, Orden de trabajo u Orden de compra, nota
                $estado = new UpdateStateServ(5, $request->servicio_id, '', "Firma Electrónica Recepción"); 
                $estado->actualizaEstado(); //Genera la actualización                    
            
            DB::commit();

            //Enviar correo de soporte de transaccion V.2 del proceso

        } catch (Exception $e) {

            DB::rollback();
            $messaje = $e->getMessage();
            abort('403', $messaje);
        }

        return view('miscellany.checkoutSignature', compact('llave', 'time', 'proceso', 'numero_documento'));   

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

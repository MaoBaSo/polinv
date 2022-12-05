<?php
/**
 * Clase General para soporte encriptamiento de datos sensibles. 
 * Author: Mauricio Baquero Soto
 * Enero de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */

namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Parametro;

class Crypto{

        //Encripta a 128
        public function set_encrypt_128($traza){
                //Declaracion de Variables de encriptamiento
                $COD = "AES-128-ECB";
                $KEY = "Itu4^xzW9Sy5";
                //$vendedor = uniqid() . '#' . openssl_encrypt(1, $COD, $KEY);
                $cryptTraza = openssl_encrypt($traza, $COD, $KEY);
                //$descript = openssl_decrypt($token, $COD, $KEY);
                return $cryptTraza;               
        }        
        //Desencripta 128
        public function get_encrypt_128($token){
                //Declaracion de Variables de desencriptamiento
                $COD = "AES-128-ECB";
                $KEY = "Itu4^xzW9Sy5";
                $descript = openssl_decrypt($token, $COD, $KEY);
                return $descript;
        }
        //Encripta a 64
        public function set_encrypt_64($traza){
                $cryptTraza = base64_encode($traza);
                return $cryptTraza;               
        }        
        //Desencripta 64
        public function get_encrypt_64($token){
                $deCryptTraza = base64_decode($token);
                return $deCryptTraza;
        }

        //GENERA LLAVES PARA FIRMAS
        //Encripta a 128
        public function set_llave_firma($traza, $TOKEN_PRIVATE){
                //Declaracion de Variables de encriptamiento
                $COD = "AES-128-ECB";
                $KEY =  $TOKEN_PRIVATE;
                $cryptTraza = openssl_encrypt($traza, $COD, $KEY);
                return $cryptTraza;               
        }          


}


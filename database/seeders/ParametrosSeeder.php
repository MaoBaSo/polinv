<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Parametro;

class ParametrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Ingresa datos inciales de la tabla parametros        
        //DB::table('conf_parametros')->insert(['key' => 'PAIS','descripcion' => 'Tabla de Paises','variable_1' => '1','variable_2' => 'Colombia',]);
        //Parametro::truncate();

        //Parametros Generales Iniciales
        $parametros = new Parametro; //1
            $parametros->key = 'PAIS';
            $parametros->descripcion = 'Tabla de Paises';
            $parametros->variable_1 = 'Colombia';
        $parametros->save();
        $parametros = new Parametro; //2
            $parametros->key = 'PAIS';
            $parametros->descripcion = 'Tabla de Paises';
            $parametros->variable_1 = 'Panamá';
        $parametros->save();
        $parametros = new Parametro; //3
            $parametros->key = 'CIUDAD';
            $parametros->descripcion = 'Tabla de Ciudades';
            $parametros->relacion = '2';
            $parametros->variable_1 = 'Ciudad de Panamá';
        $parametros->save();

        $parametros = new Parametro; //4
            $parametros->key = 'TIPO_DOCUMENTO';
            $parametros->descripcion = 'Tabla de Tipos Documento';
            $parametros->variable_1 = 'NIT';
        $parametros->save();  
        $parametros = new Parametro; //5
            $parametros->key = 'TIPO_DOCUMENTO';
            $parametros->descripcion = 'Tabla de Tipos Documento';
            $parametros->variable_1 = 'CEDULA CIUDADANIA';
        $parametros->save();
        $parametros = new Parametro; //6
            $parametros->key = 'TIPO_DOCUMENTO';
            $parametros->descripcion = 'Tabla de Tipos Documento';
            $parametros->variable_1 = 'CEDULA EXTRANJERIA';
        $parametros->save(); 

        //Presentaciones
         $parametros = new Parametro; //7
            $parametros->key = 'PRESENTACION';
            $parametros->descripcion = 'Tabla de presentaciones de producto';
            $parametros->variable_1 = 'Unidades';
        $parametros->save();       
        $parametros = new Parametro; //8
            $parametros->key = 'PRESENTACION';
            $parametros->descripcion = 'Tabla de presentaciones de producto';
            $parametros->variable_1 = 'Mililitros';
        $parametros->save();        
        
        //Parametros de Sistema
        $parametros = new Parametro;//9
            $parametros->key = 'USR_tipo';
            $parametros->descripcion = 'Tipos de usuarios, para: JPEX';
            $parametros->variable_1 = 'JPEX';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //10
            $parametros->key = 'USR_tipo';
            $parametros->descripcion = 'Tipos de usuarios, para: CLIENTE';
            $parametros->variable_1 = 'Clientes';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //11
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'AUTOMOVIL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //12
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'BUS';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //13
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'BUSETA';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //14
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'CAMIÓN';
            $parametros->de_sistema = 1;
        $parametros->save();        
        $parametros = new Parametro; //15
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'CAMIONETA';
            $parametros->de_sistema = 1;
        $parametros->save();    
        $parametros = new Parametro; //16
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'CAMPERO';
            $parametros->de_sistema = 1;
        $parametros->save();    
        $parametros = new Parametro; //17
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'MICROBÙS';
            $parametros->de_sistema = 1;
        $parametros->save();            
        $parametros = new Parametro; //18
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'TRACTOCAMIÒN';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //19
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'VOLQUETA';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //20
            $parametros->key = 'TIPO_VEHICULO';
            $parametros->descripcion = 'Tabla tipos de vehículos';
            $parametros->variable_1 = 'OTRO';
            $parametros->de_sistema = 1;
        $parametros->save();

        $parametros = new Parametro; //21
            $parametros->key = 'IVA';
            $parametros->descripcion = 'Impuesto a las ventas Colombia';
            $parametros->variable_1 = '19';
            $parametros->de_sistema = 1;
        $parametros->save();        

        $parametros = new Parametro; //22
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'GASOLINA';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //23
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'DIESEL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //24
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'GAS';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //25
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'HÍBRIDO';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //26
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'ELÉCTRICO';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //27
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'ETANOL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //28
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'BIODISEL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //29
            $parametros->key = 'TIPO_COMBUSTIBLE';
            $parametros->descripcion = 'Tabla tipo de combustibles';
            $parametros->variable_1 = 'HIDROGENO';
            $parametros->de_sistema = 1;
        $parametros->save();

        $parametros = new Parametro; //30
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'PARTICULAR';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //31
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'PÙBLICO';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //32
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'DIPLOMATICO';
            $parametros->de_sistema = 1;
        $parametros->save();        
        $parametros = new Parametro; //33
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'OFICIAL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //34
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'ESPECIAL';
            $parametros->de_sistema = 1;
        $parametros->save();
        $parametros = new Parametro; //35
            $parametros->key = 'TIPO_SERVICIO';
            $parametros->descripcion = 'Tabla tipo de servicio';
            $parametros->variable_1 = 'OTROS';
            $parametros->de_sistema = 1;
        $parametros->save();


    }
}

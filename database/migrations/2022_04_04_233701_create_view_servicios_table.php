<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW v_info_servicios AS
            SELECT
            serv_servicios_items.id,
            serv_servicios.created_at as fecha_creacion,
            serv_servicios.id as numero_valorizacion,
            serv_servicios.numero_orden_trabajo,
            serv_servicios.numero_orden_compra,
            serv_servicios.placa,
            serv_servicios.movil,
            CONCAT(inv_servicios.sku, ' (', inv_servicios.nombre, ')') as procedimiento,
            serv_servicios_items.accion,
            if(
              serv_servicios.estado = 1, 'Abierto', 
                if(serv_servicios.estado = 2, 'En Proceso', 
                    if(serv_servicios.estado = 3, 'Control Calidad', 
                        if(serv_servicios.estado = 4, 'Finalizado', 'Error en parametro')
                    )
                )
            ) as estado,
            serv_servicios_items.valor as valor_bruto_item,
            serv_servicios_items.descuento as descuento,
            (serv_servicios_items.valor - serv_servicios_items.descuento) as valor_con_descuento,
            (
                (
                    (serv_servicios_items.valor - serv_servicios_items.descuento)
                    * 
                    (select variable_1 from conf_parametros where `key` = 'IVA')
                )/100
            ) as IVA,
            (
                (serv_servicios_items.valor - serv_servicios_items.descuento)
                +
                (
                    (
                        (serv_servicios_items.valor - serv_servicios_items.descuento)
                        * 
                        (select variable_1 from conf_parametros where `key` = 'IVA')
                    )/100
                )
            ) as valor_neto_item
            
            FROM serv_servicios_items
            JOIN serv_servicios ON
                serv_servicios.id = serv_servicios_id
            JOIN inv_servicios ON
                inv_servicios.id = serv_servicios_items.inv_servicios_id
            WHERE serv_servicios_items.deleted_at is null    
            AND serv_servicios.deleted_at is null
            AND inv_servicios.deleted_at is null
            ORDER BY serv_servicios.id desc;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_info_servicios");
    }
}

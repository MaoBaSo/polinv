<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewServiciosBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
            CREATE VIEW v_info_servicios_base AS
            SELECT 
            serv_servicios.id,
            serv_servicios.fecha_servicio as fecha_creacion,
            serv_servicios.placa,
            serv_servicios.movil, 
            serv_servicios.tipo,
            serv_servicios.id as numero_valorizacion,
            serv_servicios.numero_orden_trabajo,
            serv_servicios.numero_orden_compra,
            if(
              serv_servicios.estado = 1, 'Abierto', 
                if(serv_servicios.estado = 2, 'En Proceso', 
                    if(serv_servicios.estado = 3, 'Control Calidad', 
                        if(serv_servicios.estado = 4, 'Finalizado', 'Error en parametro')
                    )
                )
            ) as estado,
            serv_servicios.valor_bruto_procedimiento as valor_bruto_procedimiento,
            (
                SELECT SUM(descuento) FROM serv_servicios_items
                WHERE deleted_at IS NULL
                AND serv_servicios_items.serv_servicios_id = serv_servicios.id
            
            ) as descuento,
            
            (
                serv_servicios.valor_bruto_procedimiento
                -
                (
                    SELECT SUM(descuento) FROM serv_servicios_items
                    WHERE deleted_at IS NULL
                    AND serv_servicios_items.serv_servicios_id = serv_servicios.id
            
                )
            ) as bruto_descuento,
            
            (
                (
                    (
                        serv_servicios.valor_bruto_procedimiento - 
                        (
                            SELECT SUM(descuento) FROM serv_servicios_items
                            WHERE deleted_at IS NULL
                            AND serv_servicios_items.serv_servicios_id = serv_servicios.id
                        )
                    
                    )
                    * 
                    (select variable_1 from conf_parametros where `key` = 'IVA')
                )/100
            ) as IVA,
            
            (
                (
                    serv_servicios.valor_bruto_procedimiento
                    -
                    (
                        SELECT SUM(descuento) FROM serv_servicios_items
                        WHERE deleted_at IS NULL
                        AND serv_servicios_items.serv_servicios_id = serv_servicios.id
            
                    )
                )
                +
                (
                    (
                        (
                            serv_servicios.valor_bruto_procedimiento - 
                            (
                                SELECT SUM(descuento) FROM serv_servicios_items
                                WHERE deleted_at IS NULL
                                AND serv_servicios_items.serv_servicios_id = serv_servicios.id
                            )
                        
                        )
                        * 
                        (select variable_1 from conf_parametros where `key` = 'IVA')
                    )/100
                )
            ) as valor_neto,
            serv_servicios.nota_servicio
            FROM serv_servicios
            WHERE
            serv_servicios.deleted_at is null;
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

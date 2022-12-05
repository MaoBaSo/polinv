<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateViewAPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW v_info_pagar_empleados AS
            SELECT 
            ope_item_servicio_empledo.token,
            emp_empleados.identificacion,
            CONCAT (emp_empleados.primer_nombre, ' ', emp_empleados.segundo_nombre, ' ', emp_empleados.primer_apellido, ' ', emp_empleados.segundo_apellido) AS nombre,
            serv_servicios.numero_orden_trabajo,
            serv_servicios.movil,
            serv_servicios.placa,
            inv_servicios.tipo_vehiculo,
            CONCAT (inv_servicios.sku, ' (', inv_servicios.nombre, ')') as procedimiento,
            serv_servicios_items.accion,
            ope_item_servicio_empledo.valor_comision,
            ope_item_servicio_empledo.porcentaje,
            ope_item_servicio_empledo.valor_pagar
            FROM ope_item_servicio_empledo
                JOIN serv_servicios ON
                serv_servicios.id = ope_item_servicio_empledo.servicio_id
                JOIN serv_servicios_items ON
                serv_servicios_items.id = ope_item_servicio_empledo.item_id
                JOIN inv_servicios ON
                inv_servicios.id = serv_servicios_items.inv_servicios_id
                JOIN emp_empleados ON
                emp_empleados.id = ope_item_servicio_empledo.empleado_id
            WHERE ope_item_servicio_empledo.deleted_at is null
            AND serv_servicios.deleted_at is null
            AND ope_item_servicio_empledo.estado = 3;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_info_pagar_empleados");
    }
}

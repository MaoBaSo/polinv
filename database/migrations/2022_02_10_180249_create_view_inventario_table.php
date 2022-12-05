<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateViewInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW v_inv_productos AS
            select
                inv_productorbodega.id,
                inv_productorbodega.cantidad_actual,
                inv_productos.nombre as nombre_producto,
                inv_productos.sku,
                inv_productos.numero_parte,
                inv_productos.oem,
                inv_productos.factor_maximo,
                inv_productos.factor_minimo,
                inv_productos.caracteristicas,
                inv_productos.pais_id,
                inv_productos.fabricante_id,
                inv_productos.keywords,
                inv_bodegas.nombre as nombre_bodega,
                inv_bodegas.ciudad_id,
                conf_parametros.variable_1,
                inv_sub_linea.nombre as nombre_linea,
                inv_sub_linea.linea_id
            from inv_productorbodega
            join inv_productos
            on inv_productorbodega.producto_id = inv_productos.id
            join inv_bodegas
            on inv_productorbodega.bodega_id = inv_bodegas.id
            join conf_parametros
            on inv_productos.presentacion_id = conf_parametros.id
            join inv_sub_linea
            on inv_productos.sublinea_id = inv_sub_linea.id
            where inv_productorbodega.deleted_at is null
            and inv_productos.deleted_at is null
            and inv_bodegas.deleted_at is null
            and inv_sub_linea.deleted_at is null;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_inv_productos");
    }
}

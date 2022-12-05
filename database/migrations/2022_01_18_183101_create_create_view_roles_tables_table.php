<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCreateViewRolesTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW v_seg_permisos AS
                SELECT
                seg_permisos.id AS id, 
                seg_roles.nombre AS rol,
                seg_caso_uso.caso_uso AS caso_uso,
                seg_permisos.lee AS lee,
                seg_permisos.crea AS crea,
                seg_permisos.edita AS edita,
                seg_permisos.elimina AS elimina
                FROM seg_permisos 
                JOIN seg_roles ON
                    seg_roles.id = seg_permisos.rol_id
                JOIN seg_caso_uso ON
                    seg_caso_uso.id = seg_permisos.caso_id
                WHERE seg_permisos.deleted_at is null;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW v_seg_permisos");
    }
}

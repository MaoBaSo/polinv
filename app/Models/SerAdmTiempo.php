<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerAdmTiempo extends Model
{
    use SoftDeletes;
    
    Protected $table = 'serv_administrativo_tiempos';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'serv_servicios_id', 
        'nuevo_tipo',
        'nuevo_estado',
        'creado_por',
        'nota'
    ];


}

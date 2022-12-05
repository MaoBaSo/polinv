<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CliUbicacionBodega extends Model
{
    use SoftDeletes;
    
    Protected $table = 'cli_ubicacion_bodega';
    protected $dates = ['deleted_at'];
}

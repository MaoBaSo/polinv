<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerIndiceImagenes extends Model
{
    use SoftDeletes;
    
    Protected $table = 'serv_indice_imagenes';
    protected $dates = ['deleted_at'];
}

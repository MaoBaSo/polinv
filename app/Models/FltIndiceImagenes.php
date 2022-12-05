<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FltIndiceImagenes extends Model
{
    use SoftDeletes;
    
    Protected $table = 'flt_indice_imagenes_flotas';
    protected $dates = ['deleted_at'];
}

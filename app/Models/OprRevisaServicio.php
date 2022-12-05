<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OprRevisaServicio extends Model
{
    use SoftDeletes;
    
    Protected $table = 'ope_calidad';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'serv_servicios_id ', 
        'item_id ',
        'cant_img',
        'creado_por',
        'nota',
        'estado_revision'
    ];

}


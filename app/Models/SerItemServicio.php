<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerItemServicio extends Model
{
    use SoftDeletes;
    
    Protected $table = 'serv_servicios_items';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'serv_servicios_id',
        'inv_servicios_id',
        'valor', 
        'descuento',
        'accion', 
        'cant_img',
        'nota_item',
        'ok_revisado'
    ];

    public function invServicio()
    {
        return $this->belongsTo('App\Models\InvServicio', 'inv_servicios_id');
    } 

}

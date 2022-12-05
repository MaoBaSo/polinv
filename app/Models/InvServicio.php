<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvServicio extends Model
{
    use SoftDeletes;
    
    Protected $table = 'inv_servicios';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'nombre', 
        'sku', 
        'codigo_servicio', 
        'tipo_vehiculo',
        'valor_reparar_pintar',
        'valor_cambiar_pintar',
        'valor_cambiar_reparar',
        'valor_fabricar',
        'valor_base_hora',
        'tiempo_estandar',
        'caracteristicas',
        'pais_id'
    ];
    
    public function itemServicio()
    {
        return $this->hasMany('App\Models\SerItemServicio');
    } 


}

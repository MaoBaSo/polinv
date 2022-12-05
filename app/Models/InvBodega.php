<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvBodega extends Model
{
    use SoftDeletes;

    Protected $table = 'inv_bodegas';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre', 
        'direccion',
        'referencia_direccion',
        'notas',
        'creado_por',
        'pais_id ',
        'ciudad_id '
    ];

    public function pais()
    {
        return $this->belongsTo('App\Models\Parametro', 'pais_id');
    } 

    public function ciudad()
    {
        return $this->belongsTo('App\Models\Parametro', 'ciudad_id');
    } 

}

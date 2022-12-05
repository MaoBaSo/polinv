<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvSubLinea extends Model
{
    use SoftDeletes;
    
    Protected $table = 'inv_sub_linea';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'linea_id', 
        'nombre',
        'caracteristicas'
    ];

    public function linea()
    {
        return $this->belongsTo('App\Models\InvLinea', 'linea_id');
    } 


}

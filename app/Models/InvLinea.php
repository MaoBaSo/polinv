<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvLinea extends Model
{
    use SoftDeletes;
    
    Protected $table = 'inv_linea';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'nombre', 
        'caracteristicas',
        'pais_id'
    ];


    public function sublinea()
    {
        return $this->hasMany('App\Models\InvSubLinea');
    } 

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parametro extends Model
{
    use SoftDeletes;
    Protected $table = 'conf_parametros';

    protected $dates = ['deleted_at'];


    public function bodega()
    {
        return $this->hasMany('app\Models\InvBodega');
    } 


}

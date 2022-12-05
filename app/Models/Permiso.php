<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use SoftDeletes;
    
    Protected $table = 'seg_permisos';
    protected $dates = ['deleted_at'];

    public function caso_uso()
    {
        return $this->belongsTo('App\Models\Caso_uso', 'caso_id');
    } 

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol', 'rol_id');
    }

}

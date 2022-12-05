<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caso_uso extends Model
{
    use SoftDeletes;
    
    Protected $table = 'seg_caso_uso';
    protected $dates = ['deleted_at'];

    public function permiso()
    {
        return $this->hasMany('App\Models\Permiso');
    } 

}

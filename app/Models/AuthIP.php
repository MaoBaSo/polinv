<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthIP extends Model
{

    use SoftDeletes;

    Protected $table = 'seg_white_list';
    protected $dates = ['deleted_at'];


    public function cliente()
    {
        return $this->belongsTo('App\Models\CliCliente', 'cliente_id');
    } 

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CliCliente extends Model
{
    use SoftDeletes;
    
    Protected $table = 'cli_clientes';
    protected $dates = ['deleted_at'];

    public function AutIp()
    {
        return $this->hasMany('App\Models\AuthIP');
    } 

    public function SerServicio()
    {
        return $this->hasMany('App\Models\SerServicio');
    } 


}

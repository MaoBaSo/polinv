<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CliPatios extends Model
{
    use SoftDeletes;
    
    Protected $table = 'cli_patios';
    protected $dates = ['deleted_at'];

    public function servicios()
    {
        return $this->hasMany('App\Models\SerServicio');
    } 

    public static function listPatios($id){
        return CliPatios::where('cliente_id', $id)->get();
    }

}

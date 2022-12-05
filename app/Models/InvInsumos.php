<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvInsumos extends Model
{
    use SoftDeletes;
    
    Protected $table = 'inv_insumos';
    protected $dates = ['deleted_at'];
}

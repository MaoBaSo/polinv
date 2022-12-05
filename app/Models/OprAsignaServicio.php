<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OprAsignaServicio extends Model
{
    use SoftDeletes;

    Protected $table = 'ope_item_servicio_empledo';
    protected $dates = ['deleted_at'];
}

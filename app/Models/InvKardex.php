<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvKardex extends Model
{
    use SoftDeletes;
    
    Protected $table = 'inv_kardex';
    protected $dates = ['deleted_at'];
}

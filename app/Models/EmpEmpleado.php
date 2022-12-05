<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpEmpleado extends Model
{
    use SoftDeletes;
    
    Protected $table = 'emp_empleados';
    protected $dates = ['deleted_at'];
}

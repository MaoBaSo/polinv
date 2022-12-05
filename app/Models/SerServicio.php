<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerServicio extends Model
{
    use SoftDeletes;
    
    Protected $table = 'serv_servicios';
    protected $dates = ['deleted_at'];
    

    protected $fillable = [
        'patio_id', 
        'cliente_id',
        'pais_id',
        'placa',
        'movil',
        'nota_servicio',
        'tipo',
        'estado',
        'valor_bruto_procedimiento',
        'numero_orden_trabajo',
        'numero_orden_compra',
        'creado_por'
    ];

    public function patio()
    {
        return $this->belongsTo('App\Models\CliPatios', 'patio_id');
    } 

    public function cliente()
    {
        return $this->belongsTo('App\Models\CliCliente', 'cliente_id');
    } 


}

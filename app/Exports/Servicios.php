<?php
/**
 * Informe de Servicios CON ÍTEMS por rango de fecha. 
 * Author: Mauricio Baquero Soto
 * Abril de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */
namespace App\Exports;

use App\Models\V_Servicios;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class Servicios implements FromQuery , WithHeadings , WithMapping
{

    use Exportable;

    public function __construct(string $fechaInicio, string $fechaFin)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function query()
    {
        //Se agrega un dia mas al margen de la consulta
        $date = Carbon::parse($this->fechaFin);
        $lfecha = $date->addDay();
        
        return V_Servicios::query()
        ->where('fecha_creacion','>=',$this->fechaInicio)
        ->where('fecha_creacion','<=',$lfecha->toDateString());

    }

    public function headings(): array
    {
        return [
            'FECHA',
            'VALORIZACION',
            'ORDEN TRABAJO',
            'ORDEN COMPRA',
            //'PLACA', OT: 260522-012
            'MOVIL',
            'PROCEDIMIENTO',
            'ACCION',
            'ESTADO',
            'VALOR BRUTO ITEM',
            'DESCUENTO',
            'VALOR CON DESCUENTO',
            'IVA',
            'VALOR NETO ITEM',
        ];
    }

    public function map($row): array
    {
        $fecha = Carbon::parse($row->fecha_creacion)->format('d/m/Y H:i:s');

        return [
            $row->fecha_creacion,
            $row->numero_valorizacion,
            $row->numero_orden_trabajo,
            $row->numero_orden_compra,
            //$row->placa, OT: 260522-012
            $row->movil,
            $row->procedimiento,
            $row->accion,
            $row->estado,
            $row->valor_bruto_item,
            $row->descuento,
            $row->valor_con_descuento,
            $row->IVA,
            $row->valor_neto_item
        ];
    }



}

<?php

namespace App\Exports;

use App\Models\V_Pago_Empleados;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PagoComision implements FromCollection , WithHeadings , WithMapping
{
    use Exportable;

    public function collection()
    {
        return V_Pago_Empleados::all();
    }


    public function headings(): array
    {
        return [
            'TOKEN',
            'IDENTIFICACIÓN',
            'NOMBRE',
            'ORDEN TRABAJO',
            'MOVIL',
            'PLACA',
            'TIPO VEHÍCULO',
            'PROCEDIMIENTO',
            'ACCION',
            'COMISION BASE',
            'PORCENTAJE',
            'A PAGAR',
        ];
    }

    public function map($row): array
    {
       
        return [
            $row->token,
            $row->identificacion,
            $row->nombre,
            $row->numero_orden_trabajo,
            $row->movil,
            $row->placa,
            $row->tipo_vehiculo,
            $row->procedimiento,
            $row->accion,
            $row->valor_comision,
            $row->porcentaje,
            $row->valor_pagar
        ];
    }



}

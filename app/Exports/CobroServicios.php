<?php

namespace App\Exports;

use App\Models\V_Cobros_Servicios;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CobroServicios implements FromCollection , WithHeadings , WithMapping
{
    use Exportable;

    public function collection()
    {
        return V_Cobros_Servicios::all();
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'PLACA',
            'MOVIL',
            'VALORIZACION',
            'ORDEN TRABAJO',
            'ORDEN COMPRA',
            'VALOR BRUTO',
            'DESCUENTO',
            'VALOR BRUTO CON DESCUENTO',
            'IVA',
            'VALOR NETO A COBRAR',
            'NOTA',
        ];
    }

    public function map($row): array
    {
       
        return [
            $row->fecha_creacion,
            $row->placa,
            $row->movil,
            $row->numero_valorizacion,
            $row->numero_orden_trabajo,
            $row->numero_orden_compra,
            $row->valor_bruto_procedimiento,
            $row->descuento,
            $row->bruto_descuento,
            $row->IVA,
            $row->valor_neto,
            $row->nota_servicio,

        ];
    }
}

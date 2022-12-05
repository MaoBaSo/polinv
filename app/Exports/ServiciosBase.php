<?php
/**
 * Informe de Servicios SIN ÍTEMS por rango de fecha. 
 * Author: Mauricio Baquero Soto
 * Abril de 2.022
 * =====================================
 * Editado por / Fecha ediciòn
 * 
 */
namespace App\Exports;

use App\Models\V_Servicios_Base;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ServiciosBase implements FromQuery , WithHeadings , WithMapping
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
        
        return V_Servicios_Base::query()
        ->where('fecha_creacion','>=',$this->fechaInicio)
        ->where('fecha_creacion','<=',$lfecha->toDateString());

    }

    public function headings(): array
    {
        return [
            'FECHA',
            //'PLACA', OT: 260522-012
            'MOVIL',
            'TIPO',
            'No VALORACIÓN',
            'No ORDEN TRABAJO',
            'No ORDEN COMPRA',
            'ESTADO',
            'VALOR BRUTO',
            'DESCUENTO',
            'BRUTO CON DESCUENTO',
            'IVA',
            'VALOR NETO',
            'NOTA',
        ];
    }

    public function map($row): array
    {
        $fecha = Carbon::parse($row->fecha_creacion)->format('d/m/Y H:i:s');

        return [
            $row->fecha_creacion,
            //$row->placa, OT: 260522-012
            $row->movil,
            $row->tipo,
            $row->numero_valorizacion,
            $row->numero_orden_trabajo,
            $row->numero_orden_compra,
            $row->estado,
            $row->valor_bruto_procedimiento,
            $row->descuento,
            $row->bruto_descuento,
            $row->IVA,
            $row->valor_neto,
            $row->nota_servicio
        ];
    }
}

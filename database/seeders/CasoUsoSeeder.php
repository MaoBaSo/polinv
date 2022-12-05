<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caso_uso;
use Illuminate\Support\Facades\DB;

class CasoUsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //DB::statement('SET FOREIGN_KEY_CHECKS=0');
        //Caso_uso::truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //Crea caso de uso
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Accesos'; //Nombre del caso de uso 1
            $Caso->slug = 'gestion-accesos'; //Slug del caso de uso
            $Caso->nota = 'Acceso inicial de sistema'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Parametros'; //Nombre del caso de uso 2
            $Caso->slug = 'gestion-parametros'; //Slug del caso de uso
            $Caso->nota = 'Gestiona tabla parametros'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Compañías'; //Nombre del caso de uso 3
            $Caso->slug = 'gestion-companias'; //Slug del caso de uso
            $Caso->nota = 'Gestiona tabla Compañías'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Logs'; //Nombre del caso de uso 4
            $Caso->slug = 'gestion-logs'; //Slug del caso de uso
            $Caso->nota = 'Gestiona tabla Logs'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Líneas y Sublineas'; //Nombre del caso de uso 5
            $Caso->slug = 'gestion-lineas-sublineas'; //Slug del caso de uso
            $Caso->nota = 'Gestiona Maestro de lineas y sublineas en inventario'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Bodegas'; //Nombre del caso de uso 6
            $Caso->slug = 'gestion-bodegas'; //Slug del caso de uso
            $Caso->nota = 'Gestiona maestro de Bodegas'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Tipo Servicios'; //Nombre del caso de uso 7
            $Caso->slug = 'gestion-tipo-servicios'; //Slug del caso de uso
            $Caso->nota = 'Gestiona maestro de servicios'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Productos'; //Nombre del caso de uso 8
            $Caso->slug = 'gestion-productos'; //Slug del caso de uso
            $Caso->nota = 'Gestiona maestro de productos'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Ingresa Producto'; //Nombre del caso de uso 9
            $Caso->slug = 'ingresa-producto'; //Slug del caso de uso
            $Caso->nota = 'Gestiona movimientos de ingreso en el inventario'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Transfiere Producto'; //Nombre del caso de uso 10
            $Caso->slug = 'transfiere-producto'; //Slug del caso de uso
            $Caso->nota = 'Gestiona movimientos de transferencia en el inventario'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Ajusta Producto'; //Nombre del caso de uso 11
            $Caso->slug = 'ajusta-producto'; //Slug del caso de uso
            $Caso->nota = 'Gestiona movimientos de ajuste de productos en el inventario'; //Nota
        $Caso->save();        
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Clientes'; //Nombre del caso de uso 12
            $Caso->slug = 'gestion-clientes'; //Slug del caso de uso
            $Caso->nota = 'Gestiona tabla clientes'; //Nota
        $Caso->save();         
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Lista Blanca'; //Nombre del caso de uso 13
            $Caso->slug = 'lista-blanca'; //Slug del caso de uso
            $Caso->nota = 'Gestiona de lista blanca de IP'; //Nota
        $Caso->save();  
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Servicios'; //Nombre del caso de uso 14
            $Caso->slug = 'gestion-servicios'; //Slug del caso de uso
            $Caso->nota = 'Gestión proceso de patio'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Revisa Calidad Proceso'; //Nombre del caso de uso 15
            $Caso->slug = 'revisa-calidad-proceso'; //Slug del caso de uso
            $Caso->nota = 'Revisión final de calidad del trabajo'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Reporte Cotización'; //Nombre del caso de uso 16
            $Caso->slug = 'reporte-cotizacion'; //Slug del caso de uso
            $Caso->nota = 'Genera archivo PDF de la cotización del servicio'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Reporte Calidad'; //Nombre del caso de uso 17
            $Caso->slug = 'reporte-calidad'; //Slug del caso de uso
            $Caso->nota = 'Genera archivo PDF del proceso Entrega de vehículo Calidad'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Reporte Servicios'; //Nombre del caso de uso 18
            $Caso->slug = 'reporte-servicios'; //Slug del caso de uso
            $Caso->nota = 'Genera archivo XLSX de los servicios en un rango de tiempo'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Crear Descuento'; //Nombre del caso de uso 19
            $Caso->slug = 'crear-descuento'; //Slug del caso de uso
            $Caso->nota = 'Crea descuento sobre valor de ítem'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'PDF. Orden Trabajo'; //Nombre del caso de uso 20
            $Caso->slug = 'pdf-orden-trabajo'; //Slug del caso de uso
            $Caso->nota = 'Genera PDF de Orden de Trabajo'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'DashBoard Cliente'; //Nombre del caso de uso 21
            $Caso->slug = 'dashboard-cliente'; //Slug del caso de uso
            $Caso->nota = 'Acceso al dashboard de Cliente'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'PDF. Recepcion'; //Nombre del caso de uso 22
            $Caso->slug = 'pdf-recepcion'; //Slug del caso de uso
            $Caso->nota = 'Genera PDF de recepción de trabajo'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Gestión Empleados'; //Nombre del caso de uso 23
            $Caso->slug = 'gestion-empleados'; //Slug del caso de uso
            $Caso->nota = 'CRUD Empleados'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Asignar servicios a técnicos'; //Nombre del caso de uso 24
            $Caso->slug = 'asignar-servicio-tecnico'; //Slug del caso de uso
            $Caso->nota = 'Asigna servicio a Técnicos'; //Nota
        $Caso->save();        
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Dashboard Técnicos'; //Nombre del caso de uso 25
            $Caso->slug = 'dasboard-tecnicos'; //Slug del caso de uso
            $Caso->nota = 'Cambia estado operativo de servicios'; //Nota
        $Caso->save();
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Kardex Producto'; //Nombre del caso de uso 26
            $Caso->slug = 'kardex-producto'; //Slug del caso de uso
            $Caso->nota = 'Genera Informe Kardex Producto'; //Nota
        $Caso->save();        
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Inventario'; //Nombre del caso de uso 27
            $Caso->slug = 'inventario'; //Slug del caso de uso
            $Caso->nota = 'Genera Informe Inventario'; //Nota
        $Caso->save();  
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Genera y cierra comisiones'; //Nombre del caso de uso 28
            $Caso->slug = 'genera-cierra-comisiones'; //Slug del caso de uso
            $Caso->nota = 'Genera Informe y Cierra Comisiones'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Finaliza Servicios'; //Nombre del caso de uso 29
            $Caso->slug = 'finaliza-servicios'; //Slug del caso de uso
            $Caso->nota = 'Finaliza los servicios poniendo documento de cierre'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Buscar Servicio'; //Nombre del caso de uso 30
            $Caso->slug = 'buscar-servicio'; //Slug del caso de uso
            $Caso->nota = 'Genera VTA de búsqueda de servicio'; //Nota
        $Caso->save(); 
        $Caso = new Caso_uso;
            $Caso->caso_uso = 'Generar Token'; //Nombre del caso de uso 31
            $Caso->slug = 'genera-token'; //Slug del caso de uso
            $Caso->nota = 'Genera TOKEN a un usuario'; //Nota
        $Caso->save();

    }
}

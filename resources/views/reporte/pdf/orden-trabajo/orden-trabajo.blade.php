<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotización</title>

	<!-- Custom CSS -->	
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {font-family: 'Roboto', sans-serif;} 
        table {
            font-size: 12px;
            width: 100%;
            border: .2px solid rgb(121, 112, 112);
            border-collapse: collapse;
            padding: 2px;
        }
        table tr, td, th {
            border: .2px solid rgb(121, 112, 112);
            padding: 5px;
            /* Alto de las celdas */
            height: 10px;

        }
        #t-firma{font-size: 12px;}
        #t-img{font-size: 10px;}
        #t-img img{width: 300px; height: 199px;}

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            color: rgb(12, 11, 11);
            text-align: center;
            font-size: 12px;
            line-height: 35px;
        }
    </style>

</head>
<body>
     <!--ENCABEZADO-->
     <table>
        <tbody>
            <tr>
                <td style="width: 20%; border: .2px solid rgb(254, 250, 250)!important"><img src="{{ asset('img/bus-logo-360x266.png') }}" class="card-img img-responsive w-60"  alt="..."></td>
                <td class="text-center"  style="width: 60%; border: .2px solid rgb(254, 250, 250)!important">
                    <h2>Orden de Trabajo</h2>
                    <h4>Servicio de latonería y pintura</h4>
                </td>
                <td style="width: 20%; border: .2px solid rgb(254, 250, 250)!important">
                    <h5>JPEX-003</h5>
                    <span class="text-muted">Versión. 1</span>
                </td>
            </tr>
        </tbody>
    </table>
    <!--DATOS DE CLIENTE Y NUMERO DE VALORIZACION-->
    <!--Primera Linea-->
    <table>
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Patio</th>
            <th>Placa</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>{{ $servicio->cliente->nombre }}</th>
            <td>{{ $servicio->patio->nombre }}</td>
            <td>{{ $servicio->placa }}</td>
            <td>{{ $servicio->created_at->format('d-m-Y'); }}</td>
          </tr>
        </tbody>
      </table>
    <!--Segunda Linea-->
    <table>
        <thead>
            <tr>
                <th>Movil</th>
                <th>Tipo Vehículo</th>
                <th>Orden Trabajo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{ $servicio->movil }}</th>
                <td>{{ $tipo_vehiculo->tipo_vehiculo }}</td>
                <td style="background-color: aliceblue" class="text-center">{{ $servicio->numero_orden_trabajo }}</td>
            </tr>
        </tbody>
    </table>
    <!--ITEMS Y VALORIZACION-->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Procedimiento</th>
                <th>Bruto</th>
                <th>Desc.</th>
                <th>Neto</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $cont_id = 10;
            ?>
            @foreach ($items_servicio as $item)  
                <tr>
                    <td>{{ $cont_id }}</td>
                    <td>{{ $item->invServicio->sku . ' (' . $item->accion . ') (' .$item->invServicio->nombre . ')' }}</td>
                    <td>{{ number_format($item->valor)}}</td>
                    <td>{{ number_format($item->descuento)}}</td>
                    <td>{{ number_format($item->valor - $item->descuento)}}</td>
                </tr>
                <?php 
                    $cont_id += 10;
                ?>
            @endforeach            

            <tr>
                <td style="text-align: right; height: 10px !important;" colspan="2">Sub-Totales</td>
                <td><b>{{ number_format($servicio->valor_bruto_procedimiento) }}</b></td>
                <td><b>{{ number_format(Miscellany::getDescServicio($servicio->id)) }}</b></td>
                <td><b>{{ number_format(Miscellany::getValServicio($servicio->id)) }}</b></td>
            </tr>

            <tr>
                <td style="text-align: right;" colspan="4">Valor IVA</td>
                <td>{{ number_format($val_iva) }}</td>
            </tr>

            <tr>
                <td style="text-align: right;" colspan="4">Valor NETO</td>
                <td>{{ number_format(Miscellany::getValServicio($servicio->id) + $val_iva) }}</td>
            </tr>
        </tbody>
    </table>
    <!--FIRMA-->
    <table>
        <thead>
            <tr>
                <th>Aprobado por:</th>
                <th>Creado por:</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 50%">{{ $autorizado_por->name }} <br> {{ $autorizado_por->email }}</td>
                <td style="width: 50%">{{ $creado_por->name }} <br> {{ $creado_por->email }}</td>
            </tr>            
            <tr>
                <td colspan="2" style="background-color: aliceblue; word-break: break-all;">TOKEN: <br>
                    {{ substr($firma->firma, 0, 96)  }} <br>
                    {{ substr($firma->firma, 96, 150)  }}
                
                </td>
            </tr>
        </tbody>
    </table>
    <!--GESTION DE IMAGENES-->                
    <table id="t-img">
        <thead></thead>
        <tbody>
            @foreach ($items_servicio as $item)
                <tr>
                    <td>
                        @if($item->cant_img > 0)
                            <?php 
                                $cont = 1;
                            ?>
                                <p>{{ $item->invServicio->sku }}</p>
                                <br>
                                @foreach(range(1,$item->cant_img) as $current)
                                        <img src="{{ asset('imgservices/'. $servicio->cliente_id .'/'. $item->id .'-'. $cont .'.jpeg') }}" alt="">
                                    <?php 
                                        $cont++;
                                    ?>
                                @endforeach  
                                
                        @endif    
                    </td> 
                </tr>                     
            @endforeach 
        </tbody>
    </table>
    <!--FOOTER-->
    <footer>
        <p>Generado {{ $impresion }} | By: APPEX</p>
    </footer>

</body>
</html>
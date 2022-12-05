<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calidad</title>

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
    <table style="border:none !important;">
        <tbody>
            <tr style="border:none !important;">
                <td style="width: 20%; border:none !important;"><img src="{{ asset('img/bus-logo-360x266.png') }}" class="card-img img-responsive w-60"  alt="..."></td>
                <td class="text-center"  style="width: 60%; border:none !important;">
                    <h2>Revisión Calidad</h2>
                    <h4>Servicio de latonería y pintura</h4>
                </td>
                <td style="width: 20%; border:none !important;">
                    <h5>JPEX-002</h5>
                    <span class="text-muted">Versión. 3</span>
                </td>
            </tr>
        </tbody>
    </table>
    <!--DATOS DE CLIENTE Y NUMERO DE OT-->
    <!--Primera Linea-->
    <table>
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Patio</th>
            <th>Placa</th>
            <th>Orden trabajo</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>{{ $servicio->cliente->nombre }}</th>
            <td>{{ $servicio->patio->nombre }}</td>
            <td>{{ $servicio->placa }}</td>
            <td>No. {{ $servicio->numero_orden_trabajo }}</td>
            <td>{{ $servicio->fecha_servicio }}</td>
          </tr>
        </tbody>
      </table>



    <!--Segunda Linea-->
    <table>
        <thead>
            <tr>
                <th>Movil</th>
                <th>Tipo Vehículo</th>
                <th>Doc. Recepción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{ $servicio->movil }}</th>
                <td>{{ $tipo_vehiculo->tipo_vehiculo }}</td>

                @if(!is_null($autorizado_por))
                <td style="background-color: aliceblue">TOKEN</td>
                @else
                    <td style="background-color: aliceblue"></td>
                @endif

            </tr>
        </tbody>
    </table>
    <!--Tercera Linea-->
    <table>
        <thead></thead>
        <tbody>
            <tr>
                <th>Inicio de proceso: {{ $tiempo_inicio->tiempo_inicio }}</th>
                <td>Fin de proceso: {{ $tiempo_fin->tiempo_fin }}</td>
            </tr>
        </tbody>
    </table>

    <!--ITEMS-->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Procedimiento</th>
                <th>OK JPEX</th>
                <th>OK Cliente</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $cont_id = 10;
            ?>
            @foreach ($items_servicio as $item)
                <tr>
                    <td>{{ $cont_id }}</td>
                    <td>{{ $item->sku . ' (' . $item->accion . ') (' .$item->nombre . ')' }}</td>
                    <td>OK</td>

                    @if(!is_null($autorizado_por))
                    <td style="background-color: aliceblue">OK</td>
                    @else
                        <td style="background-color: aliceblue"></td>
                    @endif
   
                </tr>
            <?php 
              $cont_id += 10;
            ?>                
            @endforeach            

        </tbody>
    </table>
    <!--FIRMA-->
    <table>
        <thead>
            <tr>
                <th>Recibido por:</th>
                <th>Firma</th>
                <th>Entregado por:</th>
            </tr>
        </thead>
        <tbody>
            <tr>

                @if(!is_null($autorizado_por))
                    <td style="width: 50%">{{ $autorizado_por->name }} <br> {{ $autorizado_por->email }}</td>
                    <td style="width: 20%">ELECTRÓNICA</td>
                    <td style="width: 30%">{{ $creado_por->name }} <br> {{ $creado_por->email }}</td>   
                @else
                    <td style="width: 50%"></td>
                    <td style="width: 20%"></td>
                    <td style="width: 30%">{{ Auth::user()->name }} <br> {{ Auth::user()->email }}</td> 
                @endif

                @if(!is_null($autorizado_por))
                    <tr>
                        <td colspan="3" style="background-color: aliceblue">TOKEN: <br> 
                            {{ substr($firma->firma, 0, 96)  }} <br>
                            {{ substr($firma->firma, 96, 192)  }}
                        </td>
                    </tr>                        
                @endif 

            </tr>            
        </tbody>
    </table>
    
    <!--GESTION DE IMAGENES-->                
    <table id="t-img">
        <thead></thead>
        <tbody>

            @foreach ($items_servicio as $item)

                <!--Actualizacion OT: 090722-003 -->
                @if($item->cant_img == 0)

                    <?php 
                        $cont = 1;
                        $newImages = getListImgQA($item->id);
                        $cant_img = $newImages->count();
                    ?>

                    <!--Si contador es igual a 0, nueva rutina de imagenes-->
                    @foreach($newImages as $imagen)
                        <?php
                            if($cont == 3){
                                $cont = 1;
                            } 
                        ?>
                            
                        @if($cont == 1)
                            <tr>
                                <td>
                                    <p>{{  $item->sku}}</p>                  
                                    <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />  
                                </td>
                        @else
                                <td>
                                    <p>{{  $item->sku}}</p>                  
                                    <img class="img-responsive" src="{{ asset($imagen->url . $imagen->nombre_archivo) }}"  alt="Image description" />  
                                </td> 
                            </tr>                           
                        @endif

                        <?php 
                            $cont++;
                        ?>

                        @if($cant_img == 1)
                            </tr> 
                        @endif

                    @endforeach  

                @else

                    <tr>
                        <td>

                            <?php 
                                $cont = 1;
                            ?>
                            <p>{{ $item->sku }}</p>
                            <br>
                            @foreach(range(1,$item->cant_img) as $current)
                                <img class="img-responsive" src="{{ asset('imgservices/'. $servicio->cliente_id .'/calidad/'. $item->id .'-'. $cont .'.jpeg') }}" alt="">
                                <?php 
                                    $cont++;
                                ?>
                            @endforeach  
                                        
                        </td> 
                    </tr>                     

                @endif
                <!--/Actualizacion OT: 090722-003 -->  

            @endforeach 

        </tbody>
    </table>

    <footer>
        <p>Generado {{ $impresion }} | By: APPEX</p>
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>

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
            padding: 0px;
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
                    <h2>Kardex</h2>
                    <h4>Movimientos producto</h4>
                </td>
                <td style="width: 20%; border: .2px solid rgb(254, 250, 250)!important">
                    <h5>JPEX-007</h5>
                    <span class="text-muted">Versión. 1</span>
                </td>
            </tr>
        </tbody>
    </table>
    <!--DATOS DE INVENTARIO-->
        <!--Marca producto-->
        <table>
            <thead>
            <tr>  
                <th style="width: 40%;">Nombre</th> 
                <th style="width: 20%;">SKU</th>
                <th style="width: 20%;">Numero Parte</th>
                <th style="width: 20%;">OEM</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->sku }}</td>
                    <td>{{ $producto->numero_parte }}</td>
                    <td>{{ $producto->oem }}</td>
                </tr>
            </tbody>
        </table>
        <br>
    @foreach ($kardex as $item) 
        <!--Fila 1-->
        <table>
            <thead>
            <tr>  
                <th style="width: 25%; background-color: aliceblue;">Fecha</th> 
                <th style="width: 25%; background-color: aliceblue;">Movimiento</th>
                <th style="width: 25%; background-color: aliceblue;">Cantidad</th>
                <th style="width: 25%; background-color: aliceblue;">Documento</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->tipo_movimiento }}</td>
                    <td>{{ $item->cantidad_movimiento }}</td>
                    <td>{{ $item->documento_referencia }}</td>
                </tr>
            </tbody>
        </table>
        <!--Fila 2-->
        <table>
            <thead>
            <tr>  
                <th style="width: 40%;">Bodega Origen</th> 
                <th style="width: 40%;">Bodega Destino</th>
                <th style="width: 20%;">Costo neto</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ getNameBodega($item->bodega_procedencia) }}</td>
                    <td>{{ getNameBodega($item->bodega_destino) }}</td>
                    <td>{{ $item->costo_neto }}</td>
                </tr>
            </tbody>
        </table>
        <!--Fila 3-->
        <table>
            <thead>
            <tr>  
                <th style="width: 50%;">Vence Garantía</th> 
                <th style="width: 50%;">Autor Movimiento</th>

            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->vencimiento_garantia }}</td>
                    <td>{{ getUserName($item->creado_por) }}</td>
                </tr>
            </tbody>
        </table>
        <!--Fila 4-->
        <table>
            <thead>
            <tr>  
                <th>Nota</th> 
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->nota }}</td>
                </tr>
            </tbody>
        </table>
        <br>
    @endforeach 

    <!--FOOTER-->
    <footer>
        <p>Generado {{ $impresion }} | By: APPEX</p>
    </footer>

</body>
</html>
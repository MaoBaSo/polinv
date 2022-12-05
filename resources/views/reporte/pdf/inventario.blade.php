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
                    <h2>Inventario</h2>
                    <h4>Soporte conteo físico</h4>
                </td>
                <td style="width: 20%; border: .2px solid rgb(254, 250, 250)!important">
                    <h5>JPEX-006</h5>
                    <span class="text-muted">Versión. 1</span>
                </td>
            </tr>
        </tbody>
    </table>
    <!--DATOS DE INVENTARIO-->
    <table>
        <thead>
          <tr>  
            <th style="width: 25%;">Bodega</th> 
            <th style="width: 43%;">Producto</th>
            <th style="width: 8%;">Mínimo</th>
            <th style="width: 8%;">Máximo</th>
            <th style="width: 8%;">Exist.</th>
            <th style="width: 8%;">Conteo</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($inventario as $item) 
                <tr>
                    <td>{{ $item->nombre_bodega }}</td>
                    <td>{{ $item->nombre_producto }}</td>
                    <td>{{ $item->factor_minimo }}</td>
                    <td>{{ $item->factor_maximo }}</td>
                    <td>{{ $item->cantidad_actual }}</td>
                    <td style="background-color: aliceblue"></td>
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
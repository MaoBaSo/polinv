
@extends('layouts.correo')

@section('saludo')
    Cordial saludo, Sr(a) {{ $usuario->name }}.
@stop

@section('contenido')

<p>El presente correo tiene como finalidad informarle que el sistema genero un TOKEN a su nombre para realizar firmas online.</p>


<table align="center" cellpadding="0" cellspacing="0" width="50%" style="border-collapse: collapse;">
    <tr>
        <td align="center" style="padding:20px 0 15px 0;background:beige;">
            <h4>{{ $TOKEN_public }}</h4>
        </td>
    </tr>
</table>    


<p>Le recomendamos salvaguardar esta clave, no la comparta, en caso de que usted crea que su carácter de SECRETO se ha visto comprometido, por favor solicite una nueva al administrador del sistema.</p>

@stop

@section('nota')
   Si tiene alguna duda, por favor busque alguno de nuestros Jefes de Patio.
@stop
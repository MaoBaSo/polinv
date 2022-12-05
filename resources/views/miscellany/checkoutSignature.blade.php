{{-- **************************************** --}}
{{-- ***CHECKOUT DE FIRMA --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Abril de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {font-family: 'Roboto', sans-serif;} 
        table {
            background-color: white;
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

    </style>

@endsection


@section('menu')

    @include('layouts._menuCliente')

@endsection


@section('contenido')

    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-success card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-light">PROCESO FIRMADO CORRECTAMENTE</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div  class="panel-wrapper collapse in">
                    <div  class="panel-body">

                        <p>Usted acaba de firmar el siguiente documento:</p>
                        <br>
                        <table>
                            <thead>
                            <tr>
                                <th>Tipo Documento</th>
                                <th>Numero</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>{{ $proceso }}</th>
                                <td>{{ $numero_documento }}</td>
                                <td>{{ $time }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="text-center mt-20 mb-20">
                            <span>Llave firma</span>
                            <h5>{{ $llave }}</h5>
                        </div>
                        
                        <div  class="text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-rounded btn-icon left-icon btn-sm"><i class="fa fa-hand-o-left"></i> <span>Volver</span></a>
                            <button onclick="printHTML()" class="btn btn-primary btn-rounded btn-icon left-icon btn-sm"><i class="fa  fa-print"></i> <span>Imprimir</span></button>
                            <script>
                                function printHTML() {
                                  if (window.print) {
                                    window.print();
                                  }
                                }
                            </script>
                        </div>
                
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- /Row -->

@endsection

@section('scripts')


@endsection
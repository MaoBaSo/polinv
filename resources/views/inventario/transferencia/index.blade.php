{{-- **************************************** --}}
{{-- ***Panel de ADMINISTRACION --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Enero de 2.022 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')
@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

    <div class="row">
        <h1>Transferencias entre bodegas</h1>
        <h3>Rutina encargada de transferir productos entre bodegas</h3>

        <ol style="margin-left: 2rem; margin-top: 2rem">
            <li>CRUD transferencia.</li>
        </ol>
   
    </div>

@endsection

@section('scripts')
@endsection
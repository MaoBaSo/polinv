{{-- **************************************** --}}
{{-- ***Panel de SUPER USUARIO --}}
{{-- ***Author: Mauricio Baquero Soto --}}
{{-- ***Septiembre de 2.021 --}}
{{-- **************************************** --}}

@extends('layouts.template')

@section('estilos')

    <style>
        .page-wrapper {
        margin-left: 250px;
        padding: 85px 20px;
        position: relative;
        background-image: url({{ asset('img/fondo.png') }});
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        background-size: cover;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        transition: all 0.4s ease;
        left: 0; }

        @media (max-width: 1400px) {
            .page-wrapper {
            margin-left: 0px; }
            }

    </style>

@endsection


@section('menu')

    @include('layouts._menuAdministrador')

@endsection


@section('contenido')

@endsection

@section('scripts')

@endsection
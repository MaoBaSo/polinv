
<!--Retorno vista Cliente-->
<li>
    <a href="{{ route('gestion-operativa.index') }}"><div class="pull-left"><i class="ti-dashboard mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="clearfix"></div></a>

</li>
<!--Menu 1-->
<li>
    <a href="javascript:void(0);" data-toggle="collapse" data-target="#menu_1"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Impresión</span></div><div class="pull-right"><i class="ti-angle-down"></i></div><div class="clearfix"></div></a>
    <ul id="menu_1" class="collapse collapse-level-1">
        <li>
            <a href="{{ route('documentos-ordentrabajo.filters') }}">PDF. Imprimir Orden Trabajo</a>
        </li>
        <li>
            <a href="{{ route('documentos-recepcion.filters') }}">PDF. Imprimir Entrega</a>
        </li>
    </ul>
</li>
<!--Menu 2-->
<li>
    <a href="javascript:void(0);" data-toggle="collapse" data-target="#menu_2"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Reportes</span></div><div class="pull-right"><i class="ti-angle-down"></i></div><div class="clearfix"></div></a>
    <ul id="menu_2" class="collapse collapse-level-1">        
        <li>
            <a href="{{ route('buscar-servicios.filters') }}">VTA. Buscar Servicio </a>
        </li>        
        
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#chart_dr"><div class="pull-left"><span class="right-nav-text">SER/OPT. Informes </span></div><div class="pull-right"><i class="ti-angle-down "></i></div><div class="clearfix"></div></a>
                
            <ul id="chart_dr" class="collapse collapse-level-2 dr-change-pos">
                <li>
                    <a href="{{ route('reportes-servicios-base.filters') }}">INF. Servicios Base</a>
                </li>
                <li>
                    <a href="{{ route('reportes-servicios.filters') }}">INF. Servicios / Ítems</a>
                </li>
            </ul>
            
        </li>

    </ul>
</li>
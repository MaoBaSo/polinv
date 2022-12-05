<!--Retorno vista principal-->
<li>
    <a href="{{ route('dashboard') }}"><div class="pull-left"><i class="ti-dashboard mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="clearfix"></div></a>
</li>
<!--Menu sistema-->
<li>
    <a href="javascript:void(0);" data-toggle="collapse" data-target="#sistema_dr"><div class="pull-left"><i class="zmdi zmdi-settings mr-20"></i><span class="right-nav-text">Sistema</span></div><div class="pull-right"><i class="ti-angle-down"></i></div><div class="clearfix"></div></a>
    <ul id="sistema_dr" class="collapse collapse-level-1">
        <li>
            <a href="{{ route('gestion-roles.index') }}">SEG. Gestión Roles</a>
        </li>
        <li>
            <a href="{{ route('gestion-permisos.index') }}">SEG. Gestión Permisos</a>
        </li>
        <li>
            <a href="{{ route('gestion-usuarios.index') }}">SEG. Gestión Usuarios</a>
        </li>
        <li>
            <a href="{{ route('gestion-logs.index') }}">SEG. Gestión Logs</a>
        </li>
        <li>
            <a href="{{ route('gestion-lista-blanca.index') }}">SEG. Lista Blanca</a>
        </li>
        <li>
            <a href="{{ route('gestion-parametros.index') }}">CONF. Parametros</a>
        </li>

    </ul>
</li>
<!--Menu Inventario-->
<li>
    <a href="javascript:void(0);" data-toggle="collapse" data-target="#comp_dr"><div class="pull-left"><i class="ti-check-box  mr-20"></i><span class="right-nav-text">Inventario</span></div><div class="pull-right"><i class="ti-angle-down "></i></div><div class="clearfix"></div></a>
    <ul id="comp_dr" class="collapse collapse-level-1">
        <li>
            <a href="{{ route('inventario.home') }}">INV. Gestión Inventario</a>
        </li>
        <li>
            <a href="{{ route('inventario-productos.index') }}">INV. Crear Productos</a>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#form_dr"><div class="pull-left"><span class="right-nav-text">INV. Maestros </span></div><div class="pull-right"><i class="ti-angle-down "></i></div><div class="clearfix"></div></a>
            <ul id="form_dr" class="collapse collapse-level-2 dr-change-pos">
                <li>
                    <a href="{{ route('inventario-bodegas.index') }}">MAES. Bodegas</a>
                    
                </li>
                <li>
                    <a href="{{ route('inventario-lineas.index') }}">MAES. Líneas</a>
                </li>
                <li>
                    <a href="{{ route('inventario-sublineas.index') }}">MAES. Sub-Líneas</a>
                </li>               
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#chart_dr"><div class="pull-left"><span class="right-nav-text">INV. Informes </span></div><div class="pull-right"><i class="ti-angle-down "></i></div><div class="clearfix"></div></a>
                <ul id="chart_dr" class="collapse collapse-level-2 dr-change-pos">
                    <li>
                        <a href="{{ route('documentos-kardex.filters') }}">INF. Kardex de producto</a>
                    </li>
                    <li>
                        <a href="{{ route('documentos.inventario') }}">INF. Inventario</a>
                    </li>
                </ul>
        </li>

    </ul>
</li>




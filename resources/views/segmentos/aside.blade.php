<nav id="sidebar" class="sidebar">
   <div class="sidebar-content js-simplebar">
      <a class="sidebar-brand text-center" href=" {{ url('/') }}">
         {{-- <span class="align-middle">Ecolimp</span> --}}
         <img src="{{ asset('img/ecolimp.png') }}" alt="homepage" width="150" class="light-logo" />
         <h2 class="title-aside mt-1">Gestión de Inventario</h2>
      </a>

      <ul class="sidebar-nav">

         {{-- *********************************************************** --}}
         {{-- ******************* MENU DE ADMINISTRACION **************** --}}
         {{-- *********************************************************** --}}
         @canany(['ROL-LISTAR', 'PERMISO-LISTAR', 'USUARIO-LISTAR', 'PERSONAL-LISTAR'])
         <li class="sidebar-header text-center bg-light-info py-2">
            <span> Administración </span>
         </li>
         @endcanany
         @can('ROL-LISTAR')
         <li class="sidebar-item">
            <a data-target="#roles" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-user-unlock"></i> <span class="align-middle">Roles</span>
            </a>
            <ul id="roles" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('roles.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan
         @can('PERMISO-LISTAR')
         <li class="sidebar-item">
            <a data-target="#permisos" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-user-shield"></i> <span class="align-middle">Permisos</span>
            </a>
            <ul id="permisos" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('permisos.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('USUARIO-LISTAR')
         <li class="sidebar-item">
            <a data-target="#usuarios" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-users"></i> <span class="align-middle">Usuarios</span>
            </a>
            <ul id="usuarios" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('usuarios.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('PERSONAL-LISTAR')
         <li class="sidebar-item">
            <a data-target="#empleados" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-user-tie" style="margin-right: 1.1rem;"></i> <span class="align-middle">Personal</span>
            </a>
            <ul id="empleados" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('empleados.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         {{-- *********************************************************** --}}
         {{-- ******************* MENU DE INVENTARIO ******************** --}}
         {{-- *********************************************************** --}}
         @canany(['CATEGORIA-LISTAR','PRODUCTO-LISTAR','INSTALACION-LISTAR','PROVEEDOR-LISTAR'])
         <li class="sidebar-header text-center bg-light-info py-2">
            <span>Inventario</span>
         </li>
         @endcanany
         @can('CATEGORIA-LISTAR')
         <li class="sidebar-item">
            <a data-target="#categorias" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="far fa-boxes-alt"></i> <span class="align-middle">Categoria</span>
            </a>
            <ul id="categorias" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('categorias.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>

         @endcan

         @can('PRODUCTO-LISTAR')
         <li class="sidebar-item">
            <a data-target="#productos" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fal fa-pump-soap" style="margin-right: 1.2rem;"></i> <span class="align-middle">Productos</span>
            </a>
            <ul id="productos" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('productos.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('INSTALACION-LISTAR')
         <li class="sidebar-item">
            <a data-target="#instalaciones" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-store-alt" style="left: -2px"></i> <span class="align-middle" style="position: relative; left: -2px">Centro de Costo</span>
            </a>
            <ul id="instalaciones" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('instalaciones.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('PROVEEDOR-LISTAR')
         <li class="sidebar-item">
            <a data-target="#proveedores" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fad fa-user-secret"></i> <span class="align-middle">Proveedores</span>
            </a>
            <ul id="proveedores" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('proveedores.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         {{-- *********************************************************** --}}
         {{-- ******************* MENU DE LOGISTICA ******************** --}}
         {{-- *********************************************************** --}}
         @canany(['INGRESO-LISTAR','SALIDA-LISTAR','CONSULTA-LISTAR'])
         <li class="sidebar-header text-center bg-light-info py-2">
            <span>Logistica</span>
         </li>
         @endcanany

         @can('INGRESO-LISTAR')
         <li class="sidebar-item">
            <a data-target="#ingresos" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fas fa-inbox-in"></i> <span class="align-middle">Registro Productos</span>
            </a>
            <ul id="ingresos" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('ingresos.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('SALIDA-LISTAR')
         <li class="sidebar-item">
            <a data-target="#salidas" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="fas fa-inbox-out"></i> <span class="align-middle">Entrega Materiales</span>
            </a>
            <ul id="salidas" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('salidas.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

         @can('CONSULTA-LISTAR')
         <li class="sidebar-item">
            <a data-target="#consultas" data-toggle="collapse" class="sidebar-link collapsed">
               <i class="far fa-search"></i> <span class="align-middle">Consulta de Materiales</span>
            </a>
            <ul id="consultas" class="sidebar-dropdown list-unstyled collapse " data-parent="#sidebar">
               <li class="sidebar-item"><a class="sidebar-link" href="{{ route('consultas.index') }}"><i class="far fa-scrubber"></i>Lista</a></li>
            </ul>
         </li>
         @endcan

      </ul>

   </div>
</nav>
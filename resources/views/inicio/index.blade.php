@extends('main')

@section('contenido')



<div class="row">
   @can('ROL-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href=" {{ route('roles.create') }} ">
         <img src="img/inicio/rol.png" class="icono-inicio p-4" width="180" alt="Empleado">
         <div class="card-body">
            <h4>NUEVO ROL</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('PERSONAL-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href=" {{ route('empleados.create') }} ">
         <img src="img/inicio/empleado.png" class="icono-inicio p-4" width="180" alt="Empleado">
         <div class="card-body">
            <h4>NUEVO EMPLEADO</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('PRODUCTO-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href=" {{ route('productos.create') }} ">
         <img src="img/inicio/producto.png" class="icono-inicio p-4" width="180" alt="Producto">
         <div class="card-body">
            <h4>NUEVO PRODUCTO</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('PROVEEDOR-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href="{{ route('proveedores.create') }} ">
         <img src="img/inicio/proveedor.png" class="icono-inicio p-4" width="180" alt="Proveedor">
         <div class="card-body">
            <h4>NUEVO PROVEEDOR</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('INSTALACION-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href="{{ route('instalaciones.create') }}# ">
         <img src="img/inicio/instalacion.png" class="icono-inicio p-4" width="180" alt="Instalacion">
         <div class="card-body">
            <h4>NUEVO CENTRO DE COSTO</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('INGRESO-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href="{{ route('ingresos.create') }} ">
         <img src="img/inicio/registro.png" class="icono-inicio p-4" width="180" alt="RegistroProductos">
         <div class="card-body">
            <h4>REGISTRO DE MATERIALES</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('SALIDA-CREAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href="{{ route('salidas.create') }}">
         <img src="img/inicio/entrega.png" class="icono-inicio p-4" width="180" alt="Empleado">
         <div class="card-body">
            <h4>ENTREGA DE MATERIALES</h4>
         </div>
      </a>
   </div>
   @endcan

   @can('CONSULTA-LISTAR')
   <div class="col-6 col-md-4 col-lg-3">
      <a class="card d-flex justify-content-center align-items-center btn btn-light" type="button" href="{{ route('consultas.index') }}">
         <img src="img/inicio/consulta.png" class="icono-inicio p-4" width="180" alt="Empleado">
         <div class="card-body">
            <h4>CONSULTAR ENTREGA DE MATERIALES</h4>
         </div>
      </a>
   </div>
   @endcan

</div>

@endsection
@extends('main')

@section('titulo')
Detalle Consulta
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{ route('consultas.index') }}"><span><i class="far fa-search mr-2"></i></span>Consultas</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="fal fa-list-alt mr-1"></i></span>Detalle</li>
</ol>

<div class="col-12 mb-3 text-right">
   <a href="{{ route('consultas.index') }}" class="btn btn-success">
      <span class="btn-label"><i class="fas fa-long-arrow-left mr-2"></i></span>Regresar
   </a>
</div>



<div class="row d-flex justify-content-center">

   <div class="col-12">
      <div class="card card-border">
         <div class="card-body row">

            <div class="col-12 col-sm-6 col-md-6 col-lg-2 mt-2">
               {!! Html::decode(Form::label('cod_salida', 'Código <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('cod_salida', isset($salida) ? $salida->codigo : '', ['class' => 'form-control', 'placeholder' => 'CÓDIGO SALIDA', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2" id="nomcc_typeahead">
               {!! Html::decode(Form::label('nomcc', 'Nombre del C.C. <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_cc', isset($salida) ? $salida->instalacion->nombre : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE DEL C.C.', 'readonly']) !!}
            </div>

            {{-- *************************** CAMPOS AUTORELLENADOS - CENTROS DE COSTO ******************************* --}}
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mt-2">
               {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia C.C.', ['class' => 'font-weight-bold mt-1'])) !!}
               {!! Form::text('nom_fantasia', isset($salida) ? $salida->instalacion->nom_fantasia : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA C.C.', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('nrodoc', 'RUT C.C.', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_cc', isset($salida) ? $salida->instalacion->nrodoc : '', ['class' => 'form-control', 'placeholder' => 'RUT DEL C.C.', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('tel_cc', 'Teléfono C.C.', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('tel_cc', isset($salida) ? $salida->instalacion->telefono : '', ['class' => 'form-control', 'placeholder' => 'TELÉFONO C.C.', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-phone-rotary"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('region', isset($salida) ? $salida->instalacion->region->nombre : '', ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('provincia', isset($salida) ? $salida->instalacion->provincia->nombre : '', ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('comuna', isset($salida) ? $salida->instalacion->comuna->nombre : '', ['class' => 'form-control', 'placeholder' => 'COMUNA', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-5 mt-2">
               {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('dir_cc', isset($salida) ? $salida->instalacion->direccion : '', ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-4 mt-2">
               {!! Html::decode(Form::label('nom_contacto', 'Nombre Contacto', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('nom_contacto', isset($salida) ? $salida->instalacion->nom_contacto : '', ['class' => 'form-control', 'placeholder' => 'NOMBRE CONTACTO', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('nro_contacto', 'RUT Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('rut_contacto', isset($salida) ? $salida->instalacion->nrodoc_contacto : '', ['class' => 'form-control', 'placeholder' => 'RUT CONTACTO', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fal fa-id-card"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('cel_contacto', 'Celular Contacto', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('cel_contacto', isset($salida) ? $salida->instalacion->cel_contacto : '', ['class' => 'form-control', 'placeholder' => 'CELULAR CONTACTO', 'readonly']) !!}
                  <div class="input-group-text">
                     <i class="fas fa-mobile-android-alt"></i>
                  </div>
               </div>
            </div>
            {{-- *************************** // CAMPOS AUTORELLENADOS - CENTROS DE COSTO ******************************* --}}

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('fecha_inicio', 'Fecha Inicio <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_inicio', isset($salida) ? date('d-m-Y', strtotime($salida->fecha_inicial)) : '', ['class' => 'form-control', 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('fecha_fin', 'Fecha Fin <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
               <div class="input-group">
                  {!! Form::text('fecha_fin', isset($salida) ? date('d-m-Y', strtotime($salida->fecha_final)) : '', ['class' => 'form-control' , 'readonly', 'placeholder' => 'DD-MM-YYYY']) !!}
                  <div class="input-group-text">
                     <i class="far fa-calendar-alt"></i>
                  </div>
               </div>
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('usu_responsable', 'Usuario Creador', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('usu_responsable', $salida->usuario_creador->name, ['class' => 'form-control', 'placeholder' => 'RESPONSABLE', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('usu_responsable', 'Usuario Editor', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('usu_responsable', isset($salida->usuario_editor) ? $salida->usuario_editor->name : '', ['class' => 'form-control', 'placeholder' => 'RESPONSABLE', 'id' => 'usu_responsable', 'readonly']) !!}
            </div>

            <div class="col-12 col-sm-6 col-md- col-lg-3 mt-2">
               {!! Html::decode(Form::label('recibidor', 'Recibido por', ['class' => 'font-weight-bold'])) !!}
               {!! Form::text('recibido_por', isset($salida->recibido_por) ? $salida->recibido_por : '', ['class' => 'form-control', 'placeholder' => 'RESPONSABLE', 'id' => 'recibido_por', 'readonly']) !!}
            </div>

            <div class="col-6 mt-2">
               {!! Html::decode(Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold'])) !!}
               {!! Form::textarea('observaciones', isset($salida) ? $salida->observaciones : '', ['class' => 'form-control alfanumerico', 'readonly', 'rows' => '2', 'style' => 'resize:none', 'maxlength' => '100']) !!}
            </div>


         </div>

      </div>
   </div>

   <div class="col-12">

      <div class="card card-border px-3" id="card_productos">
         <div class="card-body row">

            <div class="col-12 px-0">
               <table class="table table-sm table-hover table-bordered text-nowrap font-table w-100" id="tabla_salida_productos">
                  <thead class="text-center">
                     <tr class="bg-light-blue ">
                        <th colspan="6" class="py-2">PRODUCTOS ENTREGADOS</th>
                     </tr>
                     <tr class="bg-light-blue">
                        <th width="5%">N°</th>
                        <th width="40%">Producto</th>
                        <th width="25%">Presentación</th>
                        <th width="15%">Stock Actual</th>
                        <th width="15%">Cantidad</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($mov_productos as $producto)
                     <tr>
                        <td class="text-center">{{ $loop->index + 1  }}</td>
                        <td class="producto_typeahead">
                           {!! Form::text('producto_ingreso[]', $producto->nomProducto, ['class' => 'form-control', 'placeholder' => 'BUSCAR PRODUCTO', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('pres_producto[]', $producto->presProducto, ['class' => 'form-control ', 'placeholder' => 'PRES.', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('stock_producto[]', $producto->stock, ['class' => 'form-control ', 'placeholder' => 'STOCK', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('cantidad_ingreso[]', $producto->cantidad, ['class' => 'form-control', 'placeholder' => 'CANTIDAD', 'readonly']) !!}
                        </td>

                     </tr>
                     @endforeach
                  </tbody>
               </table>


            </div>

         </div>


      </div>

   </div>

</div>






@endsection

{{-- @section('script')
<script src="{{ asset('scripts/script_ingresosS.js') }}"></script>
@endsection --}}
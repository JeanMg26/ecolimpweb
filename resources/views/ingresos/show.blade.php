@extends('main')

@section('titulo')
Detalle de Ingresos de Productos
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{ route('ingresos.index') }}"><span><i class="fas fa-inbox-in mr-2"></i></span>Ingreso de Productos</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="fal fa-list-alt mr-1"></i></span>Detalle</li>
</ol>

<div class="col-12 mb-3 text-right">
   <a href="{{ route('ingresos.index') }}" class="btn btn-success">
      <span class="btn-label"><i class="fas fa-long-arrow-left mr-2"></i></span>Regresar
   </a>
</div>

<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">

               <div class="col-12 col-sm-6 col-lg-4 col-xl-2 mt-2">
                  {!! Html::decode(Form::label('num_registro', 'N° Registro', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('cod_ingreso', isset($ingreso) ? $ingreso->codigo : '', ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-8 col-xl-4 mt-2" id="nomproveedor_typeahead">
                  {!! Form::label('nom_proveedor', 'Nombre del Proveedor', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nom_proveedor', $ingreso->proveedor->nombre, ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3 mt-2">
                  {!! Html::decode(Form::label('nom_fantasia', 'Nombre Fantasia', ['class' => 'font-weight-bold mt-1'])) !!}
                  {!! Form::text('nom_fantasia', $ingreso->proveedor->nom_fantasia, ['class' => 'form-control', 'placeholder' => 'NOMBRE FANTASIA', 'readonly', 'id' => 'nom_fantasia']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('rut_proveedor', 'RUT del Proveedor', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('rut_proveedor', $ingreso->proveedor->nrodoc, ['class' => 'form-control', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('tel_proveedor', 'Tel. del Proveedor', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('tel_proveedor', $ingreso->proveedor->telefono, ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Html::decode(Form::label('region', 'Región', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('region', $ingreso->proveedor->region->nombre, ['class' => 'form-control', 'placeholder' => 'REGIÓN', 'id' => 'region', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Html::decode(Form::label('provincia', 'Provincia', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('provincia', $ingreso->proveedor->provincia->nombre, ['class' => 'form-control', 'placeholder' => 'PROVINCIA', 'id' => 'provincia', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Html::decode(Form::label('comuna', 'Comuna', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('comuna', $ingreso->proveedor->comuna->nombre, ['class' => 'form-control', 'placeholder' => 'COMUNA', 'id' => 'comuna', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-7 col-xl-5 mt-2">
                  {!! Html::decode(Form::label('direccion', 'Dirección', ['class' => 'font-weight-bold'])) !!}
                  {!! Form::text('dir_proveedor', $ingreso->proveedor->direccion, ['class' => 'form-control', 'placeholder' => 'DIRECCIÓN', 'id' => 'dir_proveedor', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-5 col-xl-4 mt-2">
                  {!! Form::label('nom_contacto', 'Nombre del Contacto', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nom_contacto', $ingreso->proveedor->nom_contacto, ['class' => 'form-control', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('nrodoc_contacto', 'RUT del Contacto', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nrodoc_contacto', $ingreso->proveedor->nrodoc_contacto, ['class' => 'form-control', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('cel_contacto', 'Cel. del Contacto', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('cel_contacto', $ingreso->proveedor->cel_contacto, ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('tipodoc', 'Tipo Documento', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('tipodoc', $ingreso->tipodoc, ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('nrodoc', 'N° Documento', ['class' => 'font-weight-bold']) !!}
                  <div class="input-group">
                     {!! Form::text('nrodoc_ingreso', $ingreso->nrodoc, ['class' => 'form-control alfanumerico', 'readonly']) !!}
                     <div class="input-group-text">
                        <i class="fal fa-file-invoice"></i>
                     </div>
                  </div>
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('fecha_emision', 'Fecha Ingreso', ['class' => 'font-weight-bold mt-2']) !!}
                  <div class="input-group">
                     {!! Form::text('fec_emision', date('d-m-Y', strtotime($ingreso->fecha_emision)), ['class' => 'form-control', 'readonly']) !!}
                     <div class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                     </div>
                  </div>
               </div>

               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('creado_por', 'Creado por', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('creado_por', $ingreso->usuario_creador->name, ['class' => 'form-control', 'readonly']) !!}
               </div>
               <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-2">
                  {!! Form::label('editado_por', 'Editado por', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('editado_por', isset($ingreso->usuario_editor) ? $ingreso->usuario_editor->name : '', ['class' => 'form-control', 'readonly']) !!}
               </div>

               <div class="col-12 mt-2">
                  {!! Form::label('observaciones', 'Observaciones', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::textarea('observaciones', $ingreso->observaciones, ['class' => 'form-control', 'readonly', 'rows' => '2']) !!}
               </div>






            </div>
         </div>
      </div>
   </div>

   <div class="col-12">

      <div class="card card-border px-3" id="card_productos">
         <div class="card-body row">
            <div class="col-12 table-responsive">
               <table class="table table-sm table-hover table-bordered text-nowrap font-table w-100" id="tabla_ingres_productos">
                  <thead class="text-center">
                     <tr class="bg-light-blue ">
                        <th colspan="8" class="py-2">PRODUCTOS AGREGADOS</th>
                     </tr>
                     <tr class="bg-light-blue">
                        <th width="5%">N°</th>
                        <th width="25%">Producto</th>
                        <th width="15%">Presentación</th>
                        <th width="15%">Stock Actual</th>
                        <th width="10%">Cantidad</th>
                        <th width="15%">P. Unitario</th>
                        <th width="15%">Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($mov_productos as $producto)
                     <tr>
                        <td>{{ $loop->index + 1  }}</td>
                        <td>
                           {!! Form::text('nom_producto', $producto->nomProducto, ['class' => 'form-control', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('pres_producto[]', $producto->presProducto, ['class' => 'form-control ', 'id' => 'presProducto_'.($loop->index+1), 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('stock_producto[]', $producto->stock, ['class' => 'form-control ', 'id' => 'stockIN_'.($loop->index+1), 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('cantidad', $producto->cantidad, ['class' => 'form-control', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('precio', number_format($producto->precio_unitario, 2), ['class' => 'form-control', 'readonly']) !!}
                        </td>
                        <td>
                           {!! Form::text('total', number_format($producto->total, 2), ['class' => 'form-control total', 'readonly']) !!}
                        </td>
                     </tr>

                     @endforeach

                  </tbody>
               </table>
            </div>

            <div class="col-12">
               <div class="row d-flex justify-content-end">
                  <div class="col-2">
                     {!! Form::label('subtotal', 'SUBTOTAL', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-2">
                     {!! Form::text('subTotalFinal', null, ['class' => 'form-control', 'placeholder' => 'SUBTOTAL', 'id' => 'subTotalFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>
            <div class="col-12 mt-2">
               <div class="row d-flex justify-content-end">
                  <div class="col-6 col-xl-2">
                     {!! Form::label('iva', 'IVA', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-6 col-xl-2">
                     {!! Form::text('ivaFinal', null, ['class' => 'form-control', 'placeholder' => 'IVA', 'id' => 'ivaFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>
            <div class="col-12 mt-2">
               <div class="row d-flex justify-content-end">
                  <div class="col-2">
                     {!! Form::label('total', 'TOTAL', ['class' => 'font-weight-bold']) !!}
                  </div>
                  <div class="col-2">
                     {!! Form::text('totalFinal', null, ['class' => 'form-control', 'placeholder' => 'TOTAL', 'id' => 'TotalFinal', 'readonly']) !!}
                  </div>
               </div>
            </div>

            <div class="col-12 text-center">
               <a type="button" href="{{ route('impresion.ingresos', ['ingreso_id' => $ingreso->id]) }}" class="btn btn-secondary"><i class="far fa-download mr-1"></i>Imprimir</a>
            </div>


         </div>



      </div>

   </div>
</div>






@endsection

@section('script')
<script src="{{ asset('scripts/script_ingresosS.js') }}"></script>
@endsection
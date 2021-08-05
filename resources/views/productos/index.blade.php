@extends('main')

@section('titulo')
Productos
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fal fa-pump-soap mr-1"></i>Productos</span></li>
</ol>

<div class="col-12 collapse" id="filtrosCollapse">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-12 col-sm-6 col-xl-3" id="nomproducto_typeahead">
               {!! Form::label('nomproducto', 'Nombre', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('nomproducto_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'nomproducto_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR PRODUCTO']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3" id="codproducto_typeahead">
               {!! Form::label('nomproducto', 'Código', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('codproducto_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'codproducto_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR CÓDIGO']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
               {!! Form::label('categoria', 'Categoria', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::select('categoria_buscar', ['' => 'TODOS'] + $categoria, null, ['class' => 'form-control', 'id' => 'categoria_buscar']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
               {!! Form::label('estado', 'Estado', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::select('estado_buscar', ['' => 'TODOS'] + $estado, null, ['class' => 'form-control', 'id' => 'estado_buscar']) !!}
            </div>

            <div class="col-6">
               {!! Form::label('stock', 'Stock de Productos', ['class' => 'font-weight-bold mt-2']) !!}
               <div class="row">
                  <div class="col-6">
                     {!! Form::text('stock_min', null, ['class' => 'form-control alfanumerico', 'id' => 'stock_mayor', 'maxlength' => '4', 'autocomplete' => 'off', 'placeholder' => 'MAYOR O IGUAL QUE']) !!}
                  </div>
                  <div class="col-6">
                     {!! Form::text('stock_max', null, ['class' => 'form-control alfanumerico', 'id' => 'stock_menor', 'maxlength' => '4', 'autocomplete' => 'off', 'placeholder' => 'MENOR O IGUAL QUE']) !!}
                  </div>
               </div>
            </div>

            <div class="col-12 col-xl-6 d-flex justify-content-center justify-content-xl-end align-items-xl-end ">
               <button class="btn btn-light-blue px-4 mr-2" id="buscar">
                  <i class="far fa-search mr-2"></i>Buscar
               </button>
               <button class="btn btn-light-blue px-4" id="reiniciar">
                  <i class="far fa-eraser mr-2"></i>Limpiar
               </button>
            </div>

         </div>

      </div>
   </div>
</div>

@can('PRODUCTO-CREAR')
<div class="col-12 d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-light-blue px-4" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" id="filtrar">
      <i class="far fa-filter mr-2"></i>Filtros
   </button>
   <a href="{{ route('productos.create') }}" class="btn btn-success">
      <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
   </a>
</div>
@endcan

{{-- *********** TABLE CARD ************** --}}
<div class="col-xl-12">
   <div class="card font-table">
      <div class="card-body">

         <table id="tabla_productos" class="table table-sm table-hover table-bordered font-table text-nowrap w-100">
            <thead>
               <tr class="bg-light-blue">
                  <th colspan="10" class="text-center py-3">
                     <h4 class="font-weight-bold mb-0" style="color: #1f4173">PRODUCTOS REGISTRADOS</h4>
                  </th>
               </tr>
               <tr class="text-center font-weight bg-light-blue pr-1">
                  <th class="py-2" width="5%">Nº</th>
                  <th class="py-2" width="8%">IMAGEN</th>
                  <th class="py-2" width="8%">CODIGO</th>
                  <th class="py-2" width="16%">NOMBRE</th>
                  <th class="py-2" width="16%">PRESENTACION</th>
                  <th class="py-2" width="15%">CATEGORIA</th>
                  <th class="py-2" width="10%">STOCK</th>
                  <th class="py-2" width="10%">CANT. MÍNIMA</th>
                  <th class="py-2" width="10%">ESTADO</th>
                  <th class="py-2" width="15%">ACCIONES</th>
               </tr>
            </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}


{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade pr-0" id="showModal" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-primary">
         <div class="modal-header bg-light-blue">
            <h5 class="modal-title font-modal text-center font-weight-bold">DETALLE DEL PRODUCTO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body row d-flex justify-content-center">
            <div class="col-10 row mb-2">

               <div class="card border-secondary">
                  <div class="card-body">
                     <div class="col-12 d-flex justify-content-center align-items-center">
                        <img class="img-fluid" width="150" id="limagen_pro">
                     </div>
                  </div>
               </div>

               <div class="col-12 row mt-3 mt-md-0">
                  {!! Form::label('codigo', 'CÓDIGO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lcod_pro"></p>
                  </div>

                  {!! Form::label('nombre', 'NOMBRE:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnom_pro"></p>
                  </div>

                  {!! Form::label('tipo', 'TIPO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="ltipo_pro"></p>
                  </div>

                  {!! Form::label('presentacion', 'PRESENTACIÓN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 mb-0">
                     <p class="mb-2" id="lpres_pro"></p>
                  </div>

                  {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lest_pro"></p>
                  </div>

                  {!! Form::label('descripcion', 'DESCRIPCIÓN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 mb-0">
                     <p class="mb-2" id="ldes_pro"></p>
                  </div>

               </div>

            </div>
         </div>

      </div>
   </div>
</div>
{{-- *********** /AGREGAR - MODAL ************** --}}


{{-- ************* ELIMINAR - MODAL **************** --}}
<div class="modal fade font-modal" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false">
   <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">Eliminar Registro</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body my-2">
            <p class="text-center mb-0">¿Deseas eliminar este registro?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            {!! Form::button('Si, Eliminar', ['class'=>'btn btn-danger mr-1', 'type'=>'button', 'name' => 'ok_button', 'id' => 'ok_button']) !!}
            {!! Form::button('No, Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
         </div>
      </div>
   </div>
</div>
{{-- ************* /DELETE- MODAL **************** --}}



@endsection


@section('script')
<script src="{{ asset('scripts/script_productos.js') }}"></script>

@endsection
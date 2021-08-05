@extends('main')

@section('titulo')
Entrega de Materiales
@endsection

@section('contenido')

<div class="row">

   <div class="col-12">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
         </li>
         <li class="breadcrumb-item"><span><i class="fas fa-inbox-out mr-2"></i>Entrega de Materiales</span></li>
      </ol>
   </div>

   {{--**************************** FILTROS ****************************--}}
   <div class="col-12 collapse" id="filtrosCollapse">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-12 col-sm-6 col-xl-3" id="nomcc_typeahead">
                  {!! Form::label('nom_cc', 'Nombre C.C.', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nomcc_buscar', null, ['class' => 'form-control letras', 'id' => 'nomcc_buscar', 'maxlength' => '9', 'autocomplete' => 'off']) !!}
               </div>
               <div class="col-12 col-sm-6 col-xl-3" id="rutcc_typeahead">
                  {!! Form::label('ruccc', 'RUT C.C.', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('rutcc_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'rutcc_buscar', 'maxlength' => '9', 'autocomplete' => 'off']) !!}
               </div>

               <div class="col-12 col-xl-6">
                  {!! Html::decode(Form::label('fecha', 'Fecha', ['class' => 'font-weight-bold mt-2'])) !!}
                  <div class="row">
                     <div class="col-6">
                        <div class="input-group ">
                           {!! Form::text('fecha_inicio', null, ['class' => 'form-control input_blanco' , 'id' => 'fecha_inicio', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'FECHA INICIAL']) !!}
                           <div class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                           </div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="input-group">
                           {!! Form::text('fecha_fin', null, ['class' => 'form-control input_blanco' , 'id' => 'fecha_fin', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'FECHA FINAL']) !!}
                           <div class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col-12 col-sm-6 col-xl-3">
                  {!! Form::label('num_registro', 'N° Registro', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('num_registro', null, ['class' => 'form-control alfanumerico', 'id' => 'num_registro', 'maxlength' => '9', 'autocomplete' => 'off']) !!}
               </div>

               <div class="col-9 d-flex justify-content-end align-items-end mt-4">
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

   @can('SALIDA-CREAR')
   <div class="col-12 d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-light-blue" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" id="filtrar">
         <i class="far fa-filter mr-2"></i>Filtros
      </button>
      <a href="{{ route('salidas.create') }}" class="btn btn-success">
         <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
      </a>
   </div>
   @endcan

   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">

            <table id="tabla_salidas" class="table table-sm table-hover table-bordered text-nowrap font-table w-100">
               <thead>
                  <tr class="bg-light-blue">
                     <th colspan="10" class="text-center py-3">
                        <h4 class="font-weight-bold mb-0" style="color: #1f4173">ENTREGA DE MATERIALES REGISTRADOS</h4>
                     </th>
                  </tr>
                  <tr class="text-center bg-light-blue">
                     <th class="py-2" width="5%">Nº</th>
                     <th class="py-2" width="10%">N° REGISTRO</th>
                     <th class="py-2" width="23%">NOMBRE C.C.</th>
                     <th class="py-2" width="12%">RUT C.C.</th>
                     <th class="py-2" width="10%">TELÉFONO C.C.</th>
                     <th class="py-2" width="20%">DIRECCIÓN C.C.</th>
                     <th class="py-2" width="10%">FECHA ENTREGA</th>
                     <th class="py-2" width="10%">ENTREGADO POR</th>
                     <th class="py-2" width="10%">RECIBIDO POR</th>
                     <th class="py-2" width="10%">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center"></tbody>
            </table>
         </div>
      </div>
   </div>
   {{-- *********** /TABLE CARD ************** --}}

   {{-- ************* ELIMINAR - MODAL **************** --}}
   <div class="modal fade font-modal" id="confirmModal" role="dialog">
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

</div>
@endsection

@section('script')

<script src="{{ asset('scripts/script_salidas.js') }}"></script>


@endsection
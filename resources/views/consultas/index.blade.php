@extends('main')

@section('titulo')
Consulta de Materiales Entregados
@endsection

@section('contenido')

<div class="row">

   <div class="col-12">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
         </li>
         <li class="breadcrumb-item"><span><i class="far fa-search mr-2"></i>Consulta de Materiales Entregados</span></li>
      </ol>
   </div>

   {{-- **************************** FILTROS ****************************--}}
   <div class="col-12 collapse" id="filtrosCollapse">
      <div class="card">
         <div class="card-body">
            <div class="row">

               <div class="col-12 col-sm-6 col-xl-3" id="codproducto_typeahead">
                  {!! Form::label('codproducto_buscar', 'Código Producto', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('codproducto_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'codproducto_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR CÓDIGO']) !!}
               </div>

               <div class="col-12 col-sm-6 col-xl-3" id="nomproducto_typeahead">
                  {!! Form::label('nomproducto_buscar', 'Nombre Producto', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nomproducto_buscar', null, ['class' => 'form-control letras', 'id' => 'nomproducto_buscar', 'maxlength' => '15', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR NOMBRE']) !!}
               </div>


               <div class="col-12 col-sm-6 col-xl-3" id="nomcc_typeahead">
                  {!! Form::label('nom_cc', 'Nombre Centro Costo', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('nomcc_buscar', null, ['class' => 'form-control letras', 'id' => 'nomcc_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR NOMBRE']) !!}
               </div>

               <div class="col-12 col-sm-6 col-xl-3" id="rutcc_typeahead">
                  {!! Form::label('ruccc', 'RUT Centro Costo', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::text('rutcc_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'rutcc_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR RUT']) !!}
               </div>

               <div class="col-12 col-sm-6 col-xl-3">
                  {!! Form::label('entregado_por', 'Entregado Por', ['class' => 'font-weight-bold mt-2']) !!}
                  {!! Form::select('entregado_por', ['' => 'TODOS'] + $entregado_por, null, ['class' => 'form-control', 'id' => 'entregado_por']) !!}
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

               <div class="col-12 d-flex justify-content-center justify-content-xl-end align-items-center mt-4">
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

   <div class="col-12 d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-light-blue" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" id="filtrar">
         <i class="far fa-filter mr-2"></i>Filtros
      </button>

   </div>

   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card font-table">
         <div class="card-body">

            <table id="tabla_consultas" class="table table-sm table-hover table-bordered text-nowrap font-table w-100">
               <thead>
                  <tr class="bg-light-blue">
                     <th colspan="12" class="text-center py-3">
                        <h4 class="font-weight-bold mb-0" style="color: #1f4173">ENTREGA DE MATERIALES REGISTRADOS</h4>
                     </th>
                  </tr>

                  <tr class="text-center bg-light-blue">
                     <th colspan="1" class="py-2"></th>
                     <th colspan="4" class="py-2">PRODUCTO</th>
                     <th colspan="2" class="py-2">CENTRO DE COSTO</th>
                     <th colspan="5" class="py-2"></th>
                  </tr>

                  <tr class="text-center bg-light-blue">
                     <th width="4%" class="py-2">Nº</th>
                     <th class="py-2">CODIGO</th>
                     <th class="py-2">PRODUCTO</th>
                     <th class="py-2">PRES.</th>
                     <th class="py-2">CANTIDAD</th>
                     <th class="py-2">NOMBRE</th>
                     <th class="py-2">RUT</th>
                     <th class="py-2">F. ENTREGA</th>
                     <th class="py-2">RES. ENTREGO</th>
                     <th class="py-2">RESP. RECIBIO</th>
                     <th class="py-2">ACCIÓN</th>
                  </tr>
               </thead>
               <tbody class="text-center"></tbody>
            </table>
         </div>
      </div>
   </div>
   {{-- *********** /TABLE CARD ************** --}}







</div>
@endsection

@section('script')

<script src="{{ asset('scripts/script_consultas.js') }}"></script>

@endsection
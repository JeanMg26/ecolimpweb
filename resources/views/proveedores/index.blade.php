@extends('main')

@section('titulo')
Proveedores
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fad fa-user-secret mr-2"></i>Proveedores</span></li>
</ol>


<div class="col-12 collapse" id="filtrosCollapse">
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col-12 col-sm-6 col-xl-3" id="nomproveedor_typeahead">
               {!! Form::label('nomproveedor', 'Nombre del Proveedor', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('nomproveedor_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'nomproveedor_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR NOMBRE']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3" id="rutproveedor_typeahead">
               {!! Form::label('nomproveedor', 'RUT del Proveedor', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('rutproveedor_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'rutproveedor_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR RUT']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3" id="nomcontacto_typeahead">
               {!! Form::label('nomcontacto', 'Nombre del Contacto', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('nomcontacto_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'nomcontacto_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR NOMBRE']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3" id="rutcontacto_typeahead">
               {!! Form::label('rutcontacto_buscar', 'RUT Contacto', ['class' => 'font-weight-bold mt-2']) !!}
               {!! Form::text('rutcontacto_buscar', null, ['class' => 'form-control alfanumerico', 'id' => 'rutcontacto_buscar', 'maxlength' => '9', 'autocomplete' => 'off', 'placeholder' => 'BUSCAR POR RUT']) !!}
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
               {!! Form::label('estado', 'Estado', ['class' => 'font-weight-bold mt-2 mt-2']) !!}
               {!! Form::select('estado_buscar', ['' => 'TODOS'] + $estado, null, ['class' => 'form-control', 'id' => 'estado_buscar']) !!}
            </div>

            <div class="col-xl-9 d-flex justify-content-center align-items-center justify-content-xl-end align-items-xl-end mt-3">
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

@can('PROVEEDOR-CREAR')
<div class="col-12 d-flex justify-content-between align-items-center mb-3">
   <button class="btn btn-light-blue px-4" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" id="filtrar">
      <i class="far fa-filter mr-2"></i>Filtros
   </button>
   <a href="{{ route('proveedores.create') }}" class="btn btn-success">
      <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
   </a>
</div>
@endcan

{{-- *********** TABLE CARD ************** --}}
<div class="col-xl-12">
   <div class="card font-table">
      <div class="card-body">

         <table id="tabla_proveedores" class="table table-sm table-hover table-bordered text-nowrap font-table w-100">
            <thead>
               <tr class="bg-light-blue">
                  <th colspan="9" class="text-center py-3">
                     <h4 class="font-weight-bold mb-0" style="color: #1f4173">PROVEEDORES REGISTRADOS</h4>
                  </th>
               </tr>

               <tr class="text-center bg-light-blue">
                  <th colspan="1" class="py-2"></th>
                  <th colspan="3" class="py-2">PROVEEDOR</th>
                  <th colspan="3" class="py-2">CONTACTO</th>
                  <th colspan="2" class="py-2"></th>
               </tr>

               <tr class="text-center bg-light-blue">
                  <th width="6%">N??</th>
                  <th width="18%">NOMBRE</th>
                  <th width="12%">RUT</th>
                  <th width="12%">TEL??FONO</th>
                  <th width="18%">NOMBRE</th>
                  <th width="12%">RUT</th>
                  <th width="12%">CELULAR</th>
                  <th width="10%">ESTADO</th>
                  <th width="20%">ACCIONES</th>
               </tr>
            </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}

{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade font-modal px-0" id="showModal">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-primary">
         <div class="modal-header bg-light-blue">
            <h5 class="modal-title font-weight-bold">DETALLE DEL REGISTRO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body my-2">
            <div class="row d-flex justify-content-center align-items-center">

               <div class="col-12 col-lg-10">
                  <div class="card card-border">
                     <div class="card-header text-center font-weight-bold">DATOS DEL PROVEEDOR</div>
                     <div class="card-body">
                        <div class="col-12 col-lg-11 row mt-3 mt-md-0">
                           {!! Form::label('nom_proveedor', 'NOMBRE:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lnom_proveedor"></p>
                           </div>

                           {!! Form::label('nom_fantasia', 'NOMBRE FANTASIA:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lnom_fantasia"></p>
                           </div>

                           {!! Form::label('nrodoc', 'RUN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lnrodoc_proveedor"></p>
                           </div>

                           {!! Form::label('region', 'REGI??N - PROVINCIA - COMUNA:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lregion"></p>
                           </div>

                           {!! Form::label('direccion', 'DIRECCI??N:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="ldir_proveedor"></p>
                           </div>

                           {!! Form::label('email', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lemail_proveedor"></p>
                           </div>

                           {!! Form::label('telefono', 'TEL??FONO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="ltel_proveedor"></p>
                           </div>

                           {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lest_proveedor"></p>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="card card-border">
                     <div class="card-header text-center font-weight-bold">DATOS DEL CONTACTO</div>
                     <div class="card-body">
                        <div class="col-12 col-md-10 row mt-3 mt-md-0">
                           {!! Form::label('nom_contacto', 'NOMBRE:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lnom_contacto"></p>
                           </div>

                           {!! Form::label('nrodoc_contacto', 'RUN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-sm-6 ">
                              <p class="mb-2" id="lnrodoc_contacto"></p>
                           </div>

                           {!! Form::label('email_contacto', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lemail_contacto"></p>
                           </div>

                           {!! Form::label('cel_contacto', 'CELULAR:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                           <div class="col-12 col-md-7 ">
                              <p class="mb-2" id="lcel_contacto"></p>
                           </div>

                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- *********** /MOSTRAR - MODAL ************** --}}

{{-- ************* ELIMINAR - MODAL **************** --}}
<div class="modal fade font-modal" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false">
   <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-danger">
         <div class="modal-header bg-danger">
            <h5 class="modal-title font-modal text-white">ELIMINAR REGISTRO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body my-2">
            <p class="text-center mb-0">Deseas eliminar este registro?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            {!! Form::button('Si, Eliminar', ['class'=>'btn btn-danger mr-1', 'type'=>'button', 'name' => 'ok_button', 'id' => 'ok_button']) !!}
            {!! Form::button('No, Cancelar', ['class'=>'btn btn-light', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
         </div>
      </div>
   </div>
</div>
{{-- ************* /DELETE- MODAL **************** --}}




@endsection




@section('script')

<script src="{{ asset('scripts/script_proveedores.js') }}"></script>

@endsection
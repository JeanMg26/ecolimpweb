@extends('main')

@section('titulo')
Usuarios
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fad fa-users mr-1"></i>Usuarios</span></li>
</ol>

@can('USUARIO-CREAR')
<div class="col-12" align="right">
   <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">
      <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
   </a>
</div>
@endcan

{{-- *********** TABLE CARD ************** --}}
<div class="col-xl-12">
   <div class="card font-table">
      <div class="card-body">

         <table id="tabla_usuarios" class="table table-sm table-hover table-bordered text-nowrap font-table w-100">
            <thead>
               <tr class="bg-light-blue">
                  <th colspan="7" class="text-center py-3">
                     <h4 class="font-weight-bold mb-0" style="color: #1f4173">USUARIOS REGISTRADOS</h4>
                  </th>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td><input colspan="1" class="form-control filter" id="buscar_columna2" placeholder="BUSCAR POR USUARIO"></td>
                  <td><input colspan="1" class="form-control filter" id="buscar_columna3" placeholder="BUSCAR POR EMAIL"></td>
                  <td class="text-center pr-1" id="parent"> {!! Form::select('rol', ['' => ''] + $rol, null, ['class' => 'form-control', 'id' => 'buscar_select1']) !!} </td>
                  <td colspan="2" class="text-center">
                     <button type="button" class="btn btn-light" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button>
                  </td>
               </tr>
               <tr class="text-center bg-light-blue">
                  <th class="py-2" width="5%%">Nº</th>
                  <th class="py-2" width="10%">IMAGEN</th>
                  <th class="py-2" width="20%">NOMBRE DE USUARIO</th>
                  <th class="py-2" width="20%">EMAIL</th>
                  <th class="py-2" width="15%">ROL</th>
                  <th class="py-2" width="10%">ESTADO</th>
                  <th class="py-2" width="20%">ACCIONES</th>
               </tr>
            </thead>
            <tbody class="text-center"></tbody>
         </table>
      </div>
   </div>
</div>
{{-- *********** /TABLE CARD ************** --}}


{{-- *********** MOSTRAR - MODAL ************** --}}
<div class="modal fade font-modal pr-0" id="showModal">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-primary">
         <div class="modal-header bg-light-blue">
            <h5 class="modal-title font-weight-bold">DETALLE DEL REGISTRO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">
               <div class="col-12 col-md-3 d-flex justify-content-center align-items-center">
                  <img class="img-fluid" width="150" id="limagen_emp">
               </div>
               <div class="col-12 col-md-9 row mt-3 mt-md-0">
                  {!! Form::label('nom_emp', 'NOMBRE DEL PERSONAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnom_emp"></p>
                  </div>
                  {!! Form::label('run', 'RUN:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnrodoc_emp"></p>
                  </div>
                  {!! Form::label('celular', 'CELULAR:', ['class' => 'col-12 col-md-5 font-weight-bold mb-2']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="" id="lcelular_emp"></p>
                  </div>
                  <div class="col-12">
                     <hr class="mt-1">
                  </div>
                  {!! Form::label('nom_usu', 'NOMBRE DE USUARIO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnom_usu"></p>
                  </div>
                  {!! Form::label('email_usu', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lemail_usu"></p>
                  </div>
                  {!! Form::label('rol_usu', 'ROL DEL USUARIO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lrol_usu"></p>
                  </div>
                  {!! Form::label('descripcion', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lest_usu"></p>
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
         <div class="modal-body">
            <p class="text-center my-2">¿Deseas eliminar este registro?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            {!! Form::button('Si, Eliminar', ['class'=>'btn btn-danger mr-1', 'type'=>'button', 'name' => 'ok_button', 'id' => 'ok_button']) !!}
            {!! Form::button('No, Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
         </div>
      </div>
   </div>
</div>
{{-- ************* /DELETE- MODAL **************** --}}

{{-- ************* RESETEAR PASSWORD **************** --}}
<div class="modal fade font-modal" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false">
   <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-success">
         <div class="modal-header bg-success-light">
            <h5 class="modal-title font-modal text-white">Restablecer Contraseña</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p class="text-center my-2">Deseas restablecer la contraseña?</p>
         </div>
         <div class="modal-footer d-flex justify-content-center">
            {!! Form::button('Si, Restablecer', ['class'=>'btn btn-success mr-1', 'type'=>'button', 'name' => 'reset_button', 'id' => 'reset_button']) !!}
            {!! Form::button('No, Cancelar', ['class'=>'btn btn-light', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
         </div>
      </div>
   </div>
</div>
{{-- ************* /DELETE- MODAL **************** --}}

@endsection


@section('script')
<script src="{{ asset('scripts/script_usuarios.js') }}"></script>

@endsection
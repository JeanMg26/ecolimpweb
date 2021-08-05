@extends('main')

@section('titulo')
Empleados
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fad fa-user-tie mr-2"></i>Empleados</span></li>
</ol>

@can('PERSONAL-CREAR')
<div class="col-12" align="right">
   <a href="{{ route('empleados.create') }}" class="btn btn-success mb-3">
      <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
   </a>
</div>
@endcan


{{-- *********** TABLE CARD ************** --}}
<div class="col-xl-12">
   <div class="card font-table">
      <div class="card-body">

         <table id="tabla_empleados" class="table table-sm table-hover table-bordered text-nowrap font-table w-100">
            <thead>
               <tr class="bg-light-blue">
                  <th colspan="9" class="text-center py-3">
                     <h4 class="font-weight-bold mb-0" style="color: #1f4173">PERSONAL REGISTRADO</h4>
                  </th>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td><input colspan="1" class="form-control filter" id="buscar_columna2" placeholder="BUSCAR POR NOMBRE"></td>
                  <td><input colspan="1" class="form-control filter" id="buscar_columna3" placeholder="BUSCAR POR CELULAR"></td>
                  <td class="text-center pr-1" id="parent"> {!! Form::select('rol', ['' => ''] + $rol, null, ['class' => 'form-control', 'id' => 'buscar_select4']) !!} </td>
                  <td colspan="2" class="text-center">
                     <button type="button" class="btn btn-light" id="btn-filtro"><i class="far fa-broom mr-2"></i>Borrar Filtro</button>
                  </td>
               </tr>
               <tr class="text-center bg-light-blue">
                  <th class="py-2" width="5%%">Nº</th>
                  <th class="py-2" width="10%">IMAGEN</th>
                  <th class="py-2" width="20%">NOMBRES</th>
                  <th class="py-2" width="10%%">CELULAR</th>
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
<div class="modal fade pr-0" id="showModal" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content border-primary">
         <div class="modal-header bg-light-blue">
            <h5 class="modal-title font-modal text-center font-weight-bold">DETALLES DEL REGISTRO</h5>
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
                  {!! Form::label('descripcion', 'TIPO DE DOCUMENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="ltipodoc_emp"></p>
                  </div>

                  {!! Form::label('nrodoc', 'NÚMERO DE DOCUMENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnrodoc_emp"></p>
                  </div>

                  {!! Form::label('completos', 'NOMBRES Y APELLIDOS:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 mb-0">
                     <p class="mb-2" id="lcomp_emp"></p>
                  </div>

                  {!! Form::label('cargo', 'CARGO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lcargo_emp"></p>
                  </div>

                  {!! Form::label('email', 'EMAIL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lemail_emp"></p>
                  </div>

                  {!! Form::label('genero', 'GENERO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lgen_emp"></p>
                  </div>

                  {!! Form::label('fec_nac', 'FEC. NACIMIENTO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lfec_nac"></p>
                  </div>


                  {!! Form::label('celular', 'NRO. CELULAR:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lcelu_emp"></p>
                  </div>

                  {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lest_emp"></p>
                  </div>

                  <div class="col-12">
                     <hr class="mt-1">
                  </div>

                  {!! Form::label('nom_usu', 'NOMBRE DE USUARIO INICIAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lnom_usu"></p>
                  </div>

                  {!! Form::label('pass_usu', 'CONTRASEÑA INICIAL:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                  <div class="col-12 col-md-7 ">
                     <p class="mb-2" id="lpass_usu"></p>
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

<script src="{{ asset('scripts/script_empleados.js') }}"></script>

@endsection
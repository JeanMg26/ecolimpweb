@extends('main')

@section('titulo')
Roles
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fad fa-user-unlock mr-1"></i>Roles</span></li>
</ol>


<div class="row">
   @can('ROL-CREAR')
   <div class="col-12" align="right">
      <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">
         <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
      </a>
   </div>
   @endcan

   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">

            <table id="tabla_roles" class="table table-sm table-hover table-bordered font-table text-nowrap w-100">
               <thead>
                  <tr class="bg-light-blue">
                     <th colspan="4" class="text-center py-3">
                        <h4 class="font-weight-bold mb-0" style="color: #1f4173">ROLES REGISTRADOS</h4>
                     </th>
                  </tr>
                  <tr>
                     <td colspan="1"></td>
                     <td colspan="1"><input class="form-control alfanumerico" id="buscar_columna1" placeholder="BUSCAR POR ROL"></td>
                     <td colspan="2"></td>
                  </tr>

                  <tr class="text-center bg-light-blue">
                     <th class="py-2" scope="col">Nº</th>
                     <th class="py-2" scope="col">DESCRIPCIÓN</th>
                     <th class="py-2" scope="col">ESTADO</th>
                     <th class="py-2" scope="col">ACCIONES</th>
                  </tr>
               </thead>
               <tbody class="text-center"></tbody>
            </table>

         </div>
      </div>
   </div>
   {{-- *********** /TABLE CARD ************** --}}

   {{-- *********** MOSTRAR - MODAL ************** --}}
   <div class="modal fade font-card rol px-0" id="showModal">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content border-primary">
            <div class="modal-header bg-light-blue">
               <h5 class="modal-title font-weight-bold">DETALLES DEL REGISTRO</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12">
               <div class="form-group row d-flex justify-content-center">

                  <div class="col-12 row mt-3 mt-md-0">

                     <div class="col-12 col-sm-6 col-md-7 row my-2">
                        {!! Form::label('nombre', 'NOMBRE:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                        <div class="col-12 col-md-7 mb-0">
                           <p class="mb-2" id="lnom_rol"></p>
                        </div>
                     </div>
                     <div class="col-12 col-sm-6 col-md-5 row my-2">
                        {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0']) !!}
                        <div class="col-12 col-md-7 ">
                           <p class="mb-2" id="lest_rol"></p>
                        </div>
                     </div>

                     <div class="col-12 mt-2">
                        <div class="card card-border">
                           <div class="card-header bg-gris text-center font-weight-bold">PERMISOS</div>
                           {{-- <div class="row" id="permisos"></div> --}}
                           <div id="permisito" class="card-body font-permisos row"></div>

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
         <div class="modal-content border-primary">
            <div class="modal-header bg-danger">
               <h5 class="modal-title text-white">ELIMINAR REGISTRO</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body my-2">
               <p class="text-center mb-0">¿Deseas eliminar este registro?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
               {!! Form::button('Si, Eliminar', ['class' => 'btn btn-danger mr-1', 'type' => 'button', 'name' => 'ok_button', 'id' =>
               'ok_button']) !!}
               {!! Form::button('No, Cancelar', ['class' => 'btn btn-light ml-1', 'type' => 'button', 'data-bs-dismiss' =>
               'modal']) !!}
            </div>
         </div>
      </div>
   </div>
   {{-- ************* /DELETE- MODAL **************** --}}


</div>



@endsection

@section('script')

<script src="{{ asset('scripts/script_roles.js') }}"></script>

@endsection
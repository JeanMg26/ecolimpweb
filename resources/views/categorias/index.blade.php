@extends('main')

@section('titulo')
Categoria
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><span><i class="fad fa-user-shield mr-1"></i>Categorias</span></li>
</ol>

<div class="row mt-3">
   @can('CATEGORIA-CREAR')
   <div class="col-12" align="right">
      <button type="button" class="btn btn-success mb-3" id="crear_registro">
         <span class="btn-label"><i class="fad fa-plus-circle mr-2"></i></span>Nuevo Registro
      </button>
   </div>
   @endcan

   {{-- *********** TABLE CARD ************** --}}
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">

            <table id="tabla_categorias" class="table table-sm table-hover table-bordered font-table text-nowrap w-100">
               <thead class="bg-light-blue">
                  <tr class="bg-light-blue">
                     <th colspan="9" class="text-center py-3">
                        <h4 class="font-weight-bold mb-0" style="color: #1f4173">CATEGORIAS REGISTRADAS</h4>
                     </th>
                  </tr>
                  <tr class="text-center ">
                     <th class="py-2" scope="col">Nº</th>
                     <th class="py-2" scope="col">NOMBRE</th>
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


   {{-- *********** AGREGAR/EDITAR - MODAL ************** --}}
   <div class="modal fade font-modal px-0" id="modalCategoria">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-primary">
            <div class="modal-header bg-light-blue">
               <h5 class="modal-title font-weight-bold">NUEVA CATEGORIA</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="post" id="form-categoria">
               @csrf
               <div class="d-flex justify-content-center">
                  <div class="col-12 col-sm-10 col-md-10">
                     <div class="modal-body col-12 pb-2 pt-4">
                        <div class="form-group row mb-2">
                           {!! Html::decode(Form::label('nombre', 'NOMBRE: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3'])) !!}
                           <div class="col-12 col-md-9">
                              {!! Form::text('nom_categoria', null, ['class' => 'form-control alfanumerico' , 'id' => 'nom_categoria', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DE LA CATEGORIA']) !!}
                              <div class="alert alert-danger py-0 mb-0 mt-2 d-none font-alert" id="nom_categoria-error"></div>
                           </div>
                        </div>

                        <div class="form-group row mb-2">
                           {!! Html::decode(Form::label('estado', 'ESTADO: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3'])) !!}
                           <div class="col-12 col-md-9">
                              {!! Form::select('est_categoria', ['1' => 'HABILITADO','0' => 'INHABILITADO'], null, ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_categoria']) !!}
                              <div class="alert alert-danger py-0 mb-0 mt-2 d-none font-alert" id="est_categoria-error"></div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
               <div class="modal-footer text-center">
                  {!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
                  {!! Form::hidden('categoria_id', null, ['id' => 'categoria_id']) !!}
                  {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success mr-1 action_button', 'type'=>'submit']) !!}
                  {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
               </div>
            </form>
         </div>
      </div>
   </div>
   {{-- *********** /AGREGAR/EDITAR - MODAL ************** --}}

   {{-- *********** MOSTRAR - MODAL ************** --}}
   <div class="modal fade font-modal px-0" id="showModal">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-primary">
            <div class="modal-header bg-light-blue">
               <h5 class="modal-title font-weight-bold">DETALLE DEL REGISTRO</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body col-12 my-2">
               <div class="form-group row d-flex justify-content-center">

                  <div class="col-12 col-md-10 row mt-3 mt-md-0">
                     {!! Form::label('nom_cat', 'NOMBRE DE LA CATEGORIA:', ['class' => 'col-12 col-sm-6 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-6 ">
                        <p class="mb-2" id="lnom_cat"></p>
                     </div>

                     {!! Form::label('estado', 'ESTADO:', ['class' => 'col-12 col-sm-6 font-weight-bold mb-0']) !!}
                     <div class="col-12 col-sm-6 ">
                        <p class="mb-2" id="lest_cat"></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- *********** /MOSTRAR - MODAL ************** --}}


   {{-- ************* ELIMINAR - MODAL **************** --}}
   <div class="modal fade font-modal px-0" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-sm">
         <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
               <h5 class="modal-title text-white">Eliminar Categoria</h5>
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
<script src="{{ asset('scripts/script_categorias.js') }}"></script>
@endsection
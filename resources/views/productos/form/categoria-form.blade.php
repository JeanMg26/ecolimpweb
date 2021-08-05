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




         {{-- <form method="post" id="form-categoria"> --}}
         {{-- @csrf --}}
         <div class="d-flex justify-content-center">
            <div class="col-12 col-sm-10 col-md-10">
               <div class="modal-body col-12 pb-2 pt-4">
                  <div class="form-group row mb-2">
                     {!! Html::decode(Form::label('nombre', 'NOMBRE: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3'])) !!}
                     <div class="col-12 col-md-9">
                        {!! Form::text('nom_categoria', null, ['class' => 'form-control' , 'id' => 'nom_categoria', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DE LA CATEGORIA']) !!}
                        <div class="alert alert-danger py-0 mb-0 mt-2 d-none font-alert" id="nom_categoria-error"></div>
                     </div>
                  </div>

                  <div class="form-group row mb-2">
                     {!! Html::decode(Form::label('estado', 'ESTADO: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label col-12 col-md-3'])) !!}
                     <div class="col-12 col-md-9">
                        {!! Form::select('est_categoria', ['1' => 'HABILITADO','0' => 'INHABILITADO'], '1', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_categoria']) !!}
                        <div class="alert alert-danger py-0 mb-0 mt-2 d-none font-alert" id="est_categoria-error"></div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
         <div class="modal-footer text-center">
            {!! Form::hidden('action', 'Agregar', ['id' => 'action']) !!}
            {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success mr-1 action_button', 'type'=>'button', 'id' => 'nueva_cat']) !!}
            {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button', 'data-bs-dismiss' => 'modal']) !!}
         </div>
         {{-- </form> --}}
      </div>
   </div>
</div>
{{-- *********** /AGREGAR/EDITAR - MODAL ************** --}}
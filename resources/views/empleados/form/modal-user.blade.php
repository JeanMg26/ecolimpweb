{{-- *********** MODAL - MOSTRAR USUARIO ************** --}}
<div class="modal fade font-modal" id="viewUser" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-info">
         <div class="modal-header bg-info">
            <h5 class="modal-title font-modal text-white text-center font-weight-bold">DATOS DEL USUARIO</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body col-12">
            <div class="form-group row d-flex justify-content-center">

               <div class="col-12 col-md-11 row">
                  {!! Form::label('descripcion', 'USUARIO:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0 mt-1']) !!}
                  <div class="col-12 col-md-7">
                     <p class="mb-2" id="usuario"></p>
                  </div>

                  {!! Form::label('completos', 'CONTRASEÑA:', ['class' => 'col-12 col-md-5 font-weight-bold mb-0 mt-1']) !!}
                  <div class="col-12 col-md-7 mb-0">
                     <p class="mb-2" id="clave"></p>
                  </div>

               </div>

            </div>
         </div>

         <div class="card-footer text-center">
            {!! Form::button('<i class="far fa-check mr-1"></i>Aceptar', ['class'=>'btn btn-info mr-1', 'type'=>'submit']) !!}
         </div>
      </div>
   </div>
</div>
{{-- *********** /AGREGAR - MODAL ************** --}}
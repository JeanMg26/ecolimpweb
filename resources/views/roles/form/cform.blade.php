<div class="row">

   <div class="col-12 col-lg-6 mb-sm-2 mb-lg-0">
      <div class="form-group row{{ $errors->has('nom_rol') ? ' has-error' : '' }}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>',
         ['class' => 'font-weight-bold col-form-label col-12 col-sm-3 col-md-4 col-xl-3'])) !!}
         <div class="col-12 col-sm-9 col-md-8 col-xl-9">
            {!! Form::text('nom_rol', null, ['class' => 'form-control alfanumerico', 'id' => 'nom_rol', 'placeholder' => 'DESCRIPCIÓN',
            'autofocus', 'autocomplete' => 'off']) !!}
            @include('roles.alertas.nom_rol-request')

         </div>
      </div>
   </div>

   <div class="col-12 col-lg-6">
      <div class="form-group row">
         {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>',
         ['class' => 'font-weight-bold col-form-label col-12 col-sm-3 col-md-4 col-xl-3'])) !!}
         <div class="col-12 col-sm-9 col-md-8 col-xl-9 {{ $errors->has('est_rol') ? ' has-error-select2' : '' }}">
            {!! Form::select('est_rol', ['1' => 'HABILITADO', '0' => 'DESHABILITADO'], '1', [
            'class' => 'form-control', 'placeholder' => 'SELECCIONAR...', 'id' => 'est_rol' ]) !!}
            @include('roles.alertas.est_rol-request')
         </div>
      </div>
   </div>

   <div class="col-12">
      <hr>
   </div>

   <div class="col-12">
      <div class="form-group row">
         <div class="col-12 mt-2">
            <div class="card card-border mb-0 {{ $errors->has('permisos') ? 'has-error-card' : '' }}">
               <div class="card-header bg-gris font-weight-bold">Permisos
               </div>
               <div class="card-body font-permisos row">

                  @foreach ($collection as $module => $permisos)
                  <div class="col-6 col-sm-4 col-lg-3">
                     <p class="font-weight-bold">{{ $module }}</p>
                     <ul class="list-unstyled">
                        @foreach ($permisos as $permiso)
                        <li class="mb-2">
                           {{ Form::checkbox('permisos[]', $permiso->id, false, ['class' => 'toggle-one', 'data-size' => 'xs', 'data-onstyle' => 'success', 'data-offstyle' => 'danger']) }}
                           {{ $permiso->nombre }}
                        </li>
                        @endforeach
                     </ul>
                  </div>
                  @endforeach

               </div>
            </div>
            @include('roles.alertas.permiso-request')
            <div id="error-permiso-query"></div>
         </div>
      </div>
   </div>
</div>
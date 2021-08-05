{{-- ************* CARGAR IMAGEN ************ --}}
<div class="row mb-0">
   <div class="col-12 col-lg-3 d-flex justify-content-center align-items-center">
      <div class="row d-flex justify-content-center">
         <div class="col-12 col-md-11 col-lg-10 text-center">
            <a onclick="$('#miImagenInput').click()" id="mostrar_imagen">
               <img class="img-fluid" width="150" id="mi_img" src="{{ url('/img/user.jpg') }}">
            </a>
            <div class="text-center font-mini">
               {!! Html::decode(Form::label('aviso', 'Máximo 1MB (1024KB)', ['class' => 'font-weight-bold mt-2'])) !!}
               @include('empleados.alertas.imagen_emp-request')
            </div>
            {{-- ***** BOTON DE SUBIR IMAGEN ***** --}}
            <div class="text-center mt-2">
               {!! Html::decode(Form::label('miImagenInput', '<i class="fas fa-cloud-upload-alt"></i> Subir Imagen', ['class' => 'btn btn-success py-1'])) !!}
               {!! Form::file('imagen_emp', ['class' => 'custom-file-input subir', 'id' => 'miImagenInput', 'style' => 'display:none', 'accept' => 'image/x-png,image/jpeg']) !!}
            </div>
         </div>
      </div>
   </div>

   <div class="col-12 col-lg-9">
      <div class="row">
         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('tipodoc_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('tipodocumento', 'Tipo de Documento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold ledit'])) !!}
            {!! Form::select('tipodoc_emp', ['CARNET DE EXTRANJERIA' => 'CARNET DE EXTRANJERIA', 'RUN' => 'RUN'], null, ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'tipodoc_emp', 'autofocus']) !!}
            @include('empleados.alertas.tipodoc_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md- col-lg-4 mt-2">
            {!! Html::decode(Form::label('nrodoc', 'Nro de RUN <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('nrodoc_emp') ? ' has-error' : ''}}">
               {!! Form::text('nrodoc_emp', null, ['class' => 'form-control numeros2', 'placeholder' => 'NÚMERO RUN', 'maxlength' => '14', 'autocomplete' => 'off', 'id' => 'nrodoc_emp']) !!}
               <div class="input-group-text">
                  <i class="fal fa-id-card"></i>
               </div>
            </div>
            @include('empleados.alertas.nrodoc_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md- col-lg-4 mt-2">
            {!! Html::decode(Form::label('nacimiento', 'Fec. Nacimiento <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('fec_nac') ? ' has-error' : ''}}">
               {!! Form::text('fec_nac', null, ['class' => 'form-control input_blanco', 'placeholder' => 'DD-MM-YYYY', 'maxlength' => '10', 'autocomplete' => 'off', 'readonly', 'id' => 'fec_nac']) !!}
               <div class="input-group-text">
                  <i class="fal fa-calendar-alt"></i>
               </div>
            </div>
            @include('empleados.alertas.fec_nac-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2{{ $errors->has('nom_emp') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombres <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('nom_emp', null, ['class' => 'form-control letras' , 'placeholder' => 'NOMBRES', 'autocomplete' => 'off', 'maxlength' => '30', 'id' => 'nom_emp']) !!}
            @include('empleados.alertas.nom_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2{{ $errors->has('ape_emp') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('apellido', 'Apellidos <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('ape_emp', null, ['class' => 'form-control letras', 'id' => 'ape_emp', 'placeholder' => 'APELLIDOS', 'autocomplete' => 'off','maxlength' => '30', 'id' => 'ape_emp']) !!}
            @include('empleados.alertas.ape_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-8 mt-2">
            {!! Html::decode(Form::label('email', 'Correo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            <div class="input-group{{ $errors->has('email_emp') ? ' has-error' : ''}}">
               {!! Form::text('email_emp', null, ['class' => 'form-control', 'placeholder' => 'EJEMPLO@ABC.COM', 'autocomplete' => 'off', 'maxlength' => '40', 'id' => 'email_emp']) !!}
               <div class="input-group-text">
                  <i class="fas fa-at"></i>
               </div>
            </div>
            @include('empleados.alertas.email_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('gen_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('genero', 'Género <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('gen_emp', ['M' => 'MASCULINO', 'F' => 'FEMENINO'], null, ['class' => 'form-control form-control-sm', 'placeholder'=> 'SELECCIONAR...', 'id' => 'gen_emp']) !!}
            @include('empleados.alertas.gen_emp-request')
         </div>


         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('cargo_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('cargo', 'Cargo <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('cargo_emp', ['' => ''] + $rol, null, ['class' => 'form-control', 'id' => 'cargo_emp']) !!}
            @include('empleados.alertas.cargo_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2">
            {!! Html::decode(Form::label('celular', 'Celular', ['class' => 'font-weight-bold mt-1'])) !!}
            <div class="input-group{{ $errors->has('cel_emp') ? ' has-error' : ''}}">
               {!! Form::text('cel_emp', null, ['class' => 'form-control numeros', 'placeholder' => '999999999', 'maxlength' => '9', 'autocomplete' => 'off', 'id' => 'cel_emp']) !!}
               <div class="input-group-text">
                  <i class="fas fa-mobile-android-alt"></i>
               </div>
            </div>
            @include('empleados.alertas.cel_emp-request')
         </div>

         <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-2{{ $errors->has('est_emp') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('est_emp', ['1' => 'ACTIVO', '0' => 'INACTIVO'], '1', ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_emp']) !!}
            @include('empleados.alertas.est_emp-request')
         </div>
      </div>
   </div>
</div>
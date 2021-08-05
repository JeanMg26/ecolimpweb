<div class="card border-light-blue mb-3">
   <div class="card-header text-center font-weight-bold">DATOS DEL CENTRO DE COSTO</div>
   <div class="card-body row pt-0">

      <div class="col-12 col-md-8 col-lg-8 mt-2 {{ $errors->has('nom_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
         {!! Form::text('nom_instalacion', isset($instalacion) ? $instalacion->nombre : '', ['class' => 'form-control letras' , 'id' => 'nom_instalacion', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL CENTRO DE COSTO', 'maxlength' => '50' ,'autofocus']) !!}
         @include('instalaciones.alertas.nom_instalacion-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('nrodoc_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nrodoc', 'RUT: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('nrodoc_instalacion', isset($instalacion) ? $instalacion->nrodoc : '', ['class' => 'form-control numeros2' , 'id' => 'nrodoc_instalacion', 'autocomplete' => 'off', 'placeholder' => 'NÚMERO DE RUN', 'maxlength' => '14']) !!}
         @include('instalaciones.alertas.nrodoc_instalacion-request')
      </div>

      <div class="col-12 col-md-6 col-lg-6 mt-2{{ $errors->has('email_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('email_instalacion', isset($instalacion) ? $instalacion->email : '', ['class' => 'form-control' , 'id' => 'email_instalacion', 'autocomplete' => 'off', 'placeholder' => 'EMAIL', 'maxlength' => '50']) !!}
         @include('instalaciones.alertas.email_instalacion-request')
      </div>

      <div class="col-12 col-md-3 col-lg-3 mt-2{{ $errors->has('tel_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('telefono', 'Telefóno:', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('tel_instalacion', isset($instalacion) ? $instalacion->telefono : '', ['class' => 'form-control numeros' , 'id' => 'tel_instalacion', 'autocomplete' => 'off', 'placeholder' => 'TELÉFONO', 'maxlength' => '9']) !!}
         @include('instalaciones.alertas.tel_instalacion-request')
      </div>

      {{-- **************** REGION - PROVINCIA - COMUNA **************** --}}

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('region') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('region', 'Región: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('region', $region, isset($instalacion) ? $instalacion->regiones_id : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'region']) !!}
         @include('instalaciones.alertas.region-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('provincia') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('provincia', 'Provincia: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('provincia', $provincia, isset($instalacion) ? $instalacion->provincias_id : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'provincia', 'data-old' => $instalacion->provincias_id]) !!}
         @include('instalaciones.alertas.provincia-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('comuna') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('comuna', 'Comuna: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('comuna', $comuna, null, ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'comuna', 'data-old' => $instalacion->comunas_id]) !!}
         @include('instalaciones.alertas.comuna-request')
      </div>

      {{-- **************** /FIN - REGION - PROVINCIA - COMUNA **************** --}}

      <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('dir_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('direccion', 'Dirección: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('dir_instalacion', isset($instalacion) ? $instalacion->direccion : '', ['class' => 'form-control alfanumerico2' , 'id' => 'dir_instalacion', 'autocomplete' => 'off', 'placeholder' => 'DIRECCIÓN', 'maxlength' => '50']) !!}
         @include('instalaciones.alertas.dir_instalacion-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('est_instalacion') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('est_instalacion', ['1' => 'HABILITADO','0' => 'INHABILITADO'], isset($instalacion) ? $instalacion->estado : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_instalacion']) !!}
         @include('instalaciones.alertas.est_instalacion-request')
      </div>

   </div>
</div>

<div class="card border-light-blue mb-0">
   <div class="card-header text-center font-weight-bold">DATOS DEL CONTACTO</div>
   <div class="card-body row pt-0">

      <div class="col-12 col-md-12 col-lg-12 mt-2{{ $errors->has('nom_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('nom_contacto', isset($instalacion) ? $instalacion->nom_contacto : '', ['class' => 'form-control letras' , 'id' => 'nom_contacto', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL CONTACTO', 'maxlength' => '40']) !!}
         @include('instalaciones.alertas.nom_contacto-request')
      </div>

      <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('email_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('email_contacto', isset($instalacion) ? $instalacion->email_contacto : '', ['class' => 'form-control' , 'id' => 'email_contacto', 'autocomplete' => 'off', 'placeholder' => 'EMAIL DEL CONTACTO', 'maxlength' => '50']) !!}
         @include('instalaciones.alertas.email_contacto-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('cel_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('celular', 'Celular:', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('cel_contacto', isset($instalacion) ? $instalacion->cel_contacto : '', ['class' => 'form-control numeros' , 'id' => 'cel_contacto', 'autocomplete' => 'off', 'placeholder' => 'CELULAR DEL CONTACTO', 'maxlength' => '9']) !!}
         @include('instalaciones.alertas.cel_contacto-request')
      </div>

   </div>
</div>
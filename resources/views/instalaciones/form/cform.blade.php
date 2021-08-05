<ul class="nav nav-tabs" id="myTab" role="tablist">
   <li class="nav-item" role="presentation">
      <button class="nav-link  tab-button active" id="instalacion-tab" data-bs-toggle="tab" data-bs-target="#instalacion" type="button" role="tab" aria-controls="home" aria-selected="true">Centro de Costo</button>
   </li>
   <li class="nav-item" role="presentation">
      <button class="nav-link tab-button" id="contacto-tab" data-bs-toggle="tab" data-bs-target="#contacto" type="button" role="tab" aria-controls="profile" aria-selected="false">Contacto</button>
   </li>
</ul>

<div class="tab-content" id="myTabContent">
   {{-- ***************** CENTRO DE COSTO **************** --}}
   <div class="tab-pane fade show active px-4" id="instalacion" role="instalacion" aria-labelledby="home-tab">
      <div class="row pt-4 pb-5">

         <div class="col-12 col-md-12 col-lg-12 col-xl-6 mt-2 {{ $errors->has('nom_instalacion') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('nom_instalacion', null, ['class' => 'form-control alfanumerico' , 'id' => 'nom_instalacion', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL CENTRO DE COSTO', 'maxlength' => '50' ,'autofocus']) !!}
            @include('instalaciones.alertas.nom_instalacion-request')
         </div>

         <div class="col-12 col-md-8 col-lg-8 col-xl-6 mt-2 {{ $errors->has('nom_fantasia') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre de Fantasía:', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('nom_fantasia', null, ['class' => 'form-control alfanumerico' , 'id' => 'nom_fantasia', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DE FANTASIA', 'maxlength' => '50' ,'autofocus']) !!}
            @include('instalaciones.alertas.nom_fantasia-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 col-xl-3 mt-2{{ $errors->has('nrodoc_instalacion') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('nrodoc', 'RUT: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group">
               {!! Form::text('nrodoc_instalacion', null, ['class' => 'form-control numeros2' , 'id' => 'nrodoc_instalacion', 'autocomplete' => 'off', 'placeholder' => 'NÚMERO DE RUN', 'maxlength' => '12']) !!}
               <div class="input-group-text">
                  <i class="fal fa-id-card"></i>
               </div>
            </div>
            @include('instalaciones.alertas.nrodoc_instalacion-request')
         </div>

         <div class="col-12 col-md-8 col-lg-8 col-xl-6 mt-2">
            {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group {{ $errors->has('email_instalacion') ? ' has-error-select2' : ''}}">
               {!! Form::text('email_instalacion', null, ['class' => 'form-control' , 'id' => 'email_instalacion', 'autocomplete' => 'off', 'placeholder' => 'EMAIL', 'maxlength' => '50']) !!}
               <div class="input-group-text">
                  <i class="fas fa-at"></i>
               </div>
            </div>
            @include('instalaciones.alertas.email_instalacion-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 col-xl-3 mt-2">
            {!! Html::decode(Form::label('telefono', 'Telefono:', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group {{ $errors->has('cel_instalacion') ? ' has-error-select2' : ''}}">
               {!! Form::text('tel_instalacion', null, ['class' => 'form-control numeros' , 'id' => 'tel_instalacion', 'autocomplete' => 'off', 'placeholder' => 'TELÉFONO', 'maxlength' => '9']) !!}
               <div class="input-group-text">
                  <i class="fas fa-mobile-android-alt"></i>
               </div>
            </div>
            @include('instalaciones.alertas.tel_instalacion-request')
         </div>

         {{-- **************** REGION - PROVINCIA - COMUNA **************** --}}

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('est_proveedor') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('region', 'Región: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            {!! Form::select('region', $region, null, ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'region']) !!}
            @include('instalaciones.alertas.region-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('provincia') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('provincia', 'Provincia: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            {!! Form::select('provincia', [], null, ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'provincia']) !!}
            {!! Form::hidden('provincia_id', null, ['class' => 'form-control', 'id' => 'provincia_id']) !!}
            @include('instalaciones.alertas.provincia-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('comuna') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('comuna', 'Comuna: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            {!! Form::select('comuna', [], null, ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'comuna']) !!}
            {!! Form::hidden('comuna_id', null, ['class' => 'form-control', 'id' => 'comuna_id']) !!}
            @include('instalaciones.alertas.comuna-request')
         </div>

         {{-- **************** /FIN - REGION - PROVINCIA - COMUNA **************** --}}

         <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('dir_instalacion') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('direccion', 'Dirección: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group">
               {!! Form::text('dir_instalacion', null, ['class' => 'form-control alfanumerico2' , 'id' => 'dir_instalacion', 'autocomplete' => 'off', 'placeholder' => 'DIRECCIÓN', 'maxlength' => '50']) !!}
               <div class="input-group-text">
                  <i class="fal fa-street-view"></i>
               </div>
            </div>
            @include('instalaciones.alertas.dir_instalacion-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('est_instalacion') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            {!! Form::select('est_instalacion', ['1' => 'HABILITADO','0' => 'INHABILITADO'], '1', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_instalacion']) !!}
            @include('instalaciones.alertas.est_instalacion-request')
         </div>

      </div>
   </div>


   {{-- *************** CONTACTO *************** --}}
   <div class="tab-pane fade px-4" id="contacto" role="contacto" aria-labelledby="profile-tab">
      <div class=" row pt-4 pb-5">

         <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('nom_contacto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            {!! Form::text('nom_contacto', null, ['class' => 'form-control letras' , 'id' => 'nom_contacto', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL CONTACTO', 'maxlength' => '40']) !!}
            @include('instalaciones.alertas.nom_contacto-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('nrodoc_contacto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('nrodoc', 'RUT:', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group">
               {!! Form::text('nrodoc_contacto', null, ['class' => 'form-control numeros2' , 'id' => 'nrodoc_contacto', 'autocomplete' => 'off', 'placeholder' => 'NÚMERO DE RUN', 'maxlength' => '12']) !!}
               <div class="input-group-text">
                  <i class="fal fa-id-card"></i>
               </div>
            </div>
            @include('instalaciones.alertas.nrodoc_contacto-request')
         </div>

         <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('email_contacto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group">
               {!! Form::text('email_contacto', null, ['class' => 'form-control' , 'id' => 'email_contacto', 'autocomplete' => 'off', 'placeholder' => 'EMAIL DEL CONTACTO', 'maxlength' => '50']) !!}
               <div class="input-group-text">
                  <i class="fas fa-at"></i>
               </div>
            </div>
            @include('instalaciones.alertas.email_contacto-request')
         </div>

         <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('cel_contacto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('celular', 'Celular:', ['class' => 'font-weight-bold col-form-label'])) !!}
            <div class="input-group">
               {!! Form::text('cel_contacto', null, ['class' => 'form-control numeros' , 'id' => 'cel_contacto', 'autocomplete' => 'off', 'placeholder' => 'CELULAR DEL CONTACTO', 'maxlength' => '9']) !!}
               <div class="input-group-text">
                  <i class="fas fa-mobile-android-alt"></i>
               </div>
            </div>
            @include('instalaciones.alertas.cel_contacto-request')
         </div>

      </div>
   </div>
</div>
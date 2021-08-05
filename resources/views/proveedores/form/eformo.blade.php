<div class="card border-light-blue mb-3">
   <div class="card-header text-center font-weight-bold">DATOS DEL PROVEEDOR</div>
   <div class="card-body row pt-0">


      <div class="col-12 col-md-12 col-lg-6 col-xl-6 mt-2 {{ $errors->has('nom_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
         {!! Form::text('nom_proveedor', isset($proveedor) ? $proveedor->nombre : '', ['class' => 'form-control alfanumerico' , 'id' => 'nom_proveedor', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL PROVEEDOR', 'autofocus', 'maxlength' => '50']) !!}
         @include('proveedores.alertas.nom_proveedor-request')
      </div>

      <div class="col-12 col-md-8 col-lg-6 col-xl-6 mt-2 {{ $errors->has('nom_fantasia') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre de Fantasia: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
         {!! Form::text('nom_fantasia', isset($proveedor) ? $proveedor->nom_fantasia : '', ['class' => 'form-control alfanumerico' , 'id' => 'nom_fantasia', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DE FANTASIA', 'maxlength' => '50']) !!}
         @include('proveedores.alertas.nom_fantasia-request')
      </div>

      <div class="col-12 col-md-4 col-lg-3 col-xl-3 mt-2{{ $errors->has('nrodoc_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nrodoc', 'RUN: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('nrodoc_proveedor', isset($proveedor) ? $proveedor->nrodoc : '', ['class' => 'form-control numeros2' , 'id' => 'nrodoc_proveedor', 'autocomplete' => 'off', 'placeholder' => 'NÚMERO DE RUN', 'maxlength' => '14']) !!}
         @include('proveedores.alertas.nrodoc_proveedor-request')
      </div>

      <div class="col-12 col-md-4 col-lg-3 col-xl-3 mt-2{{ $errors->has('cel_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('celular', 'Celular:', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('cel_proveedor', isset($proveedor) ? $proveedor->celular : '', ['class' => 'form-control numeros' , 'id' => 'cel_proveedor', 'autocomplete' => 'off', 'placeholder' => 'CELULAR', 'maxlength' => '9']) !!}
         @include('proveedores.alertas.cel_proveedor-request')
      </div>


      <div class="col-12 col-md-8 col-lg-6 col-xl-6 mt-2{{ $errors->has('email_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('email_proveedor', isset($proveedor) ? $proveedor->email : '', ['class' => 'form-control' , 'id' => 'email_proveedor', 'autocomplete' => 'off', 'placeholder' => 'EMAIL', 'maxlength' => '50']) !!}
         @include('proveedores.alertas.email_proveedor-request')
      </div>

      {{-- **************** REGION - PROVINCIA - COMUNA **************** --}}

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('region') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('region', 'Región: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('region', $region, isset($proveedor) ? $proveedor->regiones_id : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'region']) !!}
         @include('proveedores.alertas.region-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('provincia') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('provincia', 'Provincia: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('provincia', [], isset($proveedor) ? $proveedor->provincias_id : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'provincia', 'data-old' => $proveedor->provincias_id]) !!}
         @include('proveedores.alertas.provincia-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('comuna') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('comuna', 'Comuna: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('comuna', [], isset($proveedor) ? $proveedor->comunas_id : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'comuna', 'data-old' => $proveedor->comunas_id]) !!}
         @include('proveedores.alertas.comuna-request')
      </div>

      {{-- **************** /FIN - REGION - PROVINCIA - COMUNA **************** --}}

      <div class="col-12 col-md-8 col-lg-8 col-xl-9 mt-2{{ $errors->has('dir_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('direccion', 'Dirección: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('dir_proveedor', isset($proveedor) ? $proveedor->direccion : '', ['class' => 'form-control alfanumerico2' , 'id' => 'dir_proveedor', 'autocomplete' => 'off', 'placeholder' => 'DIRECCIÓN', 'maxlength' => '50']) !!}
         @include('proveedores.alertas.dir_proveedor-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 col-xl-3 mt-2{{ $errors->has('est_proveedor') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('estado', 'Estado: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::select('est_proveedor', ['1' => 'HABILITADO','0' => 'INHABILITADO'], isset($proveedor) ? $proveedor->estado : '', ['class' => 'form-select', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_proveedor']) !!}
         @include('proveedores.alertas.est_proveedor-request')
      </div>

   </div>
</div>

<div class="card border-light-blue mb-0">
   <div class="card-header text-center font-weight-bold">DATOS DEL CONTACTO</div>
   <div class="card-body row pt-0">

      <div class="col-12 col-md-12 col-lg-12 mt-2{{ $errors->has('nom_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('nombre', 'Nombre: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('nom_contacto', isset($proveedor) ? $proveedor->nom_contacto : '', ['class' => 'form-control letras letras' , 'id' => 'nom_contacto', 'autocomplete' => 'off', 'placeholder' => 'NOMBRE DEL CONTACTO', 'maxlength' => '40']) !!}
         @include('proveedores.alertas.nom_contacto-request')
      </div>

      <div class="col-12 col-md-8 col-lg-8 mt-2{{ $errors->has('email_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('email', 'Email: <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('email_contacto', isset($proveedor) ? $proveedor->email_contacto : '', ['class' => 'form-control' , 'id' => 'email_contacto', 'autocomplete' => 'off', 'placeholder' => 'EMAIL DEL CONTACTO', 'maxlength' => '50']) !!}
         @include('proveedores.alertas.email_contacto-request')
      </div>

      <div class="col-12 col-md-4 col-lg-4 mt-2{{ $errors->has('cel_contacto') ? ' has-error-select2' : ''}}">
         {!! Html::decode(Form::label('celular', 'Celular:', ['class' => 'font-weight-bold col-form-label'])) !!}
         {!! Form::text('cel_contacto', isset($proveedor) ? $proveedor->cel_contacto : '', ['class' => 'form-control numeros' , 'id' => 'cel_contacto', 'autocomplete' => 'off', 'placeholder' => 'CELULAR DEL CONTACTO', 'maxlength' => '9']) !!}
         @include('proveedores.alertas.cel_contacto-request')
      </div>

   </div>
</div>
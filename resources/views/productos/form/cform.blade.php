<div class="row mb-0">
   <div class="col-12 col-md-4 col-lg-4 col-xl-3 d-flex justify-content-center align-items-center">
      <div class="row d-flex justify-content-center">
         <div class="col-12 col-md-11 col-lg-10 text-center">
            <a onclick="$('#miImagenInput').click()" id="mostrar_imagen">
               <img class="img-fluid" width="170" id="mi_img" src="{{ url('/img/product.png') }}">
            </a>
            <div class="text-center font-mini">
               {!! Html::decode(Form::label('aviso', 'Máximo 1MB (1024KB)', ['class' => 'mt-2'])) !!}
               @include('productos.alertas.img_producto-request')
            </div>
            {{-- ***** BOTON DE SUBIR IMAGEN ***** --}}
            <div class="text-center">
               {!! Html::decode(Form::label('miImagenInput', '<i class="fas fa-cloud-upload-alt"></i> Subir Imagen', ['class' => 'btn btn-success py-1', 'style' => 'cursor:pointer'])) !!}
               {!! Form::file('img_producto', ['class' => 'custom-file-input subir', 'id' => 'miImagenInput', 'style' => 'display:none', 'accept' => 'image/x-png,image/jpeg']) !!}
            </div>
         </div>
      </div>
   </div>


   <div class="col-12 col-md-8 col-lg-8 col-xl-9">
      <div class="row">
         <div class="col-12 col-sm-7 col-lg-12 col-xl-7 mt-2 mx-0 px-sm-2 row {{ $errors->has('categoria') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('categoria', 'Categoria <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold pl-0'])) !!}
            <div class="col-11 pl-0">
               {!! Form::select('categoria', ['' => 'SELECCIONAR...'] + $categoria, null, ['class' => 'form-control', 'autocomplete' => 'off', 'autofocus']) !!}
            </div>
            <div class="col-1 px-0" style="margin-top: -3px;">
               <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Nueva Categoria" id="crear_registro">
                  <i class="far fa-plus-circle"></i>
               </button>
            </div>

            @include('productos.alertas.categoria-request')
         </div>

         <div class="col-12 col-sm-5 col-lg-12 col-xl-5 mt-2 px-sm-2 px-md-3 px-lg-2 px-xxl-2 {{ $errors->has('cod_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('codigo', 'Código <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('cod_producto', null, ['class' => 'form-control alfanumerico' , 'placeholder' => 'Código del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.cod_producto-request')
         </div>

         <div class="col-12 col-sm-12 col-lg-12 col-xl-12 mt-2 px-sm-2{{ $errors->has('nom_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('nom_producto', null, ['class' => 'form-control alfanumerico' , 'placeholder' => 'Nombre del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.nom_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 col-xl-5 mt-2 px-sm-2{{ $errors->has('presen_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('presentacion', 'Presentación <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('presen_producto', null, ['class' => 'form-control alfanumerico' , 'placeholder' => 'Presentación del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.presen_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 col-xl-4 mt-2 px-sm-2{{ $errors->has('est_producto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('est_producto', ['1' => 'ACTIVO', '0' => 'INACTIVO'], '1', ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_producto']) !!}
            @include('productos.alertas.est_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 col-xl-3 mt-2 px-sm-2{{ $errors->has('est_producto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('cant_minima', 'Cant. Mínima <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('cant_minima',null, ['class' => 'form-control numeros', 'placeholder'=> 'CANT. MÍNIMA', 'autocomplete' => 'off', 'maxlength' => '4']) !!}
            @include('productos.alertas.est_producto-request')
         </div>

         <div class="col-12 col-sm-12 col-lg-12 col-xl-12 mt-2 px-sm-2{{ $errors->has('des_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('descripcion', 'Descripción <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::textarea('des_producto', null, ['class' => 'form-control' , 'placeholder' => 'Descripción del producto', 'autocomplete' => 'off', 'rows' => 4, 'cols' => 40]) !!}
            @include('productos.alertas.des_producto-request')
         </div>




      </div>
   </div>
</div>
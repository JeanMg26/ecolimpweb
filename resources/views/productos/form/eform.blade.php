<div class="row mb-0">
   <div class="col-12 col-lg-3 d-flex justify-content-center align-items-center">
      <div class="row d-flex justify-content-center">
         <div class="col-12 col-md-11 col-lg-10 text-center">
            <a onclick="$('#miImagenInput').click()" id="mostrar_imagen">
               @if ($producto->rutaimagen == "")
               <img class="img-fluid" width="180" id="mi_img" src="{{ url('/img/product.png') }}">
               @else
               <img class="img-fluid" width="180" id="mi_img" src="/uploads/{{$producto->rutaimagen}}">
               @endif
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


   <div class="col-12 col-lg-9">
      <div class="row">
         <div class="col-12 col-sm-6 col-lg-6 mt-2 px-sm-2{{ $errors->has('cat_producto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('categoria', 'Categoria <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::select('categoria', ['' => 'SELECCIONAR...'] + $categoria, isset($producto) ? $producto->categorias_id : '', ['class' => 'form-control', 'autocomplete' => 'off', 'autofocus']) !!}
            @include('productos.alertas.categoria-request')
         </div>
         <div class="col-12 col-sm-6 col-lg-6 mt-2 px-sm-2{{ $errors->has('nom_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('codigo', 'Código <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('cod_producto', isset($producto) ? $producto->codigo : '', ['class' => 'form-control alfanumerico' , 'placeholder' => 'Código del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.cod_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 mt-2 px-sm-2{{ $errors->has('nom_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('nombre', 'Nombre <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('nom_producto', isset($producto) ? $producto->nombre : '', ['class' => 'form-control alfanumerico' , 'placeholder' => 'Nombre del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.nom_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-4 mt-2 px-sm-2{{ $errors->has('nom_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('presentacion', 'Presentación <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::text('presen_producto', isset($producto) ? $producto->presentacion : '', ['class' => 'form-control alfanumerico' , 'placeholder' => 'Presentación del producto', 'autocomplete' => 'off']) !!}
            @include('productos.alertas.presen_producto-request')
         </div>

         <div class="col-12 col-sm-4 col-lg-4 mt-2 px-sm-2{{ $errors->has('est_producto') ? ' has-error-select2' : ''}}">
            {!! Html::decode(Form::label('estado', 'Estado <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::select('est_producto', ['1' => 'ACTIVO', '0' => 'INACTIVO'], isset($producto) ? $producto->estado : '', ['class' => 'form-control', 'placeholder'=> 'SELECCIONAR...', 'id' => 'est_producto']) !!}
            @include('productos.alertas.est_producto-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 col-xl-3 mt-2 px-sm-2{{ $errors->has('cant_minima') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('cant_minima', 'Cant. Mínima <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold mt-1'])) !!}
            {!! Form::text('cant_minima', isset($producto) ? $producto->cant_minima : '', ['class' => 'form-control numeros', 'placeholder'=> 'CANT. MÍNIMA', 'autocomplete' => 'off', 'maxlength' => '4']) !!}
            @include('productos.alertas.cant_minima-request')
         </div>

         <div class="col-12 col-sm-6 col-lg-12 mt-2 px-sm-2{{ $errors->has('nom_producto') ? ' has-error' : ''}}">
            {!! Html::decode(Form::label('descripcion', 'Descripción <span class="text-danger font-weight-normal h6 ml-1">*</span>', ['class' => 'font-weight-bold'])) !!}
            {!! Form::textarea('des_producto', isset($producto) ? $producto->descripcion : '', ['class' => 'form-control' , 'placeholder' => 'Descripción del producto', 'autocomplete' => 'off', 'rows' => 4, 'cols' => 40]) !!}
            @include('productos.alertas.des_producto-request')
         </div>




      </div>
   </div>
</div>
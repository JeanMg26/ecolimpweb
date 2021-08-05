@extends('main')

@section('titulo')
Productos
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><a href="{{ route('productos.index') }}"><i class="fal fa-pump-soap mr-1"></i>Productos</a></li>
   <li class="breadcrumb-item active"><span><i class="far fa-plus mr-1"></i>Agregar</span></li>
</ol>

<div class="card card-default">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::open(['route' => 'productos.store', 'method' => 'POST' , 'class' => 'col-12 col-md-11 col-lg-11 col-xl-10 col-xxl-9', 'files' => true, 'id' => 'form-producto']) !!}
      {!! Form::token() !!}

      @include('productos.form.cform')
      @include('productos.form.categoria-form')

   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
      <a href="{{ route('productos.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>

@endsection

@section('script')
<script src="{{ asset('scripts/script_productosC.js') }}"></script>
@endsection
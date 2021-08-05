@extends('main')

@section('titulo')
Registro de Materiales
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{ route('ingresos.index') }}"><span><i class="fas fa-inbox-in mr-2"></i></span>Registro de Materiales</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="fas fa-plus mr-1"></i></span>Agregar</li>
</ol>

<div class="card card-default">
   <div class="card-body d-flex justify-content-center row mt-3 pb-0">
      {!! Form::open(['route' => 'ingresos.store', 'method' => 'POST' , 'class' => 'col-12 col-md-11 col-lg-12 font-sm', 'files' => true, 'id' => 'form-ingreso']) !!}
      {!! Form::token() !!}

      @include('ingresos.form.cform')

   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success mr-1', 'type' => 'submit', 'id' => 'enviar']) !!}
      <a href="{{ route('ingresos.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_ingresosC.js') }}"></script>
@endsection
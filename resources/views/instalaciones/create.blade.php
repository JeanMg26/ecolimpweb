@extends('main')

@section('titulo')
Centros de Costo
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><a href="{{ route('instalaciones.index') }}"><span><i class="fad fa-store-alt mr-2"></i></span>Centro de Costos</a></li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="fas fa-plus mr-1"></i></span>Agregar</li>
</ol>

<div class="card card-default">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::open(['route' => 'instalaciones.store', 'method' => 'POST' , 'class' => 'col-12 col-md-11 col-xl-10 font-sm', 'files' => true, 'id' => 'form-instalacion']) !!}
      {!! Form::token() !!}

      @include('instalaciones.form.cform')

   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="fas fa-arrow-to-right mr-2"></i>Siguiente', ['class'=>'btn btn-primary next_tab mr-1', 'type' => 'button']) !!}
      {!! Form::button('<i class="fas fa-arrow-to-left mr-2"></i>Atras', ['class'=>'btn btn-primary px-4 d-none back_tab mr-1', 'type' => 'button']) !!}
      {!! Form::button('<i class="fas fa-save mr-2"></i>Guardar', ['class'=>'btn btn-success mr-1', 'type' => 'submit', 'id' => 'btn-action', 'disabled']) !!}
      <a href="{{ route('instalaciones.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_instalacionesC.js') }}"></script>
@endsection
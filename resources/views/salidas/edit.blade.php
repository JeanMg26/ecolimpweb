@extends('main')

@section('titulo')
Entrega de Materiales
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{ route('salidas.index') }}"><span><i class="fas fa-inbox-out mr-2"></i></span>Entrega de Materiales</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="far fa-edit mr-1"></i></span>Actualizar</li>
</ol>

<div class="card card-default">
   <div class="card-body d-flex justify-content-center row mt-3 pb-0">
      {!! Form::open(['method' => 'POST' , 'class' => 'col-12 col-md-11 col-lg-12 font-sm', 'id' => 'form-salida']) !!}
      {!! Form::hidden('id_salida', $salida->id, []) !!}
      {!! Form::token() !!}

      @include('salidas.form.eform')

   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-light-blue mr-1', 'type' => 'submit', 'id' => 'enviar']) !!}
      <a href="{{ route('salidas.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_salidasE.js') }}"></script>
@endsection
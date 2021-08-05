@extends('main')

@section('titulo')
Personal
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i>Inicio</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{ route('empleados.index') }}"><span><i class="fad fa-user-tie mr-2"></i></span>Personal</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="far fa-edit mr-1"></i>Editar</span></li>
</ol>


<div class="card card-default">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::model($empleado, ['route' => ['empleados.update', $empleado->id], 'method' => 'PUT', 'class' => 'col-12 col-md-11 col-xl-11', 'files' => true, 'id' => 'form-empleado']) !!}


      {!! Form::token() !!}

      @include('empleados.form.eform')


   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-light-blue mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
      <a href="{{ route('empleados.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_empleadosE.js') }}"></script>
@endsection
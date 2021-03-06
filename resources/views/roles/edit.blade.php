@extends('main')

@section('titulo')
Roles
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
   <li class="breadcrumb-item">
      <a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
   </li>
   <li class="breadcrumb-item"><a href="{{ route('roles.index') }}"><i class="fad fa-user-lock mr-1"></i>Roles</a></li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="far fa-edit mr-1"></i>Editar</span></li>
</ol>

<div class="card card-default">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::model($rol, ['route' => ['roles.update', $rol->id], 'method' => 'PUT', 'class' => 'col-12 col-md-11 col-xl-10 font-sm', 'id' => 'form-rol']) !!}
      {!! Form::token() !!}

      @include('roles.form.eform')

   </div>

   <div class="card-footer text-center">
      {!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-light-blue mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
      <a href="{{ route('roles.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light ml-1', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>

@endsection

@section('script')
<script src="{{ asset('scripts/script_rolesE.js') }}"></script>
@endsection
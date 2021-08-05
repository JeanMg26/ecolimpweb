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
   <li class="breadcrumb-item">
      <a href="{{ route('proveedores.index') }}"><span><i class="fad fa-user-secret mr-2"></i></span>Proveedores</a>
   </li>
   <li class="breadcrumb-item active" aria-current="page"><span><i class="far fa-edit mr-1"></i>Editar</span></li>
</ol>


<div class="card card-default">
   <div class="card-body d-flex justify-content-center row my-3">
      {!! Form::model($proveedor, ['route' => ['proveedores.update', $proveedor->id], 'method' => 'PUT', 'class' => 'col-12 col-md-11 col-xl-10', 'files' => true, 'id' => 'form-proveedor']) !!}
      {!! Form::token() !!}

      @include('proveedores.form.eform')

   </div>
   <div class="card-footer text-center">
      {!! Form::button('<i class="fas fa-arrow-to-right mr-2"></i>Siguiente', ['class'=>'btn btn-primary next_tab mr-1', 'type' => 'button']) !!}
      {!! Form::button('<i class="fas fa-arrow-to-left mr-2"></i>Atras', ['class'=>'btn btn-primary px-4 d-none back_tab mr-1', 'type' => 'button']) !!}
      {!! Form::button('<i class="far fa-sync-alt mr-2"></i>Actualizar', ['class'=>'btn btn-light-blue mr-1', 'type'=>'submit', 'name' => 'submit', 'value' => 'Aceptar']) !!}
      <a href="{{ route('instalaciones.index') }}">
         {!! Form::button('<i class="fas fa-times mr-2"></i>Cancelar', ['class'=>'btn btn-light', 'type' => 'button']) !!}
      </a>
      {!! Form::close() !!}
   </div>
</div>
@endsection

@section('script')
<script src="{{ asset('scripts/script_proveedoresE.js') }}"></script>
@endsection
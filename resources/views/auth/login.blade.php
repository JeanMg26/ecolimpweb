@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-sm-9 col-md-7 col-lg-6 col-xl-4">
         <div class="card border-light-blue">
            <div class="card-header bg-light-blue text-center font-weight-bold" style="font-size: 14px">
               {{ __('Gestión de Inventario') }}
            </div>
            <div class="card-body">
               <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="row mb-3">
                     {{-- <label for="email"
                           class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                     --}}
                     <div class="col-12">
                        <div class="input-group">
                           <div class="input-group-text">
                              <i class="far fa-at"></i>
                           </div>
                           <input type="username" class="form-control @error('username') is-invalid @enderror" placeholder="Usuario" name="username" autocomplete="username" value="{{ isset($username_login) ? $username_login : '' }}" required autofocus>
                           @error('username')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="row mb-3">
                     {{-- <label for="password"
                           class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                     --}}
                     <div class="col-12">
                        <div class="input-group ">
                           <div class="input-group-text">
                              <i class="fas fa-lock"></i>
                           </div>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" autocomplete="current-password" name="password" required>
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="row mb-3">
                     <div class="col-12">
                        <div class="icheck-primary">
                           <input type="checkbox" name="remember" id="remember" {{ isset($username_login) ? 'checked' : '' }} style="margin-top: 3px !important;">
                           <label class="form-check-label no-seleccionable" for="remember">
                              {{ __('Recordar contraseña') }}
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="row mb-3 mb-0">
                     <div class="col-md-12">
                        <button type="submit" class="btn btn-light-blue font-weight-bold col-12">
                           {{ __('Ingresar') }}
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
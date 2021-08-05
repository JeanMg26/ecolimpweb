<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>Ecomlimp | Sistema de Inventario</title>
   {{-- Script Bootstrap 5 --}}
   {!!Html::script('js/app.js')!!}

   {!!Html::favicon('img/ecolimp.png')!!}
   {{-- Bootstrap 5 --}}
   {!!Html::style("css/bootstrap.css")!!}
   {{-- FontAwesome --}}
   {!!Html::style('css/all.css')!!}
   {{-- Estilos de Login --}}
   {!!Html::style("css/login.css")!!}
   {{-- CheckBox --}}
   {!!Html::style("css/icheck-bootstrap.css")!!}
   {{-- Fuentes --}}
   {!!Html::style('fonts/font.css')!!}
</head>

<body>
   <div id="app">
      <div class="mt-5 text-center">
         <img src="{{ url('img/ecolimp.png') }}" class="img-fluid mr-2" width="350px">
      </div>
      <main class="py-4">
         <div class="container">
            @yield('content')
         </div>
      </main>
   </div>
</body>

</html>
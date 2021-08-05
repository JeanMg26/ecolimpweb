<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   {!!Html::favicon('img/ecolimp.png')!!}

   <title>@yield('titulo', 'EcolimpSys') | Sistema Ecolimp</title>
   {{-- Bootstrap --}}
   {!!Html::style('css/app.css')!!}
   {{-- Fuentes --}}
   {!!Html::style('fonts/font.css')!!}
   {!!Html::style('css/bootstrap4-toggle.min.css')!!}
   {{-- Fontawesome Iconos --}}
   {!!Html::style('css/all.css')!!}
   {{-- DataTables --}}
   {!!Html::style('css/datatables/dataTables.bootstrap5.min.css')!!}
   {!!Html::style('css/datatables/rowGroup.dataTables.min.css')!!}
   <!-- Select2 Input -->
   {!!Html::style('css/select2.min.css')!!}
   <!-- Autocomplete -->
   {!!Html::style('css/jquery-ui.css')!!}
   <!-- Calendario Datepicker -->
   {!!Html::style('css/bootstrap-datepicker3.css')!!}
   {{-- Toastr - Notificaciones --}}
   {!!Html::style('css/toastr.min.css')!!}
   {{-- Estilos Propios --}}
   {!!Html::style('css/estilos.css')!!}


   {{-- ZiggyLaravel - Rutas de Laravel para Archivos JS --}}
   @routes
   {{-- @toastr_css --}}

</head>

<body>
   <div class="wrapper">

      @include('segmentos.aside')

      <div class="main">

         @include('segmentos.navbar')


         <main class="content">
            <div class="container-fluid p-0">

               @yield('contenido')
               @include('usuarios.perfil_usuario')

            </div>
         </main>

         @include('segmentos.footer')



      </div>
   </div>


   {!!Html::script('js/jquery-3.5.1.min.js')!!}
   {{-- Bootstrap --}}
   {!!Html::script('js/app.js')!!}
   {!!Html::script('js/bootstrap.bundle.min.js')!!}
   {!!Html::script('js/bootstrap4-toggle.min.js')!!}
   {{-- DataTables --}}
   {!!Html::script('js/datatables/jquery.dataTables.min.js')!!}
   {!!Html::script('js/datatables/dataTables.bootstrap5.min.js')!!}
   {!!Html::script('js/datatables/dataTables.rowGroup.min.js')!!}
   {{-- Select2 Input--}}
   {!!Html::script('js/select2.min.js')!!}
   {!!Html::script('js/select2-spanish.js')!!}
   {{-- Toastr - Notificaciones--}}
   {!!Html::script('js/toastr.min.js')!!}
   {{-- Sweetalert2 - Alertas --}}
   {!!Html::script('js/sweetalert2.all.min.js')!!}

   {{-- Validaciones - Client-Side --}}
   {!!Html::script('js/validations/jquery.validate.js')!!}
   {!!Html::script('js/validations/jquery.validate.file.js')!!}
   {!! Html::script('js/validations/validaciones.js') !!}
   <!-- Formatos para Input Date -->
   {!!Html::script('js/jquery.mask.min.js')!!}
   {{-- Separador de miles --}}
   {!!Html::script('js/jquery.number.min.js')!!}
   <!--  Autocomplete -->
   {!!Html::script('js/jquery-ui.js')!!}
   {!!Html::script('js/bootstrap3-typeahead.min.js')!!}
   {{-- Plugin para saltar con tecla enter los campos --}}
   {!!Html::script('js/jquery.tabbable.js')!!}
   <!-- Calendario Datepicker -->
   {!!Html::script('js/bootstrap-datepicker.js')!!}
   {!!Html::script('js/bootstrap-datepicker.es.min.js')!!}
   {{-- Estilos propios --}}
   {!!Html::script('js/myscript.js')!!}
   {{-- Actualizar usuarios --}}
   {!! Html::script('js/actualizar_usuario.js') !!}

   {{-- @toastr_js --}}
   @toastr_render



   @yield('script')



</body>

</html>
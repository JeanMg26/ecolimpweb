@if ($errors->get('tel_instalacion'))
<div class="alert alert-danger alerta-error" id="tel_instalacion-error">
   @foreach ($errors->get('tel_instalacion') as $telefono)
   {{ $telefono}}
   <br>
   @endforeach
</div>
@endif
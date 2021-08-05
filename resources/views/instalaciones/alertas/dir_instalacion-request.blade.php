@if ($errors->get('dir_instalacion'))
<div class="alert alert-danger alerta-error" id="dir_instalacion-error">
   @foreach ($errors->get('dir_instalacion') as $direccion)
   {{ $direccion}}
   <br>
   @endforeach
</div>
@endif
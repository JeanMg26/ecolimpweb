@if ($errors->get('imagen_usu'))
<div class="alert alert-danger alerta-error" id="imagen_usu-error">
   @foreach ($errors->get('imagen_usu') as $imagen)
   {{ $imagen}}
   <br>
   @endforeach
</div>
@endif
@if ($errors->get('rol_usu'))
<div class="alert alert-danger alerta-error" id="rol_usu-error">
   @foreach ($errors->get('rol_usu') as $rol)
   {{ $rol}}
   <br>
   @endforeach
</div>
@endif
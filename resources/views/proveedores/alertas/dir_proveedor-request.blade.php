@if ($errors->get('dir_proveedor'))
<div class="alert alert-danger alerta-error" id="dir_proveedor-error">
   @foreach ($errors->get('dir_proveedor') as $direccion)
   {{ $direccion}}
   <br>
   @endforeach
</div>
@endif
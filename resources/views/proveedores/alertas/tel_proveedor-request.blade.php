@if ($errors->get('tel_proveedor'))
<div class="alert alert-danger alerta-error" id="tel_proveedor-error">
   @foreach ($errors->get('tel_proveedor') as $telefono)
   {{ $telefono}}
   <br>
   @endforeach
</div>
@endif
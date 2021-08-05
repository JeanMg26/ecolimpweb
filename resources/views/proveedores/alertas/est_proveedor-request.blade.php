@if ($errors->get('est_proveedor'))
<div class="alert alert-danger alerta-error" id="est_proveedor-error">
   @foreach ($errors->get('est_proveedor') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
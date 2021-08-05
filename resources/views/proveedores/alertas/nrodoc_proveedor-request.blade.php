@if ($errors->get('nrodoc_proveedor'))
<div class="alert alert-danger alerta-error" id="nrodoc_proveedor-error">
   @foreach ($errors->get('nrodoc_proveedor') as $nrodoc)
   {{ $nrodoc}}
   <br>
   @endforeach
</div>
@endif
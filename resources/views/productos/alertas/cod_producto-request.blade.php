@if ($errors->get('cod_producto'))
<div class="alert alert-danger alerta-error" id="cod_producto-error">
   @foreach ($errors->get('cod_producto') as $codigo)
   {{ $codigo}}
   <br>
   @endforeach
</div>
@endif
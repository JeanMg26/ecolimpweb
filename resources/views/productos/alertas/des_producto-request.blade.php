@if ($errors->get('des_producto'))
<div class="alert alert-danger alerta-error" id="des_producto-error">
   @foreach ($errors->get('des_producto') as $descripcion)
   {{ $descripcion}}
   <br>
   @endforeach
</div>
@endif
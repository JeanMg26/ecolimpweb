@if ($errors->get('presen_producto'))
<div class="alert alert-danger alerta-error" id="presen_producto-error">
   @foreach ($errors->get('presen_producto') as $presentacion)
   {{ $presentacion}}
   <br>
   @endforeach
</div>
@endif
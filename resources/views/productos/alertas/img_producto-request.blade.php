@if ($errors->get('img_producto'))
<div class="alert alert-danger alerta-error" id="img_producto-error">
   @foreach ($errors->get('img_producto') as $imagen)
   {{ $imagen}}
   <br>
   @endforeach
</div>
@endif
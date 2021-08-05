@if ($errors->get('est_producto'))
<div class="alert alert-danger alerta-error" id="est_producto-error">
   @foreach ($errors->get('est_producto') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
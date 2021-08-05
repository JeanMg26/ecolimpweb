@if ($errors->get('est_instalacion'))
<div class="alert alert-danger alerta-error" id="est_instalacion-error">
   @foreach ($errors->get('est_instalacion') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
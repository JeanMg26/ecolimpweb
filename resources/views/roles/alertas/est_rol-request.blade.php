@if ($errors->get('est_rol'))
<div class="alert alert-danger alerta-error" id="est_rol-error">
   @foreach ($errors->get('est_rol') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
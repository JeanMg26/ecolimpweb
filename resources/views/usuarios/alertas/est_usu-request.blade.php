@if ($errors->get('est_usu'))
<div class="alert alert-danger alerta-error" id="est_usu-error">
   @foreach ($errors->get('est_usu') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
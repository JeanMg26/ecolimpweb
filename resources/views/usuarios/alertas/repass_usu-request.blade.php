@if ($errors->get('repass_usu'))
<div class="alert alert-danger alerta-error" id="repass_usu-error">
   @foreach ($errors->get('repass_usu') as $repass)
   {{ $repass}}
   <br>
   @endforeach
</div>
@endif
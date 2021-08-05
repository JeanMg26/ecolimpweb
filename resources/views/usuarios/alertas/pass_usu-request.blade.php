@if ($errors->get('pass_usu'))
<div class="alert alert-danger alerta-error" id="pass_usu-error">
   @foreach ($errors->get('pass_usu') as $pass)
   {{ $pass}}
   <br>
   @endforeach
</div>
@endif
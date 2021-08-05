@if ($errors->get('oldpass_usu'))
<div class="alert alert-danger alerta-error" id="oldpass_usu-error">
   @foreach ($errors->get('oldpass_usu') as $oldpass)
   {{ $oldpass}}
   <br>
   @endforeach
</div>
@endif
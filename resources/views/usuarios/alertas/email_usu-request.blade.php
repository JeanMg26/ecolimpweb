@if ($errors->get('email_usu'))
<div class="alert alert-danger alerta-error" id="email_usu-error">
   @foreach ($errors->get('email_usu') as $email)
   {{ $email}}
   <br>
   @endforeach
</div>
@endif
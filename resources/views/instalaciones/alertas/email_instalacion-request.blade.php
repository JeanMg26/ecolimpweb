@if ($errors->get('email_instalacion'))
<div class="alert alert-danger alerta-error" id="email_instalacion-error">
   @foreach ($errors->get('email_instalacion') as $email)
   {{ $email}}
   <br>
   @endforeach
</div>
@endif
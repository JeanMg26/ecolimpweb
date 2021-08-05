@if ($errors->get('email_contacto'))
<div class="alert alert-danger alerta-error" id="email_contacto-error">
   @foreach ($errors->get('email_contacto') as $emailc)
   {{ $emailc}}
   <br>
   @endforeach
</div>
@endif
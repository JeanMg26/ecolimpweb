@if ($errors->get('email_emp'))
<div class="alert alert-danger alerta-error" id="email_emp-error">
   @foreach ($errors->get('email_emp') as $email)
   {{ $email}}
   <br>
   @endforeach
</div>
@endif
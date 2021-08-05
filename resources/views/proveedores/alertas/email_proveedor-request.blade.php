@if ($errors->get('email_proveedor'))
<div class="alert alert-danger alerta-error" id="email_proveedor-error">
   @foreach ($errors->get('email_proveedor') as $email)
   {{ $email}}
   <br>
   @endforeach
</div>
@endif
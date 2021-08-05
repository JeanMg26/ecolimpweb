@if ($errors->get('username'))
<div class="alert alert-danger alerta-error" id="username-error">
   @foreach ($errors->get('username') as $username)
   {{ $username}}
   <br>
   @endforeach
</div>
@endif
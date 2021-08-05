@if ($errors->get('nom_fantasia'))
<div class="alert alert-danger alerta-error" id="nom_fantasia-error">
   @foreach ($errors->get('nom_fantasia') as $telefono)
   {{ $telefono}}
   <br>
   @endforeach
</div>
@endif
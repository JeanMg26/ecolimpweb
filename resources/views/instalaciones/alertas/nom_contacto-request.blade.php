@if ($errors->get('nom_contacto'))
<div class="alert alert-danger alerta-error" id="nom_contacto-error">
   @foreach ($errors->get('nom_contacto') as $nombrec)
   {{ $nombrec}}
   <br>
   @endforeach
</div>
@endif
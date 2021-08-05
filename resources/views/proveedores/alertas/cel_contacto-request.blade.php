@if ($errors->get('cel_contacto'))
<div class="alert alert-danger alerta-error" id="cel_contacto-error">
   @foreach ($errors->get('cel_contacto') as $celularc)
   {{ $celularc}}
   <br>
   @endforeach
</div>
@endif
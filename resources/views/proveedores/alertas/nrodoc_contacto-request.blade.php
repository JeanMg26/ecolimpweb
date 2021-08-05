@if ($errors->get('nrodoc_contacto'))
<div class="alert alert-danger alerta-error" id="nrodoc_contacto-error">
   @foreach ($errors->get('nrodoc_contacto') as $nrodoc)
   {{ $nrodoc}}
   <br>
   @endforeach
</div>
@endif
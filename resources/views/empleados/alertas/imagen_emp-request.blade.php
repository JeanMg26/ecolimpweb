@if ($errors->get('imagen_emp'))
<div class="alert alert-danger alerta-error" id="imagen_emp-error">
   @foreach ($errors->get('imagen_emp') as $imagen)
   {{ $imagen}}
   <br>
   @endforeach
</div>
@endif
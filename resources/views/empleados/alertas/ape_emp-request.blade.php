@if ($errors->get('ape_emp'))
<div class="alert alert-danger alerta-error" id="ape_emp-error">
   @foreach ($errors->get('ape_emp') as $apellido)
   {{ $apellido}}
   <br>
   @endforeach
</div>
@endif
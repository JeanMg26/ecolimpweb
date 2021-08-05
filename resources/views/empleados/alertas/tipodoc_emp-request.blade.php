@if ($errors->get('tipodoc_emp'))
<div class="alert alert-danger alerta-error" id="tipodoc_emp-error">
   @foreach ($errors->get('tipodoc_emp') as $tipodoc)
   {{ $tipodoc}}
   <br>
   @endforeach
</div>
@endif
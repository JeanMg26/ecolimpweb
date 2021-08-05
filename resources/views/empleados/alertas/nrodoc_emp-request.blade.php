@if ($errors->get('nrodoc_emp'))
<div class="alert alert-danger alerta-error" id="nrodoc_emp-error">
   @foreach ($errors->get('nrodoc_emp') as $nrodoc)
   {{ $nrodoc}}
   <br>
   @endforeach
</div>
@endif
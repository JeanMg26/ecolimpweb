@if ($errors->get('cargo_emp'))
<div class="alert alert-danger alerta-error" id="cargo_emp-error">
   @foreach ($errors->get('cargo_emp') as $cargo)
   {{ $cargo}}
   <br>
   @endforeach
</div>
@endif
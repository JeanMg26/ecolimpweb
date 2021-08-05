@if ($errors->get('gen_emp'))
<div class="alert alert-danger alerta-error" id="gen_emp-error">
   @foreach ($errors->get('gen_emp') as $genero)
   {{ $genero}}
   <br>
   @endforeach
</div>
@endif
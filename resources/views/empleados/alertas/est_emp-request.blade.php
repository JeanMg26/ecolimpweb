@if ($errors->get('est_emp'))
<div class="alert alert-danger alerta-error" id="est_emp-error">
   @foreach ($errors->get('est_emp') as $estado)
   {{ $estado}}
   <br>
   @endforeach
</div>
@endif
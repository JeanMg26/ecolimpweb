@if ($errors->get('cel_emp'))
<div class="alert alert-danger alerta-error" id="cel_emp-error">
   @foreach ($errors->get('cel_emp') as $celular)
   {{ $celular}}
   <br>
   @endforeach
</div>
@endif
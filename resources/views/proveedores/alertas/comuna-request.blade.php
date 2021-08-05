@if ($errors->get('comuna'))
<div class="alert alert-danger alerta-error" id="comuna-error">
   @foreach ($errors->get('comuna') as $comuna)
   {{ $comuna}}
   <br>
   @endforeach
</div>
@endif
@if ($errors->get('nrodoc_instalacion'))
<div class="alert alert-danger alerta-error" id="nrodoc_instalacion-error">
   @foreach ($errors->get('nrodoc_instalacion') as $nrodoc)
   {{ $nrodoc}}
   <br>
   @endforeach
</div>
@endif
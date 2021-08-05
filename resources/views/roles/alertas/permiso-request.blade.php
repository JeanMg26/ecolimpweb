@if ($errors->get('permisos'))
<div class="alert alert-danger alerta-error" id="permisos-alerta">
   @foreach ($errors->get('permisos') as $permiso)
   {{ $permiso}}
   <br>
   @endforeach
</div>
@endif
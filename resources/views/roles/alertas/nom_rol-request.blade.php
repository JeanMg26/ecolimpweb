@if ($errors->get('nom_rol'))
<div class="alert alert-danger alerta-error" id="nom_rol-alerta">
   @foreach ($errors->get('nom_rol') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
@if ($errors->get('nom_instalacion'))
<div class="alert alert-danger alerta-error" id="nom_instalacion-error">
   @foreach ($errors->get('nom_instalacion') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
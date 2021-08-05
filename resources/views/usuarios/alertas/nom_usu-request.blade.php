@if ($errors->get('nom_usu'))
<div class="alert alert-danger alerta-error" id="nom_usu-error">
   @foreach ($errors->get('nom_usu') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
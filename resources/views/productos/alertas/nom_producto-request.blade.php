@if ($errors->get('nom_producto'))
<div class="alert alert-danger alerta-error" id="nom_producto-error">
   @foreach ($errors->get('nom_producto') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
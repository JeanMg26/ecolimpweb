@if ($errors->get('nom_proveedor'))
<div class="alert alert-danger alerta-error" id="nom_proveedor-error">
   @foreach ($errors->get('nom_proveedor') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
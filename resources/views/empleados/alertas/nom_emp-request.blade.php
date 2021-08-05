@if ($errors->get('nom_emp'))
<div class="alert alert-danger alerta-error" id="nom_emp-error">
   @foreach ($errors->get('nom_emp') as $nombre)
   {{ $nombre}}
   <br>
   @endforeach
</div>
@endif
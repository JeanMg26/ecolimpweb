@if ($errors->get('categoria'))
<div class="alert alert-danger alerta-error" id="categoria-error">
   @foreach ($errors->get('categoria') as $categoria)
   {{ $categoria}}
   <br>
   @endforeach
</div>
@endif
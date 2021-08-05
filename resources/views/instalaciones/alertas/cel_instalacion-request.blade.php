@if ($errors->get('cel_instalacion'))
<div class="alert alert-danger alerta-error" id="cel_instalacion-error">
   @foreach ($errors->get('cel_instalacion') as $celular)
   {{ $celular}}
   <br>
   @endforeach
</div>
@endif
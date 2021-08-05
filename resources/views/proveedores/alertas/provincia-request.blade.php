@if ($errors->get('provincia'))
<div class="alert alert-danger alerta-error" id="provincia-error">
   @foreach ($errors->get('provincia') as $celularc)
   {{ $celularc}}
   <br>
   @endforeach
</div>
@endif
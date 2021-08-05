@if ($errors->get('cant_minima'))
<div class="alert alert-danger alerta-error" id="cant_minima-error">
   @foreach ($errors->get('cant_minima') as $cant_minima)
   {{ $cant_minima}}
   <br>
   @endforeach
</div>
@endif
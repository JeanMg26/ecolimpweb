@if ($errors->get('region'))
<div class="alert alert-danger alerta-error" id="region-error">
   @foreach ($errors->get('region') as $region)
   {{ $region}}
   <br>
   @endforeach
</div>
@endif
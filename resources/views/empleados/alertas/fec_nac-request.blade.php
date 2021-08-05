@if ($errors->get('fec_nac'))
<div class="alert alert-danger alerta-error" id="fec_nac-error">
   @foreach ($errors->get('fec_nac') as $fec_nacimiento)
   {{ $fec_nacimiento}}
   <br>
   @endforeach
</div>
@endif
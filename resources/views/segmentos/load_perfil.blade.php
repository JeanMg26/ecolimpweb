@if (Auth::user()->rutaimagen == "" || Auth::user()->rutaimagen == null)
<img class="img-fluid avatar img-fluid rounded mr-1" src="{{ url('/img/user.jpg') }}">
@else
<img class="img-fluid avatar img-fluid rounded mr-1" src="/uploads/{{Auth::user()->rutaimagen}}">
@endif

<span class="hidden-md-down"> {{ Auth::user()->name }} <i class="far fa-angle-down ml-1"></i></span>
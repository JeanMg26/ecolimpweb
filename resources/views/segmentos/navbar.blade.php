<nav class="navbar navbar-expand navbar-light navbar-bg">
   <a class="sidebar-toggle d-flex">
      <i class="hamburger align-self-center"></i>
   </a>

   <div class="navbar-collapse collapse">
      <ul class="navbar-nav navbar-align">

         <li class="nav-item dropdown u-pro">
            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
               <i class="align-middle" data-feather="settings"></i>
            </a>

            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown" id="perfil_usuario">
               {{-- <img src="{{ asset('img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded mr-1" alt="Charles Hall" /> --}}

               @if (Auth::user()->rutaimagen == "" || Auth::user()->rutaimagen == null)
               <img class="img-fluid avatar img-fluid rounded mr-1" src="{{ url('/img/user.jpg') }}">
               @else
               <img class="img-fluid avatar img-fluid rounded mr-1" src="/uploads/{{Auth::user()->rutaimagen}}">
               @endif

               <span class="hidden-md-down"> {{ Auth::user()->name }} <i class="far fa-angle-down ml-1"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right centrar-derecha centrar-derecha ">
               <a class="dropdown-item actualizar_perfil" href="#" id="{{ Auth::user()->id }}"><i class="fal fa-user mr-3"></i>Perfil</a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="far fa-sign-out-alt mr-3"></i>Salir
               </a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
               </form>
            </div>
         </li>
      </ul>
   </div>
</nav>
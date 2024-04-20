<nav class="navbar bg-body-tertiary position-relative">
  <div class="container-lg">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    @guest
    <a href="{{route('signIn.user')}}" class="login-link text-decoration-none d-flex align-items-center gap-1 "><i
        class="ri-login-circle-line"></i>Sign in</a>
    @endguest
    @auth
    <div class="dropdown">
      <a class="nav-link d-flex gap-2 pt-3 pt-md-0 align-items-center justify-content-end dropdown-toggle"
        href="user-edit-profile.html" role="button" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{asset('img/Ellipse 4.png')}}" class="img-fluid img-avatar" />
      </a>
      <ul class="dropdown-menu dropdown-menu-end px-2">
        <li class="rounded-2 dropdown-list my-profile">
          <a class="dropdown-item text-white rounded-2" href="user-edit-profile.html"><i
              class="ri-user-3-line me-2 text-white"></i>Edit Profile</a>
        </li>
        <li class="rounded-2 dropdown-list">
          <a href="" class="dropdown-item rounded-2 text-white"><i
              class="ri-logout-circle-line me-2 text-white"></i>Sign
            Out</a>
        </li>
      </ul>
    </div>
    @endauth
  </div>
</nav>
<nav id="sidebarMenu" class="col col-md-3 col-lg-2  bg-dark navbar-dark collapse sidebar d-md-block">

    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item">

                {{-- DROPDOWN MENU --}}
                <div class="dropdown d-md-none">
                    <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }} - Quick Links
                    </a>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-start">
                        <li>
                            <a class="dropdown-item" href="/">{{ __('Home') }}</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profile') }}</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.dashboard' ? 'bg-secondary' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i> Dashboard
                </a>

                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.projects.index' ? 'bg-secondary' : '' }}"
                    href="{{ route('admin.projects.index') }}">
                    <i class="fa-solid fa-diagram-project fa-lg fa-fw"></i> {{ __('Projects') }}
                </a>

                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.types.index' ? 'bg-secondary' : '' }}"
                    href="{{ route('admin.types.index') }}">
                    <i class="fa-solid fa-tag fa-lg fa-fw"></i></i> {{ __('Project Types') }}
                </a>


                <a class="nav-link text-white {{ Route::currentRouteName() == 'admin.projects.recycle' ? 'bg-secondary' : '' }}"
                    href="{{ route('admin.projects.recycle') }}">
                    <i class="fa-regular fa-trash-can fa-lg fa-fw"></i> {{ __('Recycle Bin') }}
                </a>

            </li>

        </ul>

    </div>

</nav>

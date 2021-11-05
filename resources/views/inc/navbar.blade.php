<nav class="navbar-expand-md navbar-light bg-white shadow-sm navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <img height ="100%" src='/storage/icon/wedodemy-all-white-nav.png'>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/courses">Courses</a>
                            </li>
                        @else
                            @if(Auth::user()->is_prof == 0)                            
                                <li class="nav-item">
                                    <a class="nav-link" href="/appointment">Appointments</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="/course">Courses</a>
                            </li>
                            @if(Auth::user()->is_prof)
                                <li class="nav-item">
                                    <a class="nav-link" href="/prof/appointment">Appointments</a>
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" href="/prof/approval">Approvals</a>
                                </li>
                                <li class="nav-item"> 
                                    <a class="nav-link" href="/prof/answers">Answers</a>
                                </li>
                            @endif
                        @endguest
                        {{-- @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/appointment">Appointment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/course">Course</a>
                            </li>
                        @endguest --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a  class="dropdown-item" @if(auth()->user()->is_admin == 1)href="admin/home" @elseif(auth()->user()->is_prof == 1) href="/prof/home"@else href="/home"@endif>
                                        Home
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
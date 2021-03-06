<header class="navbar navbar-default navbar-fixed-top" id="top" role="banner">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>


                    <!-- Branding Image -->
                    <a class="navbar-brand logo" href="{{ url('/') }}"><img src="img/commprop1.png" width="40px" height="40px" alt="CommProp">

                    </a>

                     <a class="navbar-brand divider-vertical" >     <!--  {{ config('app.name', 'Laravel') }} -->

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                            <li>
                               <a href="{{ url('/manage-properties') }}"> Property </a>
                            </li>



                            <li>
                               <a  href="{{ url('/map') }}">Location</a>
                            </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <!--  <li><a href="{{ url('/register') }}">Register</a></li>   -->
                        @else

                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                              <!--       <li><a href="#" >Role: {{ Auth::user()->getRoleName() }}</a></li>
                           <li>
                                  <a  href="{{ url('/readme') }}">Todo</a>
                                </li>   -->
                                <li>
                                  <a  href="{{ url('/dashboard') }}">Dashboard</a>
                                </li>
                                <li>
                                  <a  href="{{ url('/logs') }}">Logs</a>
                                </li>
                           <!--     <li>
                                  <a  href="{{ url('/dropzone2') }}">Dropzone</a>
                                </li>    -->

                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

</header>

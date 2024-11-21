<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}" />

        <!-- Custom CSS -->
        <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/libs/chartist/chartist.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
        <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" />
    </head>

    <body>
        <div id="app" class="d-flex">
            <!-- Sidebar -->
            @auth
            <div class="sidebar bg-dark" id="sidebar">
                <div class="text-center py-4">
                    <h3 class="text-white">{{ Auth::user()->name }}</h3>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="fa fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('newsletters.create') ? 'active' : '' }}"
                            href="{{ route('newsletters.create') }}">
                            <i class="fa fa-pencil-alt"></i> Create New Mail
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('subscribers.index') ? 'active' : '' }}"
                            href="{{ route('subscribers.index') }}">
                            <i class="fa fa-users"></i> Email List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('dashboard.smtp-settings') ? 'active' : '' }}"
                            href="{{ route('dashboard.smtp-settings') }}">
                            <i class="fa fa-cogs"></i> SMTP Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('profile.change-password') ? 'active' : '' }}"
                            href="{{ route('profile.change-password') }}">
                            <i class="fa fa-key"></i> Change Password
                        </a>
                    </li>

                    <!-- Admin Dashboard Link (only visible to super admins) -->
                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-cogs"></i> Admin Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('settings.index') ? 'active' : '' }}"
                            href="{{ route('settings.index') }}">
                            <i class="fa fa-cogs"></i> Registration
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            @endauth

            <!-- Main Content Area -->
            <div id="main-content" class="flex-grow-1">
                <header class="bg-white shadow-sm">
                    <nav class="navbar navbar-expand navbar-light">
                        <div class="container-fluid">
                            <button class="btn btn-dark d-md-none" id="toggleSidebar">☰</button>
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                    </nav>
                </header>
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Demo JS and Scripts -->
        <!-- Scripts -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
        <script src="{{ asset('dist/js/feather.min.js') }}"></script>
        <script src="{{ asset('assets/libs/perfect-scrollbar/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('dist/js/custom.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
        <script src="{{ asset('assets/libs/chartist/chartist.min.js') }}"></script>
        <script src="{{ asset('assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
        <script src="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('dist/js/pages/dashboards/dashboard1.min.js') }}"></script>

        <script>
        // Sidebar toggle for mobile view
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            let sidebar = document.getElementById('sidebar');
            sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block';
        });
        </script>
    </body>

</html>
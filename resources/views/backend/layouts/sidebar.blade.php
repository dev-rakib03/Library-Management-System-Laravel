<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('admin.dashboard.index')}}"> <img alt="image" src="{{asset('/')}}backend/assets/img/logo.png" class="header-logo" /> <span
            class="logo-name">{{ config('app.name')}}</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown {{Route::is('admin.dashboard.index') ? 'active' : ''}} ">
          <a href="{{route('admin.dashboard.index')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>


        @if (Auth::guard('admin')->user()->can('role.view') && Auth::guard('admin')->user()->can('admin.view'))
        <li class="menu-header">Roles & Users</li>
        @else
            @if (Auth::guard('admin')->user()->can('role.view'))
            <li class="menu-header">Roles</li>
            @endif
            @if (Auth::guard('admin')->user()->can('admin.view'))
            <li class="menu-header">Users</li>
            @endif
        @endif


        @if (Auth::guard('admin')->user()->can('role.view'))
        <li class="dropdown {{Route::is('admin.roles.index') || Route::is('admin.roles.create') ||Route::is('admin.roles.edit') ? 'active' : ''}} ">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Roles</span></a>
          <ul class="dropdown-menu">
            @if (Auth::guard('admin')->user()->can('role.view'))
            <li class=" {{Route::is('admin.roles.index') || Route::is('admin.roles.create') ||Route::is('admin.roles.edit') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.roles.index')}}">All Roles</a></li>
            @endif
        </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('admin.view') || Auth::guard('admin')->user()->can('admin.create'))
        <li class="dropdown {{Route::is('admin.admins.index') || Route::is('admin.admins.create') ||Route::is('admin.admins.edit') ? 'active' : ''}} ">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user"></i><span>Users</span></a>
            <ul class="dropdown-menu">
              @if (Auth::guard('admin')->user()->can('admin.view'))
              <li class=" {{Route::is('admin.admins.index') || Route::is('admin.admins.edit') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.admins.index')}}">All Users</a></li>
              @endif
              @if (Auth::guard('admin')->user()->can('admin.create'))
              <li class=" {{Route::is('admin.admins.create') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.admins.create')}}">Add Users</a></li>
              @endif
            </ul>
        </li>
        @endif

        {{-- <li class="dropdown {{Route::is('admin.users.index') || Route::is('admin.users.create') ||Route::is('admin.users.edit') ? 'active' : ''}} ">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Users</span></a>
            <ul class="dropdown-menu">
              <li class=" {{Route::is('admin.users.index') || Route::is('admin.users.edit') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.users.index')}}">All Users</a></li>
              <li class=" {{Route::is('admin.users.create') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.users.create')}}">Add User</a></li>
            </ul>
        </li> --}}

        @if (Auth::guard('admin')->user()->can('categories.view'))
        <li class="menu-header">Category & Sub-Category</li>
        @endif


        @if (Auth::guard('admin')->user()->can('categories.view'))
        <li class="dropdown {{Route::is('categories.index') || Route::is('categories.create') ||Route::is('categories.edit') ? 'active' : ''}} ">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>All Category</span></a>
          <ul class="dropdown-menu">
            @if (Auth::guard('admin')->user()->can('categories.view'))
            <li class=" {{Route::is('categories.index') ? 'active' : ''}} "><a class="nav-link" href="{{route('categories.index')}}">All Category</a></li>
            @endif
            @if (Auth::guard('admin')->user()->can('categories.create'))
            <li class=" {{Route::is('categories.create') ? 'active' : ''}} "><a class="nav-link" href="{{route('categories.create')}}">Add Category</a></li>
            @endif
        </ul>
        </li>
        @endif


        @if (Auth::guard('admin')->user()->can('books.view')||Auth::guard('admin')->user()->can('books.create'))
        <li class="menu-header">Books</li>
        @endif

        @if (Auth::guard('admin')->user()->can('books.view'))
        <li class="dropdown {{Route::is('books.index') ? 'active' : ''}} ">
            <a href="{{route('books.index')}}" class="nav-link"><i data-feather="book"></i><span>All Books</span></a>
        </li>
        @endif
        @if (Auth::guard('admin')->user()->can('books.create'))
        <li class="dropdown {{Route::is('books.create') ? 'active' : ''}} ">
            <a href="{{route('books.create')}}" class="nav-link"><i data-feather="book-open"></i><span>Add Book</span></a>
        </li>
        @endif


        {{-- <li class="dropdown {{Route::is('admin.users.index') || Route::is('admin.users.create') ||Route::is('admin.users.edit') ? 'active' : ''}} ">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Users</span></a>
            <ul class="dropdown-menu">
              <li class=" {{Route::is('admin.users.index') || Route::is('admin.users.edit') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.users.index')}}">All Users</a></li>
              <li class=" {{Route::is('admin.users.create') ? 'active' : ''}} "><a class="nav-link" href="{{route('admin.users.create')}}">Add User</a></li>
            </ul>
        </li> --}}

        @if (Auth::guard('admin')->user()->can('settings.site'))
        <li class="menu-header">Settings</li>
        @endif
        @if (Auth::guard('admin')->user()->can('settings.site'))
        <li class="dropdown  {{Route::is('settings.site.index') ? 'active' : ''}} ">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>Settings</span></a>
          <ul class="dropdown-menu">
            @if (Auth::guard('admin')->user()->can('settings.site'))
            <li class="  {{Route::is('settings.site.index') ? 'active' : ''}} "><a class="nav-link" href="{{route('settings.site.index')}}">Site Settings</a></li>
            @endif
          </ul>
        </li>
        @endif







        <!--
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i
              data-feather="pie-chart"></i><span>Charts</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="chart-amchart.html">amChart</a></li>
            <li><a class="nav-link" href="chart-apexchart.html">apexchart</a></li>
            <li><a class="nav-link" href="chart-echart.html">eChart</a></li>
            <li><a class="nav-link" href="chart-chartjs.html">Chartjs</a></li>
            <li><a class="nav-link" href="chart-sparkline.html">Sparkline</a></li>
            <li><a class="nav-link" href="chart-morris.html">Morris</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="feather"></i><span>Icons</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="icon-font-awesome.html">Font Awesome</a></li>
            <li><a class="nav-link" href="icon-material.html">Material Design</a></li>
            <li><a class="nav-link" href="icon-ionicons.html">Ion Icons</a></li>
            <li><a class="nav-link" href="icon-feather.html">Feather Icons</a></li>
            <li><a class="nav-link" href="icon-weather-icon.html">Weather Icon</a></li>
          </ul>
        </li>
        <li class="menu-header">Media</li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="image"></i><span>Gallery</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="light-gallery.html">Light Gallery</a></li>
            <li><a href="gallery1.html">Gallery 2</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="flag"></i><span>Sliders</span></a>
          <ul class="dropdown-menu">
            <li><a href="carousel.html">Bootstrap Carousel.html</a></li>
            <li><a class="nav-link" href="owl-carousel.html">Owl Carousel</a></li>
          </ul>
        </li>
        <li><a class="nav-link" href="timeline.html"><i data-feather="sliders"></i><span>Timeline</span></a></li>
        <li class="menu-header">Maps</li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="map"></i><span>Google
              Maps</span></a>
          <ul class="dropdown-menu">
            <li><a href="gmaps-advanced-route.html">Advanced Route</a></li>
            <li><a href="gmaps-draggable-marker.html">Draggable Marker</a></li>
            <li><a href="gmaps-geocoding.html">Geocoding</a></li>
            <li><a href="gmaps-geolocation.html">Geolocation</a></li>
            <li><a href="gmaps-marker.html">Marker</a></li>
            <li><a href="gmaps-multiple-marker.html">Multiple Marker</a></li>
            <li><a href="gmaps-route.html">Route</a></li>
            <li><a href="gmaps-simple.html">Simple</a></li>
          </ul>
        </li>
        <li><a class="nav-link" href="vector-map.html"><i data-feather="map-pin"></i><span>Vector
              Map</span></a></li>
        <li class="menu-header">Pages</li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i
              data-feather="user-check"></i><span>Auth</span></a>
          <ul class="dropdown-menu">
            <li><a href="auth-login.html">Login</a></li>
            <li><a href="auth-register.html">Register</a></li>
            <li><a href="auth-forgot-password.html">Forgot Password</a></li>
            <li><a href="auth-reset-password.html">Reset Password</a></li>
            <li><a href="subscribe.html">Subscribe</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i
              data-feather="alert-triangle"></i><span>Errors</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="errors-503.html">503</a></li>
            <li><a class="nav-link" href="errors-403.html">403</a></li>
            <li><a class="nav-link" href="errors-404.html">404</a></li>
            <li><a class="nav-link" href="errors-500.html">500</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="anchor"></i><span>Other
              Pages</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="create-post.html">Create Post</a></li>
            <li><a class="nav-link" href="posts.html">Posts</a></li>
            <li><a class="nav-link" href="profile.html">Profile</a></li>
            <li><a class="nav-link" href="contact.html">Contact</a></li>
            <li><a class="nav-link" href="invoice.html">Invoice</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown"><i
              data-feather="chevrons-down"></i><span>Multilevel</span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Menu 1</a></li>
            <li class="dropdown">
              <a href="#" class="has-dropdown">Menu 2</a>
              <ul class="dropdown-menu">
                <li><a href="#">Child Menu 1</a></li>
                <li class="dropdown">
                  <a href="#" class="has-dropdown">Child Menu 2</a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Child Menu 1</a></li>
                    <li><a href="#">Child Menu 2</a></li>
                  </ul>
                </li>
                <li><a href="#"> Child Menu 3</a></li>
              </ul>
            </li>
          </ul>
        </li>-->
      </ul>
    </aside>
  </div>

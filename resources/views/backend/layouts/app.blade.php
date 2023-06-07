<!DOCTYPE html>
<html lang="en">
<head>
  <!--meta tag-->
  @include('backend.layouts.metatag')
  <title>@yield('title')-{{ config('app.name')}}</title>
  <!-- Css -->
  @include('backend.layouts.style')
</head>
<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- Nav Bar -->
      @include('backend.layouts.navbar')
      <!-- Side Bar -->
      @include('backend.layouts.sidebar')
      <!-- Main Content -->
      <div class="main-content">
        <!--Massages-->
        @include('backend.layouts.massages')
        <section class="section">
          <div class="section-body">
            <!-- add content here -->
            @yield('content')
          </div>
        </section>
        <!-- settingSidebar -->
        @include('backend.layouts.settingSidebar')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="https://boraxip.com/">Boraxip</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!--JS Scripts-->
  @include('backend.layouts.javascript')
</body>
</html>

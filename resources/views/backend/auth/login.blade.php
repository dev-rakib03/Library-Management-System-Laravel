<!DOCTYPE html>
<html lang="en">
<head>
  <!--meta tag-->
  @include('backend.layouts.metatag')
  <title>Login-{{ config('app.name')}}</title>
  <!-- Css -->
  @include('backend.layouts.style')
  <link rel="stylesheet" href="{{asset('/')}}backend/assets/bundles/bootstrap-social/bootstrap-social.css">
</head>
<body>
    <div class="loader"></div>
    <div id="app">
      <section class="section">
        <div class="container mt-5">
          <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Login</h4>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('admin.login.submit') }}" class="needs-validation" novalidate="">
                    @csrf
                    @include('backend.layouts.massages')
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" tabindex="1" required autocomplete="email" autofocus>
                      <div class="invalid-feedback">
                        Please fill in your email
                      </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        <div class="float-right">
                        @if (Route::has('password.request'))
                          <a href="{{ route('password.request') }}" class="text-small">
                            Forgot Password?
                          </a>
                        @endif
                        </div>
                      </div>
                      <input id="password" type="password" class="form-control" @error('password') is-invalid @enderror" name="password" tabindex="2" required  autocomplete="current-password">
                      <div class="invalid-feedback">
                        please fill in your password
                      </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              {{-- <div class="mt-5 text-muted text-center">
                Don't have an account? <a href="auth-register.html">Create One</a>
              </div> --}}
            </div>
          </div>
        </div>
      </section>
    </div>

    @include('backend.layouts.javascript')
</body>
</html>

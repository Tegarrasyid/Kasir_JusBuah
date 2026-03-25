<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-social.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/templatemo_style.css') }}" rel="stylesheet">
</head>

<body>

<div class="templatemo-bg-image-1" style="min-height:100vh; display:flex; align-items:center;">
    <div class="container">
        <div class="col-md-12">

            <form class="form-horizontal templatemo-login-form-2"
                  method="POST"
                  action="{{ route('login') }}">

                @csrf

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1>Halaman Login</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="templatemo-one-signin col-md-6 col-md-offset-3">

                        {{-- EMAIL --}}
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Email</label>
                                <div class="templatemo-input-icon-container">
                                    <i class="fa fa-user"></i>
                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           required>

                                    @error('email')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label">Password</label>
                                <div class="templatemo-input-icon-container">
                                    <i class="fa fa-lock"></i>
                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required>

                                    @error('password')
                                        <span class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-warning btn-block">
                                    LOGIN
                                </button>
                            </div>
                        </div>

                        {{-- FORGOT PASSWORD --}}
                        @if (Route::has('password.request'))
                        <div class="form-group text-center">
                            <a href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        </div>
                        @endif

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
</body>
</html>
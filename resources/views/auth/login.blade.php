@extends('layouts.app')

@section('title', 'Login')

@section('style')
    <style>
        .custom-wrapper main {
            width: 100% !important;
            margin-left: 0 !important;
        }
    </style>
@endsection

@section('content')
    <main class="d-flex min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <form method="POST" action="{{ route('login') }}">
                        <div class="row justify-content-center">
                            <img src="{{asset('assets/EFORS1.png')}}" alt="EFORS_Logo" />
                        </div>
                        @csrf
        
                            <div class="col-md-12 mb-2">
                                <label for="email" class="">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="password" class="">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
        

                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
        
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection

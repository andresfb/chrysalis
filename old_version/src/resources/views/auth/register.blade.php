@extends('layouts.guest')

@section('body-class', 'register-page')

@section('content')

    <div class="register-box">

        <div class="register-logo">
            <b>{{ config('app.name', 'Laravel') }}</b>
        </div>

        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>

            <div class="card-body register-card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input autocomplete="name" autofocus class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name" required type="text" value="{{ old('name') }}" placeholder="{{ __('Name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input autocomplete="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                               required type="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="input-group mb-3">
                        <input autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" id="password"
                               name="password" required type="password" placeholder="{{ __('Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input autocomplete="new-password" class="form-control" id="password-confirm" name="password_confirmation" required
                               type="password" placeholder="{{ __('Confirm Password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

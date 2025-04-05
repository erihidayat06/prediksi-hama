@extends('auth.layouts.main')

@section('content')
    <style>
        .divider:after,
        .divider:before {
            content: "" !important;
            flex: 1 !important;
            height: 1px !important;
            background: #e0e0e0 !important;
            /* Light gray for dividers */
        }

        .h-custom {
            height: calc(100% - 73px) !important;
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100% !important;
            }
        }

        .btn-primary {
            background-color: #4CAF50 !important;
            /* Green */
            border-color: #4CAF50 !important;
        }

        .btn-primary:hover {
            background-color: #45a049 !important;
            /* Darker green on hover */
            border-color: #45a049 !important;
        }

        .card {
            border: 1px solid #c8e6c9 !important;
            /* Light green border for card */
            background-color: #e6f4ea !important;
        }


        .form-control:focus {
            border-color: #81c784;
            /* Slightly darker green focus border */
            box-shadow: 0 0 0 0.2rem rgba(129, 199, 132, 0.25);
            /* Green focus shadow */
        }
    </style>
    <section class="vh-100">
        <div class="container h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="text-center">
                    <a href="/"><img src="/img/logo-pedia.png" class="img-fluid" alt="Sample image" width="150"></a>
                </div>
                <div class="col-md-8 col-lg-8 col-xl-5">
                    <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                        <div class="card-body">

                            <div class="card-title mb-4 text-center">
                                <h3 class="fw-bold" style="color: #2e7d32;">Register</h3>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label text-sub">{{ __('Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label text-sub">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label text-sub">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirm"
                                        class="form-label text-sub">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="text-sub">Already have an account? <a href="{{ route('login') }}">Login</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('auth.layouts.main')

@section('content')
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #e0e0e0;
            /* Light gray for dividers */
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .btn-primary {
            background-color: #4CAF50;
            /* Green */
            border-color: #4CAF50;
        }

        .btn-primary:hover {
            background-color: #45a049;
            /* Darker green on hover */
            border-color: #45a049;
        }

        .card {
            border: 1px solid #c8e6c9;
            background-color: #e6f4ea;
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
                    <div class="card shadow-lg p-3 mb-5 rounded">
                        <div class="card-body">

                            <div class="card-title mb-4 text-center">
                                <h3 class="fw-bold" style="color: #2e7d32;">Login</h3>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label text-sub">Email Address</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label text-sub">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-sub" for="remember">Remember Me</label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>

                                <div class="mt-3 text-center">
                                    <p class="text-sub">Don't have an account? <a
                                            href="{{ route('register') }}">Register</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

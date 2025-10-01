@extends('frontend.frontend_dashboard')

@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Forgot Password</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Forgot Password</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    {{-- <div class="container">
        <h2>Forgot Password</h2>
        <form action="{{ route('forgot.send') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Send OTP</button>
        </form>
    </div> --}}

    <!-- Forgot Password section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Forgot Password?</h3>
                            <h4>Enter your email address</h4>
                        </div>
                        <form method="POST" action="{{ route('forgot.send') }}">
                            @csrf
                            <div class="input-box">
                                <form class="row g-4">
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="Email Address">
                                            <label for="email">Email Address</label>
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="form-control" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div> --}}
                                    <br>
                                    <div class="col-12">
                                        <button class="btn btn-animation w-100 justify-content-center" type="submit">Send OTP</button>
                                    </div>
                                </form>
                            </div>
                        </form>

                        <div class="sign-up-box">
                            <h4>Don't have an account?</h4>
                            <a href="{{ route('register') }}">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Forgot Password section end -->
@endsection

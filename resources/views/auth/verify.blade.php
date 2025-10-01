@extends('frontend.frontend_dashboard')

@section('main')
    @php
        $userEmail = session('temp_user.email');
    @endphp
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Email Verification</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Email Verification</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Verification Section Start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title text-center">
                            {{-- <h3>Welcome To CampusMart BD</h3> --}}
                            <h3>Enter OTP To Verify Your Email</h3>
                            <p class="text-muted small mt-2">
                                We sent a verification code to <strong>{{ $userEmail }}</strong>.
                                If you don’t see the email, check your spam folder.
                                Sometimes it may take a few minutes to arrive.
                            </p>
                        </div>

                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="alert alert-success text-center">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- OTP Verification Form -->
                        <form method="POST" action="{{ route('verify.email.submit') }}">
                            @csrf
                            <div class="form-floating theme-form-floating log-in-form mb-3">
                                <input type="text" name="code" class="form-control" id="code"
                                    placeholder="Enter OTP" required>
                                <label for="code">OTP Code</label>
                                @error('code')
                                    <p class="text-danger mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class="btn btn-animation w-100 justify-content-center" type="submit">
                                Submit
                            </button>
                        </form>

                        <!-- Resend OTP -->
                        <div class="sign-up-box text-center mt-3 fs-6">
                            Didn't receive code?
                            <form method="POST" action="{{ route('resend.otp') }}" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="text-danger"
                                    style="background: none; border: none; cursor: pointer; text-decoration: none;">
                                    Resend OTP
                                </button>
                            </form>
                        </div>

                        <!-- Other Options -->
                        <div class="other-log-in text-center my-3 align-middle">
                            <h6>or</h6>
                        </div>

                        <div class="sign-up-box text-center">
                            <a href="{{ route('register') }}">Sign Up Again !</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Verification Section End -->
@endsection

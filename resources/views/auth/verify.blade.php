@extends('frontend.frontend_dashboard')

@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Log In</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Log In</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To CampusMart BD</h3>
                            <h4>Confirm Your Account</h4>
                        </div>
                        <form method="POST" action="">
                            @csrf
                            <div class="input-box">
                                <form class="row g-4">
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="number" name="code" class="form-control" id="code"
                                                placeholder="code">
                                            <label for="Code">Confirmation Code</label>
                                        </div>
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
    <!-- log in section end -->
@endsection

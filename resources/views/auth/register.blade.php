@extends('frontend.frontend_dashboard')
@section('main')
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>User Register</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">User Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('frontend') }}/assets/images/sign-up.jpg" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To Campus Mart BD</h3>
                            <h4>Create New Account For USER</h4>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input-box">
                                <form class="row g-4">
                                    <!-- Name Input -->
                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="fullname" placeholder="Full Name"
                                                value="{{ old('name') }}">
                                            <label for="fullname">User Full Name</label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email Input -->
                                    <div class="col-12 mb-4">
                                        <div class="form-floating theme-form-floating">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" placeholder="Email Address"
                                                value="{{ old('email') }}">
                                            <label for="email">User Email Address</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Input -->
                                    <div class="col-12 mb-4">
                                        <div class="form-floating theme-form-floating">
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" id="tel" placeholder="Phone No"
                                                value="{{ old('phone', '+88') }}"
                                                onfocus="if(this.value == '') { this.value='+88'; }"
                                                oninput="enforceBDCountryCode()" maxlength="14">
                                            <label for="tel">User Phone No</label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="col-12 mb-4">
                                        <div class="form-floating theme-form-floating">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" placeholder="Password">
                                            <label for="password">Password</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">Sign Up</button>
                                    </div>
                                </form>
                            </div>
                        </form>


                        <div class="other-log-in">
                            <h6>or</h6>
                        </div>

                        <div class="sign-up-box">
                            <h4>Already have an account?</h4>
                            <a href="{{ route('login') }}">Log In</a>
                        </div>

                        <div class="sign-up-box">
                            <h4 >Become a Seller?</h4>
                            <a style="color: red; font-weight: 600;" href="{{ route('login') }}">Registration Now For SELLER</a>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
            </div>
        </div>
    </section>

    <script>
        function enforceBDCountryCode() {
            var input = $('#tel'); // jQuery selector
            var value = input.val(); // Get value using jQuery

            // Enforce the +880 prefix, if removed, it will auto-fill again
            if (!value.startsWith('+88')) {
                input.val('+88'); // Set value using jQuery
            }
        }
    </script>
@endsection

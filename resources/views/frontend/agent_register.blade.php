@extends('frontend.frontend_dashboard')
@section('main')
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Seller Registration</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Seller Registration</li>
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
                        <img src="{{ asset('frontend') }}/assets/images/seller_registration.jpg" class="img-fluid"
                            alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>Sign up as a <strong>SELLER</strong> - CampusMart BD</h4>
                        </div>

                        <form method="POST" action="{{ route('agentregister.store') }}">
                            @csrf
                            <div class="input-box">
                                <div class="row g-1">
                                    <!-- Name Input -->
                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="fullname" placeholder="Full Name"
                                                value="{{ old('name') }}" required>
                                            <label for="fullname">Shop Name</label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email Input -->
                                    <div class="col-12 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" placeholder="Email Address"
                                                value="{{ old('email') }}" required>
                                            <label for="email">Email Address</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Phone Input -->
                                    <div class="col-12 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" id="tel" placeholder="Phone No"
                                                value="{{ old('phone') }}" oninput="enforceBDCountryCode()" maxlength="14"
                                                required pattern="\+8801[3-9][0-9]{8}">
                                            <label for="tel">Phone No</label>
                                            <small class="form-text text-muted">Enter a valid Bangladeshi phone number
                                                (e.g., +8801XXXXXXXXX).</small>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="col-12 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                id="password" placeholder="Password" required>
                                            <label for="password">Password</label>
                                            <small class="form-text text-muted">Password must be at least 6 characters long
                                                (can include letters, digits, or special characters like @).</small>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="other-log-in">
                            <h6>or</h6>
                        </div>

                        <div class="sign-up-box">
                            <h4>Already have an account?</h4>
                            <a href="{{ route('login') }}">Log In</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
            </div>
        </div>
    </section>

    <script>
        function enforceBDCountryCode() {
            var input = $('#tel');
            var value = input.val();

            // Enforce +88 prefix
            if (!value.startsWith('+88')) {
                input.val('+88' + value.replace(/^\+88/, ''));
            }

            // Allow only + and digits, limit to 14 characters
            value = input.val().replace(/[^0-9+]/g, '').substring(0, 14);
            input.val(value);

            // Real-time validation feedback
            var errorDiv = input.siblings('.invalid-feedback');
            if (value.length < 13 || !/^\+8801[3-9][0-9]{8}$/.test(value)) {
                input.addClass('is-invalid');
                errorDiv.text('Please enter a valid Bangladeshi phone number (e.g., +8801XXXXXXXXX).').show();
            } else {
                input.removeClass('is-invalid');
                errorDiv.hide();
            }
        }
    </script>

    <!-- Ensure jQuery is included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

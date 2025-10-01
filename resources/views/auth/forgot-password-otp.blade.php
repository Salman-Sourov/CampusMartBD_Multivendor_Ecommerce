@extends('frontend.frontend_dashboard')

@section('main')
    <div class="container">
        <h2>Enter OTP</h2>
        <form action="{{ route('forgot.otp.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>OTP Code</label>
                <input type="number" name="otp" class="form-control" required>
                @error('otp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Verify OTP</button>
        </form>

        <div class="mt-3">
            <form action="{{ route('forgot.send') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_password_email') }}">
                <button type="submit" class="btn btn-link">Resend OTP</button>
            </form>
        </div>
    </div>
@endsection


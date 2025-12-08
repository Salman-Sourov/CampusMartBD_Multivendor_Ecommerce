@extends('agent.agent_dashboard')
@section('agent')
    <div class="page-content mt-5">
        {{-- ACTIVE ACCOUNT --}}
        @if ($agentId->status == 'active')
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: #fff;">
                <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3 p-3">

                    {{-- Agent Image --}}
                    <div class="flex-shrink-0">
                        <img src="{{ !empty($agentId->image) ? asset($agentId->image) : asset('upload/no_image.jpg') }}"
                            alt="Agent Image" class="rounded-circle border border-secondary shadow-sm"
                            style="width: 80px; height: 80px; object-fit: cover;">
                    </div>

                    {{-- Content --}}
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="letter-spacing: 0.5px;">Account Active</h5>
                        <p class="mb-2" style="font-size: 0.9rem;">
                            Your agent account is currently <strong>active</strong>. You can manage your listings, profile,
                            and other dashboard features.
                        </p>
                        <p class="mb-0 text-light" style="font-size: 0.85rem;">
                            Welcome back, <strong>{{ $agentId->name }}</strong>!
                        </p>
                    </div>
                </div>
            </div>

            {{-- INACTIVE ACCOUNT --}}
        @else
            <div class="card shadow-lg border-0"
                style="background: #aa02022c; color: #f1f1f1; border-left: 5px solid #ff6b6b;">
                <div class="card-body d-flex flex-column flex-md-row align-items-start gap-3 p-3">

                    {{-- Agent Image --}}
                    <div class="flex-shrink-0">
                        <img src="{{ !empty($agentId->image) ? asset($agentId->image) : asset('upload/no_image.jpg') }}"
                            alt="Agent Image" class="rounded-circle border border-secondary shadow-sm"
                            style="width: 80px; height: 80px; object-fit: cover;">
                    </div>

                    {{-- Content --}}
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-2" style="letter-spacing: 0.5px;">Account Inactive</h5>
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">
                            To activate your account, please complete your verification by providing the following:
                        </p>

                        <ul class="list-unstyled mb-3" style="font-size: 0.9rem;">
                            <li><i class="fas fa-check-circle text-success me-2"></i> Institution Name</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Roll / ID Number</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> NID Photo</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Student ID Photo</li>
                        </ul>

                        <a href="{{ route('agent.profile') }}" class="btn btn-gradient btn-sm px-4 py-2 text-white"
                            style="background: linear-gradient(90deg, #019d35, #018331); border: none;">
                            <i class="fas fa-user-edit me-1"></i> Complete Verification
                        </a>

                        <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;">
                            Once submitted, our admin team will review your information and activate your account shortly.
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

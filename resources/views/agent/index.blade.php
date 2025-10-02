@extends('agent.agent_dashboard')
@section('agent')
    @php
        $id = Auth::user()->id;
        $agentId = App\Models\User::find($id);
        $status = $agentId->status;
    @endphp

    <div class="page-content">

        @if ($status == 'active')
            <h4>Agent Account is <span class="text-success">Active</span></h4>
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <br>
                    <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
                </div>
            </div>
        @else
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 text-danger" style="font-size: 1.5rem;"></i>
                    <div>
                        <h4 class="alert-heading mb-2 text-danger">Agent Account Inactive</h4>
                        <p class="mb-0">Your account is under review. Please be patient—our admin team will check and
                            approve it shortly.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
@endsection

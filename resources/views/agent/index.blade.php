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
            <h4>Agent Account is <span class="text-danger">Inactive</span></h4>
            <p class="text-danger"><b> Please wait admin will check and approve your account</b></p>
        @endif
    </div>
@endsection

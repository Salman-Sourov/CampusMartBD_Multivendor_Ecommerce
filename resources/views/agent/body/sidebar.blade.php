@php
    $id = Auth::user()->id;
    $agentId = App\Models\User::find($id);
    $status = $agentId->status;
@endphp

<nav class="sidebar">
    <div class="sidebar-header" style="background: #011b39;">
        <a href="{{ route('index') }}" target="_blank" class="sidebar-brand">
            CampusMart<span> BD</span>
        </a>
    </div>
    <div class="sidebar-body" style="background: #011b39;">
        <ul class="nav">
            <li class="nav-item nav-category">Seller Dashboard</li>
            <li class="nav-item">
                <a href="{{ route('agent.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            @if ($status == 'active')
                <li class="nav-item nav-category">CampusMart BD Seller</li>
            @else
            {{-- <p>Inactive Account</p> --}}
            @endif
        </ul>
    </div>
</nav>

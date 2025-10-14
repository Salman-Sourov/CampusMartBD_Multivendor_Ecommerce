<div class="text-start">
    <h5>{{ $user->name }}</h5>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone }}</p>
    <p><strong>Institution:</strong> {{ $ver->institution->name ?? 'N/A' }}</p>
    <p><strong>Roll:</strong> {{ $ver->roll ?? 'N/A' }}</p>
    <p><strong>Verification Date:</strong> {{ $ver->verification_date ?? 'N/A' }}</p>

    <div class="d-flex justify-content-center gap-3 mt-3">
        @if ($ver->nid)
            <div>
                <p><strong>NID Photo</strong></p>
                <img src="{{ asset('upload/agent_ver_images/' . $ver->nid) }}" class="img-fluid rounded shadow"
                    width="300">
            </div>
        @endif
        @if ($ver->student_id)
            <div>
                <p><strong>Student ID Photo</strong></p>
                <img src="{{ asset('upload/agent_ver_images/' . $ver->student_id) }}" class="img-fluid rounded shadow"
                    width="300">
            </div>
        @endif
    </div>
</div>

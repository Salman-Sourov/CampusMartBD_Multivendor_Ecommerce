@extends('agent.agent_dashboard')
@section('agent')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @php
        $allSubmitted =
            $profileData->verification &&
            $profileData->verification->institution &&
            $profileData->verification->roll &&
            $profileData->verification->nid &&
            $profileData->verification->student_id;
    @endphp
    <div class="page-content">
        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <img class="wd-100 rounded-circle"
                                    src="{{ !empty($profileData->image) ? url('upload/agent_images/' . $profileData->image) : url('upload/no_image.jpg') }}"
                                    alt="profile">
                                <span class="h4 ms-3 ">{{ $profileData->name }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Shop Name</label>
                            <p class="text-muted">{{ $profileData->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Shop Email</label>
                            <p class="text-muted">{{ $profileData->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone</label>
                            <p class="text-muted">{{ $profileData->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    {{-- Verification --}}
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Seller Verification of - {{ $profileData->name }}</h6>

                            {{-- Notice --}}
                            @if (!$allSubmitted)
                                <div class="alert alert-info rounded shadow-sm mb-4">
                                    Please submit all required fields carefully. Once saved, these cannot be edited.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('agent.verification') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row g-3"> {{-- adds uniform gap between columns --}}
                                    {{-- Institution --}}
                                    <div class="col-md-6">
                                        <label for="institution" class="form-label">College/University *</label>
                                        @if ($profileData->verification->institution ?? '')
                                            <input type="text" class="form-control"
                                                value="{{ $institutions->where('id', $profileData->verification->institution)->first()?->name ?? '' }}"
                                                readonly>
                                        @else
                                            <select name="institution_id" class="form-control" id="institution">
                                                <option value="">Select your Institution</option>
                                                @foreach ($institutions as $institution)
                                                    <option value="{{ $institution->id }}"
                                                        {{ old('institution_id', $profileData->verification->institution ?? '') == $institution->id ? 'selected' : '' }}>
                                                        {{ $institution->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('institution_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>

                                    {{-- Roll --}}
                                    <div class="col-md-6">
                                        <label for="roll" class="form-label">University/College Roll No *</label>
                                        @if ($profileData->verification->roll ?? '')
                                            <input type="text" class="form-control"
                                                value="{{ $profileData->verification->roll }}" readonly>
                                        @else
                                            <input type="text" name="roll" class="form-control" id="roll"
                                                autocomplete="off"
                                                value="{{ old('roll', $profileData->verification->roll ?? '') }}">
                                            @error('roll')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>

                                    {{-- NID Upload --}}
                                    <div class="col-md-6 mt-3">
                                        <label for="nid" class="form-label">Upload NID Photo *</label>
                                        <input class="form-control mb-2" name="nid" type="file" id="nid">
                                        <img id="showNidImage" class="rectangle"
                                            src="{{ !empty($profileData->verification->nid) ? url('upload/agent_ver_images/' . $profileData->verification->nid) : url('upload/no_image.jpg') }}"
                                            width="170" height="120">
                                    </div>

                                    {{-- Student ID Upload --}}
                                    <div class="col-md-6 mt-3">
                                        <label for="student_id" class="form-label">Upload Student ID Photo *</label>
                                        <input class="form-control mb-2" name="student_id" type="file" id="student_id">
                                        <img id="showStudentImage" class="rectangle"
                                            src="{{ !empty($profileData->verification->student_id) ? url('upload/agent_ver_images/' . $profileData->verification->student_id) : url('upload/no_image.jpg') }}"
                                            width="170" height="120">
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="mt-4">
                                    @if (!$allSubmitted)
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    @else
                                        <button type="button" class="btn btn-success" disabled>Account Activated</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Profile --}}
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Seller Profile - {{ $profileData->name }}</h6>
                            <form method="POST" action="{{ route('agent.profile.store') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- Row 2: Phone + Address --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                autocomplete="off" value="{{ old('phone', $profileData->phone ?? '') }}">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control" id="address"
                                                autocomplete="off"
                                                value="{{ old('address', $profileData->address ?? '') }}">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Row 3: Upload + Preview --}}
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="image">Upload Photo</label>
                                            <input class="form-control" name="photo" type="file" id="image">
                                            @error('photo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex justify-content-center mb-3">
                                        <img id="showImage" class="wd-80 rounded-circle"
                                            src="{{ !empty($profileData->image) ? url('upload/agent_images/' . $profileData->image) : url('upload/no_image.jpg') }}"
                                            alt="profile" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <script>
        // NID preview
        document.getElementById('nid').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('showNidImage').src = e.target.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });

        // Student ID preview
        document.getElementById('student_id').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('showStudentImage').src = e.target.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

@endsection

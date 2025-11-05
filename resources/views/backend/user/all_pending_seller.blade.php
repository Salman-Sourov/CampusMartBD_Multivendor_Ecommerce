@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Pending Sellers</h6>

                        {{-- Table for large screens only --}}
                        <div class="table-responsive d-none d-md-block" style="overflow-x:auto;">
                            <table id="dataTableExample" class="table table-bordered table-striped align-midde">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Shop Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>NID</th>
                                        <th>S_ID_Photo</th>
                                        <th>Institution</th>
                                        <th>ID/Roll</th>
                                        <th>Address</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($inactive_seller as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>
                                                <img src="{{ !empty($item->verification->nid) && file_exists(public_path('upload/agent_ver_images/' . $item->verification->nid)) ? asset('upload/agent_ver_images/' . $item->verification->nid) : asset('upload/no_image.jpg') }}"
                                                    style="width:50px; height:30px; cursor:pointer;" class="preview-image"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                    data-image="{{ asset('upload/agent_ver_images/' . $item->verification->nid) }}">
                                            </td>
                                            <td>
                                                <img src="{{ !empty($item->verification->student_id) && file_exists(public_path('upload/agent_ver_images/' . $item->verification->student_id)) ? asset('upload/agent_ver_images/' . $item->verification->student_id) : asset('upload/no_image.jpg') }}"
                                                    style="width:50px; height:30px; cursor:pointer;" class="preview-image"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                    data-image="{{ asset('upload/agent_ver_images/' . $item->verification->student_id) }}">
                                            </td>
                                            <td class="two-line-column">{{ $item->verification->institutionData->name ?? 'N/A' }}</td>
                                            <td>{{ $item->verification->roll ?? 'N/A' }}</td>
                                            <td class="two-line-column">{{ $item->address ?? 'N/A' }}</td>
                                            <td class="two-line-column">{{ $item->created_at->timezone('Asia/Dhaka')->format('g:i A | j M Y') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $item->status == 'pending' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                    <a href="{{ route('verification.confirm', $item->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i data-feather="check-circle"></i>
                                                    </a>
                                                    <a href="{{ route('verification.reject', $item->id) }}"
                                                        class="btn btn-sm btn-danger">
                                                        <i data-feather="x-circle"></i>
                                                    </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Card layout for small screens --}}
                        <div class="d-md-none">
                            @forelse ($inactive_seller as $key => $item)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h6>{{ $item->name }}</h6>
                                        <p>Email: {{ $item->email }}</p>
                                        <p>Phone: {{ $item->phone }}</p>
                                        <p>Institution: {{ $item->verification->institutionData->name ?? 'N/A' }}</p>
                                        <p>Roll: {{ $item->verification->roll ?? 'N/A' }}</p>
                                        <p class="two-line">Address: {{ $item->address ?? 'N/A' }}</p>
                                        <div class="d-flex mb-2">
                                            {{-- NID --}}
                                            <img src="{{ !empty($item->verification->nid) &&
                                            file_exists(public_path('upload/agent_ver_images/' . $item->verification->nid))
                                                ? asset('upload/agent_ver_images/' . $item->verification->nid)
                                                : asset('upload/no_image.jpg') }}"
                                                style="width:70px; height:40px; cursor:pointer; margin-right:5px;"
                                                class="preview-image" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ asset('upload/agent_ver_images/' . $item->verification->nid) }}">
                                            {{-- Student ID --}}
                                            <img src="{{ !empty($item->verification->student_id) &&
                                            file_exists(public_path('upload/agent_ver_images/' . $item->verification->student_id))
                                                ? asset('upload/agent_ver_images/' . $item->verification->student_id)
                                                : asset('upload/no_image.jpg') }}"
                                                style="width:70px; height:40px; cursor:pointer;" class="preview-image"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ asset('upload/agent_ver_images/' . $item->verification->student_id) }}">
                                        </div>
                                        <p>Time: {{ $item->created_at->timezone('Asia/Dhaka')->format('g:i A | j M Y') }}
                                        </p>
                                        <span
                                            class="badge rounded-pill {{ $item->status == 'pending' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                        <div class="mt-2">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-warning viewDetails"
                                                data-id="{{ $item->id }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                            @if ($item->status == 'pending')
                                                <a href="{{ route('verification.confirm', $item->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                                <a href="{{ route('verification.reject', $item->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i data-feather="x-circle"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">No data available</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewImages = document.querySelectorAll('.preview-image');
            const modalImage = document.getElementById('modalImage');

            previewImages.forEach(img => {
                img.addEventListener('click', function() {
                    modalImage.src = this.getAttribute('data-image');
                });
            });
        });
    </script>


@endsection

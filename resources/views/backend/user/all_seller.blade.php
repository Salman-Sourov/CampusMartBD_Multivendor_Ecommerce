@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Active Sellers</h6>

                        {{-- Table for large screens only --}}
                        <div class="table-responsive d-none d-md-block" style="overflow-x:auto;">
                            <table id="dataTableExample" class="table table-bordered table-striped align-midde">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>ID</th>
                                        <th>Shop Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Institution</th>
                                        <th>NID</th>
                                        <th>SID</th>
                                        {{-- <th>ID/Roll</th>
                                        <th>Address</th>
                                        <th>Time</th> --}}
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($active_seller as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>CMS-0{{ $item->id }}</td>
                                            <td class="two-line-column">{{ $item->name }}</td>
                                            <td class="two-line-column">{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td class="two-line-column">
                                                {{ $item->verification->institutionData->name ?? 'N/A' }}</td>
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
                                            {{-- <td>{{ $item->verification->roll ?? 'N/A' }}</td>
                                            <td class="two-line-column">{{ $item->address ?? 'N/A' }}</td>
                                            <td class="two-line-column">
                                                {{ $item->created_at->timezone('Asia/Dhaka')->format('g:i A | j M Y') }}
                                            </td> --}}
                                            <td>
                                                <span
                                                    class="badge rounded-pill {{ $item->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <!-- Check Seller Profile (Backend) -->
                                                    <a href="#"
                                                        class="btn btn-sm btn-success text-white rounded-pill shadow px-2 py-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Check Seller Profile (Backend)">
                                                        <i data-feather="user-check" class="align-middle me-1"
                                                            style="width:14px; height:14px;"></i>
                                                    </a>

                                                    <!-- View Shop (Frontend) -->
                                                    <a href=""
                                                        class="btn btn-sm btn-outline-info rounded-pill shadow px-2 py-1"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="View Shop (Frontend)" target="_blank">
                                                        <i data-feather="eye" class="align-middle me-1"
                                                            style="width:14px; height:14px;"></i>
                                                    </a>
                                                </div>
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
                            @forelse ($active_seller as $key => $item)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h6>Serial: {{ $item->$key + 1 }}</h6>
                                        <h6>Seller ID: CMS-0{{ $item->id }}</h6>
                                        <h6>Name: {{ $item->name }}</h6>
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
                                        <div class="d-flex gap-1 mt-2">
                                            <a href="#"
                                                class="btn btn-sm btn-success text-white rounded-pill shadow px-3 py-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="View Seller Profile">
                                                <i data-feather="user-check" class="align-middle me-1"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-sm btn-outline-info rounded-pill shadow px-3 py-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Shop"
                                                target="_blank">
                                                <i data-feather="eye" class="align-middle me-1"></i>
                                            </a>
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

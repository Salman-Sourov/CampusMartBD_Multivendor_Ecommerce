@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Institutions
                </button>
            </ol>
        </nav>

        <!-- Add Institutions Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Institutions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <form id="addInstitutionsForm" method="POST"  action="{{ route('institutions.store') }}"
                            class="forms-sample" onsubmit="event.preventDefault(); StoreInstitutions();"> --}}
                        <form id="addInstitutionsForm" method="POST" enctype="multipart/form-data"
                            action="{{ route('institutions.store') }}"
                            onsubmit="event.preventDefault(); StoreInstitutions();">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" id="name">
                                <span id="name_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Logo *</label>
                                <input class="form-control" name="image" type="file" id="image">
                                <span id="image_error" class="text-danger"></span>
                            </div>
                            <!-- Image preview -->
                            <div class="form-group">
                                <img id="showImage" src="#" alt="Image Preview"
                                    style="max-width: 200px; display: none;">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Institutions</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALL institutions --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Institutions</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th class="serial-col">Sl</th>
                                        <th>Name</th>
                                        <th class="hidden-column">Logo</th>
                                        <th class="hidden-column">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="institutionsTableBody">
                                    @if ($institutions && count($institutions) > 0)
                                        @foreach ($institutions as $key => $item)
                                            <tr>
                                                <td class="serial-col">{{ $key + 1 }}</td>
                                                <td class="two-line-column">{{ $item->name }}</td>
                                                <td class="hidden-column"><img src="{{ !empty($item->logo) ? url($item->logo) : url('upload/no_image.jpg') }}"
                                                        style="width:70px; height:40px;"> </td>
                                                <td class="hidden-column">
                                                    @if ($item->status == 'active')
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">InActive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-inverse-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        id="{{ $item->id }}" onclick="institutionEdit(this.id)">
                                                        Edit
                                                    </button>

                                                    <a href="javascript:void(0);" class="btn btn-inverse-danger delete-btn"
                                                        data-id="{{ $item->id }}" title="Delete">Delete
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit institutions Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Institution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editInstitutionForm" method="POST" enctype="multipart/form-data" class="forms-sample"
                        onsubmit="event.preventDefault(); UpdateInstitution();">
                        @csrf
                        <!-- Simulate PATCH method -->
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="institution_id" id="institution_id">

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Name *</label>
                            <input type="text" name="edit_name" class="form-control" id="edit_name">
                            <span id="edit_name_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_image" class="form-label">Image *</label>
                            <input class="form-control" name="edit_image" type="file" id="edit_image">
                        </div>

                        <!-- Image preview -->
                        <div class="form-group mb-3">
                            <img id="edit_showImage" class="wd-100 rounded-circle"
                                src="{{ !empty($institution->logo) ? url('upload/institution/' . $institution->logo) : url('upload/no_image.jpg') }}"
                                alt="profile">
                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Store Institutions --}}
    {{-- Store Institutions --}}
    <script type="text/javascript">
        function StoreInstitutions() {
            var formData = new FormData(document.getElementById('addInstitutionsForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('institutions.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        // toastr.success(data.message);
                        // setTimeout(function() {
                        //     window.location.reload(); // Reload the page to see the new institution
                        // }, 100);
                        toastr.success(data.message);

                        // Append new row to table dynamically
                        $('#institutionsTableBody').append(`
    <tr>
        <td>${data.institution.id}</td>
        <td>${data.institution.name}</td>
        <td><img src="${data.institution.logo ? data.institution.logo : '/upload/no_image.jpg'}" style="width:70px;height:40px;"></td>
        <td><span class="badge rounded-pill bg-success">Active</span></td>
        <td>
            <button type="button" class="btn btn-inverse-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="${data.institution.id}" onclick="institutionEdit(${data.institution.id})">Edit</button>
            <a href="javascript:void(0);" class="btn btn-inverse-danger delete-btn" data-id="${data.institution.id}">Delete</a>
        </td>
    </tr>
`);

                        $('#addModal').modal('hide');
                        $('#addInstitutionsForm')[0].reset();
                        $('#showImage').hide();


                        $('#addInstitutionsForm')[0].reset(); // Reset the correct form
                    } else {
                        for (let field in data.errors) {
                            $('#' + field + '_error').text(data.errors[field][
                                0
                            ]); // Show validation error messages
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr); // Log the error for debugging
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); // Show validation errors
                    }
                }
            });
        }
    </script>

    {{-- Preview Image --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result).css('display',
                        'block'); // Ensure it displays
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    {{-- Edit institutions --}}
    <script type="text/javascript">
        function institutionEdit(institution_id) {
            $.ajax({
                type: 'GET',
                url: '/institutions/' + institution_id + '/edit',
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        $('#institution_id').val(data.institution_id);
                        $('#edit_name').val(data.institution_name);

                        // Show logo or fallback image
                        var imgSrc = data.logo ? data.logo : '/upload/no_image.jpg';
                        $('#edit_showImage').attr('src', imgSrc);

                        $('#editModal').modal('show'); // Open modal with data loaded
                    }
                },
                error: function(err) {
                    console.log(err);
                    toastr.error('Failed to fetch institution data.');
                }
            });
        }
    </script>

    {{-- Update institutions --}}
    <script type="text/javascript">
        function UpdateInstitution() {
            var formData = new FormData(document.getElementById('editInstitutionForm'));
            var institutionId = $('#institution_id').val();
            formData.append('_method', 'PATCH');

            $.ajax({
                type: 'POST',
                url: '/institutions/' + institutionId,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        $('#editModal').modal('hide');
                        // toastr.success(data.message);
                        // setTimeout(() => window.location.reload(), 100);
                        toastr.success(data.message);
                        $('#editModal').modal('hide');

                        // Update the corresponding row instantly
                        const row = $(`#institutionsTableBody tr`).find(
                            `button[id="${$('#institution_id').val()}"]`).closest('tr');
                        row.find('td:nth-child(2)').text($('#edit_name').val());
                        if (data.updated_logo) {
                            row.find('img').attr('src', data.updated_logo);
                        }
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        for (let field in errors) {
                            $('#' + field + '_error').text(errors[field][0]);
                        }
                    }
                }
            });
        }
    </script>


    {{-- Delete Institution instantly --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var button = $(this); // The clicked button
            var id = button.data('id');
            var url = '{{ route('institutions.destroy', ':id') }}';
            url = url.replace(":id", id);

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the table row instantly
                        button.closest('tr').fadeOut(300, function() {
                            $(this).remove();
                        });
                        toastr.success(response.message);
                    } else {
                        toastr.error('Failed to delete institution.');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while deleting.');
                    console.log(xhr);
                }
            });
        });
    </script>


@endsection

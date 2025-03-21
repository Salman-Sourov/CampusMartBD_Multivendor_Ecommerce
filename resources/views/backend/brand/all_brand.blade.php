@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Brand
                </button>
            </ol>
        </nav>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBrandForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreBrand();">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" name="name" class="form-control" id="name">
                                <span id="name_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="banglaInputText" class="form-label">Name in Bangla *</label>
                                <input type="text" name="name_bangla" class="form-control" id="banglaInputText">
                                <span id="name_bangla_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                                <span id="description_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" name="website" class="form-control" id="website">
                                <span id="website_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Image *</label>
                                <input class="form-control" name="image" type="file" id="image">
                                <span id="image_error" class="text-danger"></span>
                            </div>
                            <!-- Image preview -->
                            <div class="form-group">
                                <img id="showImage" src="#" alt="Image Preview"
                                    style="max-width: 200px; display: none;">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- ALL brand --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Brand</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($brands && count($brands) > 0)
                                        @foreach ($brands as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td><img src="{{ !empty($item->logo) ? url($item->logo) : url('upload/no_image.jpg') }}"
                                                        style="width:70px; height:40px;"> </td>
                                                <td>
                                                    @if ($item->status == 'active')
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">InActive</span>
                                                    @endif
                                                </td>
                                                <td>

                                                    {{-- <a class="btn toggle-class {{ $item->status == 'active' ? 'btn-inverse-success' : 'btn-inverse-danger' }}"
                                                        title="Status" data-id="{{ $item->id }}"
                                                        data-status="{{ $item->status }}">

                                                        <i
                                                            data-feather="{{ $item->status == 'active' ? 'toggle-left' : 'toggle-right' }}"></i>
                                                    </a> --}}

                                                    <button type="button" class="btn btn-inverse-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        id="{{ $item->id }}" onclick="brandEdit(this.id)">
                                                        Edit
                                                    </button>

                                                    {{-- <button type="button" class="btn btn-inverse-danger"
                                                        data-id="{{ $item->id }}" id="delete">Delete</button> --}}

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

    <!-- Edit Brand Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBrandForm" method="POST" enctype="multipart/form-data" class="forms-sample"
                        onsubmit="event.preventDefault(); UpdateBrand();">
                        @csrf
                        <!-- Simulate PATCH method -->
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="brand_id" id="brand_id">

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Name *</label>
                            <input type="text" name="edit_name" class="form-control" id="edit_name">
                            <span id="edit_name_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_banglaInputText" class="form-label">Bangla Name *</label>
                            <input type="text" name="edit_banglaInputText" class="form-control"
                                id="edit_banglaInputText">
                            <span id="edit_banglaInputText_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea name="edit_description" class="form-control" id="edit_description" rows="4"></textarea>
                            <span id="edit_description_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_website" class="form-label">Website</label>
                            <input type="text" name="edit_website" class="form-control" id="edit_website">
                            <span id="edit_website_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_image" class="form-label">Image *</label>
                            <input class="form-control" name="edit_image" type="file" id="edit_image">
                        </div>

                        <!-- Image preview -->
                        <div class="form-group mb-3">
                            <img id="edit_showImage" class="wd-100 rounded-circle"
                                src="{{ !empty($brand->logo) ? url('upload/brand/' . $brand->logo) : url('upload/no_image.jpg') }}"
                                alt="profile">
                        </div>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Store Brand --}}
    <script type="text/javascript">
        function StoreBrand() {
            var formData = new FormData(document.getElementById('addBrandForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('brand.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        toastr.success(data.message);
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 1500);

                        $('#addBrandForm')[0].reset(); // Reset the correct form
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

    {{-- Edit Brand --}}
    <script type="text/javascript">
        function brandEdit(brand_id) {
            $.ajax({
                type: 'GET',
                url: '/brand/' + brand_id + '/edit', // Ensure this is the correct route
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        $('#brand_id').val(data.brand_id);
                        $('#edit_name').val(data.brand_name);
                        $('#edit_banglaInputText').val(data.name_bangla);
                        $('#edit_description').val(data.description);
                        $('#edit_website').val(data.website);
                        // $('#edit_image').val(data.logo);
                        var imgSrc = data.logo ? data.logo : '/upload/no_image.jpg';
                        $('#edit_showImage').attr('src', imgSrc);
                        $('#editModal').modal('show'); // Open modal with data loaded

                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>

    {{-- Update Brand --}}
    <script type="text/javascript">
        function UpdateBrand() {
            var formData = new FormData(document.getElementById('editBrandForm'));
            var brandId = $('#brand_id').val(); // Get the brand ID
            console.log(brandId);

            $.ajax({
                type: 'POST', // POST method to support _method PATCH
                url: '/brand/' + brandId,
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token header
                },
                success: function(data) {
                    if (data.success) {
                        $('#editModal').modal('hide'); // Close the modal
                        toastr.success(data.message); // Show success notification
                        // Optionally refresh the brand list or table here
                        setTimeout(function() {
                            window.location.reload(); // Reload the page to see the new brand
                        }, 1500);
                    } else {
                        for (let field in data.errors) {
                            $('#' + field + '_error').text(data.errors[field][0]); // Show error
                        }
                    }
                },

                error: function(xhr) {
                    console.log(xhr); // Log the error for debugging
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); // Show error
                    }
                }


            });
        }
    </script>

    {{-- Delete Brand --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('brand.destroy', ':id') }}';
            url = url.replace(":id", id); // Replace placeholder with actual ID

            // SweetAlert confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request if the user confirms
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}" // Include CSRF token for security
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );

                                toastr.success('Deleted Successfully.');
                                setTimeout(function() {
                                    window.location
                                        .reload(); // Reload the page to see the new brand
                                }, 1500); // Reload the page after successful deletion

                                // Delay the reload to show the message
                            } else {
                                toastr.error('Failed to delete the brand.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred while deleting the item.');
                            console.log(xhr); // Log the error for debugging
                        }
                    });
                }
            });
        });
    </script>

    {{-- Bangla Language --}}
    <script src="{{ asset('backend/assets/js/bangla.js') }}"></script>
    <script>
        $('#edit_banglaInputText').bangla({
            enable: true
        });
        $('#edit_banglaInputText').bangla('on');

        $('#edit_banglaInputText').bangla({
            enable: true
        });
        $('#edit_banglaInputText').bangla('on');
    </script>

@endsection

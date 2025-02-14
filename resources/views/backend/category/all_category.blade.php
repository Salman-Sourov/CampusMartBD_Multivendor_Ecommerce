@extends('admin.admin_dashboard')
@section('admin')


    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Category
                </button>
            </ol>
        </nav>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCategoryForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreCategory();">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name*</label>
                                <input type="text" name="name" class="form-control" id="name">
                                <span id="name_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="banglaInputText" class="form-label">Name in Bangla*</label>
                                <input type="text" name="name_bangla" class="form-control" id="banglaInputText">
                                <span id="name_bangla_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4"></textarea>
                                <span id="description_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" name="image" type="file" id="image">
                            </div>
                            <!-- Image preview -->
                            <div class="form-group mb-3">
                                <img id="showImage" src="#" alt="Image Preview"
                                    style="max-width: 200px; display: none;">
                            </div>

                            {{-- <div class="col-9-row d-flex justify-content-start align-items-center mb-3">
                                <div class="form-check mb-2 me-4"> <!-- Added margin to space between checkboxes -->
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
                                    <label class="form-check-label" for="is_featured">
                                        Featured Category
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="enableSubcat" class="form-check-input" id="enableSubcat">
                                    <label class="form-check-label" for="enableSubcat">
                                        Enable Sub Category
                                    </label>
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        {{-- ALL category Modal --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Category</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Category Name</th>
                                        <th>Bangla Name</th>
                                        <th>Description</th>
                                        <th>Logo</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($categories && count($categories) > 0)
                                        @foreach ($categories as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->translations->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td><img src="{{ !empty($item->image) ? url($item->image) : url('upload/no_image.jpg') }}"
                                                        style="width:70px; height:40px;"> </td>
                                                <td>
                                                    @if ($item->status == 'active')
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">InActive</span>
                                                    @endif
                                                </td>
                                                <td>

                                                    <button type="button" class="btn btn-inverse-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        id="{{ $item->id }}" onclick="categoryEdit(this.id)">
                                                        Edit
                                                    </button>

                                                    <a href="javascript:void(0);"
                                                        class="btn btn-inverse-danger delete-btn"
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


    <!-- Edit Category Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" method="POST" enctype="multipart/form-data" class="forms-sample"
                        onsubmit="event.preventDefault(); UpdateCategory();">
                        @csrf
                        <!-- Simulate PATCH method -->
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="cat_id" id="cat_id">

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Name*</label>
                            <input type="text" name="edit_name" class="form-control" id="edit_name">
                            <span id="edit_name_error" class="text-danger"></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit_banglaInputText" class="form-label">Bangla Name*</label>
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
                            <label for="edit_image" class="form-label">Image</label>
                            <input class="form-control" name="edit_image" type="file" id="edit_image">
                        </div>

                        <!-- Image preview -->
                        <div class="form-group mb-3">
                            <img id="edit_showImage" class="wd-100 rounded-circle"
                                src="{{ !empty($category->image) ? url('upload/category/' . $category->image) : url('upload/no_image.jpg') }}"
                                alt="profile">
                        </div>

                        {{-- <div class="col-9-row d-flex justify-content-start align-items-center mb-3">
                            <div class="form-check mb-2 me-4"> <!-- Added margin to space between checkboxes -->
                                <input type="checkbox" name="is_featured" class="form-check-input"
                                    id="edit_is_featured">
                                <label class="form-check-label" for="edit_is_featured">
                                    Featured Category
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="enableSubcat" class="form-check-input"
                                    id="edit_enableSubcat">
                                <label class="form-check-label" for="edit_enableSubcat">
                                    Enable Sub Category
                                </label>
                            </div>
                        </div> --}}


                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Store Category --}}
    <script type="text/javascript">
        function StoreCategory() {
            var formData = new FormData(document.getElementById('addCategoryForm'));



            $.ajax({
                type: 'POST',
                url: '{{ route('category.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        toastr.success(data.message);
                        $('#addCategoryForm')[0].reset();
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
        function categoryEdit(cat_id) {
            $.ajax({
                type: 'GET',
                url: '/category/' + cat_id + '/edit', // Ensure this is the correct route
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                    } else {
                        $('#cat_id').val(data.cat_id);
                        $('#edit_name').val(data.name);
                        $('#edit_banglaInputText').val(data.name_bangla);
                        $('#edit_description').val(data.description);

                        // $('#edit_image').val(data.logo);
                        var imgSrc = data.image ? data.image : '/upload/no_image.jpg';
                        $('#edit_showImage').attr('src', imgSrc);
                        $('#edit_is_featured').prop('checked', data.is_featured ==
                        1); // Check if 'is_featured' is true
                        $('#edit_enableSubcat').prop('checked', data.enableSubcat ==
                        1); // Check if 'enableSubcat' is true
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
        function UpdateCategory() {
            var formData = new FormData(document.getElementById('editCategoryForm'));
            var cat_Id = $('#cat_id').val(); // Get the brand ID
            console.log(cat_Id);

            $.ajax({
                type: 'POST', // POST method to support _method PATCH
                url: '/category/' + cat_Id,
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

    {{-- Delete Category --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('category.destroy', ':id') }}';
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
                                }, 1500);
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

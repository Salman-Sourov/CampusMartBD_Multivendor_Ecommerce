@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#addModal">
                    Add Stock
                </button>
            </ol>
        </nav>

        <!-- Add Category Stock  -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addStockForm" method="POST" action="" class="forms-sample"
                            onsubmit="event.preventDefault(); StoreStock();">
                            @csrf
                            <input type="hidden" name="product_id" value={{ $product_id->id }}>
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Attribute Set</label>
                                <select name="attribute_set" class="form-control" id="attribute_set"
                                    onChange="attributeChange()">
                                    <option value="">Select Attribute Set</option>
                                    <!-- Options will be dynamically populated here -->
                                    @foreach ($attributeSets as $attributeSet)
                                        <option value="{{ $attributeSet->id }}">{{ $attributeSet->title }}</option>
                                    @endforeach
                                </select>
                                <span id="attribute_set_error" class="text-danger"></span>
                                <!-- Error message placeholder -->
                            </div>

                            <div class="form-group mb-3 attribute_container">
                                <label for="attribute" class="form-label">Attribute</label>
                                <select name="attribute" class="form-control" id="attribute_id">

                                </select>
                                @error('attribute')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <span id="attribute_error" class="text-danger"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Price</label>
                                <input name="price" type="number" class="form-control" id="price">
                                <span id="price_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Sale Price</label>
                                <input name="sale_price" type="number" class="form-control" id="sale_price">
                                <span id="sale_price_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>




                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Stock</label>
                                <input name="stock" type="number" class="form-control" id="stock">
                                <span id="stock_error" class="text-danger"></span> <!-- Error message placeholder -->
                            </div>

                            <button type="submit" class="btn btn-primary">Add Stock</button>
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
                                        <th>Product Name</th>
                                        <th>Attribute</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="brandTableBody">
                                    @if ($stocks && count($stocks) > 0)
                                        @foreach ($stocks as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @php
                                                        $product = App\Models\Product::where(
                                                            'id',
                                                            $item->product_id,
                                                        )->first();
                                                    @endphp
                                                    {{ $product->name }}
                                                </td>

                                                <td>
                                                    @php
                                                        $attribute = App\Models\Product_attribute::where(
                                                            'id',
                                                            $item->attribute_id,
                                                        )->first();
                                                    @endphp
                                                    {{ $attribute->title }}
                                                </td>

                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->sale_price }}</td>
                                                <td>{{ $item->stock }}</td>

                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">InActive</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-inverse-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                                        id="{{ $item->id }}" onclick="stockEdit(this.id)">
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


    <!-- Edit Stock Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editStockForm" method="POST" enctype="multipart/form-data" class="forms-sample"
                        onsubmit="event.preventDefault(); UpdateStock();">
                        @csrf
                        <!-- Simulate PATCH method -->
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="product_id" id="product_id">

                        <div class="form-group mb-3">
                            <label for="edit_name" class="form-label">Attribute Set</label>

                            <select name="edit_attribute_set" class="form-control" id="edit_attribute_set"
                                onChange="EditAttributeChange()">
                                <option value="">Select Attribute Set</option>
                                <!-- Options will be dynamically populated here -->
                                @foreach ($attributeSets as $attributeSet)
                                    <option value="{{ $attributeSet->id }}">{{ $attributeSet->title }}</option>
                                @endforeach
                            </select>
                            <span id="edit_attribute_set_error" class="text-danger"></span>
                        </div>


                        <div class="form-group mb-3 edit_attribute_container">
                            <label for="attribute" class="form-label">Attribute</label>
                            <select name="edit_attribute" class="form-control" id="edit_attribute_id">

                            </select>
                            @error('attribute')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span id="edit_attribute_error" class="text-danger"></span>
                        </div>



                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Price</label>
                            <input name="edit_price" type="number" class="form-control" id="edit_price">
                            <span id="edit_price_error" class="text-danger"></span> <!-- Error message placeholder -->
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Sale Price</label>
                            <input name="edit_sale_price" type="number" class="form-control" id="edit_sale_price">
                            <span id="edit_sale_price_error" class="text-danger"></span>
                            <!-- Error message placeholder -->
                        </div>




                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Stock</label>
                            <input name="edit_stock" type="number" class="form-control" id="edit_stock">
                            <span id="edit_stock_error" class="text-danger"></span> <!-- Error message placeholder -->
                        </div>


                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- Store Stock --}}
    <script type="text/javascript">
        function attributeChange() {
            var attribute_set = $('#attribute_set').val();
            console.log('Selected Attribute Set ID:', attribute_set);

            if (attribute_set) {
                $.ajax({
                    url: '/get-attribute/' + attribute_set, // URL to fetch attributes
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Fetched Attributes:', data); // Log the fetched attributes for debugging

                        $('.attribute_container').show();
                        // Clear existing options
                        $('#attribute_id').empty();

                        // Add default option
                        $('#attribute_id').append('<option value="">Select an Attribute</option>');

                        // Iterate over the data and populate the dropdown
                        $.each(data, function(index, attribute) {
                            $('#attribute_id').append('<option value="' + attribute.id + '">' +
                                attribute.title + '</option>');
                        });

                        $('#attribute_id').trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching attributes:', error);
                    }
                });
            } else {
                // If no attribute set is selected, clear the attribute dropdown
                $('#attribute').empty();
                $('#attribute').append('<option value="">Select an Attribute</option>');
            }
        }

        function EditAttributeChange()
        {
            var attribute_set = $('#edit_attribute_set').val();
            console.log(attribute_set);

            if (attribute_set) {
                $.ajax({
                    url: '/get-edit-attribute/' + attribute_set, // URL to fetch attributes
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Fetched Attributes:', data); // Log the fetched attributes for debugging

                        $('.edit_attribute_container').show();
                        // Clear existing options
                        $('#edit_attribute_id').empty();

                        // Add default option
                        $('#edit_attribute_id').append('<option value="">Select an Attribute</option>');

                        // Iterate over the data and populate the dropdown
                        $.each(data, function(index, attribute) {
                            $('#edit_attribute_id').append('<option value="' + attribute.id + '">' +
                                attribute.title + '</option>');
                        });

                        $('#edit_attribute_id').trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching attributes:', error);
                    }
                });
            } else {
                // If no attribute set is selected, clear the attribute dropdown
                $('#edit_attribute').empty();
                $('#edit_attribute').append('<option value="">Select an Attribute</option>');
            }
        }

        function StoreStock() {
            var formData = new FormData(document.getElementById('addStockForm'));

            $.ajax({
                type: 'POST',
                url: '{{ route('stock.store') }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    //console.log(data); // Check the success response in the console

                    if (data.success) {
                        $('#addModal').modal('hide'); // Close modal
                        toastr.success(data.message);
                        $('#addStockForm')[0].reset();
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

<script type="text/javascript">
    function stockEdit(stock_id) {
        $.ajax({
            type: 'GET',
            url: '/stock/' + stock_id + '/edit', // Ensure this is the correct route
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    console.log(data.error);
                } else {
                    // Set the value of edit_attribute_set dropdown
                    $('#edit_attribute_set').val(data.edit_attribute_set).trigger('change');

                    var edit_attribute_set = data.edit_attribute_set;
                    console.log(edit_attribute_set); // To verify the selected attribute set ID

                    // Fetch attributes if a valid attribute set is selected
                    if (edit_attribute_set) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-stock-attribute/' + edit_attribute_set, // Correct the route
                            dataType: 'json',
                            success: function(attributeData) {
                                if (attributeData.error) {
                                    console.log(attributeData.error);
                                } else {
                                    $('#edit_attribute_id').empty(); // Clear existing options

                                    // Add default option
                                    $('#edit_attribute_id').append(
                                        '<option value="">Select an Attribute</option>'
                                    );

                                    // Populate attribute options dynamically
                                    $.each(attributeData, function(index, attribute) {
                                        $('#edit_attribute_id').append(
                                            '<option value="' + attribute.id + '">' + attribute.title + '</option>'
                                        );
                                    });

                                    // Set the previously selected attribute
                                    $('#edit_attribute_id').val(data.edit_attribute).trigger('change');
                                }
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        });
                    }

                    // Set the rest of the fields in the modal
                    $('#product_id').val(data.product_id); // Ensure 'product_id' is in the response
                    $('#edit_price').val(data.edit_price);
                    $('#edit_sale_price').val(data.edit_sale_price);
                    $('#edit_stock').val(data.edit_stock);

                    // Open the modal
                    $('#editModal').modal('show');
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>


    {{-- Update Stock  --}}
    <script type="text/javascript">
        function UpdateStock() {
            var formData = new FormData(document.getElementById('editStockForm'));
            var product_Id = $('#product_id').val(); // Get the brand ID
            console.log('hello');

            $.ajax({
                type: 'POST',  // POST method, but _method field will simulate PATCH
                url: '/stock/' + product_Id,
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

    {{-- Delete Stock  --}}
    <script type="text/javascript">
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Get the data-id from the button
            var url = '{{ route('stock.destroy', ':id') }}';
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
                                toastr.error('Failed to delete the Stock.');
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

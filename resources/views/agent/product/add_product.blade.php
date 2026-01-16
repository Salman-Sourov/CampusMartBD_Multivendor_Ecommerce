@extends('agent.agent_dashboard')
@section('agent')
    <div class="page-content">
        <div class="row profile-body">
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Product</h4>
                            <h5 class="text-danger mb-2">* Marks all field are mendatory</h5>
                            <form method="post" action="{{ route('product.store') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group mb-3">
                                            <label class="form-label text-danger">Product Name *</label>
                                            <input type="text" name="product_name" class="form-control"
                                                value="{{ old('product_name') }}">
                                            @error('product_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="banglaInputText" class="form-label">Name in Bangla *</label>
                                            <input type="text" name="product_name_bangla" class="form-control"
                                                id="banglaInputText" value="{{ old('product_name_bangla') }}">
                                            @error('product_name_bangla')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label class="form-label text-danger">Product Quantity *</label>
                                            <input type="text" name="quantity" class="form-control"
                                                value="{{ old('quantity') }}">
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="categoryr" class="form-label text-danger">Category *</label>
                                            <select name="category_id" class="form-control" id="category_id"
                                                onChange="categoryChanged()">
                                                <option value="">Select a Category</option>
                                                @foreach ($categories as $category)
                                                    {{-- <option value="{{ $category->id }}">{{ $category->name }}</option> --}}
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="sub_category" class="form-label">Sub Category</label>
                                            <select name="sub_category_id" class="form-control" id="sub_category">
                                            </select>
                                            @error('sub_category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label text-danger">Sale Price (Sell/New Price) *</label>
                                            <input type="text" name="sale_price" class="form-control"
                                                value="{{ old('sale_price') }}">
                                            @error('sale_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Price (Old Price)</label>
                                            <input type="text" name="price" class="form-control"
                                                value="{{ old('price') }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label text-danger">Short Content *</label>
                                            <textarea name="short_content" class="form-control" id="exampleFormControlTextarea1" rows="4">{{ old('short_content') }}</textarea>
                                            @error('short_content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label text-danger">Main Thumbnail *</label>
                                            <input type="file" name="thumbnail" class="form-control"
                                                onChange="mainThamUrl(this)">
                                            <img src="" id="mainThmb">
                                            @error('thumbnail')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    <h5 class="text-warning mb-2">Below fields are optional</h5>

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Long Description</label>
                                            <textarea name="description" class="form-control" rows="10">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="imageFieldsContainer">
                                        <div id="image-input-container" class="form-group mb-3 image-field">
                                            <label class="form-label text-warning">Multiple Images</label>
                                            <div class="d-flex mb-2">
                                                <input type="file" name="multi_img[]" class="form-control multiImg">
                                                <button type="button"
                                                    class="btn btn-primary ms-2 addMoreButton">+</button>
                                            </div>
                                            <img class="image-preview ms-2"
                                                style="width: 50px; height:50px; display: none;" src="" />
                                            @error('multi_img')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <button type="submit" class="btn btn-primary">Save Changes </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        function categoryChanged() {
            var categoryId = $('#category_id').val();
            // Get selected category ID
            // console.log('Selected Category ID:', categoryId);
            if (categoryId) {
                $.ajax({
                    url: "{{ url('agent/get-subcategories') }}/" + categoryId, // URL to fetch subcategories
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sub_category').empty().append('<option value="">Select a Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name +
                                '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.log('Error fetching subcategories:', xhr.responseText);
                    }
                });
            } else {
                $('#sub_category').empty();
            }
        }


        $(document).ready(function() {
            let imageCounter = 1; // Start from 1 for the first cloned input

            // Handle adding a new input field
            $('#imageFieldsContainer').on('click', '.addMoreButton', function() {
                // Clone the first image field
                var imageField = $('.image-field').first().clone();

                // Remove any file from the cloned input and hide/reset the preview
                $(imageField).find('input[type="file"]').val('');
                $(imageField).find('.image-preview').attr('src', '').hide(); // Reset image preview

                // Update the IDs for the new input and preview
                $(imageField).find('input[type="file"]').attr('id', 'imageInput_' + imageCounter);
                $(imageField).find('.image-preview').attr('id', 'imagePreview_' + imageCounter);

                // Create a remove button
                var removeButton = $('<button/>', {
                    type: 'button',
                    class: 'btn btn-danger ms-2 removeButton',
                    text: '-'
                });

                // Append the remove button next to the cloned "+" button
                $(imageField).find('.addMoreButton').after(removeButton);

                // Append the new image field to the container
                $('#imageFieldsContainer').append(imageField);

                imageCounter++; // Increment the counter for the next input
            });

            // Handle removing an input field
            $('#imageFieldsContainer').on('click', '.removeButton', function() {
                $(this).closest('.image-field').remove(); // Remove the closest image field
            });

            // Handle image preview
            $('#imageFieldsContainer').on('change', 'input[type="file"]', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Find the corresponding preview image for the input
                        $(this).closest('.image-field').find('.image-preview').attr('src', e.target
                            .result).show();
                    }.bind(this); // Bind 'this' to access the input element within the FileReader
                    reader.readAsDataURL(file);
                }
            });
        });

        function mainThamUrl(input) {
            // Check if a file has been selected
            if (input.files && input.files[0]) {
                var reader = new FileReader(); // Create a FileReader object

                reader.onload = function(e) {
                    // Set the src of the img element to the file's data URL
                    var img = document.getElementById('mainThmb');
                    img.src = e.target.result;
                    // Update the src to the loaded file
                    img.style.width = '50px'; // Set width
                    img.style.height = '50px'; // Set height
                    img.style.display = 'block'; // Show the image
                }

                reader.readAsDataURL(input.files[0]); // Read the selected file as a data URL
            }
        }
    </script>
@endsection

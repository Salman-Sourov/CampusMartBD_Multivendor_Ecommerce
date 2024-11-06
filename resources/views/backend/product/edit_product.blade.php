@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="row profile-body">
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Edit Product</h6>

                            <form method="POST" action="{{ route('product.update',$product->id) }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" value="{{ $product->id }}" name="update_prduct_id">
                                
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Product Name *</label>
                                            <input type="text" name="product_name" class="form-control"
                                                value="{{ $product->name }}">
                                            @error('product_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="banglaInputText" class="form-label">Name in Bangla</label>
                                            <input type="text" name="product_name_bangla" class="form-control"
                                                id="banglaInputText"
                                                value="{{ $product->translatiosn ? $product->translations->name : 'N/A' }}">
                                            @error('product_name_bangla')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group mb-3">
                                            <label for="brand" class="form-label">Brand</label>
                                            <select name="brand_id" class="form-control" id="brand">
                                                <option selected="" disabled="">Select a Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <input type="hidden" id="sub_category_id"
                                                value="{{ $product->categories->category_id }}">
                                            <select name="category_id" class="form-control" id="category_id"
                                                onChange="categoryChanged()">
                                                <option value="">Select a Category</option>

                                                @if ($product->categories->category_detail->parent_id)
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->categories->category_detail->parent_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $product->categories->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif


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

                                    <div class="col-sm-2">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Product Quantity</label>
                                            <input type="text" name="quantity" class="form-control" placeholder="N/A"
                                                value="{{ old('quantity', $product->quantity) }}">
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="text" name="price" class="form-control" placeholder="N/A"
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Sale Price</label>
                                            <input type="text" name="sale_price" class="form-control" placeholder="N/A"
                                                value="{{ old('sale_price', $product->sale_price) }}">
                                            @error('sale_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">Start Date</label>
                                        <input class="form-control mb-4 mb-md-0" data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd" inputmode="numeric" value="{{ old('start_date', $product->start_date) }}">
                                    </div> --}}

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date', $product->start_date) }}">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date', $product->end_date) }}">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Length</label>
                                            <input type="text" name="length" class="form-control" placeholder="N/A"
                                                value="{{ old('length', $product->length) }}">
                                            @error('length')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Wide</label>
                                            <input type="text" name="wide" class="form-control" placeholder="N/A"
                                                value="{{ old('wide', $product->wide) }}">
                                            @error('wide')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Height</label>
                                            <input type="text" name="height" class="form-control" placeholder="N/A"
                                                value="{{ old('height', $product->height) }}">
                                            @error('height')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Weight</label>
                                            <input type="text" name="weight" class="form-control" placeholder="N/A"
                                                value="{{ old('weight', $product->weight) }}">
                                            @error('weight')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Short Content</label>
                                            <textarea name="short_content" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                                placeholder="N/A">{{ old('short_content', $product->content) }}</textarea>
                                            @error('short_content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Long Description</label>
                                            <textarea name="description" class="form-control" rows="10">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="form-label">Main Thumbnail</label>
                                            <input type="file" name="thumbnail" class="form-control"
                                                onChange="mainThamUrl(this)">
                                            <img src="" id="mainThmb">
                                            @error('thumbnail')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <img src="{{ asset($product->thumbnail) }}"
                                                style="width:100px; height:100px;">
                                        </div>
                                    </div>

                                    <div class="col-sm-7">
                                        <div class="page-content" style="margin-top: -35px;">
                                            <div class="row profile-body">
                                                <div class="col-md-12 col-xl-12 middle-wrapper">
                                                    <div class="row">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Edit Multi Image</h6>

                                                                <form method="post" action="" id="myForm"
                                                                    enctype="multipart/form-data">
                                                                    @csrf

                                                                    <div class="table-responsive">
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Sl</th>
                                                                                    <th>Image</th>
                                                                                    {{-- <th>Change Image</th> --}}
                                                                                    <th>Delete</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($product->multi_images as $multi_image => $img)
                                                                                    <tr>
                                                                                        <td>{{ $multi_image + 1 }}</td>
                                                                                        <td class="py-1">
                                                                                            <img src="{{ asset($img->image_detail->image) }}"
                                                                                                alt="image"
                                                                                                style="width: 80px";
                                                                                                height="190px">
                                                                                        </td>

                                                                                        {{-- <td><input type="file" 
                                                                                                class="form-control"
                                                                                                name="multi_img[{{ $img->id }}]"
                                                                                                value="{{ $img->image_detail->id }}">

                                                                                        </td> --}}
                                                                                        {{-- multiimage id --}}
                                                                                        <td>
                                                                                            {{-- <input type="submit"
                                                                                                class="btn btn-primary px-4"
                                                                                                value="Update Image"> --}}
                                                                                            <a href="{{ route('deleteMultiImg.delete', $img->image_detail->id) }}"
                                                                                                class="btn btn-danger"
                                                                                                id="delete">Delete</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach

                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <br><br>

                                                                </form>



                                                                <form method="post"
                                                                    action="{{ route('uploadMultiImg.add') }}"
                                                                    id="myForm" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="imageid" value="">
                                                                    <input type="hidden" value="{{ $product->id }}"
                                                                        name="upload_product_id">
                                                                    <table class="table table-striped">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <input type="file"
                                                                                        class="form-control"
                                                                                        name="multi_img">
                                                                                    @error('multi_img')
                                                                                        <span
                                                                                            class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </td>

                                                                                <td>
                                                                                    <input type="submit"
                                                                                        class="btn btn-info px-4"
                                                                                        value="Add Image">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </form>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- @foreach ($product->multi_images as $multi_image) --}}
                                    {{-- <div class="row">
                                            <div class="mb-4 row align-items-center image-field">

                                                <div class="col-sm-6">
                                                    <input type="file" class="form-control image-input" name="multi_img__{{ $multi_image->image_detail->id }}" onchange="previewImage(this)">
                                                    <div class="invalid-feedback error-message"></div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="ec_multi_images_id" type="hidden" name="ec_multi_images_id[]" value="{{ $multi_image->image_detail->id }}" />
                                                    <img class="image-preview mb-4 row align-items-right" style="height: 80px; width:100px;"  src="{{ asset($multi_image->image_detail->image) }}" />

                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-danger" onclick="removeImagePreview(this)">X</button>
                                                </div>
                                            </div>
                                        </div> --}}

                                    {{-- <div class="col-sm-7" id="imageFieldsContainer">
                                            <div id="image-input-container" class="form-group mb-3 image-field">
                                                <label class="form-label">Multiple Images</label>
                                                <div class="d-flex mb-2">
                                                    <input type="file" name="multi_img[]"
                                                        class="form-control multiImg">
                                                    <button type="button"
                                                        class="btn btn-primary ms-2 addMoreButton">+</button>
                                                </div>
                                                <img class="image-preview ms-2"
                                                    style="width: 50px; height:50px; display: none;" src="" />
                                                @error('multi_img')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                    {{-- @endforeach --}}


                                    <!-- //multi image update// -->




                                    <div class="col-sm-3">
                                        <label class="form-label">Video Type</label>
                                        <select name="video_type[]" class="form-control">
                                            <option value="" disabled selected>Select Video Type</option>
                                            <option value="youtube"
                                                {{ optional($product->videos->first()->video_detail ?? null)->video_type == 'youtube' ? 'selected' : '' }}>
                                                Youtube
                                            </option>
                                            <option value="vimeo"
                                                {{ optional($product->videos->first()->video_detail ?? null)->video_type == 'vimeo' ? 'selected' : '' }}>
                                                Vimeo
                                            </option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div><!-- Col -->

                                    <div class="col-sm-9">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Video Link</label>
                                            <input type="text" name="video_link[]" class="form-control"
                                                value="{{ $product->videos->first()->video_detail->video_link ?? '' }}"
                                                placeholder="N/A">
                                        </div>
                                    </div><!-- Col -->


                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <div class="form-check form-check-inline me-3">
                                                <input type="checkbox" name="status" value="1"
                                                    class="form-check-input" id="status"
                                                    {{ $product->status == 'active' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status">Enable Status</label>
                                            </div>
                                            <div class="form-check form-check-inline me-3">
                                                <input type="checkbox" name="is_variation" value="1"
                                                    class="form-check-input" id="is_variation"
                                                    {{ $product->is_variation == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_variation">Have Variation</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="is_featured" value="1"
                                                    class="form-check-input" id="is_featured"
                                                    {{ $product->is_featured == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">Enable Featured</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var categoryId = $('#category_id').val();
        var subCategoryId = $('#sub_category_id').val(); // ID of the sub-category to be selected
        // console.log(subCategoryId);
        // console.log(categoryId);

        if (categoryId) {
            $.ajax({
                url: '/selected-subcategories/' + categoryId, // URL to fetch subcategories
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sub_category').empty(); // Clear existing options
                    $('#sub_category').append(
                        '<option value="">Select a Sub Category</option>'); // Add default option

                    $.each(data, function(key, value) {
                        $('#sub_category').append('<option value="' + value.id + '">' + value.name +
                            '</option>');

                    });

                    // After all options have been appended, set the value of the sub-category dropdown
                    if (subCategoryId) {
                        // console.log(subCategoryId);
                        // Use setTimeout to ensure the UI has updated
                        setTimeout(function() {
                            $('#sub_category').val(subCategoryId).trigger(
                                'change'); // Select the found sub-category
                        }, 100); // Delay in milliseconds (adjust if necessary)
                    }
                },
                error: function() {
                    console.log('Error fetching subcategories');
                }
            });


        }



        function categoryChanged() {
            console.log('hello');
            var categoryId = $('#category_id').val();
            // Get selected category ID


            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId, // URL to fetch subcategories
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sub_category').empty(); // Clear existing options
                        $('#sub_category').append(
                            '<option value="">Select a Sub Category</option>'); // Add default option

                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name +
                                '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error fetching subcategories');
                    }
                });
            } else {

            }
            console.log('Selected Category ID:', categoryId);

            // You can add more logic here to load subcategories based on the selected category
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

    {{-- Bangla Language --}}
    <script src="{{ asset('backend/assets/js/bangla.js') }}"></script>
    <script>
        $('#banglaInputText').bangla({
            enable: true
        });
        $('#banglaInputText').bangla('on');

        $('#banglaInputText').bangla({
            enable: true
        });
        $('#banglaInputText').bangla('on');
    </script>
@endsection

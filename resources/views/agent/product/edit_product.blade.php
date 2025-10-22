@extends('agent.agent_dashboard')

@section('agent')
<div class="page-content">

    {{-- Top Buttons --}}
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm d-flex align-items-center me-3">
            <i data-feather="box" class="me-2" style="width: 18px; height: 18px;"></i> All Products
        </a>

        <a href="{{ route('product.details', $product->id) }}" target="_blank"
            class="btn btn-success btn-sm d-flex align-items-center">
            <i data-feather="eye" class="me-2" style="width: 18px; height: 18px;"></i> View Product on Website
        </a>
    </div>

    <div class="row profile-body">
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Product</h6>

                        <form method="POST" action="{{ route('product.update', $product->id) }}" id="myForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Name *</label>
                                        <input type="text" name="product_name" class="form-control"
                                            value="{{ $product->name }}">
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Product Quantity *</label>
                                        <input type="text" name="quantity" class="form-control"
                                            value="{{ old('quantity', $product->quantity) }}">
                                        @error('quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Category *</label>
                                        <input type="hidden" id="sub_category_id"
                                            value="{{ $product->categories->category_id }}">
                                        <select name="category_id" class="form-control" id="category_id"
                                            onchange="categoryChanged()">
                                            <option value="">Select a Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ ($product->categories->category_detail->parent_id ?? $product->categories->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Subcategory --}}
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Sub Category</label>
                                        <select name="sub_category_id" class="form-control" id="sub_category"></select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Price (Old Price)</label>
                                        <input type="text" name="price" class="form-control"
                                            value="{{ old('price', $product->price) }}">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Sale Price (New Price) *</label>
                                        <input type="text" name="sale_price" class="form-control"
                                            value="{{ old('sale_price', $product->sale_price) }}">
                                        @error('sale_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Short Content*</label>
                                            <textarea name="short_content" class="form-control" rows="10">{{ old('short_content', $product->content) }}</textarea>
                                            @error('short_content')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Long Description*</label>
                                            <textarea name="description" class="form-control" rows="10">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Thumbnail --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Main Thumbnail*</label>
                                        <input type="file" name="thumbnail" class="form-control" id="image">
                                        <br>
                                        <img id="showImage" class="wd-100"
                                            src="{{ !empty($product->thumbnail) ? url($product->thumbnail) : url('upload/no_image.jpg') }}"
                                            alt="product" style="max-width: 120px;">
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- MULTI IMAGES --}}
            <div class="col-sm-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Multi Images</h6>

                        <div class="row">
                            @foreach ($product->multi_images as $multi_image => $img)
                                <div class="col-sm-1 mb-3">
                                    <div class="card">
                                        <img src="{{ asset($img->image_detail->image) }}" alt="image"
                                            class="card-img-top" style="height: 190px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <a href="{{ route('deleteMultiImg.delete', $img->image_detail->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Upload New Images --}}
                        <form method="POST" action="{{ route('uploadMultiImg.add') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="upload_product_id" value="{{ $product->id }}">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="file" class="form-control" name="multi_img">
                                            @error('multi_img')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-info px-4" value="Add Image">
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

{{-- ======================= SCRIPT SECTION ======================= --}}
<script>
    var categoryId = $('#category_id').val();
    var subCategoryId = $('#sub_category_id').val();

    // Load subcategories on page load if category selected
    if (categoryId) {
        $.ajax({
            url: "{{ url('agent/get-subcategories') }}/" + categoryId, // ✅ Corrected URL
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#sub_category').empty().append('<option value="">Select a Sub Category</option>');
                $.each(data, function(key, value) {
                    $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if (subCategoryId) {
                    setTimeout(function() {
                        $('#sub_category').val(subCategoryId).trigger('change');
                    }, 100);
                }
            },
            error: function() {
                console.log('Error fetching subcategories');
            }
        });
    }

    // Change Category → Load Subcategories
    function categoryChanged() {
        var categoryId = $('#category_id').val();
        if (categoryId) {
            $.ajax({
                url: "{{ url('agent/get-subcategories') }}/" + categoryId, // ✅ Corrected URL
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sub_category').empty().append('<option value="">Select a Sub Category</option>');
                    $.each(data, function(key, value) {
                        $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching subcategories');
                }
            });
        }
    }

    // Thumbnail Preview
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

@endsection

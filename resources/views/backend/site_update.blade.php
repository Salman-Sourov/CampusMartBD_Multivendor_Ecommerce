@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="row profile-body">
            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Trending Product</h6>

                            <form method="post" action="{{ route('update.featured.products') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group mb-2">
                                            <label for="brand" class="form-label">Select maximum 5 product</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <select name="product_id" class="form-control w-75" id="product">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if (isset($featured_products) && $featured_products->count() < 5)
                                                    <button type="submit" class="btn btn-primary">Add</button>
                                                @else
                                                    <button type="button" class="btn btn-secondary" disabled>Add</button>
                                                @endif
                                            </div>
                                            @error('product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Sale Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($featured_products as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td><img src="{{ asset($item->thumbnail) }}"
                                                        style="width:70px; height:40px;">
                                                </td>
                                                <td>৳ {{ $item->sale_price }}</td>
                                                <td>
                                                    @if ($item->is_featured == '1')
                                                        <span class="badge rounded-pill bg-success">Featured</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Not Featured</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a class="btn btn-danger" title="Delete" href="javascript:void(0);"
                                                        data-id="{{ $item->id }}" data-action="delete">
                                                        <i data-feather="trash"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Feature Photo --}}
    <script type="text/javascript">
        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault(); // Prevent default action
            var id = $(this).data('id'); // Get ID from button
            var url = '{{ route('delete.featured.products', ':id') }}'.replace(":id", id); // Corrected route name

            $.ajax({
                type: 'GET', // Consider changing to DELETE for better practice
                url: url,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message || 'Deleted Successfully.');

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    } else {
                        toastr.error(response.message || 'Failed to delete the item.');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while deleting the item.');
                    console.log(xhr);
                }
            });
        });
    </script>
@endsection

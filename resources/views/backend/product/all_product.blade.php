@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('product.create') }}" class="btn btn-inverse-info"> Add Product</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Product</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><img src="{{ asset($item->thumbnail) }}" style="width:70px; height:40px;">
                                            </td>
                                            @php
                                                $brand = App\Models\Brand::find($item->brand_id); // Corrected namespace and query
                                            @endphp
                                            <td>{{ $brand ? $brand->name : 'N/A' }}</td>
                                            <!-- Check if brand exists and display its name, otherwise 'N/A' -->

                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->sale_price }}</td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge rounded-pill bg-success">Active</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">InActive</span>
                                                @endif
                                            </td>
                                            <td>

                                                <a href="{{ route('product.edit', $item->id)}}" class="btn btn-inverse-warning" title="Edit"> <i
                                                        data-feather="edit"></i> </a>

                                                <a href="#" class="btn btn-inverse-danger" id="delete"
                                                    title="Delete"> <i data-feather="trash-2"></i> </a>
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
@endsection

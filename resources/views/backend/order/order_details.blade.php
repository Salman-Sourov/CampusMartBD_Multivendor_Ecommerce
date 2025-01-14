@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">
        {{-- ALL Order --}}
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Order Details Of {{ $orders->name }}</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Attributes</th>
                                        <th>Quantitiy</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody id="brandTableBody">
                                    @if ($orders && count($orders->product) > 0)
                                        @foreach ($orders->product as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->product_details->name }}</td>
                                                <td><img src="{{ !empty($item->product_details->thumbnail) ? url($item->product_details->thumbnail) : url('upload/no_image.jpg') }}"
                                                        style="width:70px; height:40px;"></td>

                                                @php
                                                    $order_quantity = App\Models\Order_product_quantity::where(
                                                        'order_id',
                                                        $orders->id,
                                                    )
                                                        ->where('product_id', $item->product_details->id)
                                                        ->first();
                                                    // dd($order_quantity);

                                                    $order_attributes = App\Models\Order_product_attribute::where(
                                                        'order_id',
                                                        $orders->id,
                                                    )
                                                        ->where('product_id', $item->product_details->id)
                                                        ->first();

                                                    $attributes = $order_attributes
                                                        ? App\Models\Product_attribute::whereIn(
                                                            'id',
                                                            explode(',', $order_attributes->attributes),
                                                        )->get()
                                                        : collect([]);
                                                        // dd($attributes);
                                                @endphp
                                                <td>
                                                    @if ($attributes->count() > 0)
                                                        @foreach ($attributes as $attribute)
                                                            <span class="badge bg-primary">{{ $attribute->title }}</span>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $order_quantity->quantity }}</td>
                                                <td>৳ {{ $item->product_details->sale_price }}</td>
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

@endsection

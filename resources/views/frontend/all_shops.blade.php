<title>All Shops - CampusMartBD</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>All Shops</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">All Shops</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Grid Section Start -->
    <section class="seller-grid-section mb-5">
    <div class="container-fluid-lg">
        <div class="row g-4">
            @forelse ($active_seller as $seller)
                <div class="col-xxl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="seller-card-standard position-relative">
                        <a href="{{ route('shop.details', $seller->id) }}" class="stretched-link"></a>

                        <div class="seller-card-body">
                            <div class="seller-header">
                                <div class="seller-logo-container">
                                    <img src="{{ !empty($seller->image) ? asset($seller->image) : asset('upload/no_image.jpg') }}"
                                        alt="{{ $seller->name }}">
                                </div>
                                <div class="seller-info">
                                    <h3 class="seller-name">{{ $seller->name }}</h3>
                                    <span class="product-count-badge">
                                        <i class="fa-solid fa-box-open"></i> {{ count($seller->products) }} Products
                                    </span>
                                </div>
                            </div>

                            <hr class="card-divider">

                            <div class="seller-footer">
                                <div class="location-info">
                                    <i class="fa-solid fa-building-columns"></i>
                                    <span>{{ $seller->verification->institutionData->name ?? 'Campus Mart' }}</span>
                                </div>
                                <div class="visit-action">
                                    <span class="visit-text">Visit Store</span>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('upload/no_data.png') }}" alt="No Seller" style="width: 150px; opacity: 0.5;">
                    <p class="mt-3 text-secondary">No professional sellers found at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
    <!-- Grid Section End -->
@endsection

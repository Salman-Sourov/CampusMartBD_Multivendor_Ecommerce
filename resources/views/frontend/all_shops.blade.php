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
    <section class="seller-grid-section mb-3">
        <div class="container-fluid-lg">
            @forelse ($active_seller as $seller)
                <div class="row g-4">
                    <div class="col-xxl-4 col-md-6">
                        <div class="seller-grid-box seller-grid-box-1">
                            <div class="grid-image">
                                <div class="image">
                                    {{ $shop->name }}
                                </div>
                                <div class="contain-name">
                                    <div>
                                        <h3>{{ $seller->name }}</h3>
                                    </div>
                                    <label class="product-label">{{ count($seller->products) }} Products</label>
                                </div>
                            </div>

                            <div class="grid-contain">
                                <div class="seller-contact-details">
                                    <div class="seller-contact">
                                        <div class="seller-icon">
                                            <i class="fa-solid fa-map-pin"></i>
                                        </div>
                                        <div class="contact-detail">
                                            <h5>{{ $seller->verification->institutionData->name }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="seller-category">
                                    <button onclick="window.location.href = '{{ route('shop.details', $seller->id) }}';"
                                        class="btn btn-sm theme-bg-color text-white fw-bold">Visit Store <i
                                            class="fa-solid fa-arrow-right-long ms-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No Seller Registered</p>
            @endforelse

            <nav class="custome-pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)" tabindex="-1">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0)">1</a>
                    </li>
                    <li class="page-item" aria-current="page">
                        <a class="page-link" href="javascript:void(0)">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <!-- Grid Section End -->
@endsection

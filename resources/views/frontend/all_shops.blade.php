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
    <section class="seller-grid-section">
        <div class="container-fluid-lg">
            @forelse ($active_seller as $seller)
            {{-- {{ dd($seller->image) }} --}}
                <div class="row g-4">
                    <div class="col-xxl-4 col-md-6">
                        <div class="seller-grid-box seller-grid-box-1">
                            <div class="grid-image">
                                <div class="image">
                                    <img src="{{ asset($seller->image) }}" class="img-fluid" alt="{{ $seller->name }}">
                                </div>

                                <div class="contain-name">
                                    <div>
                                        <h3>{{ $seller->name }}</h3>
                                    </div>
                                    <label class="product-label">380 Products</label>
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
                                    <button onclick="location.href = 'shop-left-sidebar.html';"
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
        </div>
    </section>
    <!-- Grid Section End -->
@endsection

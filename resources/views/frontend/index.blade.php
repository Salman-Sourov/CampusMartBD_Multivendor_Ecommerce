@extends('frontend.frontend_dashboard')
@section('main')
    @php
        use Illuminate\Support\Str;
    @endphp

    <!-- Home Section Start -->
    <section class="home-section pt-2">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <div id="bannerCarousel" class="carousel slide home-contain h-100 position-relative"
                        data-bs-ride="carousel">

                        <!-- Carousel Indicators (Dots) -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('frontend/assets/images/banner/empotech_bd_banner_1.jpg') }}"
                                    class="d-block w-100 bg-img blur-up lazyload fixed-size" alt="Banner 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_1.2.jpeg"
                                    class="d-block w-100 bg-img blur-up lazyload fixed-size" alt="Banner 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_1.1.jpg"
                                    class="d-block w-100 bg-img blur-up lazyload fixed-size" alt="Banner 3">
                            </div>
                        </div>

                        <!-- Text Overlay (remains fixed) -->
                        <div
                            class="home-detail p-center-left w-75 position-absolute top-50 start-0 translate-middle-y ps-4">
                            <div>
                                <h6>Shop Smart. Stay Safe.</h6>
                                <h1 class="w-75 text-uppercase poster-1">Get Your Daily Needs Delivered to
                                    <span class="daily">Campus</span>
                                </h1>
                                <p class="w-58 d-none d-sm-block">
                                    Your Campus, Your Marketplace – From Students, For Students <br> Empowering Students to
                                    Shop, Sell, and Support Locally
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 d-lg-inline-block d-none d-flex flex-column">
                    <!-- First Banner -->
                    <div class="home-contain h-50 mb-1">
                        <img src="{{ asset('frontend/assets/images/banner/empotech_bd_banner_3.jpg') }}"
                            class="bg-img blur-up lazyload" alt="Banner 1">
                        <div class="home-detail p-top-left home-p-sm w-90">
                            <div>
                                <h2 class="mt-0 text-danger">0% <span class="discount text-title">Delivery Charge</span>
                                </h2>
                                <h5 class="text-content fw-bold">Coming Soon to Every Campus in Bangladesh</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Second Banner -->
                    <div class="home-contain h-50">
                        <img src="{{ asset('frontend/assets/images/banner/empotech_bd_banner_3_2.jpg') }}"
                            class="bg-img blur-up lazyload" alt="Banner 2">
                        <div class="home-detail p-top-left home-p-sm w-90">
                            <div>
                                <h3 class="theme-color">Become a seller?</h3>
                                <h5 class="text-content">Register Today & Grow Your Business on CampusMartBD...</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Home Section End -->

    <!-- Category Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{ __('content.browse_by_Categories') }}</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('frontend') }}/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
                <p>Top Categories Of The Week</p>
            </div>

            @if (App::getLocale() == 'en')
                <div class="row">
                    <div class="col-12">
                        <div class="slider-9">
                            @forelse ($categories as $category)
                                <div>
                                    <a href="{{ route('category.details', $category->slug) }}"
                                        class="category-box wow fadeInUp">
                                        <div>
                                            <img src="{{ asset($category->image) }}" class="blur-up lazyload"
                                                alt="">
                                            <h5>{{ $category->name }}</h5>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <!-- You can display a message if no categories are available -->
                                <li>No categories available.</li>
                            @endforelse
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="slider-9">
                            @forelse ($categories as $category)
                                <div>
                                    <a href="{{ route('category.details', $category->slug) }}"
                                        class="category-box wow fadeInUp">
                                        <div>
                                            <img src="{{ asset($category->image) }}" class="blur-up lazyload"
                                                alt="">
                                            <h5>{{ $category->translations->name }}</h5>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <!-- You can display a message if no categories are available -->
                                <li>No categories available.</li>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Category Section End -->

    <!-- Discount Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="banner-contain">
                        <div class="banner-contain hover-effect">
                            <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_4_1.jpg"
                                class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center p-sm-4 p-3 text-white text-center">
                                <div>
                                    <h3 class="lh-base fw-bold text-light">Be Your Own Boss Sell at Your Campus</h3>
                                    <h6 class="coupon-code">From Students, For Students</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Discount Section End -->

    <!-- Product Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{ __('content.recently_added') }}</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('frontend') }}/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>

            <div class="row">
                <div class="col-xxl-9 col-xl-8">
                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        @forelse ($featured_products->take(5) as $product)
                            <div>
                                <div class="product-box-3 h-100 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">


                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ asset($product->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span
                                                class="span-name">{{ $product->categories->category_detail->name }}</span>

                                            <a href="{{ route('product.details', $product->id) }}">
                                                <h5 class="product_name">
                                                    @if (App::getLocale() == 'en')
                                                        {{ $product->name }}
                                                    @else
                                                        {{ $product->name }}
                                                    @endif
                                                </h5>
                                            </a>

                                            <p class="text-content mt-1 mb-2 product-content">{{ $product->description }}
                                            </p>
                                            @php
                                                $get_brand = App\Models\Brand::where('id', $product->brand_id)->first();
                                            @endphp
                                            <h6 class="unit">{{ $get_brand->name ?? 'No Brand' }}</h6>
                                            <h5 class="price"><span class="theme-color">৳
                                                    {{ $product->sale_price }}</span>
                                                <del>৳ {{ $product->price }}</del>
                                                <br> <br>
                                            </h5>
                                            <div class="add-to-cart-box">
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    <button class="btn btn-sm btn-animation">Buy Now</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @empty
                            <!-- Do nothing or display a message if needed -->
                        @endforelse
                    </div>
                    <br>
                    <br>
                    <div class="offer-box hover-effect">
                        <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_5_1.jpg"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="offer-contain p-4">
                            <div class="offer-detail" style="color: #023c42; text-align: center;">
                                <h2 class="text-dark" style="color: #023c42 !important;">Turn Ideas
                                    <span class="text-danger fw-bold" style="color: #023c42 !important;">into
                                        Income!</span>
                                </h2>
                                <p class="text-content fw-bold" style="color: #023c42 !important;">Start selling on
                                    CampusMartBD and grow your business today!</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="title">
                        <h2>{{ __('content.for_you') }}</h2>
                        <span class="title-leaf">
                            <svg class="icon-width">
                                <use xlink:href="{{ asset('frontend') }}/assets/svg/leaf.svg#leaf"></use>
                            </svg>
                        </span>
                    </div>

                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        @forelse ($products as $product)
                            <div>
                                <div class="product-box-3 h-100 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a
                                                href="{{ route('product.details', ['shop' => $product->agent->name, 'slug' => $product->slug]) }}">
                                                <img src="{{ asset($product->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            @if ($product->stock_status == 'stock_out')
                                                <h5 class="span-name" style="color: red; font-weight: 600;">Stock Out</h5>
                                            @else
                                                <span
                                                    class="span-name">{{ $product->categories->category_detail->name }}</span>
                                            @endif

                                            <a
                                                href="{{ route('product.details', ['shop' => $product->agent->name, 'slug' => $product->slug]) }}">
                                                <h5 class="product_name">
                                                    @if (App::getLocale() == 'en')
                                                        {{ $product->name }}
                                                    @else
                                                        {{ $product->name }}
                                                    @endif
                                                </h5>
                                            </a>

                                            <p class="text-content mt-1 mb-2 product-content">{{ $product->description }}
                                            </p>
                                            @php
                                                $get_brand = App\Models\Brand::where('id', $product->brand_id)->first();
                                            @endphp
                                            <h6 class="unit">{{ $get_brand->name ?? 'No Brand' }}</h6>
                                            <h5 class="price mb-2">
                                                <span class="theme-color">৳ {{ $product->sale_price }}</span>
                                                @if ($product->price)
                                                    <del>৳ {{ $product->price }}</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box">
                                                @if ($product->stock_status == 'stock_out')
                                                    <button type="button" class="btn btn-sm btn-animation disabled"
                                                        disabled>Buy Now</button>
                                                @else
                                                    <a
                                                        href="{{ route('product.details', ['shop' => $product->agent->name, 'slug' => $product->slug]) }}">
                                                        <button type="button" class="btn btn-sm btn-animation">Buy
                                                            Now</button>
                                                    </a>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        @empty
                            <!-- Do nothing or display a message if needed -->
                        @endforelse
                    </div>

                </div>

                <div class="col-xxl-3 col-xl-4 d-none d-xl-block">
                    <div class="position-sticky top-0">
                        <div class="ratio_209 rounded wow fadeIn">
                            <div class="banner-contain-2 rounded hover-effect">
                                <img src="{{ asset('frontend') }}/assets/images/banner/campus_mart_bd_right_banner.jpg"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="banner-detail p-top-left">
                                    <div>
                                        <h6 class="text-uppercase theme-color fw-500 mb-3">Campus Mart BD</h6>
                                        <h3 class="text-uppercase">
                                            shop <span class="brand-name">campus</span>
                                        </h3>
                                        <p class="text-content fw-500 mt-3 lh-lg">Shop Campus-Exclusive Deals, Anytime,
                                            Anywhere. Shop Smart,Save More.</p>

                                        <div class="banner-detail-box banner-detail-box-2 mb-md-3 mb-1">
                                            <h4 class="text-uppercase">up to</h4>
                                            <h2 class="mt-2">50%</h2>
                                            <h3 class="text-uppercase">off</h3>
                                        </div>
                                        {{--
                                        <div>
                                            <button onclick="location.href = 'shop-left-sidebar.html';"
                                                class="btn text-white btn-md mt-xxl-4 mt-2 home-button mend-auto theme-bg-color">Shop
                                                Now<i class="fa-solid fa-right-long icon ms-2"></i>
                                            </button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let carousel = document.querySelector("#bannerCarousel");
            let items = carousel.querySelectorAll(".carousel-item");

            carousel.addEventListener("slide.bs.carousel", function(event) {
                let activeItem = items[event.from];
                let nextItem = items[event.to];

                // Move out the previous slide
                activeItem.style.transform = "translateX(-100%)";
                activeItem.style.opacity = "0";

                // Move in the next slide
                nextItem.style.transform = "translateX(0)";
                nextItem.style.opacity = "1";
            });
        });
    </script>

@endsection

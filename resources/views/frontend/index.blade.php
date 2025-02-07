@extends('frontend.frontend_dashboard')
@section('main')
    @php
        use Illuminate\Support\Str;
    @endphp
    <!-- Home Section Start -->
    <section class="home-section pt-2">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xl-9 col-lg-8">
                    <div class="home-contain h-100">
                        <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_1.jpg"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="home-detail p-center-left w-75 position-relative mend-auto">
                            <div>
                                <h6>Exclusive offer</h6>
                                <h1 class="w-75 text-uppercase poster-1">Stay home & delivered your <span
                                        class="daily">Daily Needs</span></h1>
                                <p class="w-58 d-none d-sm-block">Many organizations have issued official
                                    statements encouraging people to reduce their intake of sugary drinks.</p>
                                {{-- <button onclick="location.href = 'shop-left-sidebar.html';"
                                    class="btn btn-animation mt-xxl-4 mt-2 home-button mend-auto">Shop Now <i
                                        class="fa-solid fa-right-long ms-2 icon"></i></button> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 d-lg-inline-block d-none ratio_156">
                    <div class="home-contain h-100">
                        <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_3.jpg"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="home-detail p-top-left home-p-sm w-75">
                            <div>
                                <h2 class="mt-0 text-danger">45% <span class="discount text-title">OFF</span>
                                </h2>
                                <h3 class="theme-color">Real Refresement</h3>
                                <h5 class="text-content">Only this week, Don't miss..</h5>
                                {{-- <a href="shop-left-sidebar.html" class="shop-button">Shop Now <i
                                        class="fa-solid fa-right-long ms-2"></i></a> --}}
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
                                    <a href="{{ route('category.details', $category->id) }}"
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
                                    <a href="{{ route('category.details', $category->id) }}"
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
                            <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_4.jpg"
                                class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center p-sm-4 p-3 text-white text-center">
                                <div>
                                    <h3 class="lh-base fw-bold text-light">Look Good, Feel Good – Shop Here!</h3>
                                    <h6 class="coupon-code">Your stisfaction is our priority</h6>
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
                                    @if ($product->stock_status == 'stock_out')
                                        <h5 style="color: red;">Stock Out</h5>
                                    @endif
                                    <div class="product-footer">
                                        <div class="product-detail">

                                            <span
                                                class="span-name">{{ $product->categories->category_detail->name }}</span>

                                            <a href="{{ route('product.details', $product->id) }}">
                                                <h5 class="product_name">
                                                    @if (App::getLocale() == 'en')
                                                        {{ $product->name }}
                                                    @else
                                                        {{ $product->translations->name }}
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
                        <img src="{{ asset('frontend') }}/assets/images/banner/empotech_bd_banner_5.jpg"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="offer-contain p-4">
                            <div class="offer-detail" style="color: white; text-align: center;">
                                <h2 class="text-dark" style="color: white !important;">Special Offers
                                    <span class="text-danger fw-bold" style="color: white !important;">of the week!</span>
                                </h2>
                                <p class="text-content" style="color: white !important;">Special offer on this week, Hurry
                                    Up!</p>
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
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ asset($product->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    @if ($product->stock_status == 'stock_out')
                                        <h5 style="color: red;">Stock Out</h5>
                                    @endif
                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span
                                                class="span-name">{{ $product->categories->category_detail->name }}</span>
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <h5 class="product_name">
                                                    @if (App::getLocale() == 'en')
                                                        {{ $product->name }}
                                                    @else
                                                        {{ $product->translations->name }}
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

                </div>

                <div class="col-xxl-3 col-xl-4 d-none d-xl-block">
                    <div class="position-sticky top-0">
                        <div class="ratio_209 rounded wow fadeIn">
                            <div class="banner-contain-2 rounded hover-effect">
                                <img src="{{ asset('frontend') }}/assets/images/banner/right_banner.jpg"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="banner-detail p-top-left">
                                    <div>
                                        <h6 class="text-uppercase theme-color fw-500">Leather Item</h6>
                                        <h3 class="text-uppercase">
                                            special <span class="brand-name">brand</span>
                                        </h3>
                                        <p class="text-content fw-500 mt-3 lh-lg">Special offer on the discount very
                                            hungry cake and sweets</p>

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

    <!-- Newsletter Section Start -->
    {{-- <section class="newsletter-section section-b-space">
        <div class="container-fluid-lg">
            <div class="newsletter-box newsletter-box-2">
                <div class="newsletter-contain py-5">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xxl-4 col-lg-5 col-md-7 col-sm-9 offset-xxl-2 offset-md-1">
                                <div class="newsletter-detail">
                                    <h2>Join our newsletter and get...</h2>
                                    <h5>$20 discount for your first order</h5>
                                    <div class="input-box">
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Your Email">
                                        <i class="fa-solid fa-envelope arrow"></i>
                                        <button class="sub-btn btn">
                                            <span class="d-sm-block d-none">Subscribe</span>
                                            <i class="fa-solid fa-arrow-right icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Newsletter Section End -->
@endsection

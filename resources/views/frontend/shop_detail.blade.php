<title>{{ $seller->name }} - CampusMart BD</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="vendore-breadscrumb-section">
        <img src="{{ asset('frontend') }}/assets/images/shop/breadcrumb.png" class="w-100 bg-img blur-up lazyload fixed-size"
            alt="Banner 2">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 style="color: #0da487">{{ $seller->name }}</h2>
                        <form>
                            <span>
                                <i class="iconly-Search icli"></i>
                            </span>
                            <input type="text" class="form-control"
                                placeholder="Search your product from {{ $seller->name }}">
                            <button class="btn theme-bg-color text-white m-0" type="button"
                                id="button-addon1">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                            </div>

                            <div class="vendor-detail-box">
                                <div class="vendor-name vendor-bottom">
                                    <div class="vendor-logo">
                                        <img src="{{ !empty($seller->image) ? asset($seller->image) : asset('upload/no_image.jpg') }}"
                                            class="img-fluid" alt="{{ $seller->name }}">
                                        <div>
                                            <h3>{{ $seller->name }}</h3>
                                        </div>
                                    </div>
                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do aldskadskm
                                        eiusmod tempor incididunt.</p> --}}
                                </div>

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
                                {{-- <div class="vendor-tag vendor-bottom">
                                    <h4>Perfect for you, if you like</h4>
                                    <ul>
                                        <li>Vegetable</li>
                                        <li>Fruit</li>
                                        <li>Meat</li>
                                        <li>Backery</li>
                                        <li>Cake</li>
                                        <li>Organic</li>
                                    </ul>
                                </div> --}}
                            </div>

                            <div class="accordion custome-accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <span>Categories</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne">
                                        <div class="accordion-body">

                                            <ul class="category-list custom-padding custom-height">
                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox" id="fruit">
                                                        <label class="form-check-label" for="fruit">
                                                            <span class="name">Fruits & Vegetables</span>
                                                            <span class="number">(15)</span>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            <span>Price</span>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree">
                                        <div class="accordion-body">
                                            <div class="range-slider">
                                                <input type="text" class="js-range-slider" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            <span>Discount</span>
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse show"
                                        aria-labelledby="headingFour">
                                        <div class="accordion-body">
                                            <ul class="category-list custom-padding">
                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            <span class="name">upto 5%</span>
                                                            <span class="number">(06)</span>
                                                        </label>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            id="flexCheckDefault1">
                                                        <label class="form-check-label" for="flexCheckDefault1">
                                                            <span class="name">5% - 10%</span>
                                                            <span class="number">(08)</span>
                                                        </label>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            id="flexCheckDefault2">
                                                        <label class="form-check-label" for="flexCheckDefault2">
                                                            <span class="name">10% - 15%</span>
                                                            <span class="number">(10)</span>
                                                        </label>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            id="flexCheckDefault3">
                                                        <label class="form-check-label" for="flexCheckDefault3">
                                                            <span class="name">15% - 25%</span>
                                                            <span class="number">(14)</span>
                                                        </label>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            id="flexCheckDefault4">
                                                        <label class="form-check-label" for="flexCheckDefault4">
                                                            <span class="name">More than 25%</span>
                                                            <span class="number">(13)</span>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <div class="right-box">
                        <div class="show-button">
                            <div class="filter-button-group mt-0">
                                <div class="filter-button d-inline-block d-lg-none">
                                    <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                                </div>
                            </div>

                            <div class="top-filter-menu">
                                <div class="category-dropdown">
                                    <h5 class="text-content">Sort By :</h5>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown">
                                            <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" id="pop"
                                                    href="javascript:void(0)">Popularity</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="low" href="javascript:void(0)">Low -
                                                    High
                                                    Price</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="high" href="javascript:void(0)">High -
                                                    Low
                                                    Price</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="aToz" href="javascript:void(0)">A - Z
                                                    Order</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="zToa" href="javascript:void(0)">Z - A
                                                    Order</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="grid-option">
                                    <ul>
                                        <li class="three-grid d-xxl-inline-block d-none">
                                            <a href="javascript:void(0)">
                                                <img src="../assets/svg/grid-3.svg" class="blur-up lazyload"
                                                    alt="">
                                            </a>
                                        </li>
                                        <li class="grid-btn active">
                                            <a href="javascript:void(0)">
                                                <img src="../assets/svg/grid-4.svg"
                                                    class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                                <img src="../assets/svg/grid.svg"
                                                    class="blur-up lazyload img-fluid d-lg-none d-inline-block"
                                                    alt="">
                                            </a>
                                        </li>
                                        <li class="list-btn">
                                            <a href="javascript:void(0)">
                                                <img src="../assets/svg/list.svg" class="blur-up lazyload"
                                                    alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div
                            class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
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
                                                    <h5 class="span-name" style="color: red; font-weight: 600;">Stock Out
                                                    </h5>
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

                                                <p class="text-content mt-1 mb-2 product-content">
                                                    {{ $product->description }}
                                                </p>
                                                @php
                                                    $get_shop = App\Models\User::where(
                                                        'id',
                                                        $product->agent_id,
                                                    )->first();
                                                @endphp
                                                <h6 class="unit">{{ $get_shop->name ?? 'Campuss Mart' }}</h6>
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
                                <p style="align-content: center">No product available for display</p>
                            @endforelse
                        </div>

                        <nav class="custome-pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-disabled="true">
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
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection

    <!-- Header Start -->
    <header class="pb-md-4 pb-0">
        <div class="header-top">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-xxl-3 d-xxl-block d-none">
                        <div class="top-left-header">
                            <i class="iconly-Location icli text-white"></i>
                            <span class="text-white">Dhaka, Bangladesh</span>
                        </div>
                    </div>

                    <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                        <div class="header-offer">
                            <div class="notification-slider">
                                <div>
                                    <div class="timer-notification">
                                        <h6><strong class="me-1">Welcome to Bazar BD!</strong>Wrap new
                                            offers/gift.<strong class="ms-1">New Coupon Code: Fast024
                                            </strong>

                                        </h6>
                                    </div>
                                </div>

                                <div>
                                    <div class="timer-notification">
                                        <h6>Something you love is now on sale!
                                            <a href="shop-left-sidebar.html" class="text-white">Buy Now
                                                !</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <ul class="about-list right-nav-about">
                            <li class="right-nav-list">
                                <div class="dropdown theme-form-select">
                                    <button class="btn dropdown-toggle" type="button" id="select-language"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (App::getLocale() == 'bn')
                                            <img src="{{ asset('frontend/assets/images/country/Bangladesh.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                            <span>বাংলা</span>
                                        @else
                                            <img src="{{ asset('frontend/assets/images/country/united-states.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                            <span>English</span>
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="select-language">
                                        {{-- English Language Option --}}
                                        <li>
                                            <a href="{{ route('lang.change', 'en') }}"
                                                class="dropdown-item {{ App::getLocale() == 'en' ? 'active' : '' }}"
                                                id="english">
                                                <img src="{{ asset('frontend/assets/images/country/united-states.png') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                                <span>English</span>
                                            </a>
                                        </li>

                                        {{-- Bangla Language Option --}}
                                        <li>
                                            <a href="{{ route('lang.change', 'bn') }}"
                                                class="dropdown-item {{ App::getLocale() == 'bn' ? 'active' : '' }}"
                                                id="bangla">
                                                <img src="{{ asset('frontend/assets/images/country/Bangladesh.png') }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                                <span>বাংলা</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="top-nav top-header sticky-header">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="navbar-top">
                            <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                            </button>
                            <a href="{{ url('/') }}" class="web-logo nav-logo">
                                <img src="{{ asset('frontend') }}/assets/images/logo/bazar-bd-logo.png"
                                    class="img-fluid blur-up lazyload" alt="">
                            </a>

                            <div class="middle-box">
                                <div class="search-box">
                                    <div class="input-group">
                                        <input type="search" class="form-control"
                                            placeholder="{{ __('content.search') }}" aria-label="Recipient's username"
                                            aria-describedby="button-addon2">
                                        <button class="btn" type="button" id="button-addon2">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="rightside-box">
                                <div class="search-full">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i data-feather="search" class="font-light"></i>
                                        </span>
                                        <input type="text" class="form-control search-type"
                                            placeholder="Search here..">
                                        <span class="input-group-text close-search">
                                            <i data-feather="x" class="font-light"></i>
                                        </span>
                                    </div>
                                </div>
                                <ul class="right-side-menu">
                                    <li class="right-side">
                                        <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <div class="search-box">
                                                    <i data-feather="search"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side">
                                        <a href="contact-us.html" class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="phone-call"></i>
                                            </div>
                                            <div class="delivery-detail">
                                                <h6>24/7 Delivery</h6>
                                                <h5>+8801869520885</h5>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <a href="wishlist.html" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li>
                                    <li class="right-side">
                                        <div class="onhover-dropdown header-badge">
                                            <button type="button" class="btn p-0 position-relative header-wishlist">
                                                <i data-feather="shopping-cart"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge">2
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>

                                            <div class="onhover-div">
                                                <ul class="cart-list">
                                                    <li class="product-box-contain">
                                                        <div class="drop-cart">
                                                            <a href="product-left-thumbnail.html" class="drop-image">
                                                                <img src="{{ asset('frontend') }}/assets/images/vegetable/product/1.png"
                                                                    class="blur-up lazyload" alt="">
                                                            </a>

                                                            <div class="drop-contain">
                                                                <a href="product-left-thumbnail.html">
                                                                    <h5>Fantasy Crunchy Choco Chip Cookies</h5>
                                                                </a>
                                                                <h6><span>1 x</span> $80.58</h6>
                                                                <button class="close-button close_button">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="product-box-contain">
                                                        <div class="drop-cart">
                                                            <a href="product-left-thumbnail.html" class="drop-image">
                                                                <img src="{{ asset('frontend') }}/assets/images/vegetable/product/2.png"
                                                                    class="blur-up lazyload" alt="">
                                                            </a>

                                                            <div class="drop-contain">
                                                                <a href="product-left-thumbnail.html">
                                                                    <h5>Peanut Butter Bite Premium Butter Cookies 600 g
                                                                    </h5>
                                                                </a>
                                                                <h6><span>1 x</span> $25.68</h6>
                                                                <button class="close-button close_button">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <div class="price-box">
                                                    <h5>Total :</h5>
                                                    <h4 class="theme-color fw-bold">$106.58</h4>
                                                </div>

                                                <div class="button-group">
                                                    <a href="cart.html" class="btn btn-sm cart-button">View Cart</a>
                                                    <a href="checkout.html"
                                                        class="btn btn-sm cart-button theme-bg-color
                                                    text-white">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="right-side onhover-dropdown">

                                        <div class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="user"></i>
                                            </div>
                                            @auth
                                                <div class="delivery-detail">
                                                    <h6>Hello,</h6>
                                                    <h5>{{ Auth::user()->name }}</h5>
                                                </div>
                                            @endauth
                                        </div>

                                        <div class="onhover-div onhover-div-login">
                                            <ul class="user-box-name">

                                                @auth
                                                    <li class="product-box-contain">
                                                        <a href="forgot.html">Forgot Password</a>
                                                    </li>
                                                    <li class="product-box-contain">
                                                        <a href="{{ route('user.logout') }}">logout</a>
                                                    </li>
                                                @else
                                                    <li class="product-box-contain">
                                                        <i></i>
                                                        <a href="{{ route('login') }}">Log In</a>
                                                    </li>

                                                    <li class="product-box-contain">
                                                        <a href="{{ route('register') }}">Register</a>
                                                    </li>
                                                @endauth


                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="header-nav">
                        <div class="header-nav-left">
                            <button class="dropdown-category">
                                <i data-feather="align-left"></i>
                                <span>{{ __('content.all_category') }}</span>
                            </button>

                            {{-- Categories --}}
                            <div class="category-dropdown">
                                <div class="category-title">
                                    <h5>All Categories</h5>
                                    <button type="button" class="btn p-0 close-button text-content">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <ul class="category-list">
                                    @forelse ($categories as $category)
                                        <li class="onhover-category-list">
                                            <a href="{{ route('category.details', $category->id) }}"
                                                class="category-name">
                                                <img src="{{ asset($category->image) }}" alt="">

                                                @if (App::getLocale() == 'en')
                                                    <h6>{{ $category->name }}</h6>
                                                @else
                                                    <h6>{{ $category->translations->name }}</h6>
                                                @endif

                                                <i class="fa-solid fa-angle-right"></i>
                                            </a>

                                            {{-- Check if the category has child categories --}}
                                            @if ($category->hasChild->isNotEmpty())
                                                <div class="onhover-category-box w-100">
                                                    <div class="list-1">
                                                        <div class="category-title-box">
                                                            @if (App::getLocale() == 'en')
                                                                <h5>{{ $category->name }} {{ __('content.Subcat') }}
                                                                </h5>
                                                            @else
                                                                <h5>{{ $category->translations->name }}
                                                                    {{ __('content.Subcat') }}</h5>
                                                            @endif
                                                        </div>
                                                        <ul>
                                                            {{-- Loop through each child category --}}
                                                            @foreach ($category->hasChild as $child)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('category.details', $child->id) }}">
                                                                        <img src="{{ asset($child->image) }}"
                                                                            alt="">
                                                                        @if (App::getLocale() == 'en')
                                                                            <h6>{{ $child->name }}</h6>
                                                                        @else
                                                                            <h6>{{ $child->translations->name }}</h6>
                                                                        @endif

                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @empty
                                        <!-- You can display a message if no categories are available -->
                                        <li>No categories available.</li>
                                    @endforelse

                                </ul>
                            </div>
                        </div>

                        <div class="header-nav-middle">
                            <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>

                                    {{-- Navbar --}}
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <li class="nav-item dropdown">
                                                <a href="{{ url('/') }}"
                                                    class="nav-link">{{ __('content.home') }}</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">{{ __('content.brands') }}</a>

                                                <ul class="dropdown-menu">
                                                    @forelse ($brands as $brand)
                                                        <li>
                                                            @if (App::getLocale() == 'en')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('brand.details', $brand->id) }}">
                                                                    {{ $brand->name }}
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{{ route('brand.details', $brand->id) }}">
                                                                    {{ $brand->translations->name }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @empty
                                                        <!-- Do nothing or display a message if needed -->
                                                    @endforelse
                                                </ul>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">{{ __('content.product') }}</a>

                                                @php
                                                    use Illuminate\Support\Str;
                                                @endphp

                                                <ul class="dropdown-menu">
                                                    @forelse ($products->take(5) as $product)
                                                        <li>
                                                            @if (App::getLocale() == 'en')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('product.details',$product->id) }}">
                                                                    {{ Str::limit($product->name, 20) }}
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{ route('product.details',$product->id) }}">
                                                                    {{ Str::limit($product->translations->name, 20) }}
                                                                </a>
                                                            @endif

                                                        </li>
                                                    @empty
                                                        <!-- Do nothing or display a message if needed -->
                                                    @endforelse
                                                </ul>

                                            </li>

                                            <li class="nav-item dropdown">
                                                <a href="{{ url('/') }}"
                                                    class="nav-link">{{ __('content.about') }}</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">{{ __('content.blog') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

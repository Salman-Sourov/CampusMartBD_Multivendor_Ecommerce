    <!-- Header Start -->
    <header class="pb-md-4 pb-0">
        <div class="header-top">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-xxl-3 d-xxl-block d-none">
                        <div class="top-left-header">
                            <i class="iconly-Location icli text-white"></i>
                            <span class="text-white">All campuses in Bangladesh</span>
                        </div>
                    </div>

                    <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                        <div class="header-offer">
                            <div class="notification-slider">
                                <div>
                                    <div class="timer-notification">
                                        <h6><strong class="me-1">Welcome to Campus Mart BD. </strong>Empowering Campus
                                            Entrepreneurs
                                            with Quality Products</h6>
                                        </h6>
                                    </div>
                                </div>

                                <div>
                                    <div class="timer-notification">
                                        <h6>Your Campus, Your Marketplace | Discover, Support, and Shop Student
                                            Creations
                                            <a href="{{ url('/') }}" class="text-white">Buy Now!</a>
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
                                        @if (App::getLocale() == 'bn')
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
                                        @else
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
                                        @endif
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
                                <img src="{{ asset('frontend') }}/assets/images/logo/CampusMartBD.png"
                                    class="img-fluid blur-up lazyload" alt="">
                            </a>

                            <div class="middle-box">
                                <div class="search-box">
                                    <form action="{{ route('product.search') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="search" name="search" class="form-control"
                                                placeholder="{{ __('content.search') }}" aria-label="Search"
                                                aria-describedby="button-addon2" requireds>
                                            {{-- @error('search')
                                                <span class="text-danger">{{ $message }}</span>s
                                                @enderror --}}
                                            <button class="btn btn-primary" type="submit">
                                                <i data-feather="search"></i>
                                            </button>
                                        </div>
                                    </form>
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
                                        <a href="tel:+8801521406205" class="delivery-login-box">
                                            <div class="delivery-icon">
                                                <i data-feather="phone-call"></i>
                                            </div>
                                            <div class="delivery-detail">
                                                <h6>Any Queries? Call Us!</h6>
                                                <h5>+880 1521 406205</h5>
                                            </div>
                                        </a>
                                    </li>
                                    {{-- <li class="right-side">
                                        <a href="wishlist.html" class="btn p-0 position-relative header-wishlist">
                                            <i data-feather="heart"></i>
                                        </a>
                                    </li> --}}

                                    <li class="right-side">
                                        <div class="onhover-dropdown header-badge">
                                            <button type="button" class="btn p-0 position-relative header-wishlist">
                                                <i data-feather="shopping-cart"></i>
                                                <span id="cart-quantity" @php $carts = $carts ?? []; @endphp
                                                    class="position-absolute top-0 start-100 translate-middle badge">{{ count($carts) }}
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </button>

                                            <div class="onhover-div">
                                                <ul class="cart-list">
                                                    @php
                                                        $total_price = 0;
                                                    @endphp
                                                    @forelse($carts as $key=>$cart)
                                                        <li class="product-box-contain">
                                                            <div class="drop-cart">
                                                                <a href="{{ route('product.details', $key) }}"
                                                                    class="drop-image">
                                                                    <img src="{{ asset($cart['image']) }}"
                                                                        class="blur-up lazyload" alt="">
                                                                </a>

                                                                <div class="drop-contain">
                                                                    <a href="{{ route('product.details', $key) }}">
                                                                        <h5>{{ $cart['name'] }}</h5>
                                                                    </a>
                                                                    <h6><span>{{ $cart['quantity'] }} x</span>
                                                                        {{ $cart['price'] }}</h6>
                                                                    <button class="close-button close_button"
                                                                        data-id={{ $key }}
                                                                        onclick="closeCart()">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>

                                                        @php
                                                            $total_price =
                                                                $total_price + $cart['price'] * $cart['quantity'];
                                                        @endphp
                                                    @empty
                                                        <p>Your cart is empty.</p>
                                                    @endforelse
                                                </ul>

                                                <div class="price-box">
                                                    <h5>Total :</h5>
                                                    <h4 class="theme-color fw-bold" id="total_price">৳
                                                        {{ $total_price }}</h4>
                                                </div>

                                                <div class="button-group">
                                                    <a href="" class=""></a>
                                                    <a href="{{ route('checkout') }}"
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
                                                    @if (auth()->user()->role == 'admin')
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('admin.home') }}">Admin Dashboard</a>
                                                        </li>
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('admin.logout') }}">Logout</a>
                                                        </li>
                                                    @elseif (auth()->user()->role == 'agent')
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('agent.dashboard') }}">Agent Dashboard</a>
                                                        </li>
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('agent.logout') }}">Logout</a>
                                                        </li>
                                                    @else
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('user.dashboard') }}">User Dashboard</a>
                                                        </li>
                                                        <li class="product-box-contain">
                                                            <a href="{{ route('user.logout') }}">Logout</a>
                                                        </li>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <li class="product-box-contain">
                                                        <a href="{{ route('login') }}">Log In</a>
                                                    </li>
                                                    <li class="product-box-contain">
                                                        <a href="{{ route('register') }}">User Register</a>
                                                    </li>
                                                @endguest
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
                                            <a href="{{ route('category.details', $category->slug) }}"
                                                class="category-name">
                                                <img src="{{ asset($category->image && file_exists(public_path($category->image)) ? $category->image : 'upload/category/no_category.png') }}"
                                                    alt="category_image">
                                                @if (App::getLocale() == 'en')
                                                    <h6>{{ $category->name }}</h6>
                                                @else
                                                    <h6>{{ $category->translations->name }}</h6>
                                                @endif
                                                <i class="fa-solid fa-angle-right"></i>
                                            </a>
                                        </li>
                                    @empty
                                        <li>No categories found</li>
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
                                                    class="nav-link" style="font-weight: 500;">{{ __('content.home') }}</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link" style="font-weight: 500;" href="{{ route('all.shops') }}">
                                                    {{ __('content.shops') }}
                                                </a>
                                                <ul class="dropdown-menu">
                                                    {{-- @forelse ($brands as $brand)
                                                        <li>
                                                            @if (App::getLocale() == 'en')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('brand.details', $brand->id) }}">
                                                                    {{ $brand->name ?? 'Unnamed Brand' }}
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{{ route('brand.details', $brand->id) }}">
                                                                    {{ $brand->translations->name ?? ($brand->name ?? 'Unnamed Brand') }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @empty
                                                        <li class="dropdown-item text-muted">No brands available</li>
                                                    @endforelse --}}
                                                </ul>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link" style="font-weight: 500;" href="{{ route('all.shops') }}">
                                                    {{ __('content.product') }}
                                                </a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a href="{{ url('/') }}"
                                                    class="nav-link" style="font-weight: 500;">{{ __('content.about') }}</a>
                                            </li>

                                            <li class="nav-item dropdown">
                                                <a class="nav-link" style="color: red; font-weight: 600;"
                                                    href="{{ route('agentregister.show') }}">
                                                    {{ __('content.seller') }}
                                                </a>
                                            </li>

                                            {{-- <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                    data-bs-toggle="dropdown">{{ __('content.blog') }}</a>
                                            </li> --}}
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

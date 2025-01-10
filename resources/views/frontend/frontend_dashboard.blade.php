<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fastkart">
    <meta name="keywords" content="Fastkart">
    <meta name="author" content="Fastkart">
    <link rel="icon" href="{{ asset('frontend') }}/assets/images/favicon/ElhaamBD_logo_Fav_icon.png"
        type="image/x-icon">
    <title>Elhaam BD</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- bootstrap css -->
    <link id="rtl-link" rel="stylesheet" type="text/css"
        href="{{ asset('frontend') }}/assets/css/vendors/bootstrap.css">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- wow css -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css" />

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/vendors/font-awesome.css">

    <!-- feather icon css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/vendors/feather-icon.css">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/vendors/slick/slick-theme.css">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/bulk-style.css">

    <!-- Template css -->
    <link id="color-link" rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/style.css">


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>

<body class="bg-effect">

    {{-- <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <!-- Loader End --> --}}

    @include('frontend.header')
    <!-- mobile fix menu start -->
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="index.html">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="mobile-category">
                <a href="javascript:void(0)">
                    <i class="iconly-Category icli js-link"></i>
                    <span>Category</span>
                </a>
            </li>

            <li>
                <a href="search.html" class="search-box">
                    <i class="iconly-Search icli"></i>
                    <span>Search</span>
                </a>
            </li>

            <li>
                <a href="wishlist.html" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                    <span>My Wish</span>
                </a>
            </li>

            <li>
                <a href="cart.html">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>Cart</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- mobile fix menu end -->


    @yield('main')


    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-6">
                            <div class="slider-image">
                                <img src="{{ asset('frontend') }}/assets/images/product/category/1.jpg"
                                    class="img-fluid blur-up lazyload" alt="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name">Peanut Butter Bite Premium Butter Cookies 600 g</h4>
                                <h4 class="price">$36.99</h4>
                                <div class="product-rating">
                                    <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>
                                    <span class="ms-2">8 Reviews</span>
                                    <span class="ms-2 text-danger">6 sold in last 16 hours</span>
                                </div>

                                <div class="product-detail">
                                    <h4>Product Details :</h4>
                                    <p>Candy canes sugar plum tart cotton candy chupa chups sugar plum chocolate I love.
                                        Caramels marshmallow icing dessert candy canes I love soufflé I love toffee.
                                        Marshmallow pie sweet sweet roll sesame snaps tiramisu jelly bear claw. Bonbon
                                        muffin I love carrot cake sugar plum dessert bonbon.</p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Brand Name:</h5>
                                            <h6>Black Forest</h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="brand-box">
                                            <h5>Product Code:</h5>
                                            <h6>W0690034</h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="brand-box">
                                            <h5>Product Type:</h5>
                                            <h6>White Cream Cake</h6>
                                        </div>
                                    </li>
                                </ul>

                                <div class="select-size">
                                    <h4>Cake Size :</h4>
                                    <select class="form-select select-form-size">
                                        <option selected>Select Size</option>
                                        <option value="1.2">1/2 KG</option>
                                        <option value="0">1 KG</option>
                                        <option value="1.5">1/5 KG</option>
                                        <option value="red">Red Roses</option>
                                        <option value="pink">With Pink Roses</option>
                                    </select>
                                </div>

                                <div class="modal-button">
                                    <button onclick="location.href = 'cart.html';"
                                        class="btn btn-md add-cart-button icon">Add
                                        To Cart</button>
                                    <button onclick="location.href = 'product-left.html';"
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->


    @include('frontend.footer')


    <!-- Tap to top start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->

    <!-- latest jquery-->
    <script src="{{ asset('frontend') }}/assets/js/jquery-3.6.0.min.js"></script>

    <!-- jquery ui-->
    <script src="{{ asset('frontend') }}/assets/js/jquery-ui.min.js"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('frontend') }}/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap/bootstrap-notify.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap/popper.min.js"></script>

    <!-- feather icon js-->
    <script src="{{ asset('frontend') }}/assets/js/feather/feather.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/feather/feather-icon.js"></script>

    <!-- Lazyload Js -->
    <script src="{{ asset('frontend') }}/assets/js/lazysizes.min.js"></script>

    <!-- Slick js-->
    <script src="{{ asset('frontend') }}/assets/js/slick/slick.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/slick/custom_slick.js"></script>

    <!-- Auto Height Js -->
    <script src="{{ asset('frontend') }}/assets/js/auto-height.js"></script>

    <!-- Timer Js -->
    <script src="{{ asset('frontend') }}/assets/js/timer1.js"></script>

    <!-- Fly Cart Js -->
    <script src="{{ asset('frontend') }}/assets/js/fly-cart.js"></script>

    <!-- Quantity js -->
    <script src="{{ asset('frontend') }}/assets/js/quantity-2.js"></script>

    <!-- WOW js -->
    <script src="{{ asset('frontend') }}/assets/js/wow.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/custom-wow.js"></script>

    <!-- script js -->
    <script src="{{ asset('frontend') }}/assets/js/script.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function closeCart() {
            var id = event.currentTarget.getAttribute('data-id');
            var url = "{{ route('cart.remove', ':id') }}".replace(':id', id);
            // alert(id);

            $.ajax({
                type: 'GET',
                url: url,
                contentType: false,
                processData: false,

                success: function(data) {
                    console.log(data);
                    $('#cart-quantity').text(data.update_cart_quantity);
                    $('#total_price').text(data.total_price);
                    $('#sub_total').text(data.total_price);
                    $('#total_order_amount').text(data.total_price);
                }
            });
        }
    </script>

<script>
    function toggleTransactionField() {
        var paymentOption = document.getElementById('payment-option').value;
        var transactionField = document.getElementById('transaction-field');
        if (paymentOption === 'full-amount') {
            transactionField.style.display = 'block';
        } else {
            transactionField.style.display = 'none';
        }
    }
    
</script>

<script>        
    $(document).ready(function() {
    // Trigger update when the area selection changes
    $('#area').change(function() {
        // Get the selected value from the dropdown
        var areaValue = $(this).val();
        // Default total price (replace with actual value)
        var totalPrice = parseInt($('#sub_total').text()); // Replace with your dynamic total price
        
        
        var shippingAmount = 0;
        if (areaValue) {
            shippingAmount = parseInt(areaValue);
        }
        

        // Update the shipping amount displayed
        $('#shipping_amount').text(shippingAmount);

        // Calculate and update the total order amount (including shipping)
        var totalOrderAmount = totalPrice + shippingAmount;
        
        $('#total_order_amount').text(totalOrderAmount);
    });
});
</script>

    @yield('script')


</body>

</html>

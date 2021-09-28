<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="/assets/font_icon/css/all.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
    <link rel="stylesheet" href="/assets/css/video-popup.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    @yield("styles")
</head>

<body>

<!--Preloader Start-->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!--Preloader End-->
<header class="header__main__wrap">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="/assets/img/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ABOUT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">TEAM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("sportsPress")}}">SportsPress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">NEWS</a>
                    </li>
                    <!-- site logo  -->
                    <li class="nav-item responsive-link-hide">
                        <a class="nav-link desktop__site_logo" href="#"><img src="/assets/img/logo.png" alt=""></a>
                    </li>
                    <!-- site logo  -->
                    <li class="nav-item">
                        <a class="nav-link" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Donations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('cart.show')}}"> Cart {{\Gloudemans\Shoppingcart\Facades\Cart::content()->count()}}</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</header>
@yield("content")
<footer class="footer-main-area">
    <div class="container">
        <div class="footer-inner-wrap">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-item-left">
                        <h3>ABOUT</h3>
                        <p>Bicycle rights heirloom poutine twee distillery kale chips. Thundercats pok pok seitan
                            waistcoat whatever yr. Squid cornhole iPhone umami thundercats, shabby chic pinterest
                            crucifix kogi irony. Chambray lyft flannel pok pok.

                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-item-middle">
                        <img src="/assets/img/logo.png" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="footer-item-right">
                        <h3>CONTACT INFO</h3>
                        <p>Call-center: <span>1 (323) 938-5798</span></p>
                        <p>Sales: <span>1 (888) 637-7262</span></p>
                        <p>Email: <span>info@styleixthemes.com</span></p>
                        <p class="footer-right-bottom">
                            1840 E Garvey Avenue Street
                            West Covina, CA 91791, U.S.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>© 2020 <a href="#">StylemixThemes</a> | Trademarks and brands are the property of their respective
            owners.</p>
    </div>
</footer>
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="/assets/js/main.js"></script>
@yield("scripts")
</body>

</html>

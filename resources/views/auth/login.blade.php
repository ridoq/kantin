<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-wide customizer-hide" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">
<!-- Mirrored from demos.pixinvent.com/materialize-html-admin-template/html/vertical-menu-template/auth-login-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jun 2024 03:12:37 GMT -->

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        Login Basic - Pages | Materialize - Material Design HTML Admin Template
    </title>

    <meta name="description"
        content="Materialize – is the most developer friendly &amp; highly customizable Admin Dashboard Template." />
    <meta name="keywords"
        content="dashboard, material, material design, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/materialize_admin" />

    <!-- ? PROD Only: Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "../../../../www.googletagmanager.com/gtm5445.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-5J3LMKC");
    </script>
    <!-- End Google Tag Manager -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="https://demos.pixinvent.com/materialize-html-admin-template/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/%40form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>


    <!-- Content -->

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card p-md-7 p-1">

                    <div class="card-body mt-1">
                        <h2 class="mb-1 text-primary" style="font-weight: 800;font-size:2.5rem;">Login</h2>
                        <p class="mb-5" style="color:rgba(0,0,0,.5);">
                            Please sign-in to your account and start the adventure
                        </p>

                        <form id="login-form" class="mb-5" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="email" name="email" id="email" placeholder="Your Email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    class="form-control @error('email') is-invalid @enderror" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="email">Email</label>
                            </div>
                            <div class="mb-5">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input aria-describedby="password" type="password" name="password"
                                                id="password" placeholder="Password" required
                                                autocomplete="current-password"
                                                class="form-control @error('password') is-invalid @enderror" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <label for="password">Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ri-eye-off-line"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5 d-flex justify-content-between mt-5">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} class="form-check-input  agree-term" />
                                    <label for="remember" class="form-check-label label-agree-term">Remember Me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="float-end mb-1 mt-2">
                                        <span>{{ __('Forgot Your Password?') }}</span>
                                    </a>
                                @endif
                            </div>
                            <div class="mb-5">
                                <button type="submit" name="login" id="login" class="btn btn-primary d-grid w-100 form-submit">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            @if (Route::has('register'))
                                    <a href="{{ route('register') }}"><span>{{ __('Register') }}</span></a>
                            @endif
                        </p>

            </div>
        </div>
    </div>


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/%40form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/%40form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>
</body>

<!-- Mirrored from demos.pixinvent.com/materialize-html-admin-template/html/vertical-menu-template/auth-login-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 27 Jun 2024 03:12:38 GMT -->

</html>


{{-- <div class="auth-content">
    <h2 class="form-title">Login</h2>
    <form method="POST" action="{{ route('login') }}" class="register-form" id="login-form">
        @csrf
        <div class="form-group">
            <label for="email"><i class="zmdi zmdi-email"></i></label>
            <input type="email" name="email" id="email" placeholder="Your Email" value="{{ old('email') }}" required autocomplete="email" autofocus class="@error('email') is-invalid @enderror"/>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password"><i class="zmdi zmdi-lock"></i></label>
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password" class="@error('password') is-invalid @enderror"/>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <label for="remember" class="label-agree-term">Remember Me</label>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="agree-term"/>
                </div>
                @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="form-group form-button">
            <button type="submit" name="login" id="login" class="form-submit">
                {{ __('Login') }}
            </button>
        </div>
    </form>
</div> --}}

<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../../../"/>
		<title>SidePade - Login</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta charset="utf-8" />
        <meta name="description" content="Sistem Informasi Terpadu Pemadanan Database Ekonomi Kota Mataram">
	    <meta name="keywords" content="Sistem Informasi Terpadu Pemadanan Database Ekonomi Kota Mataram">
	    <meta name="author" content="SIDEPADE">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Keen - Multi-demo Bootstrap 5 HTML Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/keen" />
		<meta property="og:site_name" content="Keenthemes | Keen" />
		<link rel="canonical" href="https://preview.keenthemes.com/keen" />
		<link rel="shortcut icon" href="{{ asset('theme/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('theme/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('theme/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank app-blank">
		<!--begin::Theme mode setup on page load-->
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50p-10">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid w-100 min-vh-100">
                    <img alt="Logo" src="{{ asset('theme/media/logos/logo-main.png') }}"
                    style="max-width: 128px;" />
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10 h-md-full">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                        method="POST">
                            @csrf
                            @method('POST')
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Form Login</h1>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email"
                                name="username" autocomplete="off"
                                class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password"
                                name="password" autocomplete="off"
                                class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <div class="d-grid my-10">
                                <button type="submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Login</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            @if($errors->any())
                            <div class="alert alert-danger d-flex align-items-center p-5 gap-2">
                                <!--begin::Icon-->
                                <i class="las la-exclamation-circle fs-5x text-danger"></i>
                                <!--end::Icon-->

                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column">
                                    <!--begin::Title-->
                                    <h4 class="mb-1 text-danger">Error</h4>
                                    <!--end::Title-->
                                    <!--begin::Content-->
                                    @foreach ($errors->all() as $error)
                                        <span>{{ $error }}.</span>
                                    @endforeach
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            @endif
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            </div>
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('theme/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('theme/js/scripts.bundle.js') }}"></script>
        <script>
            var defaultThemeMode = "light"; var themeMode;
            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if ( localStorage.getItem("data-bs-theme") !== null ) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else { themeMode = defaultThemeMode; }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>

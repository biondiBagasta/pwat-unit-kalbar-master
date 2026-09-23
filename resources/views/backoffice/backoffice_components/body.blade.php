<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../"/>
		<title>PWAT Unit Kalbar - @yield("page-title")</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<link rel="shortcut icon" href="{{ asset('theme/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{ asset('theme/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('theme/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('theme/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
		<!--end::Global Stylesheets Bundle-->
        <style>
            .toast {
                border: none !important;
            }

            /* #dataTable {
                min-width: 1200px;
            } */

            #toast-container > div {
                opacity: 1 !important;
                font-size: 1rem;
                font-weight: 500;
            }

            .hidden {
                display: none;
            }

            .main-logo {
                width: 96px;
                height: 96px;
            }

            @media only screen and (max-width: 600px) {
                .main-logo {
                    width: 64px;
                    height: 64px;
                }
            }
        </style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light";
            var themeMode; if ( document.documentElement )
            {
                if ( document.documentElement.hasAttribute("data-bs-theme-mode"))
                    {
                        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                    }
                else
                    {
                        if ( localStorage.getItem("data-bs-theme") !== null ) {
                            themeMode = localStorage.getItem("data-bs-theme");
                        } else {
                            themeMode = defaultThemeMode;
                        }
                    } if (themeMode === "system") {
                        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                    } document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
                @include('backoffice.backoffice_components.header')
				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    @extends('backoffice.backoffice_components.sidebar')
                    <!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container container-xxl -->
								<div id="kt_app_toolbar_container" class="app-container w-100 d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex
                                        text-dark fw-bold fs-1 flex-column justify-content-center my-0">
                                            @yield('page-title')
                                        </h1>
										<!--end::Title-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<!--begin::Page title-->
                                        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                                <!--begin::Item-->
                                                <li class="breadcrumb-item text-muted">
                                                    <a href="#" class="text-muted text-hover-primary">Home</a>
                                                </li>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <li class="breadcrumb-item">
                                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                                </li>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <li class="breadcrumb-item text-muted">
                                                    @yield('page-title')
                                                </li>
                                                <!--end::Item-->
                                            </ul>
                                            <!--end::Breadcrumb-->
                                        </div>
									</div>
									<!--end::Actions-->
								</div>
								<!--end::Toolbar container-->
							</div>
							<!--end::Toolbar-->
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container  container-xxl -->
								<div id="kt_app_content_container" class="app-container">
									<!--begin::Home card-->
                                    @yield('content')
									<!--end::Home card-->
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							<!--begin::Footer container-->
							<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<!--begin::Copyright-->
								<div class="text-dark order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2026 &copy;</span>
									<a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Persatuan Wanita Aneka Tambang Unit Kalbar</a>
								</div>
								<!--end::Copyright-->
							</div>
							<!--end::Footer container-->
						</div>
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
            </div>
        </div>
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('theme/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('theme/js/scripts.bundle.js') }}"></script><!--end::Javascript-->
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@5.1.4/dist/signature_pad.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('theme/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('theme/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
        {{-- <script src="{{ asset('theme/js/underscore.min.js') }}"></script> --}}
        <script src="{{ asset('theme/js/debounce.js') }}"></script>
        <script src="{{ asset('theme/js/dayjs.min.js') }}"></script>
        <script src="{{ asset('theme/js/highmaps.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

        @yield('script')

        @yield('script-child')

        @yield("script-child-second")

        <script type="text/javascript">

            $(document).ready(function () {
                function formatDateIndonesia(date) {
                    return new Intl.DateTimeFormat('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    }).format(new Date(date));
                }
                // Bagian Surat Masuk
                $.get("{{ route('correspondence.history-user') }}", function (data) {

                    let historyElementData = '';

                    if(data.length == 0) {
                        historyElementData += `
                            <div class="alert alert-info d-flex align-items-center p-5 mb-5">
                                <i class="las la-info-circle fs-2hx text-primary me-4">

                                </i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-primary">Tidak Ada Data Surat Masuk</h4>
                                </div>
                            </div>
                        `

                        $("#historySuratContainer").html(historyElementData)
                    } else {
                        data.forEach(function (d, index) {
                            var url = "{{ route('correspondence.pdf', ":id") }}";
                            url = url.replace(':id', d.id);
                            historyElementData += `<a
                            href="${url}"
                            target="_blank"
                            class="card cursor-pointer">
                                <div class="${d.readed == 0 ? 'card-body bg-light-primary' : 'card-body bg-light-success'}">
                                    <div class="d-flex flex-row align-items-center justify-content-between gap-6">
                                        <div class="d-flex flex-row align-items-center gap-6">
                                            <div class="symbol symbol-50px">
                                                <div class="${d.readed == 0 ? 'symbol-label bg-primary' : 'symbol-label bg-success'}">
                                                    <i class="${d.readed == 0 ? 'las la-envelope text-white' : 'las la-envelope-open text-white'}" style="font-size: 3rem"></i>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column gap-2">
                                                <div class="fs-2 fw-semibold">
                                                    ${d.subject}
                                                </div>
                                                <div>
                                                    <span>
                                                        <i class="las la-user fs-2"></i>
                                                    </span>
                                                    <span>
                                                        ${d.sender_data.full_name}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="fs-6 text-dark">
                                            ${formatDateIndonesia(d.letter_date)}
                                        </div>
                                    </div>
                                </div>
                            </a>`
                        });

                        $("#historySuratContainer").html(historyElementData)
                    }
                });

                // Bagian Count Post
                $.get("{{ route('post.count-waiting') }}", function(data) {
                    if(data > 0) {
                        $("#badgeCountPost").removeClass("d-none");
                        $("#badgeCountPost").text(data)
                    }
                })
            })
        </script>
	</body>
	<!--end::Body-->
</html>

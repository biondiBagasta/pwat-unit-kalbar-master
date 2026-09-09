<!--begin::Navbar-->
<div class="card card-flush mb-9" id="kt_user_profile_panel">
    <!--begin::Hero nav-->
    <div class="card-header rounded-top bgi-size-cover h-200px" style="background-position: 100% 50%;
    background-image:url({{ asset('theme/media/misc/city-background.jpg') }})"></div>
    <!--end::Hero nav-->
    <!--begin::Body-->
    <div class="card-body mt-n19">
        <!--begin::Details-->
        <div class="m-0">
            <!--begin: Pic-->
            <div class="d-flex flex-stack align-items-end pb-4 mt-n19">
                <div class="symbol symbol-125px symbol-lg-150px symbol-fixed position-relative mt-n3">
                    <img
                    src="{{
                        (Auth::user()?->member->photo) ?
                        url('/storage/members/' . Auth::user()->member->photo ) :

                        url('/storage/members/user-default.png')
                    }}"
                    alt="image"
                    class="border border-white border-4"
                    style="border-radius: 20px" />
                    <div class="position-absolute translate-middle bottom-0 start-100 ms-n1 mb-9 bg-success rounded-circle h-15px w-15px"></div>
                </div>
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="d-flex flex-stack flex-wrap align-items-end">
                <!--begin::User-->
                <div class="d-flex flex-column">
                    <!--begin::Name-->
                    <div class="d-flex align-items-center mb-2">
                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">
                            {{ Auth::user()->member->full_name }}
                        </a>
                        <a href="#" class="" data-bs-toggle="tooltip" data-bs-placement="right" title="Account is verified">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                    <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
                                    <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </a>
                    </div>
                    <!--end::Name-->
                    <!--begin::Text-->
                    <span class="fw-bold text-gray-600 fs-6 mb-2 d-block">
                        {{ Auth::user()->member->regency->name }}, {{ Auth::user()->member->regency->province->name }}
                    </span>
                    <!--end::Text-->
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap fw-semibold fs-7 pe-2">
                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary">
                            {{ Auth::user()->member->member_type->name }}
                        </a>
                        <span class="bullet bullet-dot h-5px w-5px bg-gray-400 mx-3"></span>
                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary">
                            {{ Auth::user()->member->member_role->name }}
                        </a>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::User-->
                <!--begin::Actions-->
                <div class="d-flex">
                    <button type="button"
                        class="btn btn-sm btn-primary me-3"
                        id="sendMessage">
                        <i class="las la-envelope fs-2 me-1"></i>
                        Kirim Surat
                    </button>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
    </div>
</div>
<!--end::Navbar-->

<!--begin::Nav items-->
<div id="kt_user_profile_nav" class="rounded bg-gray-200 d-flex flex-stack flex-wrap mb-9 p-2" data-kt-sticky="true" data-kt-sticky-name="sticky-profile-navs" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{target: '#kt_user_profile_panel'}" data-kt-sticky-left="auto" data-kt-sticky-top="70px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
    <!--begin::Nav-->
    <ul class="nav flex-wrap border-transparent">
        <!--begin::Nav item-->
        <li class="nav-item my-1">
            <a class="{{
                request()->route()->named('member-profile.overview') ?
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active' :
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1'
            }}"
            href="{{ route("member-profile.overview", $member_id) }}">Overview</a>
        </li>
        <!--end::Nav item-->
        <!--begin::Nav item-->
        <li class="nav-item my-1">
            <a class="{{
                request()->route()->named('member-profile.post') ?
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active' :
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1'
            }}"
            href="{{ route("member-profile.post", $member_id) }}">Posts</a>
        </li>
        <!--end::Nav item-->
        <!--begin::Nav item-->
        <li class="nav-item my-1">
            <a class="{{
                request()->route()->named('member-profile.suggestion') ?
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1 active' :
                'btn btn-sm btn-color-gray-600 bg-state-body btn-active-color-gray-800 fw-bolder fw-bold fs-6 fs-lg-base nav-link px-3 px-lg-4 mx-1'
            }}"
            href="{{ route("member-profile.suggestion", $member_id) }}">Saran</a>
    </ul>
    <!--end::Nav-->
</div>
<!--end::Nav items-->

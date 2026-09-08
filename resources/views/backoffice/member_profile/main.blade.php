@extends("backoffice.backoffice_components.body")

@section("page-title")
Member Profile
@endsection

@section("content")
@if(session("create"))
<div class="alert alert-success d-flex align-items-center p-5 mb-5">
    <i class="las la-check-circle fs-2hx text-success me-4">

    </i>
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-success">CREATE</h4>
        <span>{{ session("create") }}</span>
    </div>
</div>
@endif

@if(session("delete"))
<div class="alert alert-danger d-flex align-items-center p-5 mb-5">
    <i class="las la-trash fs-2hx text-danger me-4">

    </i>
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-danger">DELETE</h4>
        <span>{{ session("delete") }}</span>
    </div>
</div>
@endif

@if(session("update"))
<div class="alert alert-info d-flex align-items-center p-5 mb-5">
    <i class="las la-edit fs-2hx text-info me-4">

    </i>
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-info">UPDATE</h4>
        <span>{{ session("update") }}</span>
    </div>
</div>
@endif

@include("backoffice.member_profile.header")
@include("backoffice.member_profile.tabs")

@yield("tab")
@endsection

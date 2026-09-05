<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Foto</th>
                <th>Nama Lengkap</th>
                <th>Domisili</th>
                <th>Alamat Lengkap</th>
                <th>Nomor Whatsapp</th>
                <th>Pekerjaan</th>
                <th>Nama Suami</th>
                <th>Jabatan Suami</th>
                <th>Member Tag</th>
                <th>Member Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr>
                    <td style="width: 120px">
                        @if($d->photo != null)
                        <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ url('/storage/members/' . $d->photo ) }}">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-100px"
                                style="background-image:url('{{ url('/storage/members/' . $d->photo ) }}')">
                            </div>
                            <!--end::Image-->

                            <!--begin::Action-->
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                        @else
                        <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ url('/storage/members/user-default.png') }}">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-100px"
                                style="background-image:url('{{ url('/storage/members/user-default.png' ) }}')">
                            </div>
                            <!--end::Image-->

                            <!--begin::Action-->
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                        @endif
                    </td>
                    <td>{{ $d->full_name }}</td>
                    <td>
                        {{ $d->regency->name }}, {{ $d->regency->province->name }}
                    </td>
                    <td>{{ $d->address }}</td>
                    <td>{{ $d->phone_number }}</td>
                    <td>{{ $d->job }}</td>
                    <td>{{ $d->husband_name }}</td>
                    <td>{{ $d->husband_occupation }}</td>
                    <td>{{ $d->member_type->name }}</td>
                    <td>{{ $d->member_role->name }}</td>
                    <td>
                        @if($d->status == 1)
                        <span class="badge badge-light-success">Aktif</span>
                        @else
                        <span class="badge badge-light-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-2">
                            <button data-toggle="tooltip" data-id="{{ $d->id }}"
                            title="Profile" class="profile btn btn-icon btn-dark btn-sm me-1">
                                <i class="las la-user-circle fs-4"></i>
                            </button>

                            <button data-toggle="tooltip" data-id="{{ $d->id }}"
                            title="Edit" class="edit btn btn-icon btn-info btn-sm me-1">
                                <i class="las la-edit fs-4"></i>
                            </button>

                            <button data-toggle="tooltip"  data-id="{{ $d->id }}"
                            title="Delete" class="btn btn-icon btn-danger btn-sm delete">
                                <i class="las la-trash fs-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if(count($data) == 0)
<div class="alert alert-danger d-flex align-items-center p-5">
    <i class="las la-exclamation-triangle fs-2hx text-danger me-4">

    </i>
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-1 text-dark">Perhatian</h4>
        <!--end::Title-->

        <!--begin::Content-->
        <span>Data Member Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<ul class="pagination mt-5">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/member?term=$term&page=" . ($current_page - 1)) }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{ url("backoffice/member?term=$term&page=$i") }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/member?term=$term&page=" . ($current_page + 1)) }}">Next</span></a>
    </li>
</ul>

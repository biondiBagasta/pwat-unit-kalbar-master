<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Gambar</th>
                <th>Urutan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr class="align-middle">
                    <td style="width: 120px">
                        <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ url('/storage/carousels/' . $d->image ) }}">
                            <!--begin::Image-->
                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-100px"
                                style="background-image:url('{{ url('/storage/carousels/' . $d->image ) }}')">
                            </div>
                            <!--end::Image-->

                            <!--begin::Action-->
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                <i class="bi bi-eye-fill text-white fs-3x"></i>
                            </div>
                            <!--end::Action-->
                        </a>
                    </td>

                    <td>
                        Urutan ke - {{ $d->show_order }}
                    </td>

                    <td>
                        <div class="d-flex flex-column flex-md-row gap-2">
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
        <span>Data Carousel Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif


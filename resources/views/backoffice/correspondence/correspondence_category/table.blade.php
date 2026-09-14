<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>No</th>
                <th>Code</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($correspondence_categories_data as $d)
                <tr>
                    <td>
                        {{ $loop->index + 1 }}
                    </td>
                    <td>{{ $d->code }}</td>
                    <td>{{ $d->name }}</td>
                    <td>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <button data-toggle="tooltip" data-id="{{ $d->id }}"
                            title="Edit" class="child-edit btn btn-icon btn-info btn-sm me-1">
                                <i class="las la-edit fs-4"></i>
                            </button>
                            <button data-toggle="tooltip"  data-id="{{ $d->id }}"
                            title="Delete" class="btn btn-icon btn-danger btn-sm child-delete">
                                <i class="las la-trash fs-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if(count($correspondence_categories_data) == 0)
<div class="alert alert-danger d-flex align-items-center p-5">
    <i class="las la-exclamation-triangle fs-2hx text-danger me-4">

    </i>
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-1 text-dark">Perhatian</h4>
        <!--end::Title-->

        <!--begin::Content-->
        <span>Data Kategori Surat Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Nama Event</th>
                <th>Kategori</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Konten</th>
                <th>Gallery</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr>
                    <td>
                        {{ $d->name }}
                    </td>
                    <td>{{ $d->event_category->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->start_date)->format('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->end_date)->format('d F Y') }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-light-primary detail-content"
                        data-id="{{ $d->id }}">
                            <div class="d-flex flex-row gap-2">
                                <i class="las la-eye fs-2"></i>
                                <div>Lihat</div>
                            </div>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-dark gallery-button"
                        data-id="{{ $d->id }}">
                            <div class="d-flex flex-row gap-2">
                                <i class="las la-image fs-2"></i>
                                <div>Lihat</div>
                            </div>
                        </button>
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
        <span>Data Event Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<ul class="pagination mt-5">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/suggestion?term=$term&page=" . ($current_page - 1)) }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{ url("backoffice/suggestion?term=$term&page=$i") }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/suggestion?term=$term&page=" . ($current_page + 1)) }}">Next</span></a>
    </li>
</ul>

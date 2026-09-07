<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Current Balance</th>
                <th>Catatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($d->finance_date)->format('d F Y') }}</td>
                    <td>{{ $d->finance_category->name }}</td>
                    <td>
                        @if($d->finance_category->type == 1)
                        <div class="d-flex flex-row gap-2 align-items-center badge badge-light-success">
                            <i class="las la-download text-success"></i>
                            Pemasukan
                        </div>
                        @else
                        <div class="d-flex flex-row gap-2 align-items-center
                        badge badge-light-danger">
                            <i class="las la-upload text-danger"></i>
                            Pengeluaran
                        </div>
                        @endif
                    </td>
                    <td>
                        Rp {{ number_format($d->amount, 0, ',', '.') }}
                    </td>
                    <td>
                        Rp {{ number_format($d->current_balance, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ $d->notes }}
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
        <span>Data Finance Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<ul class="pagination mt-5">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text"
        href="{{ url("backoffice/finance?start-date=$start_date&end-date=$end_date&page=" . ($current_page - 1)) }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{ url("backoffice/finance?start-date=$start_date&end-date=$end_date&page=$i") }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/finance?start-date=$start_date&end-date=$end_date&page=" . ($current_page + 1)) }}">Next</span></a>
    </li>
</ul>

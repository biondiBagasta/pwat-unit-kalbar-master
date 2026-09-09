<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Posted By</th>
                <th>Judul</th>
                <th>Konten</th>
                <th>hashtag</th>
                <th>Kategori</th>
                <th>Tanggal Post</th>
                <th>Publish Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr>
                    <td>
                        {{ $d->member->full_name }}
                    </td>
                    <td>{{ $d->title }}</td>
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
                        <div class="fw-bold">
                            {{ $d->hashtag }}
                        </div>
                    </td>
                    <td>
                        {{ $d->post_category->name }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d F Y') }}</td>
                    <td>
                        @if($d->post_status->code == "WT")
                        <span class="badge badge-light-info">{{ $d->post_status->name }}</span>
                        @elseif ($d->post_status->code == "PUB")
                        <span class="badge badge-light-success">{{ $d->post_status->name }}</span>
                        @else
                        <span class="badge badge-light-danger">{{ $d->post_status->name }}</span>
                        @endif
                    </td>
                    <td>
                        <button data-toggle="tooltip"  data-id="{{ $d->id }}"
                        title="Delete" class="btn btn-icon btn-danger btn-sm delete">
                            <i class="las la-trash fs-4"></i>
                        </button>
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
        <span>Data Saran Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<ul class="pagination mt-5">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/post?term=$term&page=" . ($current_page - 1)) }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{ url("backoffice/post?term=$term&page=$i") }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/post?term=$term&page=" . ($current_page + 1)) }}">Next</span></a>
    </li>
</ul>

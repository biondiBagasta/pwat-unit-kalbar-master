<div class="table-responsive mt-10">
    <table id="dataTable" class="table table-bordered table-striped table-rounded">
        <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbodyContainer">
            @foreach ($data as $d)
                <tr>
                    <td>
                        {{ $loop->index + 1 }}
                    </td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->user_role->name }}</td>
                    <td>
                        <button data-toggle="tooltip" data-id="{{ $d->id }}"
                        title="Edit" class="edit btn btn-icon btn-info btn-sm me-1">
                            <i class="las la-edit fs-4"></i>
                        </button>
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
        <span>Data User Kosong.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<ul class="pagination mt-5">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/user?term=$term&page=" . ($current_page - 1)) }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{ url("backoffice/user?term=$term&page=$i") }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{ url("backoffice/user?term=$term&page=" . ($current_page + 1)) }}">Next</span></a>
    </li>
</ul>

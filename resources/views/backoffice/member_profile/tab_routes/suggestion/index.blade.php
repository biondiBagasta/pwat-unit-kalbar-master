@extends("backoffice.member_profile.main")

@section("tab")

@if(Auth::user()->member->id == $member_id)
<div class="d-flex flex-row justify-content-end">
    <button type="button" class="btn btn-dark mb-8" id="createButton">
        <i class="las la-edit fs-2 me-1"></i>
        Ajukan Saran
    </button>
</div>
@endif

<div class="row">
    @foreach ($data as $d)
        <div class="col-md-6">
            <!--begin::Feature post-->
            <div class="card ms-md-6">
                <!--begin::Overlay-->
                <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                href="{{
                    ($d->cover_image) ?
                    url('/storage/suggestions/' . $d->cover_image ) :

                    url('/storage/suggestions/suggestion-default.jpg')
                }}">
                    <!--begin::Image-->
                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                    style="background-image:url({{
                    ($d->cover_image) ?
                        url('/storage/suggestions/' . $d->cover_image ) :

                        url('/storage/suggestions/suggestion-default.jpg')
                    }})"></div>
                    <!--end::Image-->
                    <!--begin::Action-->
                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                        <i class="bi bi-eye-fill fs-2x text-white"></i>
                    </div>
                    <!--end::Action-->
                </a>
                <!--end::Overlay-->
                <!--begin::Body-->
                <div class="card-body mt-5">
                    <!--begin::Title-->
                    <a href="#"
                        class="fs-4 text-dark fw-bold text-hover-primary text-dark lh-base">
                        {{ $d->title }} <span class="badge badge-secondary fw-bold my-2">{{ $d->suggestion_category->name }}</span>
                    </a>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-5 text-gray-600 my-3 text-truncate line-clamb-2">
                        {!! $d->content !!}
                    </div>
                    <!--end::Text-->
                    <!--begin::Content-->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fs-6 fw-bold">
                            <!--begin::Date-->
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($d->created_at)->format('d M Y') }}</span>
                            <!--end::Date-->
                        </div>
                    </div>

                    @if(Auth::user()->member->id == $member_id)
                    <div class="d-flex flex-column
                    gap-3
                    flex-md-row justify-content-md-between align-items-md-center mt-8">
                        <button type="button" class="btn btn-sm btn-light-primary detail-content"
                        data-id="{{ $d->id }}">
                            <div class="d-flex flex-row gap-2">
                                <i class="las la-eye fs-2"></i>
                                <div>Lihat Konten</div>
                            </div>
                        </button>

                        <div class="d-flex flex-column flex-md-row gap-2">
                            <button type="button"
                            class="edit btn btn-sm btn-info"
                            data-id="{{ $d->id }}">
                                <div class="d-flex flex-row gap-2">
                                    <i class="las la-edit fs-2"></i>
                                    <div>Edit</div>
                                </div>
                            </button>

                            <button type="button" class="delete btn btn-sm btn-danger"
                            data-id="{{ $d->id }}">
                                <div class="d-flex flex-row gap-2">
                                    <i class="las la-trash fs-2"></i>
                                    <div>Hapus</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Feature post-->
        </div>
        <!--end::Col-->
    @endforeach
</div>

@if(count($data) > 0)
<ul class="pagination my-10">
    <li class="{{ $current_page == 1 ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{
        route("member-profile.suggestion", $member_id, [
                'page' => $current_page - 1
            ])
            }}">Previous</span></a>
    </li>
    @for ($i = 1; $i <= $total_page; $i++)
        <li class="{{ $current_page == $i ? 'page-item active' : 'page-item'}}">
            <a href="{{
                route("member-profile.suggestion", $member_id, [
                    'page' => $i
                ])
            }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ $current_page == $total_page ? 'page-item previous disabled' :
    'page-item previous' }}">
        <a class="page-link page-text" href="{{
            route("member-profile.suggestion", $member_id, [
                'page' => $current_page + 1
            ])
        }}">Next</span></a>
    </li>
</ul>
@endif

@if(count($data) == 0)
<div class="alert alert-primary d-flex align-items-center p-5">
    <i class="las la-info-circle fs-2hx text-primary me-4">

    </i>
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-1 text-dark">Perhatian</h4>
        <!--end::Title-->

        <!--begin::Content-->
        <span>Belum Ada Data Saran.</span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Alert-->
@endif

<div style="height: 20vh"></div>

@include("backoffice.member_profile.tab_routes.suggestion.form")

@include("backoffice.member_profile.tab_routes.suggestion.content_detail")

@endsection

@section("script")
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        var modalBody = document.querySelector("#modalBody");

        var blockUI = new KTBlockUI(modalBody, {
            message: `<div class="blockui-message">
                <span class="spinner-border text-primary"></span> Memproses data...</div>`,
        });

        // Quill Section
        var contentQuill = new Quill('#content', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block'],
                    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }]
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' // or 'bubble'
        });

        $('#createButton').click(function () {
            $('#saveBtn').show();
            $('#editBtn').hide();
            $('#id').val('');
            $('#modalForm').trigger('reset');
            $('#modalTitle').html('Ajukan Saran');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();

            const title = $("#title").val();
            const content = contentQuill.root.innerHTML;
            const suggestion_category_id = $("#suggestion_category_id").val()
            const cover_image = $("#cover_image")[0].files[0];

            if(title && content && suggestion_category_id
            ) {
                blockUI.block();
                const formData = new FormData();

                if(cover_image) {
                    formData.append("cover_image", cover_image)
                }

                formData.append("title", title)
                formData.append("content", content)
                formData.append("suggestion_category_id", suggestion_category_id)

                $.ajax({
                    data: formData,
                    url: "{{ route('suggestion.create') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.success == true) {
                            location.reload();
                        } else {
                            blockUI.release();

                            toastr.error(data.message);
                        }
                        // $('#modalForm').trigger('reset');
                        // $('#actionModal').modal('hide');
                        // toastr.success(data.create);
                        // blockUI.release();
                        // location.reload();
                    },
                    error: function(data) {
                        console.log('Error : ', data);
                        blockUI.release();
                    }
                })
            } else {
                toastr.error("Semua field harus diisi terlebih dahulu sebelum membuat data.")
            }

        });

        // Edit Update LOGIC
        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');
            var url = "{{ route('suggestion.edit', ":id") }}";
            url = url.replace(':id', id);

            $.get(url, function(data) {
                $('#modalTitle').html('Edit Data Saran');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#title").val(data.title);
                $("#suggestion_category_id").val(data.suggestion_category_id);
                contentQuill.root.innerHTML = data.content
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const title = $("#title").val();
            const content = contentQuill.root.innerHTML;
            const suggestion_category_id = $("#suggestion_category_id").val()
            const cover_image = $("#cover_image")[0].files[0];

            if(title && content && suggestion_category_id
            ) {
                var id = $('#id').val();
                var url = "{{ route('suggestion.update', ":id") }}";
                url = url.replace(':id', id);
                blockUI.block();
                const formData = new FormData();

                if(cover_image) {
                    formData.append("cover_image", cover_image)
                }

                formData.append("title", title)
                formData.append("content", content)
                formData.append("suggestion_category_id", suggestion_category_id)
                formData.append('_method', 'PUT');

                blockUI.block();

                $.ajax({
                    data: formData,
                    url: url,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if(data.success == true) {
                            location.reload();
                        } else {
                            blockUI.release();
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        console.log('Error : ', data);
                        blockUI.release();
                    }
                })
            } else {
                toastr.error("Semua field harus diisi terlebih dahulu sebelum mengupdate data.");
            }
        });

        // DELETE METHOD
        $('body').on('click', '.delete', function() {
            var id = $(this).data('id');

            var url = "{{ route('suggestion.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Saran',
                text: "Apakah anda yakin ingin menghapus data Saran ini???",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {

                if(result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(data) {
                            if(data.success == true) {
                                location.reload();
                            } else {
                                toastr.error(data.message);
                            }
                        },
                        error: function(data) {
                            console.log('Error : ', data);
                        }
                    });
                }
            });
        });

        $("body").on("click", ".detail-content", function() {
            var id = $(this).data('id');
            var url = "{{ route('suggestion.edit', ":id") }}";
            url = url.replace(':id', id);

            $.get(url, function(data) {
                $('#detailContentModalTitle').html(`Detail Saran`);
                $("#detailContentBody").html(data.content)
                $('#detailContentModal').modal('show');

                if(data.cover_image == null) {
                    $("#detailCoverImage").attr("src", "{{ url('/storage/suggestions/suggestion-default.jpg') }}");
                } else {
                    var url = "{{ url('/storage/suggestions/:image') }}";
                    url = url.replace(':image', data.cover_image);

                    $("#detailCoverImage").attr("src", url);
                }
            })
        })
    }
)
</script>
@endsection

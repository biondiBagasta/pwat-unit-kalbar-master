@extends("backoffice.backoffice_components.body")

@section("page-title")
Saran
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

<div class="row">
    <div class="{{ Auth::user()->user_role->code == 'ME' ?
        'col-12' : 'col-12 col-md-8'}}">
        <div class="card">
            <div class="card-body p-lg-10" id="cardBody">
                <h2 class="card-title mb-5">Data Saran</h2>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">

                    <button type="button" class="btn btn-primary" id="createButton">
                        <i class="las la-plus-circle fs-2 me-1"></i>
                        Tambah Data
                    </button>

                    <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                        <div class="form-group mt-5">
                            <div class="input-group mb-5">
                                <span class="input-group-text" id="basic-addon3">
                                    <i class="las la-search fs-2"></i>
                                </span>
                                <input type="text" placeholder="Ketik Kata Kunci..."
                                class="form-control" id="search" aria-describedby="basic-addon3" />
                            </div>
                        </div>
                        <button class="btn btn-secondary" id="searchButton">Cari</button>
                    </div>
                </div>

                @include("backoffice.suggestion.table")
            </div>
        </div>
    </div>

    @if(Auth::user()->user_role->code != "ME")
    <div class="col-12 col-md-4">
        @include("backoffice.suggestion.suggestion_category.index")
    </div>
    @endif
</div>

@include("backoffice.suggestion.form")

@include("backoffice.suggestion.content_detail")

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

        var deleteUI = new KTBlockUI(cardBody, {
            message: `<div class="blockui-message">
                <span class="spinner-border text-primary"></span> Proses menghapus data...</div>`,
        });

        // Search Logic
        const term = @json($term);

        $("#search").val(term);

        $("#searchButton").on("click", function() {
            const term = $("#search").val();

            const newUrl = `${window.location.pathname}?term=${term}&page=1`;
            window.location.href = newUrl;
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
            var id = $(this).data("id")

            $.get("backoffice/suggestion/edit" + "/" + id, function(data) {
                $('#detailContentModalTitle').html(`Isi Saran ${data.title} oleh ${data.member.full_name}`);
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
    });
</script>
@endsection

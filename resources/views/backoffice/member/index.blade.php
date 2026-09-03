@extends("backoffice.backoffice_components.body")

@section("page-title")
Member
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

<div class="row mb-8">
    <div class="col-12 col-md-6">
        @include("backoffice.member.member_role.index")
    </div>

    <div class="col-12 col-md-6">
        @include("backoffice.member.member_type.index")
    </div>
</div>

<div class="card">
    <div class="card-body p-lg-10" id="cardBody">
        <h2 class="card-title mb-5">Data Member</h2>

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
                        <input type="text" placeholder="Ketik Username, Role..."
                        class="form-control" id="search" aria-describedby="basic-addon3" />
                    </div>
                </div>
                <button class="btn btn-secondary" id="searchButton">Cari</button>
            </div>
        </div>


        @include("backoffice.member.table")
    </div>
</div>

@include("backoffice.member.form")
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

        // Create Logic
        $('#createButton').click(function () {
            $('#saveBtn').show();
            $('#editBtn').hide();
            $('#id').val('');
            $('#modalForm').trigger('reset');
            $('#modalTitle').html('Tambah Data Member');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();

            const username = $("#username").val();
            const password = $("#password").val();
            const user_role_id = $("#user_role_id").val();

            if(username && password && user_role_id) {
                blockUI.block();
                const formData = new FormData();

                formData.append("username", username);
                formData.append("password", password);
                formData.append("user_role_id", user_role_id);

                $.ajax({
                    data: formData,
                    url: "{{ route('user.create') }}",
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
            $.get("backoffice/user/edit" + "/" + id, function(data) {
                $('#modalTitle').html('Edit Data User');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#username").val(data.username);
                $("#user_role_id").val(data.user_role_id);
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const username = $("#username").val();
            const user_role_id = $("#user_role_id").val();
            const password = $("#password").val();

            if(username && user_role_id) {
                var id = $('#id').val();

                var url = "{{ route('user.update', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                formData.append("user_role_id", user_role_id);
                formData.append("username", username);

                if(password) {
                    formData.append("password", password)
                }


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

            var url = "{{ route('user.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data User',
                text: "Apakah anda yakin ingin menghapus data User ini???",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {

                if(result.value) {
                    blockUI.block();
                    $.ajax({
                        type: "DELETE",
                        url: url,
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
                        }
                    });
                }
            });
        });
    }
)
</script>
@endsection

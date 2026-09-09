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
                        <input type="text" placeholder="Ketik Kata Kunci..."
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

        // Search Username Logic
        function debounce(callback, delay = 500) {
            let timeout;

            return function (...args) {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    callback.apply(this, args);
                }, delay);
            };
        }

        let isValidUsername = false;

        $("#username").on("input", debounce(function() {
            const username = $(this).val();

            const checkUsernameContainerSuccess = $("#checkUsernameContainerSuccess");
            const checkUsernameContainerError = $("#checkUsernameContainerError");

            const checkUsernameMessageSuccess = $("#checkUsernameMessageSuccess");
            const checkUsernameMessageError = $("#checkUsernameMessageError");

            if(username) {
                const formData = new FormData();

                formData.append("username", username);

                $.ajax({
                    data: formData,
                    url: "{{ route('member.check-username') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.success == true) {
                            checkUsernameContainerError.addClass("d-none");
                            checkUsernameContainerSuccess.removeClass("d-none");

                            checkUsernameMessageSuccess.text(data.message);

                            isValidUsername = true;
                        } else {
                            checkUsernameContainerError.removeClass("d-none");
                            checkUsernameContainerSuccess.addClass("d-none");

                            checkUsernameMessageError.text(data.message);

                            isValidUsername = false;
                        }
                    },
                    error: function(data) {
                        console.log('Error : ', data);
                    }
                })
            }

        }));

        // Load Regency Logic
        $("#province_id").on("change", function() {
            const val = $(this).val()

            const regencyElement = $("#regency_id");

            regencyElement.selectpicker('val', '');
            regencyElement.find('option').remove();
            regencyElement.selectpicker('destroy');

            // regencyElement.empty();
            // regencyElement.selectpicker("refresh");

            if(val) {
                const formData = new FormData();

                formData.append("province_id", val);

                $.ajax({
                    data: formData,
                    url: "{{ route('member.find-many-regency') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        const options = data
                        .map(function(item) {
                            return `<option value="${item.id}">${item.name}</option>`;
                        })
                        .join("");

                        // Replace semua option lama
                        regencyElement.html(options);

                        // Reset selected value
                        regencyElement.selectpicker("val", "");

                        // Refresh bootstrap-select
                        regencyElement.selectpicker("refresh");
                    },
                    error: function(data) {
                        console.log('Error : ', data);
                    }
                })
            }
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

            const full_name = $("#full_name").val();
            const address = $("#address").val();
            const phone_number = $("#phone_number").val();
            const job = $("#job").val();
            const husband_name = $("#husband_name").val();
            const husband_occupation = $("#husband_occupation").val();
            const photo = $("#photo")[0].files[0];
            const regency_id = $("#regency_id").val();
            const username = $("#username").val();
            const member_role_id = $("#member_role_id").val();
            const member_type_id = $("#member_type_id").val();

            if(full_name && address && phone_number && job && husband_name &&
                husband_occupation && regency_id && username && member_role_id
                && member_type_id
            ) {
                blockUI.block();
                const formData = new FormData();

                if(photo) {
                    formData.append("photo", photo)
                }

                formData.append("full_name", full_name)
                formData.append("address", address)
                formData.append("phone_number", phone_number)
                formData.append("job", job)
                formData.append("husband_name", husband_name)
                formData.append("husband_occupation", husband_occupation)
                formData.append("regency_id", regency_id)
                formData.append("username", username)
                formData.append("member_role_id", member_role_id)
                formData.append("member_type_id", member_type_id)

                $.ajax({
                    data: formData,
                    url: "{{ route('member.create') }}",
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

            $.get("backoffice/member/edit" + "/" + id, function(data) {
                $('#modalTitle').html('Edit Data User');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#full_name").val(data.full_name);
                $("#address").val(data.address);
                $("#phone_number").val(data.phone_number);
                $("#job").val(data.job);
                $("#husband_name").val(data.husband_name);
                $("#husband_occupation").val(data.husband_occupation);
                $("#username").val(data.user.username);
                $("#member_role_id").val(data.member_role_id);
                $("#member_type_id").val(data.member_type_id);

                // Update SelectPicker Logic
                const formData = new FormData();

                formData.append("province_id", data.regency.province_id);

                const provinceElement = $("#province_id");
                const regencyElement = $("#regency_id");

                $.ajax({
                    data: formData,
                    url: "{{ route('member.find-many-regency') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data2) {
                        const options = data2
                        .map(function(item) {
                            return `<option value="${item.id}">${item.name}</option>`;
                        })
                        .join("");

                        // Replace semua option lama
                        regencyElement.html(options);

                        // Reset selected value
                        regencyElement.selectpicker("val", data.regency_id);
                        provinceElement.selectpicker("val", data.regency.province_id);

                        // Refresh bootstrap-select
                        provinceElement.selectpicker("refresh");
                        regencyElement.selectpicker("refresh");
                    },
                    error: function(data) {
                        console.log('Error : ', data2);
                    }
                })
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const full_name = $("#full_name").val();
            const address = $("#address").val();
            const phone_number = $("#phone_number").val();
            const job = $("#job").val();
            const husband_name = $("#husband_name").val();
            const husband_occupation = $("#husband_occupation").val();
            const photo = $("#photo")[0].files[0];
            const regency_id = $("#regency_id").val();
            const username = $("#username").val();
            const member_role_id = $("#member_role_id").val();
            const member_type_id = $("#member_type_id").val();

            if(full_name && address && phone_number && job && husband_name &&
                husband_occupation && regency_id && username && member_role_id
                && member_type_id
            ) {
                var id = $('#id').val();

                var url = "{{ route('member.update', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                if(photo) {
                    formData.append("photo", photo)
                }

                formData.append("full_name", full_name)
                formData.append("address", address)
                formData.append("phone_number", phone_number)
                formData.append("job", job)
                formData.append("husband_name", husband_name)
                formData.append("husband_occupation", husband_occupation)
                formData.append("regency_id", regency_id)
                formData.append("username", username)
                formData.append("member_role_id", member_role_id)
                formData.append("member_type_id", member_type_id)


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

            var url = "{{ route('member.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Member',
                text: "Apakah anda yakin ingin menghapus data Member ini???",
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
    }
)
</script>
@endsection

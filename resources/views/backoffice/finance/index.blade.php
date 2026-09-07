@extends("backoffice.backoffice_components.body")

@section("page-title")
Finance
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

<!--begin::Alert-->
<div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row p-5 mb-10">
    <!--begin::Icon-->
    <i class="ki-duotone ki-search-list fs-2hx text-success me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <!--end::Icon-->

    <!--begin::Wrapper-->
    <div class="d-flex flex-column pe-0 pe-sm-10">
        <!--begin::Title-->
        <h5 class="mb-1">Uang Kas</h5>
        <!--end::Title-->

        <div class="d-flex flex-row gap-4 align-items-center">
            <i class="las la-wallet fs-2hx"></i>
            <div class="fs-2hx text-dark fw-bold">
                Rp {{ number_format($balance->total, 0, ',', '.') }}
            </div>
        </div>
    </div>
    <!--end::Wrapper-->

    <!--begin::Close-->
    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
    </button>
    <!--end::Close-->
</div>
<!--end::Alert-->

<div class="row">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-body p-lg-10" id="cardBody">
                <h2 class="card-title mb-5">Data Finance</h2>

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
                                <input type="text" placeholder="Cari Berdasarkan Tanggal..."
                                class="form-control" id="filter-date"
                                aria-describedby="basic-addon3" />
                            </div>
                        </div>
                        <button class="btn btn-secondary" id="searchButton">Cari</button>
                    </div>
                </div>

                @include("backoffice.finance.table")
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        @include("backoffice.finance.finance_category.index")
    </div>
</div>

@include("backoffice.finance.form")
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

        // Filter Date Range Logic
        let start_date = null;
        let end_date = null;

        $("#filter-date").flatpickr({
            mode: "range",
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    let startDate = selectedDates[0]; // JS Date object
                    let endDate   = selectedDates[1]; // JS Date object

                    // Format to your desired string (already formatted by dateFormat)
                    let start = instance.formatDate(startDate, "Y-m-d");
                    let end   = instance.formatDate(endDate, "Y-m-d");

                    start_date = start
                    end_date = end
                }
            }
        });

        $("#searchButton").on("click", function() {
            const newUrl = `${window.location.pathname}?start-date=${start_date}&end-date=${end_date}&page=1`;
            window.location.href = newUrl;
        });

        // Finance Date
        let finance_date = null;

        $("#finance_date").flatpickr({
            defaultDate: "today",
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",

            onChange: function(selectedDates, dateStr, instance) {
                finance_date = dateStr;
            }
        });

        // Format Amount
        $("#amount").on("input", function () {
            let value = $(this).val().replace(/\D/g, "");

            if (value) {
                $(this).val(
                    `Rp. ${new Intl.NumberFormat("id-ID").format(value)}`
                );
            } else {
                $(this).val("");
            }

        });

        // Create Logic
        $('#createButton').click(function () {
            $('#saveBtn').show();
            $('#editBtn').hide();
            $('#id').val('');
            $('#modalForm').trigger('reset');
            $('#modalTitle').html('Tambah Data Finance');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();

            const amount = $("#amount").val().replace(/\D/g, "");;
            const finance_category_id = $("#finance_category_id").val();
            const notes = $("#notes").val();

            if(amount && finance_category_id && finance_date && notes) {
                blockUI.block();
                const formData = new FormData();

                formData.append("amount", amount);
                formData.append("finance_category_id", finance_category_id);
                formData.append("finance_date", finance_date);
                formData.append("notes", notes)

                $.ajax({
                    data: formData,
                    url: "{{ route('finance.create') }}",
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
            $.get("backoffice/finance/edit" + "/" + id, function(data) {
                $('#modalTitle').html('Edit Data User');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#amount").val(`Rp. ${new Intl.NumberFormat("id-ID").format(data.amount)}`);
                $("#notes").val(data.notes);
                $("#finance_category_id").val(data.finance_category_id);
                $("#finance_date")[0]._flatpickr.setDate(data.finance_date);

                finance_date = data.finance_date;
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const amount = $("#amount").val().replace(/\D/g, "");;
            const finance_category_id = $("#finance_category_id").val();
            const notes = $("#notes").val();

            if(amount && finance_category_id && finance_date && notes) {
                blockUI.block();

                var id = $('#id').val();

                var url = "{{ route('finance.update', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                formData.append("amount", amount);
                formData.append("finance_category_id", finance_category_id);
                formData.append("finance_date", finance_date);
                formData.append("notes", notes)

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

            var url = "{{ route('finance.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Finance',
                text: "Apakah anda yakin ingin menghapus data Finance ini???",
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
    });
</script>
@endsection

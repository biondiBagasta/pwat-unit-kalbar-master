@extends("backoffice.backoffice_components.body")

@section("page-title")
Event
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
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-body p-lg-10" id="cardBody">
                <h2 class="card-title mb-5">Data Event</h2>

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

                @include("backoffice.event.table")
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        @include("backoffice.event.event_category.index")
    </div>
</div>

@include("backoffice.event.form")
@endsection

@section("script")
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Flatpickr Logic
        var start_date = null;
        var end_date = null;

        // Deklarasi Flatpickr
        $("#event_date").flatpickr({
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

                    start_date = start;
                    end_date = end;
                }
            }
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
            $('#modalTitle').html('Tambah Data Event');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();

            const name = $("#name").val();
            const content = contentQuill.root.innerHTML;
            const event_category_id = $("#event_category_id").val();

            if(name && content && event_category_id && start_date
                && end_date
            ) {
                blockUI.block();
                const formData = new FormData();

                formData.append("name", name);
                formData.append("content", content);
                formData.append("event_category_id", event_category_id);
                formData.append("start_date", start_date)
                formData.append("end_date", end_date)

                $.ajax({
                    data: formData,
                    url: "{{ route('event.create') }}",
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
            $.get("backoffice/event/edit" + "/" + id, function(data) {
                $('#modalTitle').html('Edit Data Event');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#name").val(data.name);
                $("#content").val(data.content);
                $("#event_category_id").val(data.event_category_id);
                contentQuill.root.innerHTML = data.content;
                $("#event_date")[0]._flatpickr.setDate([
                    data.start_date,
                    data.end_date
                ]);

                start_date = data.start_date
                end_date = data.end_date
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const name = $("#name").val();
            const content = contentQuill.root.innerHTML;
            const event_category_id = $("#event_category_id").val();

            if(name && content && event_category_id && start_date
                && end_date
            ) {
                var id = $('#id').val();

                var url = "{{ route('event.update', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                formData.append("name", name);
                formData.append("content", content);
                formData.append("event_category_id", event_category_id);
                formData.append("start_date", start_date)
                formData.append("end_date", end_date)


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

            var url = "{{ route('event.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Event',
                text: "Apakah anda yakin ingin menghapus data Event ini???",
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

@extends("backoffice.backoffice_components.body")

@section("page-title")
Surat Menyurat
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
                <h2 class="card-title mb-5">Data Surat Menyurat</h2>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <button type="button" class="btn btn-primary" id="tambahButton">
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

                @include("backoffice.correspondence.table")
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        @include("backoffice.correspondence.correspondence_category.index")
    </div>
</div>

@include("backoffice.correspondence.form")

{{-- @include("backoffice.correspondence.content_detail") --}}
@endsection

@section("script")
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function formatDate(date) {
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        // Finance Date
        let letter_date = null;

        $("#letter_date").flatpickr({
            defaultDate: "today",
            altInput: true,
            altFormat: "j F, Y",
            dateFormat: "Y-m-d",

            onChange: function(selectedDates, dateStr, instance) {
                letter_date = dateStr;
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
                    ['code-block'],
                    [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }]
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' // or 'bubble'
        });

        // Signature Pad Logic
        const canvas = document.getElementById('signature-pad');

        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Sesuaikan ukuran canvas
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            const rect = canvas.getBoundingClientRect();

            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;

            const context = canvas.getContext('2d');

            context.setTransform(ratio, 0, 0, ratio, 0, 0);

            signaturePad.clear();
        }

        $(window).on('resize', function () {
            resizeCanvas();
        });

        // Hapus signature
        $('#clear-signature').on('click', function () {
            signaturePad.clear();
        });

        $('#actionModal').on('shown.bs.modal', function () {
            resizeCanvas();
        });
        // End Signature Pad Logic

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

        // Logic Tambah Berkas

        // ENd logic Tambah Berkas.

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
        $('#tambahButton').click(function () {
            $('#saveBtn').show();
            $('#editBtn').hide();
            $('#id').val('');
            $('#modalForm').trigger('reset');
            $('#modalTitle').html('Tambah Data Surat Menyurat');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();

            const subject = $("#subject").val();
            const content = contentQuill.root.innerHTML;
            const correspondence_category_id = $("#correspondence_category_id").val();
            const signature = signaturePad.toDataURL('image/png');
            const recepient = $("#recepient").val();

            // Belum Attachement

            if(subject && content && correspondence_category_id && signature && recepient
                && letter_date
            ) {
                blockUI.block();
                const formData = new FormData();

                formData.append("subject", subject);
                formData.append("content", content);
                formData.append("correspondence_category_id", correspondence_category_id);
                formData.append("letter_date", letter_date)
                formData.append("signature", signature)
                formData.append("recepient", recepient)

                $.ajax({
                    data: formData,
                    url: "{{ route('correspondence.create') }}",
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
            $.get("backoffice/correspondence/edit" + "/" + id, function(data) {
                $('#modalTitle').html('Edit Data Surat Menyurat');
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#actionModal').modal('show');
                $('#id').val(data.id);
                $("#subject").val(data.subject);
                $("#content").val(data.content);
                $("#correspondence_category_id").val(data.correspondence_category_id);
                $("#recepient").val(data.recepient)
                contentQuill.root.innerHTML = data.content;

                $("#letter_date")[0]._flatpickr.setDate(data.letter_date);

                letter_date = data.letter_date;
            })
        });

        $('#editBtn').click(function (e) {
            e.preventDefault();

            const subject = $("#subject").val();
            const content = contentQuill.root.innerHTML;
            const correspondence_category_id = $("#correspondence_category_id").val();
            const signature = signaturePad.toDataURL('image/png');
            const recepient = $("#recepient").val();

            // Belum Attachement

            if(subject && content && correspondence_category_id && recepient
                && letter_date
            ) {
                blockUI.block();
                const formData = new FormData();

                formData.append("subject", subject);
                formData.append("content", content);
                formData.append("correspondence_category_id", correspondence_category_id);
                formData.append("letter_date", letter_date)
                if(signature) {
                    formData.append("signature", signature)
                }

                formData.append("recepient", recepient)
                var id = $('#id').val();

                var url = "{{ route('correspondence.update', ":id") }}";
                url = url.replace(':id', id);

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

            var url = "{{ route('correspondence.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Surat Menyurat',
                text: "Apakah anda yakin ingin menghapus data Surat Menyurat ini???",
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

        // Detail Content
        $("body").on("click", ".detail-content", function() {
            // var id = $(this).data("id")

            // $.get("backoffice/event/edit" + "/" + id, function(data) {
            //     $('#detailContentModalTitle').html(`Detail Event ${data.name}`);
            //     $("#detailContentBody").html(data.content)
            //     $('#detailContentModal').modal('show');
            // })
        });

        // Gallery Logic
        let selectedEventId = 0;

        $("body").on("click", ".gallery-button", function() {
            var id = $(this).data('id');
            var url = "{{ route('event.edit', ":id") }}";
            url = url.replace(':id', id);

            selectedEventId = Number(id)

            $.get(url, function(data) {
                console.log(data)
                $('#imageFormModalTitle').html(`Gallery Event ${data.name}`);

                if(data.event_galleries.length == 0) {
                    $("#imageFormAlert").html(
                        `<div class="alert alert-danger d-flex align-items-center p-5">
                            <i class="las la-exclamation-triangle fs-2hx text-danger me-4">

                            </i>
                            <div class="d-flex flex-column">
                                <!--begin::Title-->
                                <h4 class="mt-3 text-dark">Belum Ada Gallery untuk Event ini.</h4>
                            </div>
                            <!--end::Wrapper-->
                        </div>`
                    )
                } else {
                    let tbodyHtml = "";

                    $.each(data.event_galleries, function(index, d) {
                        tbodyHtml += `
                            <tr>
                                <td>
                                   <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                   href="{{ url('/storage/event_galleries') }}/${d.photo}">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center
                                        bgi-size-cover card-rounded min-h-100px"
                                            style="background-image:url('{{ url('/storage/event_galleries') }}/${d.photo}')">
                                        </div>
                                        <!--end::Image-->

                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                                        </div>
                                        <!--end::Action-->
                                    </a>
                                </td>
                                <td>
                                    ${d.member.full_name}
                                </td>
                                <td>
                                    ${formatDate(d.created_at)}
                                </td>
                                <td>
                                    <button type="button"
                                    class="btn btn-danger btn-sm delete-image-button"
                                    data-id="${d.id}">
                                        <i class="las la-trash fs-2 me-1"></i>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        `
                    });

                    $("#imageFormTbody").html(tbodyHtml)

                    refreshFsLightbox();
                }


                $('#imageFormModal').modal('show');
            })
        });

        // Select Image Logic

        $("#addImageButton").on("click", function() {
            $("#select-image-input").trigger("click");
        });

        let selectedFileList = []

        $("#select-image-input").on("change", function() {
            const files = [...this.files];
            selectedFileList = files

            let selectedFileHtml = ""

            $.each(this.files, function(index, file) {
                const url = URL.createObjectURL(file)

                selectedFileHtml += `
                    <div class="col-12 col-lg-4" id="selected-image-${index}">
                        <div class="symbol w-100">
                            <img src="${url}" class="w-100 h-auto" alt=""/>
                            <span class="symbol-badge cursor-pointer
                            badge badge-circle bg-danger start-100 remove-image-button"
                            data-index="${index}"
                            >X</span>
                        </div>
                    </div>
                `
            });

            $("#selectedImageBody").html(
                `<div class="row g-10 mb-5">
                    ${selectedFileHtml}
                </div>
                <button type="button" class="btn btn-primary w-100 upload-image-button">
                    <i class="las la-upload fs-2 me-1"></i>
                    Upload
                </button>
                `
            )
        });

        // Remove Image Logic
        $("body").on("click", ".remove-image-button", function() {
            const index = $(this).data("index");

            $(`#selected-image-${index}`).remove()
            selectedFileList.splice(Number(index), 1);

            if(selectedFileList.length == 0) {
                $(`#uploadImageButton`).remove();
            }
        });

        // Upload Gallery Event image
        $('body').on('click', '.upload-image-button', function (e) {
            const formData = new FormData();

            formData.append("event_id", selectedEventId);

            selectedFileList.forEach((file) => {
                formData.append("image_files[]", file);
            })

            $.ajax({
                data: formData,
                url: "{{ route('event.upload-galleries') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if(data.success == true) {
                        location.reload();
                    } else {
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
                }
            })

        });

        $("body").on("click", ".delete-image-button", function() {
            var id = $(this).data('id');

            var url = "{{ route('event.delete-gallery', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Event Gallery',
                text: "Apakah anda yakin ingin menghapus data Event Gallery ini???",
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
        })
    });
</script>
@endsection

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

        async function dataUrlToFile(dataUrl, fileName) {
            const response = await fetch(dataUrl);
            const blob = await response.blob();

            return new File(
                [blob],
                fileName,
                {
                    type: blob.type
                }
            );
        }
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
        let lampiranList = [];

        // Logic Ketika Button di Tambah di Klik
        $("#addLampiranButton").on("click", function() {
            if(lampiranList.length == 0) {
                $("#belum-pilih-lampiran-message").addClass("d-none")
                $("#lampiran-container").removeClass("d-none");
            }


            let index = lampiranList.length;

            $("#lampiran-container").append(
                `
                <div class="d-flex flex-column w-100 attachment-item" data-index="${index}">
                    <div class="fs-2 fw-semibold">
                        Lampiran Ke-${index + 1}
                    </div>
                    <div class="form-group">
                        <label for="attachment_name_${index}"
                        class="control-label col-form-label">Nama Berkas</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tag fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control attachment-name" id="attachment_name_${index}"
                            name="attachment_name_${index}"
                            aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="attachment_file_${index}" class="control-label col-form-label">
                            File Berkas
                        </label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-file fs-2"></i>
                            </span>
                            <input type="file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            class="form-control attachment-file" id="attachment_file_${index}"
                            name="attachment_file_${index}"
                            aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <button type="button" class="w-100 btn btn-small btn-danger delete-attachment"
                        id="delete-attachment-${index}"
                        data-index="${index}">
                        Hapus
                    </button>

                    <hr class="my-3" />
                </div>
                `
            );

            let initialData = {
                name: null,
                file: null,
            }

            lampiranList.push(initialData);
        });

        $(document).on("change", ".attachment-name, .attachment-file", function () {

            let index = $(this).closest(".attachment-item").data("index");

            if ($(this).hasClass("attachment-name")) {
                lampiranList[index].name = $(this).val();
            }

            if ($(this).hasClass("attachment-file")) {
                lampiranList[index].file = this.files[0] ?? null;
            }
        });

        $(document).on("click", ".delete-attachment", function() {
            let index = $(this).data("index");

            lampiranList.splice(index, 1)

            // Hapus element dari DOM
            $(this).closest(".attachment-item").remove();

            // Re-index
            $("#lampiran-container .attachment-item").each(function (newIndex) {

                $(this).attr("data-index", newIndex);
                $(this).data("index", newIndex);

                $(this).find(".attachment-name")
                    .attr("id", `attachment_name_${newIndex}`)
                    .attr("name", `attachment_name_${newIndex}`);

                $(this).find(".attachment-file")
                    .attr("id", `attachment_file_${newIndex}`)
                    .attr("name", `attachment_file_${newIndex}`);

                $(this).find(".delete-attachment")
                    .attr("data-index", newIndex)
                    .data("index", newIndex);

                $(this).find(".fs-2.fw-semibold")
                    .text(`Lampiran Ke-${newIndex + 1}`);
            });

            // Kalau sudah tidak ada lampiran
            if (lampiranList.length === 0) {
                $("#belum-pilih-lampiran-message").removeClass("d-none");
            }
        })
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
        $('#createButton').click(function () {
            $('#saveBtn').show();
            $('#editBtn').hide();

            $("#lampiranButtonLabel").text("Tambahkan Lampiran");
            $("#currentLampiranContainer").addClass("d-none");
            $("#currentLampiranContainer").html("");

            if(lampiranList.length > 0) {
                lampiranList = [];
                $("#belum-pilih-lampiran-message").removeClass("d-none");
                $("#lampiran-container").addClass("d-none");
                $("#lampiran-container").html("")
            }

            $('#id').val('');
            $('#modalForm').trigger('reset');
            $('#modalTitle').html('Tambah Data Surat Menyurat');
            $('#actionModal').modal('show');
        });

        $('#saveBtn').click(async function (e) {
            e.preventDefault();

            const subject = $("#subject").val();
            const content = contentQuill.root.innerHTML;
            const correspondence_category_id = $("#correspondence_category_id").val();

            const isSignaturePadEmpty = signaturePad.isEmpty();
            const signatureString = signaturePad.toDataURL('image/png');
            const signature = await dataUrlToFile(
                signatureString,
                "signature.png"
            );

            const recepient = $("#recepient").val();

            const isValidLampiran = lampiranList.every(item =>
                item.name !== null &&
                item.file !== null
            );

            // Belum Attachement

            if(subject && content && correspondence_category_id && !isSignaturePadEmpty && recepient
                && letter_date && isValidLampiran
            ) {
                blockUI.block();
                const formData = new FormData();

                formData.append("subject", subject);
                formData.append("content", content);
                formData.append("correspondence_category_id", correspondence_category_id);
                formData.append("letter_date", letter_date)
                formData.append("signature", signature)
                formData.append("recepient", recepient)

                if(lampiranList.length > 0) {
                    lampiranList.forEach((item, index) => {
                        formData.append(
                            `attachments[${index}][name]`,
                            item.name
                        );

                        formData.append(
                            `attachments[${index}][file]`,
                            item.file
                        );
                    });
                }

                $.ajax({
                    data: formData,
                    url: "{{ route('correspondence.create') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if(data.success == true) {
                            if(lampiranList.length > 0) {
                                $("#belum-pilih-lampiran-message").removeClass("d-none");
                            }

                            $("#lampiran-container").html("");
                            lampiranList = []
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

                const recepientElement = $("#recepient");

                // Pastikan selectpicker sudah aktif
                recepientElement.selectpicker();

                // Set value
                recepientElement.selectpicker("val", String(data.recepient));


                contentQuill.root.innerHTML = data.content;

                $("#letter_date")[0]._flatpickr.setDate(data.letter_date);

                letter_date = data.letter_date;

                // Logic Update Surat
                if(lampiranList.length > 0) {
                    lampiranList = [];
                    $("#belum-pilih-lampiran-message").removeClass("d-none");
                    $("#lampiran-container").addClass("d-none");
                    $("#lampiran-container").html("")
                }

                if(data.correspondence_attachments.length > 0) {
                    $("#lampiranButtonLabel").text("Ganti Lampiran");
                    $("#belum-pilih-lampiran-message").addClass("d-none");
                    $("#currentLampiranContainer").removeClass("d-none");

                    const urlStorage = "{{ url('/storage/attachments/') }}";

                    let attachmentListHtml = ``

                    data.correspondence_attachments.forEach(function (d, index) {
                        attachmentListHtml += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${d.name}
                            <a href="${urlStorage}/${d.file_name}" class="btn btn-light-dark btn-sm edit-download-attachment"
                            data-filename="${d.file_name}">
                                <i class="las la-download fs-2 me-1"></i>
                                Download
                            </a>
                        </li>
                        `

                    });

                    $("#currentLampiranContainer").html(
                        attachmentListHtml
                    )
                } else {
                    $("#lampiranButtonLabel").text("Tambah Lampiran");
                    $("#belum-pilih-lampiran-message").removeClass("d-none");
                    $("#currentLampiranContainer").html("");
                    $("#currentLampiranContainer").addClass("d-none");
                }
            })
        });

        $('#editBtn').click(async function (e) {
            e.preventDefault();

            const subject = $("#subject").val();
            const content = contentQuill.root.innerHTML;
            const correspondence_category_id = $("#correspondence_category_id").val();

            const isSignaturePadEmpty = signaturePad.isEmpty();
            const signatureString = signaturePad.toDataURL('image/png');

            const signature = await dataUrlToFile(
                signatureString,
                "signature.png"
            );


            const recepient = $("#recepient").val();

            const isValidLampiran = lampiranList.every(item =>
                item.name !== null &&
                item.file !== null
            );

            // Belum Attachement

            if(subject && content && correspondence_category_id && recepient
                && letter_date && isValidLampiran
            ) {
                blockUI.block();
                const formData = new FormData();

                formData.append("subject", subject);
                formData.append("content", content);
                formData.append("correspondence_category_id", correspondence_category_id);
                formData.append("letter_date", letter_date)

                if(!isSignaturePadEmpty) {
                    formData.append("signature", signature)
                }


                if(lampiranList.length > 0) {
                    lampiranList.forEach((item, index) => {
                        formData.append(
                            `attachments[${index}][name]`,
                            item.name
                        );

                        formData.append(
                            `attachments[${index}][file]`,
                            item.file
                        );
                    });
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
    });
</script>
@endsection

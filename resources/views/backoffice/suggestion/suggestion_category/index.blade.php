<div class="card">
    <div class="card-body p-lg-10" id="childCardBody">
        <h2 class="card-title mb-5">Data Kategori Saran</h2>

        <button type="button" class="btn btn-primary" id="childCreateButton">
            <i class="las la-plus-circle fs-2 me-1"></i>
            Tambah Data
        </button>

        @include("backoffice.suggestion.suggestion_category.table")
    </div>
</div>

@include("backoffice.suggestion.suggestion_category.form")

@section("script-child")
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

        var modalBody = document.querySelector("#childModalBody");

        var blockUI = new KTBlockUI(modalBody, {
            message: `<div class="blockui-message">
                <span class="spinner-border text-primary"></span> Memproses data...</div>`,
        });

        var deleteUI = new KTBlockUI(cardBody, {
            message: `<div class="blockui-message">
                <span class="spinner-border text-primary"></span> Proses menghapus data...</div>`,
        });

        // Create Logic
        $('#childCreateButton').click(function () {
            $('#childSaveBtn').show();
            $('#childEditBtn').hide();
            $('#id').val('');
            $('#childModalForm').trigger('reset');
            $('#childModalTitle').html('Tambah Data Kategori Saran');
            $('#childActionModal').modal('show');
        });

        $('#childSaveBtn').click(function (e) {
            e.preventDefault();

            const code = $("#code").val();
            const name = $("#name").val();

            if(code && name) {
                blockUI.block();
                const formData = new FormData();

                formData.append("code", code);
                formData.append("name", name);

                $.ajax({
                    data: formData,
                    url: "{{ route('suggestion-category.create') }}",
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
        $('body').on('click', '.child-edit', function() {
            var id = $(this).data('id');
            $.get("backoffice/suggestion-category/edit" + "/" + id, function(data) {
                $('#childModalTitle').html('Edit Data Kategori Saran');
                $('#childSaveBtn').hide();
                $('#childEditBtn').show();
                $('#childActionModal').modal('show');
                $('#id').val(data.id);
                $("#name").val(data.name);
                $("#code").val(data.code);
            })
        });

        $('#childEditBtn').click(function (e) {
            e.preventDefault();

            const code = $("#code").val();
            const name = $("#name").val();

            if(code && name) {
                var id = $('#id').val();

                var url = "{{ route('suggestion-category.update', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                formData.append("name", name);
                formData.append("code", code);

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
        $('body').on('click', '.child-delete', function() {
            var id = $(this).data('id');

            var url = "{{ route('suggestion-category.delete', ":id") }}";
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Delete Data Kategori Saran',
                text: "Apakah anda yakin ingin menghapus data Kategori Saran ini???",
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
    });
</script>
@endsection

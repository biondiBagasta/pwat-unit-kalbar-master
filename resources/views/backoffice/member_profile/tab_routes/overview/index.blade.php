@extends("backoffice.member_profile.main")

@section("tab")
<!--begin::Row-->
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::List widget 1-->
        <div class="card card-flush h-md-100 mb-5 mb-lg-10">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Biodata</span>
                </h3>
                <!--end::Title-->

                                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button
                    type="button"
                    class="btn btn-sm btn-light-primary"
                    id="editProfileBtn">
                        <i class="las la-user-edit fs-2 me-1"></i>
                        Edit Profil
                    </button>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->

            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Nama Lengkap</div>
                    <!--end::Section-->
                    <!--begin::Statistics-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->full_name }}</span>
                    <!--end::Statistics-->
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Nomor Whatsapp</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->phone_number }}</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Pekerjaan</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->job }}</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Nama Suami</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->husband_name }}</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Pekerjaan Suami</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->husband_occupation }}</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Provinsi</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->regency->province->name }}</span>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Kabupaten / Kota</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ Auth::user()->member->regency->name }}</span>
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Alamat</div>
                    <!--end::Section-->
                    <!--begin::Statistics-->
                    <div class="d-flex flex-row gap-5">
                        <div style="width: 48px"></div>
                        <span class="text-gray-900 fw-bolder fs-6 text-end">{{ Auth::user()->member->address }}</span>
                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->

                <!--end::Item-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::LIst widget 1-->
    </div>
    <!--end::Col-->

    <!--begin::Col-->
    <div class="col-xl-6">
        <!--begin::List widget 1-->
        <div class="card card-flush h-md-100 mb-5 mb-lg-10">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Activity</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Total Post</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ $post_count }}</span>
                    <!--end::Statistics-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Total Saran</div>
                    <!--end::Section-->
                    <span class="text-gray-900 fw-bolder fs-6">{{ $suggestion_count }}</span>
                    <!--end::Statistics-->
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::LIst widget 1-->
    </div>
    <!--end::Col-->
</div>

@include("backoffice.member_profile.tab_routes.overview.form")
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

            const memberId = @json($member_id);

            if(username) {
                const formData = new FormData();

                formData.append("username", username);
                formData.append("id", memberId);

                $.ajax({
                    data: formData,
                    url: "{{ route('member.check-username-update-profile') }}",
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

        // Edit Update LOGIC
        $('#editProfileBtn').on('click', function() {
            var id = @json($member_id)

            var url = "{{ route('member.edit', ":id") }}";
            url = url.replace(':id', id);

            $.get(url, function(data) {
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

            const password = $("#password").val()

            if(full_name && address && phone_number && job && husband_name &&
                husband_occupation && regency_id && username
            ) {
                var id = @json($member_id)

                var url = "{{ route('member.update-profile', ":id") }}";
                url = url.replace(':id', id);

                const formData = new FormData();

                if(photo) {
                    formData.append("photo", photo)
                }

                if(password) {
                    formData.append("password", password);
                }

                formData.append("full_name", full_name)
                formData.append("address", address)
                formData.append("phone_number", phone_number)
                formData.append("job", job)
                formData.append("husband_name", husband_name)
                formData.append("husband_occupation", husband_occupation)
                formData.append("regency_id", regency_id)
                formData.append("username", username)


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
    }
)
</script>
@endsection


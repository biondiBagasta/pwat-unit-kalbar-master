<div class="modal fade" tabindex="-1" id="actionModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle"></h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times fs-1 text-dark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="modalBody">
                <form class="form-horizontal" id="modalForm">
                    <input type="hidden" name="id" id="id" />
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="username" class="control-label col-form-label">Username</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-id-card fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="username"
                                    name="username" aria-describedby="basic-addon3" />
                                </div>
                            </div>

                            <div class="alert alert-success p-5 my-3 d-none"
                            id="checkUsernameContainerSuccess">
                                <div class="d-flex flex-row gap-3 align-items-center">
                                    <i class="las la-check-circle fs-1 text-success">

                                    </i>
                                    <h5 class="text-success mt-2" id="checkUsernameMessageSuccess"></h5>
                                </div>
                            </div>

                            <div class="alert alert-danger p-5 mb-5 d-none"
                            id="checkUsernameContainerError">
                                <div class="d-flex flex-row gap-3 align-items-center">
                                    <i class="las la-user-times fs-1 text-danger">

                                    </i>
                                    <h5 class="text-danger mt-2" id="checkUsernameMessageError"></h5>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="full_name" class="control-label col-form-label">Nama Lengkap</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-user-circle fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="full_name"
                                    name="full_name" aria-describedby="basic-addon3" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number" class="control-label col-form-label">Nomor Whatsapp</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="lab la-whatsapp fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="phone_number"
                                    name="phone_number" aria-describedby="basic-addon3" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="job" class="control-label col-form-label">Pekerjaan</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-briefcase fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="job"
                                    name="job" aria-describedby="basic-addon3" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="husband_name" class="control-label col-form-label">Nama Suami</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-user-tie fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="husband_name"
                                    name="husband_name" aria-describedby="basic-addon3" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="husband_occupation"
                                class="control-label col-form-label">Pekerjaan Suami</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-briefcase fs-2"></i>
                                    </span>
                                    <input type="text"
                                    class="form-control" id="husband_occupation"
                                    name="husband_occupation" aria-describedby="basic-addon3" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="province_id" class="control-label col-form-label">Provinsi</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-map-marker fs-2"></i>
                                    </span>
                                    <select class="selectpicker form-control" data-live-search="true"
                                    name="province_id" id="province_id">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="regency_id" class="control-label col-form-label">Kabupaten / Kota</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-map-marker fs-2"></i>
                                    </span>
                                    <select class="selectpicker form-control" data-live-search="true"
                                    name="regency_id" id="regency_id">

                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="full_name" class="control-label col-form-label">Alamat Lengkap</label>
                                <div class="input-group mb-5">
                                    <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="member_type_id" class="control-label col-form-label">Tag</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-tags fs-2"></i>
                                    </span>
                                    <select class="form-control" name="member_type_id" id="member_type_id">
                                        <option value="">Pilih Tag</option>
                                        @foreach ($member_types_data as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="member_role_id" class="control-label col-form-label">Jabatan</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-user-tag fs-2"></i>
                                    </span>
                                    <select class="form-control" name="member_role_id" id="member_role_id">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($member_roles_data as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="photo" class="control-label col-form-label"
                                >Foto</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text" id="basic-addon3">
                                        <i class="las la-image fs-2"></i>
                                    </span>
                                    <input type="file"
                                    class="form-control" id="photo"
                                    name="photo" aria-describedby="basic-addon3" />
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="las la-times-circle fs-2"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="saveBtn">
                    <i class="las la-save fs-2"></i> Simpan
                </button>
                <button type="button" class="btn btn-primary" id="editBtn">
                    <i class="las la-save fs-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

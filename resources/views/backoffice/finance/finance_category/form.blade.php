<div class="modal fade" tabindex="-1" id="childActionModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="childModalTitle"></h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times fs-1 text-dark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="childModalBody">
                <form class="form-horizontal" id="childModalForm">
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label for="code" class="control-label col-form-label">Kode</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-code fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="code_2"
                            name="code_2" aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-form-label">Name</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-bookmark fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="name_2"
                            name="name_2" aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="type" class="control-label col-form-label">Tipe</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tags fs-2"></i>
                            </span>
                            <select class="form-control" name="type_2" id="type_2">
                                <option value="">Pilih Tipe</option>
                                <option value="0">Pengeluaran</option>
                                <option value="1">Pemasukan</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="las la-times-circle fs-2"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="childSaveBtn">
                    <i class="las la-save fs-2"></i> Simpan
                </button>
                <button type="button" class="btn btn-primary" id="childEditBtn">
                    <i class="las la-save fs-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

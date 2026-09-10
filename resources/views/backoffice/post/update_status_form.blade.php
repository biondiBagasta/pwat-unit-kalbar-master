<div class="modal fade" tabindex="-1" id="updateStatusActionModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="updateStatusModalTitle"></h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times fs-1 text-dark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" id="updateStatusModalBody">
                <form class="form-horizontal" id="updateStatusModalForm">
                    <input type="hidden" name="id" id="id" />
                    <div class="form-group">
                        <label for="post_status_id" class="control-label col-form-label">Publish Status</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tag fs-2"></i>
                            </span>
                            <select class="form-control" name="post_status_id" id="post_status_id">
                                <option value="">Pilih Publish Status</option>
                                @foreach ($post_statuses_data as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="las la-times-circle fs-2"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="updateStatusEditBtn">
                    <i class="las la-save fs-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

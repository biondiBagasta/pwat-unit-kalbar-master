<div class="modal fade" tabindex="-1" id="actionModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
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
                    <div class="form-group">
                        <label for="title" class="control-label col-form-label">Judul</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tag fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="title"
                            name="title" aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="control-label col-form-label">Konten</label>
                        <div id="content" class="form-control"></div>
                        <input type="hidden"
                        name="content" aria-describedby="basic-addon3" />
                    </div>

                    <div class="form-group">
                        <label for="suggestion_category_id" class="control-label col-form-label">Suggestion Category</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tags fs-2"></i>
                            </span>
                            <select class="form-control" name="suggestion_category_id"
                            id="suggestion_category_id">
                                <option value="">Pilih Suggestion Category</option>
                                @foreach ($suggestion_categories_data as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cover_image" class="control-label col-form-label"
                        >Cover Image (Boleh tidak Digunakan)</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-image fs-2"></i>
                            </span>
                            <input type="file"
                            class="form-control" id="cover_image"
                            name="cover_image" aria-describedby="basic-addon3" />
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

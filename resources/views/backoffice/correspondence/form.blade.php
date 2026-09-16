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
                        <label for="correspondence_category_id"
                        class="control-label col-form-label">Kategori Surat</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tags fs-2"></i>
                            </span>
                            <select class="form-control" name="correspondence_category_id"
                            id="correspondence_category_id">
                                <option value="">Pilih Kategori Surat</option>
                                @foreach ($correspondence_categories_data as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="province_id" class="control-label col-form-label">Penerima</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-user-tie fs-2"></i>
                            </span>
                            <select class="selectpicker form-control" data-live-search="true"
                            name="recepient" id="recepient">
                                <option value="">Pilih Penerima Surat</option>
                                @foreach ($members_data as $d)
                                    <option value="{{ $d->id }}">{{ $d->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="letter_date"
                        class="control-label col-form-label">Tanggal Surat</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-calendar-alt fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="letter_date"
                            aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label col-form-label">Subject</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tag fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="name"
                            name="name" aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="control-label col-form-label">Konten</label>
                        <div id="content" class="form-control"></div>
                        <input type="hidden"
                        name="content" aria-describedby="basic-addon3" />
                    </div>

                    <div class="form-group">
                        <label for="title" class="control-label col-form-label">Signature</label>
                        <div style="border: 1px solid #ddd; border-radius: 8px;">
                            <canvas
                                id="signature-pad"
                                style="
                                    width: 100%;
                                    height: 240px;
                                    display: block;
                                    touch-action: none;
                                ">
                            </canvas>
                        </div>

                        <button type="button"
                        id="clear-signature" class="w-100 btn btn-sm btn-light-danger my-4">
                            Clear Signature
                        </button>
                    </div>

                    <div class="d-flex flex-column gap-4">
                       <button type="button" class="btn btn-secondary" id="addLampiranButton">
                            <i class="las la-paperclip fs-2 me-1"></i>
                            Tambahkan Lampiran
                        </button>

                        <div id="belum-pilih-lampiran-message">
                            <div class="alert alert-info p-5 my-3">
                                <div class="d-flex flex-row gap-3 align-items-center">
                                    <i class="las la-info-circle fs-1 text-success">

                                    </i>
                                    <h5 class="mt-2">
                                        Anda tidak menggunakan lampiran.
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-4 w-100" id="lampiran-container">
                            <div class="d-flex flex-column w-100">
                                <div class="fs-2 fw-semibold">
                                    Lampiran Ke-1
                                </div>
                                <div class="form-group">
                                    <label for="attachment_name"
                                    class="control-label col-form-label">Nama Berkas</label>
                                    <div class="input-group mb-5">
                                        <span class="input-group-text" id="basic-addon3">
                                            <i class="las la-tag fs-2"></i>
                                        </span>
                                        <input type="text"
                                        class="form-control" id="attachment_name_1"
                                        name="attachment_name_1" aria-describedby="basic-addon3" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="control-label col-form-label">
                                        File Berkas
                                    </label>
                                    <div class="input-group mb-5">
                                        <span class="input-group-text" id="basic-addon3">
                                            <i class="las la-file fs-2"></i>
                                        </span>
                                        <input type="file"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                                        class="form-control" id="attachment_file_1"
                                        name="attachment_file_1"
                                        aria-describedby="basic-addon3" />
                                    </div>
                                </div>

                                <button type="button" class="w-100 btn btn-small btn-danger"
                                    id="delete-attachment-1">
                                    Hapus
                                </button>

                                <hr class="my-3" />
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

<div class="modal fade" tabindex="-1" id="imageFormModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="imageFormModalTitle"></h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times fs-1 text-dark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <button type="button" class="btn btn-dark mb-4" id="addImageButton">
                    <i class="las la-plus fs-2 me-1"></i>
                    Tambah Gambar
                </button>
                <input id="select-image-input" type="file" accept="image/*" multiple class="hidden" />
                <div id="selectedImageBody" class="my-5"></div>

                <div class="table-responsive mb-5">
                    <table id="dataTable" class="table table-bordered table-striped table-rounded">
                        <thead>
                            <tr class="fw-bold fs-6 text-muted">
                                <th>Gambar</th>
                                <th>Uploaded By</th>
                                <th>Tanggal Upload</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="imageFormTbody"></tbody>
                    </table>
                </div>

                <div id="imageFormAlert"></div>
            </div>
        </div>
    </div>
</div>

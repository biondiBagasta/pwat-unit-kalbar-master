<div class="modal fade" tabindex="-1" id="detailContentModal"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="detailContentModalTitle"></h2>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times fs-1 text-dark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="w-full d-flex flex-row justify-content-center mb-10">
                    <img
                        id="detailCoverImage"
                        class="w-full"
                        style="
                            border-radius: 12px;
                            max-width: 100%;
                            max-height: 300px;
                            object-fit: cover;
                            display: block;
                        "
                    />
                </div>
                <div id="detailContentBody"></div>
            </div>
        </div>
    </div>
</div>

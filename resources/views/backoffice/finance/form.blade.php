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
                        <label for="amount" class="control-label col-form-label">Amount</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-money-bill fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="amount"
                            name="amount" aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="finance_category_id" class="control-label col-form-label">Kategori</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-tags fs-2"></i>
                            </span>
                            <select class="form-control" name="finance_category_id"
                            id="finance_category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($finance_categories_data as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}
                                        @if($s->type == 1)
                                        (Pemasukan)
                                        @else
                                        (Pengeluaran)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="finance_date"
                        class="control-label col-form-label">Tanggal</label>
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon3">
                                <i class="las la-calendar-alt fs-2"></i>
                            </span>
                            <input type="text"
                            class="form-control" id="finance_date"
                            aria-describedby="basic-addon3" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="control-label col-form-label">Catatan</label>
                        <div class="input-group mb-5">
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
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

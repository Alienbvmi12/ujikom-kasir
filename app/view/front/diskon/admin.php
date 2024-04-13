<div class="card text-start w-100">
    <div class="card-header">

    </div>
    <div class="card-body">
        <h4 class="card-title">Kelola Diskon</h4>
        <small class="text-secondary">Ketika transaksi, diskon akan dipilih otomatis oleh sistem berdasarkan tanggal kadaluarsanya. Voucher yang akan kadaluarsa lebih awal yang akan digunakan</small><br>
        <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">Buat Baru</button>
        <div class="table-responsive">
            <table id="datatable" class="table table-striped table-hover table-borderless table-primary align-middle">

            </table>
        </div>

    </div>
    <div class="card-footer"></div>
</div>

<div class="modal fade modal-lg" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Data</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Diskon (%)</label>
                                    <input type="number" class="form-control" name="diskon" id="diskon" min="0" max="100" onchange="if(this.value > 100) this.value = 100; if(this.value < 0) this.value = 0;"/>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" style="height:100px"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3" id="minimum-transaksi-container">
                                    <label for="" class="form-label">Minimum Transaksi</label>
                                    <input class="form-control" type="number" name="minimum_transaksi" id="minimum_transaksi">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Kadaluarsa</label>
                                    <input class="form-control" type="date" name="expired_date" id="expired_date">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="submit" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card">
        <div class="card-header text-muted"></div>
        <div class="card-body">
            <h3>Laporan Penjualan</h3>
            <div class="table-responsive mt-4">
                <!-- Button trigger modal -->
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-5">
                        <div class="mb-3">
                            <label for="" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" id="date-from" />
                        </div>

                    </div>
                    <div class="col-5">
                        <div class="mb-3">
                            <label for="" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="date-until" />
                        </div>
                    </div>
                    <div class="col-2 d-flex">
                        <div class="d-grid gap-2">
                            <button type="button" name="load" id="load" onclick="loadTb()" class="btn btn-primary">
                                Load
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" class="mb-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">
                    Print Laporan Transaksi
                </button>
                <button type="button" class="mb-4 btn btn-info" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">
                    Print Laporan Omset
                </button>
                <table id="datatable" class="table table-striped table-hover table-borderless table-primary align-middle">
                </table>
                <table id="datatable2" class="mt-3 table table-striped table-hover table-borderless table-primary align-middle">
                </table>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>
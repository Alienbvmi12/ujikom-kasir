<div class="container">
    <div class="card" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
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
                <table id="datatable" class="table table-striped table-hover table-borderless table-primary align-middle">
                </table>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>
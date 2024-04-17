<div class="container">
    <div class="card" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
        <div class="card-header text-muted"></div>
        <div class="card-body">
            <h3>Kelola Produk</h3>
            <div class="table-responsive mt-4">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">
                    Buat Baru
                </button>
                <a href="<?=base_url()?>laporan/stok/" type="button" class="btn btn-info">
                    Laporan Stok
                </a>
                <table id="datatable" class="table table-striped table-hover table-borderless table-primary align-middle">
                </table>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    Form Data
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="form">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga(Rp)</label>
                                    <input type="number" class="form-control" name="harga" id="harga" placeholder="Gunakan titik (.) sebagai koma" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" id="stok" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="submit" type="button" class="btn btn-primary" onclick="create()" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
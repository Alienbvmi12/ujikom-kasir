<div class="card text-start w-100">
    <div class="card-header">
    </div>
    <div class="card-body">
        <h4 class="card-title">Kelola member</h4>
        <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">Daftarkan Member</button>
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
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nik</label>
                                    <input type="text" class="form-control" name="nik" id="nik" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" name="nomor_telepon" id="nomor_telepon" placeholder="Format: 08xxxxx" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-3">
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
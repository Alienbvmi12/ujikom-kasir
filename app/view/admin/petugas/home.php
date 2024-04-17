<div class="container">
    <div class="card" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
        <div class="card-header text-muted"></div>
        <div class="card-body">
            <h3>Kelola Petugas</h3>
            <div class="table-responsive mt-4">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('create')">
                    Buat Baru
                </button>
                <table id="datatable" class="table table-striped table-hover table-borderless table-primary align-middle">
                </table>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="modal">
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
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-control" style="width: 100%" name="status" id="status">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" />
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
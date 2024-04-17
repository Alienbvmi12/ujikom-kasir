<div class="card text-start w-100">
    <div class="card-header" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
    </div>
    <div class="card-body">
        <h2 class="card-title">Profile</h2>
        <div class="row">
            <div class="col-sm-8 p-3">
                <div class="card w-100">
                    <div class="card-body">
                        <form id="form">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $sess->user->nama; ?>" readonly  />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= $sess->user->username; ?>" readonly  />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $sess->user->email; ?>" readonly  />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 p-3">
                <div class="card w-100">
                    <div class="card-body">
                        <h4>Ubah Password</h4>
                        <form id="form2">
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Isi kolom untuk mengubah password..." />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Isi kolom untuk mengubah password..." />
                            </div>
                        </form>
                        <button type="button" id="edit2" onclick="submit2(true)" class="btn btn-warning">
                            Edit Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer"></div>
</div>
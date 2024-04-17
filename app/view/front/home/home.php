<div class="card text-start" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
    <div class="card-header">
        Dashboard
    </div>
    <div class="card-body">
        <h3>Selamat Datang <?= ($sess->user->role ?? '') == 0 ? "Admin" : "Petugas" ?></h3>
        <div class="row mt-5">
            <div class="col-sm-3">
                <div class="card text-white bg-primary text-start">
                    <div class="card-body">
                        <h4 class="card-title">Produk</h4>
                        <p class="card-text"><?= $produk ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-success text-start">
                    <div class="card-body">
                        <h4 class="card-title">Member</h4>
                        <p class="card-text"><?= $member ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-info text-start">
                    <div class="card-body">
                        <h4 class="card-title">Terjual</h4>
                        <p class="card-text"><?= $terjual ?></p>
                    </div>
                </div>
            </div>
            <?php if ($this->is_admin()) { ?>
                <div class="col-sm-3">
                    <div class="card text-white bg-warning text-start">
                        <div class="card-body">
                            <h4 class="card-title">Diskon</h4>
                            <p class="card-text"><?= $diskon ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
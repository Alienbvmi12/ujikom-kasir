<div class="card text-start" style="width : 100%">
    <div class="card-header">
        Dashboard
    </div>
    <div class="card-body">
        <h3>Selamat Datang <?= ($sess->user->role ?? '') == 0 ? "Admin" : "Petugas"?></h3>
        <div class="row mt-5">
            <div class="col-sm-3">
                <div class="card text-white bg-primary text-start">
                    <div class="card-body">
                        <h4 class="card-title">Produk</h4>
                        <p class="card-text">12</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-primary text-start">
                    <div class="card-body">
                        <h4 class="card-title">Pelanggan</h4>
                        <p class="card-text">12</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-primary text-start">
                    <div class="card-body">
                        <h4 class="card-title">Terjual</h4>
                        <p class="card-text">12</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-white bg-primary text-start">
                    <div class="card-body">
                        <h4 class="card-title">Diskon</h4>
                        <p class="card-text">12</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
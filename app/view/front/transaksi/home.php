<div class="container">
    <div class="card" style="width : 100%; background: rgba(255, 255, 255, 0.9);">
        <div class="card-header text-muted"></div>
        <div class="card-body">
            <h3>Transaksi</h3>
            <div class="row">
                <div class="col-sm-8">
                    <div id="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Produk</label>
                                    <select class="form-select" name="produk_id" id="produk_id" onchange="showHarga(this)">
                                        <option selected disabled>--Pilih Produk--</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga Satuan</label>
                                    <input type="text" disabled class="form-control" name="harga_satuan" id="harga_satuan" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kuantitas</label>
                                    <input type="number" class="form-control" name="qty" id="qty" oninput="countSubtotalRow(this)" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Subtotal</label>
                                    <input type="text" disabled class="form-control" name="subtotal" id="subtotal" />
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" name="tambah_keranjang" id="tambah_keranjang" onclick="addToCart();" class="btn btn-primary">
                                        Tambahkan ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Kasir</label>
                                <input type="text" class="form-control" value="<?= $sess->user->id . ' - ' . $sess->user->nama ?>" name="kasir" id="kasir" disabled readonly />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Member (Opsional)</label>
                                <select class="form-select" name="member_id" id="member_id" onchange="setMember(this)">
                                    <option selected disabled>--Pilih Member--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive mt-4">
                        <table id="keranjang" class="table table-striped table-hover table-borderless table-primary align-middle w-100">
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card w-100 mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Total</label>
                                        <input type="text" disabled readonly class="form-control" name="subtotal_trans" id="subtotal_trans" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Diskon</label>
                                        <input type="text" disabled readonly class="form-control" name="diskon" id="diskon" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Bayar</label>
                                        <input type="number" class="form-control" name="bayar" id="bayar" oninput="countKembalian()" />
                                    </div>
                                </div>
                                <div class="col-sm-6 px-2 pb-3">
                                    <div class="card h-100">
                                        <div class="card-body" style="text-align: left">
                                            <b style="font-size: 25px">Grand Total</b><br>
                                            <b style="font-size: 50px" id="total-view">0</b><br>
                                            <input type="hidden" disabled readonly class="form-control" name="total" id="total" />
                                            <b style="font-size: 20px">Kembalian</b><br>
                                            <b style="font-size: 20px" id="kembalian-view">0</b><br>
                                            <input type="hidden" disabled readonly class="form-control" name="kembalian" id="kembalian" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Subtotal</label>
                                        <input type="text" disabled readonly class="form-control" name="subtotal_trans" id="subtotal_trans" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Diskon</label>
                                        <input type="text" disabled readonly class="form-control" name="diskon" id="diskon" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Total</label>
                                        <input type="text" disabled readonly class="form-control" name="total" id="total" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Bayar</label>
                                        <input type="number" class="form-control" name="bayar" id="bayar" oninput="countKembalian()" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kembalian</label>
                                        <input type="text" disabled readonly class="form-control" name="kembalian" id="kembalian" />
                                    </div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button id="dashboard" class="btn btn-info me-2" onclick="location.href='<?= base_url()?>petugas/diskon'">List Diskon</button>
                                    <button id="dashboard" class="btn btn-primary me-2" onclick="location.href='<?= base_url()?>petugas/member'">Member</button>
                                    <button id="transaksi-baru" class="btn btn-warning me-2" onclick="location.reload()">Transaksi Baru</button>
                                    <button id="checkout" class="btn btn-success me-2" onclick="submitTransaksi()">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>
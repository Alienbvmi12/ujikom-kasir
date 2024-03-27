<div class="container">
    <div class="card">
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
                                    <select class="form-select" name="produk_id" id="produk_id">
                                        <option selected disabled>--Pilih Produk--</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga Satuan (Rp.)</label>
                                    <input type="number" disabled readonly class="form-control" name="harga_satuan" id="harga_satuan" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kuantitas</label>
                                    <input type="number" class="form-control" name="qty" id="qty" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga Satuan (Rp.)</label>
                                    <input type="number" disabled readonly class="form-control" name="subtotal" id="subtotal" />
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" name="tambah_keranjang" id="tambah_keranjang" class="btn btn-primary">
                                        Tambahkan ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-hover table-borderless table-primary align-middle">
                            <thead class="table-light">
                                <caption>
                                    Table Name
                                </caption>
                                <tr>
                                    <th>Column 1</th>
                                    <th>Column 2</th>
                                    <th>Column 3</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr class="table-primary">
                                    <td scope="row">Item</td>
                                    <td>Item</td>
                                    <td>Item</td>
                                </tr>
                                <tr class="table-primary">
                                    <td scope="row">Item</td>
                                    <td>Item</td>
                                    <td>Item</td>
                                </tr>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
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
                                <select class="form-select" name="member_id" id="member_id">
                                    <option selected disabled>--Pilih Member--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted"></div>
    </div>
</div>
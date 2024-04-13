<style>
    @media print {
        .print-button {
            display: none;
        }
    }
</style>
<div class="border-bottom p-4">
    <h2 style="text-align: center">PT. Alien Bumi Adidaya</h2>
    <p style="text-align: center">Jl. Kekosongan Absolut, No. 99 <br> 081224018624</p>
</div>
<div class="container px-4 py-4">
    <h2 style="text-align: center">Laporan Stok Produk <?= date("Y-m-d") ?></h2>
    <button type="button" name="" id="" onclick="print()" class="btn btn-primary print-button">
        Print
    </button>
    <button type="button" name="" id="" onclick="history.back()" class="btn btn-warning print-button">
        Kembali
    </button>
    <table class="mt-4 table table-bordered table-striped">
        <thead>
            <tr class="table-dark">
                <th>Kode Barang (ID)</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($produk as $data) {
            ?>
                <tr <?= $data->stok <= 10 ? 'class="table-danger"': ''?>>
                    <td><?= $data->id ?></td>
                    <td><?= $data->nama_produk ?></td>
                    <td>Rp.<script>
                            document.write($.number(<?= floatval($data->harga) ?>, 2, ",", "."))
                        </script>
                    </td>
                    <td><?= $data->stok ?></td>
                    <td>Rp.<script>
                            document.write($.number(<?= floatval($data->harga * $data->stok) ?>, 2, ",", "."))
                        </script>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
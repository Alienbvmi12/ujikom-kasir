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
    <h2 style="text-align: center">Laporan Transaksi</h2>
    <table class="mb-3">
        <tr>
            <td>Dari Tanggal</td>
            <td> : </td>
            <td><?= $from ?></td>
        </tr>
        <tr>
            <td>Sampai Tanggal</td>
            <td> : </td>
            <td><?= $until ?></td>
        </tr>
    </table>
    <button type="button" name="" id="" onclick="print()" class="btn btn-primary print-button">
        Print
    </button>
    <button type="button" name="" id="" onclick="excel()" class="btn btn-success print-button">
        Excel
    </button>
    <button type="button" name="" id="" onclick="history.back()" class="btn btn-warning print-button">
        Kembali
    </button>
    <table class="mt-4 table table-bordered table-striped">
        <thead>
            <tr class="table-dark">
                <th>No. Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Kasir</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalOfTotal = 0;
            foreach ($transaksi as $data) {
            ?>
                <tr>
                    <td><?= $data->id ?></td>
                    <td><?= $data->tanggal_transaksi ?></td>
                    <td><?= $data->kasir ?></td>
                    <td>Rp.<script>
                            document.write($.number(<?= $data->total ?>, 2, ",", "."))
                        </script>
                    </td>
                </tr>
            <?php
                $totalOfTotal += $data->total;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: right" colspan="4">
                    Total: Rp.<script>
                        document.write($.number(<?= $totalOfTotal ?>, 2, ",", "."))
                    </script>
                </th>
            </tr>
        </tfoot>
    </table>

    <table class="mt-4 table table-bordered table-striped d-none" id="tabel">
        <thead>
            <tr>
                <th colspan="4">
                    <h2 style="text-align: center">Laporan Transaksi</h2>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    Dari tanggal : <?= $from ?>
                </th>
            </tr>
            <tr>
                <th colspan="4">
                    Dari tanggal : <?= $until ?>
                </th>
            </tr>
            <tr class="table-dark">
                <th>No. Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Kasir</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalOfTotal = 0;
            foreach ($transaksi as $data) {
            ?>
                <tr>
                    <td><?= $data->id ?></td>
                    <td><?= $data->tanggal_transaksi ?></td>
                    <td><?= $data->kasir ?></td>
                    <td><?= $data->total ?>
                    </td>
                </tr>
            <?php
                $totalOfTotal += $data->total;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: right" colspan="4">
                    <?= $totalOfTotal ?>
                    </script>
                </th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    function excel() {
        var tbl = document.getElementById("tabel");
        var xlsx = XLSX.utils.table_to_book(tbl);
        XLSX.writeFile(xlsx, "laporan-transaksi.xlsx")
    }
</script>
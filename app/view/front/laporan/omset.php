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
    <h2 style="text-align: center">Laporan Omset</h2>
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
    <button type="button" name="" id="" onclick="history.back()" class="btn btn-warning print-button">
        Kembali
    </button>
    <table class="mt-4 table table-bordered table-striped">
        <thead>
            <tr class="table-dark">
                <th>No</th>
                <th>Bulan Tahun</th>
                <th>Omset</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalOfTotal = 0;
            $index = 0;
            foreach ($omset as $data) {
            ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $data->date ?></td>
                    <td>Rp.<script>
                            document.write($.number(<?= $data->omset ?>, 2, ",", "."))
                        </script>
                    </td>
                </tr>
            <?php
                $totalOfTotal += $data->omset;
                $index++;
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
</div>
<style>
    @media print {
        .print-button {
            display: none;
        }
    }
</style>
<div class="w-100 d-flex justify-content-center align-items-center">
    <div class="py-3 row" style="width: 520px">
        <div class="col-11">
            <div class="card w-100">
                <div class="card-body">
                    <h2 style="text-align: center">PT. Alien Bumi Adidaya</h2>
                    <p style="text-align: center">Jl. Kekosongan Absolut, No. 99 <br> 081224018624</p>

                    <table class="m-3">
                        <tr>
                            <td>No. Transaksi</td>
                            <td> : </td>
                            <td><?= $transaksi_header->no_transaksi ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Transaksi</td>
                            <td> : </td>
                            <td><?= $transaksi_header->tanggal_transaksi ?></td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td> : </td>
                            <td><?= $transaksi_header->user_id ?> - <?= $transaksi_header->user_nama ?></td>
                        </tr>
                        <tr>
                            <td>Member</td>
                            <td> : </td>
                            <td><?= $transaksi_header->member_id ?? "" ?></td>
                        </tr>
                    </table>

                    <div class="border-top border-bottom p-3">
                        <?php
                        $total_qty = 0;
                        $subtotal = 0;

                        foreach ($transaksi_detail as $data) {
                        ?>
                            <div class="row">
                                <div class="col-4"><?= $data->nama_produk ?></div>
                                <div class="col-4" style="text-align:center">
                                    <script>
                                        document.write($.number(<?= floatval($data->harga_satuan) ?>, 2, ",", "."))
                                    </script> x <?= $data->qty ?>
                                </div>
                                <div class="col-4" style="text-align:right">
                                    <script>
                                        document.write($.number(<?= floatval(floatval($data->harga_satuan) * floatval($data->qty)) ?>, 2, ",", "."))
                                    </script>
                                </div>
                            </div>
                        <?php
                            $subtotal += floatval($data->harga_satuan) * floatval($data->qty);
                            $total_qty += intval($data->qty);
                        }

                        $diskon = $subtotal * (intval($transaksi_header->diskon ?? 0) / 100);
                        $total = $subtotal - $diskon;
                        $bayar = floatval($transaksi_header->cash);
                        $kembalian = $bayar - $total;
                        ?>
                    </div>

                    <div class="row p-3 border-bottom">
                        <div class="col-sm-6">
                            <table style="width:100%">
                                <tr>
                                    <td>Total Qty</td>
                                    <td style="text-align:right"><?= $total_qty ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table style="width:100%">
                                <tr>
                                    <td>Subtotal</td>
                                    <td style="text-align:right">
                                        <script>
                                            document.write($.number(<?= floatval($subtotal) ?>, 2, ",", "."))
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td style="text-align:right"><?= $transaksi_header->diskon ?? "-" ?> <?= $transaksi_header->diskon != null ? "%" : "" ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td style="text-align:right">
                                        <script>
                                            document.write($.number(<?= floatval($total) ?>, 2, ",", "."))
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bayar</td>
                                    <td style="text-align:right">
                                        <script>
                                            document.write($.number(<?= floatval($bayar) ?>, 2, ",", "."))
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kembalian</td>
                                    <td style="text-align:right">
                                        <script>
                                            document.write($.number(<?= floatval($kembalian) ?>, 2, ",", "."))
                                        </script>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="p-3 text-center">
                        <?php
                        if ($transaksi_header->diskon != null) {
                            echo "Anda mendapatkan promo diskon membership sebesar $transaksi_header->diskon%";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1">
            <div class="d-grid gap-2">
                <button type="button" name="" id="" onclick="print()" class="btn btn-primary print-button">
                    Print
                </button>
                <button type="button" name="" id="" onclick="history.back()" class="btn btn-warning print-button">
                    Kembali
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        print();
    }, 500);
</script>
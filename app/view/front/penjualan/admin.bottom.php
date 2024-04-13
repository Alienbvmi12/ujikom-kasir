<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let table2;
    let edit_id = 0;
    let request_url = base_url + "admin/penjualan/read/";
    let request_url2 = base_url + "admin/penjualan/omset/";
    $(document).ready(function() {
        table = $("#datatable").DataTable({
            serverSide: true,
            ajax: {
                url: request_url,
                dataSrc: "data"
            },
            order: [
                [0, 'desc']
            ],
            columns: [{
                    title: "No. Transaksi",
                    data: "id"
                },
                {
                    title: "Tanggal Transaksi",
                    data: "tanggal_transaksi"
                },
                {
                    title: "Total Pembayaran",
                    data: "total",
                    render: function(data, type, row) {
                        return "Rp." + $.number(data, 2, ",", ".")
                    }
                },
                {
                    title: "Kasir",
                    data: "kasir"
                },
                {
                    title: "Aksi",
                    render: function(data, type, row) {
                        return '<a href="' + base_url + 'laporan/struk/' + row.id + '" class="btn btn-info btn-sm">Struk</a>'
                    }
                }
            ]
        });

        table2 = $("#datatable2").DataTable({
            serverSide: true,
            ajax: {
                url: request_url,
                dataSrc: "data"
            },
            order: [
                [0, 'desc']
            ],
            columns: [{
                    title: "No",
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    title: "Bulan Tahun",
                    data: "date"
                },
                {
                    title: "Omset",
                    data: "omset",
                    render: function(data, type, row) {
                        return "Rp." + $.number(data, 2, ",", ".")
                    }
                }
            ]
        })
    });

    function loadTb() {
        var from = $("#date-from").val();
        var until = $("#date-until").val();
        if (from == "" || until == "") {
            toastr.warning("Lengkapi rentang tanggal terlebih dahulu!!");
        } else {
            table.ajax.url(base_url + "admin/penjualan/read/" + from + "/" + until + "/").load();
            table2.ajax.url(base_url + "admin/penjualan/omset/" + from + "/" + until + "/").load();
        }
    }

    function printLap(type) {
        var from = $("#date-from").val();
        var until = $("#date-until").val();
        if (from == "" || until == "") {
            toastr.warning("Lengkapi rentang tanggal terlebih dahulu!!");
        } else {
            location.href = base_url + "laporan/penjualan/"+type+"/" + from + "/" + until + "/"
        }
    }
</script>
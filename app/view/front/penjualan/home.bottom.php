<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let table2;
    let edit_id = 0;
    let request_url = base_url + "penjualan/read/";
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
                    data: "kasir",
                    render: function(data, type, row) {
                        console.log(data);
                        if(data != null){
                            return data;
                        }
                        else{
                            return row.kasir2
                        }
                    }
                },
                {
                    title: "Aksi",
                    render: function(data, type, row) {
                        return '<a href="' + base_url + 'laporan/struk/' + row.id + '" class="btn btn-info btn-sm">Struk</a>'
                    }
                }
            ]
        });
    });

    function loadTb() {
        var from = $("#date-from").val();
        var until = $("#date-until").val();
        if (from == "" || until == "") {
            toastr.warning("Lengkapi rentang tanggal terlebih dahulu!!");
        } else {
            table.ajax.url(base_url + "penjualan/read/" + from + "/" + until + "/").load();
        }
    }
</script>
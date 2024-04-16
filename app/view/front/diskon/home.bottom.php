<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "petugas/diskon/read/";
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
                    title: "ID",
                    data: "id"
                },
                {
                    title: "Diskon",
                    data: "diskon",
                    render: function(data, type, row) {
                        return data + "%";
                    }
                },
                {
                    title: "Deskripsi",
                    data: "deskripsi"
                },
                {
                    title: "Minimum Transaksi",
                    data: "minimum_transaksi",
                    render: function(data, type, row) {
                        if (data == null) {
                            return "-"
                        } else {
                            return "Rp." + $.number(data, 2, ",", ".");
                        }
                    }
                },
                {
                    title: "Tanggal Kadaluarsa",
                    data: "expired_date",
                    render: function(data, type, row) {
                        $exp = new Date(data + " 00:00:00");
                        $cnt = new Date();

                        console.log($cnt);
                        if ($exp < $cnt) {
                            return "<div class='text-danger'>" + data + "</div>"
                        } else {
                            return "<div>" + data + "</div>"
                        }
                    }
                }
            ]
        });
    });
</script>
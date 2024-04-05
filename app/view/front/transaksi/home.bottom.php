<script>
    const keranjang = [{
            produk: "Ikan Nemo",
            qty: 3,
            harga: 30000,
            diskon: 10
        },
        {
            produk: "Ikan Singa",
            qty: 2,
            harga: 14000,
            diskon: 0
        }
    ];
    const base_url = "<?=base_url()?>";
    let datable;
    $(document).ready(function() {

        //Components Init

        $("#produk_id").select2({
            theme: "bootstrap-5",
            ajax: {
                url: base_url + "transaksi/__api_produk/",
                processResults: function (data){
                    return {
                        results: data.data
                    }
                }
            }
        });
        $("#member_id").select2({
            theme: "bootstrap-5",
            ajax: {
                url: base_url + "transaksi/__api_member/",
                processResults: function (data){
                    return {
                        results: data.data
                    }
                }
            }
        });

        datable = $("#keranjang").DataTable({
            data: keranjang,
            dom: "t",
            columns: [{
                    title: "No",
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    title: "Produk",
                    data: "produk"
                },
                {
                    title: "Kuantitas",
                    data: "qty"
                },
                {
                    title: "Harga",
                    data: "harga",
                    render: function(data, type, row, meta) {
                        return "Rp." + $.number(parseInt(data), 2, ".", ",");
                    }
                },
                {
                    title: "Sub Total",
                    render: function(data, type, row, meta) {
                        let subtotal = parseInt(row.qty) * parseInt(row.harga);
                        return "Rp." + $.number(subtotal, 2, ".", ",");;
                    }
                },
                {
                    title: "Diskon",
                    data: "diskon",
                    render: function(data, type, row, meta) {
                        return data < 1 ? "-" : data + "%";
                    }
                },
                {
                    title: "Total",
                    render: function(data, type, row, meta) {
                        let subtotal = parseInt(row.qty) * parseInt(row.harga);
                        let diskon = subtotal * (parseInt(row.diskon) / 100);
                        let total = subtotal - diskon;
                        return "Rp." + $.number(total, 2, ".", ",");
                    }
                },
                {
                    title: "Aksi",
                    defaultContent: `<button class="btn btn-danger"><i class="fa-regular fa-trash-can"></i></button>`
                },
            ]
        });

    });

    function showHarga(context){
        let harga = "Rp." + $.number(context.value.split("|")[1], 2, ",", ".");
        $("#harga_satuan").val(harga);
        countSubtotal(document.getElementById("qty"));
    }

    function countSubtotal(context){
        let qty = parseInt(context.value == "" ? 0: context.value);
        let hrgVal = $("#harga_satuan").val().replaceAll("Rp.", "").replaceAll(".", "").replaceAll(",", ".");
        let harga = parseFloat(hrgVal == "" ? 0: hrgVal);
        let subtotal = "Rp." + $.number(harga * qty, 2, ",", ".");
        $("#subtotal").val(subtotal);
    }

    function addToTable(produk, qty, harga, diskon) {
        keranjang.push({
            produk: produk,
            qty: qty,
            harga: harga,
            diskon: diskon
        });
        let dt = new DataTable("#keranjang");
        dt.clear().rows.add(keranjang).draw();
    }
</script>
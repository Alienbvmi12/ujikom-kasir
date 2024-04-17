<script>
    const keranjang = [];
    const info_transaksi = {
        subtotal: 0,
        diskon: {},
        total: 0,
        bayar: 0,
        kembalian: 0
    };
    let member = "";
    const kasir = "<?= $sess->admin->id ?>";
    const base_url = "<?= base_url() ?>";
    let datable;
    $(document).ready(function() {

        //Components Init

        $("#produk_id").select2({
            theme: "bootstrap-5",
            ajax: {
                url: base_url + "admin/transaksi/__api_produk/",
                processResults: function(data) {
                    return {
                        results: data.data
                    }
                }
            }
        });
        $("#member_id").select2({
            theme: "bootstrap-5",
            ajax: {
                url: base_url + "admin/transaksi/__api_member/",
                processResults: function(data) {
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
                    data: "harga_satuan",
                    render: function(data, type, row, meta) {
                        return _rupiah(parseFloat(data));
                    }
                },
                {
                    title: "Total",
                    render: function(data, type, row, meta) {
                        let subtotal = parseInt(row.qty) * parseFloat(row.harga_satuan);
                        return _rupiah(subtotal);
                    }
                },
                {
                    title: "Aksi",
                    render: function(data, type, row) {
                        return `<button class="btn btn-danger" onclick="removeFromCart('` + row.produk_id + `')"><i class="fa-regular fa-trash-can"></i></button>`;
                    }
                },
            ]
        });

    });

    function _rupiah(num) {
        return "Rp" + $.number(num, 2, ",", ".");
    }

    function _decode_rupiah(numStr) {
        return numStr.replaceAll("Rp", "").replaceAll(".", "").replaceAll(",", ".");
    }

    function setMember(context) {
        member = context.value;
        transSummary();
    }

    function showHarga(context) {
        let harga = _rupiah(context.value.split("|")[1]);
        $("#harga_satuan").val(harga);
        countSubtotalRow(document.getElementById("qty"));
    }

    function countSubtotalRow(context) {
        let qty = parseInt(context.value == "" ? 0 : context.value);
        let hrgVal = _decode_rupiah($("#harga_satuan").val());
        let harga = parseFloat(hrgVal == "" ? 0 : hrgVal);
        let subtotal = _rupiah(harga * qty);
        $("#subtotal").val(subtotal);
    }

    function addToCart() {
        var produk_id = $("#produk_id").val().split("|")[0];
        var qty = $("#qty").val() == "" ? 0 : parseInt($("#qty").val());
        if (produk_id == "") {
            toastr.warning("Mohon pilih produk terlebih dahulu!!");
            return;
        }
        if (qty == "") {
            toastr.warning("Mohon isi kuantitas!!");
            return;
        }

        $.ajax({
            type: "get",
            url: base_url + "admin/transaksi/__api_produk_add/" + produk_id + "/",
            dataType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var isduplicate = false;

                keranjang.forEach((val, idx) => {
                    if (val.produk_id == produk_id) {
                        isduplicate = true
                        var total_qty = val.qty + qty;
                        if (total_qty > response.data.stok) {
                            toastr.warning("<b>Gagal Menambahkan</b> Kuantitas yang diminta melebihi stok!!");
                        } else if (total_qty <= 0) {
                            keranjang.splice(idx, 1);
                        } else {
                            let tam = {
                                produk_id: response.data.id,
                                produk: response.data.produk,
                                qty: total_qty,
                                harga_satuan: response.data.harga_satuan,
                            };

                            keranjang[idx] = tam;
                        }
                    }
                })

                if (!isduplicate) {
                    if (qty > response.data.stok) {
                        toastr.warning("<b>Gagal Menambahkan</b> Kuantitas yang diminta melebihi stok!!");
                        return;
                    } else if (qty <= 0) {
                        toastr.warning("<b>Gagal Menambahkan</b> Mohon isi kuantitas dengan bilangan diatas nol!!");
                        return
                    }
                    let tam = {
                        produk_id: response.data.id,
                        produk: response.data.produk,
                        qty: qty,
                        harga_satuan: response.data.harga_satuan,
                    };

                    keranjang.push(tam);
                }

                console.log(keranjang);

                refreshTable();
            },
            error: function(xhr) {
                toastr.error("<b>Error</b> " + xhr.responseJSON.message);
            }
        });
    }

    function removeFromCart(id) {
        keranjang.forEach((val, idx) => {
            if (val.produk_id == id) {
                keranjang.splice(idx, 1);
            }
        });
        console.log(keranjang);
        refreshTable();
    }

    function refreshTable() {
        let dt = new DataTable("#keranjang");
        dt.clear().rows.add(keranjang).draw();
        transSummary();
    }

    function transSummary() {
        countSubtotalTrans();
        getDiskonTransaksi();
    }

    function transSummary2() {
        countTotalTrans();
        countKembalian();
    }

    function countSubtotalTrans() {
        let subtotal = 0.0;
        keranjang.forEach((value, index) => {
            let row_total = value.qty * value.harga_satuan;
            subtotal += row_total;
        });
        $("#subtotal_trans").val(
            _rupiah(subtotal)
        );
        info_transaksi.subtotal = subtotal;
    }

    function getDiskonTransaksi() {
        if (member != "") {
            let subtotal = info_transaksi.subtotal;
            $.ajax({
                method: "GET",
                url: base_url + "admin/transaksi/__api_diskon_transaksi/",
                data: "nominal=" + subtotal,
                dataType: false,
                processData: false,
                success: function(response) {
                    $("#diskon").val((response.data.diskon ?? 0) + "%");
                    info_transaksi.diskon = response.data;
                    transSummary2();
                },
                error: function(xhr) {
                    toastr.error("<b>Error</b> " + xhr.responseJSON.message);
                }
            });
        } else {
            transSummary2();
        }
    }

    function countTotalTrans() {
        let diskon = info_transaksi.subtotal * ((info_transaksi.diskon.diskon ?? 0) / 100);
        console.log(diskon);
        let total = info_transaksi.subtotal - diskon;
        $("#total").val(_rupiah(total));
        $("#total-view").html(_rupiah(total));
        info_transaksi.total = total;
    }

    function countKembalian() {
        let bayar = parseFloat($("#bayar").val() == "" ? 0 : $("#bayar").val());
        let kembalian = bayar - info_transaksi.total;
        $("#kembalian").val(_rupiah(kembalian));
        $("#kembalian-view").html(_rupiah(kembalian));
        if (kembalian < 0) {
            $("#kembalian-view").removeClass("text-success");
            $("#kembalian-view").addClass("text-danger");
        } else {
            $("#kembalian-view").removeClass("text-danger");
            $("#kembalian-view").addClass("text-success");

        }
        info_transaksi.bayar = bayar;
        info_transaksi.kembalian = kembalian;
    }

    function submitTransaksi() {
        if (keranjang.length < 1) {
            toastr.warning("Mohon mohon isi keranjang terlebih dahulu!!");
            return;
        }
        if (info_transaksi.bayar < 1 || info_transaksi.bayar == "") {
            toastr.warning("Mohon isi nominal pembayaran terlebih dahulu!!");
            return;
        }
        if (info_transaksi.bayar < info_transaksi.total) {
            toastr.warning("Nominal pembayaran tidak mencukupi!!");
            return;
        }

        let transaksi = {
            transaksi: {
                admin_id: kasir,
                member_id: $("#member_id").val() == "" ? null : $("#member_id").val(),
                subtotal_harga: info_transaksi.subtotal,
                total_harga: info_transaksi.total,
                cash: info_transaksi.bayar,
                diskon_id: info_transaksi.diskon.id == undefined ? null: info_transaksi.diskon.id,
                diskon: info_transaksi.diskon.diskon == undefined ? null: info_transaksi.diskon.diskon,
            },
            transaksi_detail: keranjang
        }

        $.ajax({
            method: "POST",
            url: base_url + "admin/transaksi/process/",
            data: JSON.stringify(transaksi),
            dataType: "json",
            processData: false,
            success: (response) => {
                if (response.status >= 200 && response.status < 300) {
                    toastr.success("<b>Success</b> " + "Transaksi Sukses!!");
                    location.href = response.data.redirect_url;
                } else {
                    toastr.warning("<b>Gagal</b> " + response.message);
                }
            },
            error: (xhr) => {
                toastr.error("<b>Error</b> " + xhr.responseJSON.message);
            }
        })
    }
</script>
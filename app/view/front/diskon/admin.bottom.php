<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "admin/diskon/read/";
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
                },
                {
                    title: "Aksi",
                    defaultContent: `
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('edit', this)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteM(this)">Delete</button>
                                    `
                }
            ]
        });
    });

    function modal(type, context) {
        if (type == 'edit') {
            const row = context.parentNode.parentNode.getElementsByTagName("td");
            edit_id = row[0].innerHTML;
            $("#diskon").val(row[1].innerHTML.replaceAll("%", ""));
            $("#deskripsi").val(row[2].innerHTML);
            $("#minimum_transaksi").val(row[3].innerHTML.replaceAll("Rp.", "").replaceAll(".", "").replaceAll(",", "."));
            $("#expired_date").val(row[4].innerHTML);

            // $.ajax({
            //     url: base_url + "admin/diskon/get_by_id/" + edit_id,
            //     method: "GET",
            //     processData: false,
            //     contentType: false,
            //     success: function(res) {
            //         $("#diskon").val(res.data.diskon);
            //         $("#deskripsi").val(res.data.deskripsi);
            //         $("#type").val(res.data.type);
            //         $("#minimum_transaksi").val(res.data.minimum_transaksi ?? "");
            //         $("#expired_date").val(res.data.expired_date);

            //         const val = document.getElementById("type").value;
            //         $("#minimum-transaksi-container").removeClass("d-none");
            //         $("#produk-id-container").removeClass("d-none");
            //         if (val == "0") {
            //             $("#minimum-transaksi-container").addClass("d-none");

            //             let $newOption = $("<option selected='selected'></option>")
            //                 .val(res.data.produk_id)
            //                 .text(row[4].innerHTML);
            //             $("#produk_id").append($newOption).trigger('change');

            //         } else {
            //             $("#produk-id-container").addClass("d-none");
            //         }
            //     },
            //     fail: function(xhr) {
            //         toastr.danger(xhr.responseJSON.message)
            //     }
            // })
            document.getElementById("submit").setAttribute("onclick", "editM()");
            $("#modalTitle").html("Edit Data");
        } else {
            $("#diskon").val("");
            $("#deskripsi").val("");
            $("#minimum_transaksi").val("");
            $("#expired_date").val("");
            document.getElementById("submit").setAttribute("onclick", "create()");
            $("#modalTitle").html("Tambah Data");
        }
    }

    function create() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "admin/diskon/create",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("<b>Berhasil</b> <br> " + response.message);
                } else {
                    toastr.error("<b>Gagal</b> <br> " + response.message);
                }
                table.ajax.reload();
            },
            error: function(xhr) {
                toastr.error("<b>Error</b> <br> " + xhr.responseJSON.message);
                table.ajax.reload();
            }
        });
    }

    function deleteM(context) {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah anda yakin untuk menghapus data?",
            icon: "warning",
            showCancelButton: true
        }).then(function(result) {
            if (result.isConfirmed) {
                const id = context.parentNode.parentNode.getElementsByTagName("td")[0].innerHTML;
                $.post(base_url + "admin/diskon/delete/" + id + "/")
                    .done(function(response) {
                        if (response.status == 200) {
                            toastr.success("<b>Berhasil</b> <br> " + response.message);
                        } else {
                            toastr.error("<b>Gagal</b> <br> " + response.message);
                        }
                        table.ajax.reload();
                    }).fail(function(xhr) {
                        toastr.error("<b>Error</b> <br> " + xhr.responseJSON.message);
                        table.ajax.reload();
                    });
            }
        })
    }

    function editM() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        formData.append("id", edit_id);
        $.ajax({
            type: "post",
            url: base_url + "admin/diskon/edit",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("<b>Berhasil</b> <br> " + response.message);
                } else {
                    toastr.error("<b>Gagal</b> <br> " + response.message);
                }
                table.ajax.reload();
            },
            error: function(xhr) {
                toastr.error("<b>Error</b> <br> " + xhr.responseJSON.message);
                table.ajax.reload();
            }
        });
    }
</script>
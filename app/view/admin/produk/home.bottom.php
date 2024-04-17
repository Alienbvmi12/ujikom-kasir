<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "admin/produk/read/";
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
                    title: "Kode Produk (ID)",
                    data: "id"
                },
                {
                    title: "Nama Produk",
                    data: "nama_produk"
                },
                {
                    title: "Harga Satuan",
                    data: "harga",
                    render: function(data, type, row) {
                        return "Rp." + $.number(data, 2, ",", ".")
                    }
                },
                {
                    title: "Stok",
                    data: "stok",
                    render: function(data, type, row) {
                        if (data < 10) {
                            return "<div class='text-danger'>" + data + "</div>";
                        }
                        else{
                            return "<div>" + data + "</div>";
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
        })
    });

    function modal(type, context) {
        if (type == 'edit') {
            const row = context.parentNode.parentNode.getElementsByTagName("td");
            edit_id = row[0].innerHTML;
            $("#nama_produk").val(row[1].innerHTML);
            $("#harga").val(row[2].innerHTML.replaceAll("Rp.", "").replaceAll(".", "").replaceAll(",", "."));
            $("#stok").val(row[3].getElementsByTagName("div")[0].innerHTML);
            document.getElementById("submit").setAttribute("onclick", "editM()");
            $("#modalTitle").html("Edit Data");
        } else {
            $("#nama_produk").val("");
            $("#harga").val("");
            $("#stok").val("");
            document.getElementById("submit").setAttribute("onclick", "create()");
            $("#modalTitle").html("Tambah Data");
        }
    }

    function create() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "admin/produk/create",
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
                $.post(base_url + "admin/produk/delete/" + id + "/")
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
            url: base_url + "admin/produk/edit",
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
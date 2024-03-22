<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "petugas/read/";
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
                    title: "Nama",
                    data: "nama"
                },
                {
                    title: "Username",
                    data: "username"
                },
                {
                    title: "Email",
                    data: "email"
                },
                {
                    title: "Status",
                    data: "status",
                    render: function(data, type, row) {
                        if (data == 0) {
                            return "Nonaktif";
                        } else {
                            return "Aktif";
                        }
                    }
                },
                {
                    title: "Dibuat Pada",
                    data: "created_at"
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
            $("#nama").val(row[1].innerHTML);
            $("#username").val(row[2].innerHTML);
            $("#email").val(row[3].innerHTML);
            $("#status").val(row[4].innerHTML.toLowerCase() == "aktif" ? "1" : "0");
            $("#password").val("");
            $("#konfirmasi_password").val("");
            document.getElementById("submit").setAttribute("onclick", "editM()");
            $("#modalTitle").html("Edit Data");
            document.getElementById("password").placeholder = "Isi kolom ini untuk mengubah password";
            document.getElementById("konfirmasi_password").placeholder = "Isi kolom ini untuk mengubah password";
        } else {
            $("#nama").val("");
            $("#username").val("");
            $("#email").val("");
            $("#status").val("1");
            $("#password").val("");
            $("#konfirmasi_password").val("");
            document.getElementById("submit").setAttribute("onclick", "create()");
            $("#modalTitle").html("Tambah Data");
            document.getElementById("password").placeholder = "";
            document.getElementById("konfirmasi_password").placeholder = "";
        }
    }

    function create() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "petugas/create",
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
                $.post(base_url + "petugas/delete/" + id + "/")
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
            url: base_url + "petugas/edit",
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
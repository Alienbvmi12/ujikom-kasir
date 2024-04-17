<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "admin/member/read/";
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
                    title: "NIK",
                    data: "nik"
                },
                {
                    title: "Nama",
                    data: "nama"
                },
                {
                    title: "No. Telepon",
                    data: "nomor_telepon"
                },
                {
                    title: "Alamat",
                    data: "alamat"
                },
                {
                    title: "Tanggal Registrasi",
                    data: "tanggal_registrasi"
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
                    title: "Status",
                    data: "status",
                    render: function(data, type, row) {
                        return data == "1" ? "Aktif" : "Nonaktif";
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
            $("#nik").val(row[1].innerHTML);
            $("#nama").val(row[2].innerHTML);
            $("#nomor_telepon").val(row[3].innerHTML);
            $("#alamat").val(row[4].innerHTML);
            $("#tanggal_registrasi").val(row[5].innerHTML);
            $("#expired_date").val(row[6].getElementsByTagName("div")[0].innerHTML);
            $("#status").val(row[7].innerHTML.toLowerCase() == "aktif" ? "1" : "0");
            document.getElementById("submit").setAttribute("onclick", "editM()");
            $("#modalTitle").html("Edit Data");
        } else {
            $("#nik").val("");
            $("#nama").val("");
            $("#nomor_telepon").val("");
            $("#alamat").val("");
            $("#tanggal_registrasi").val("");
            $("#expired_date").val("");
            $("#status").val("1");
            document.getElementById("submit").setAttribute("onclick", "create()");
            $("#modalTitle").html("Tambah Data");
        }
    }

    function create() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "admin/member/create",
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
                $.post(base_url + "admin/member/delete/" + id + "/")
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
            url: base_url + "admin/member/edit",
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
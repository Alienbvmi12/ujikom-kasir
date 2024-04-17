<script>
    const base_url = "<?= base_url() ?>";
    let table;
    let edit_id = 0;
    $(document).ready(function() {
        let request_url = base_url + "member/read/";
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
                    title: "Status",
                    data: "status",
                    render: function(data, type, row) {
                        return data == "1" ? "Aktif" : "Nonaktif";
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
                    render: function(data, type, row) {
                        if (row.status == "1") {
                            return `
                                    <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('edit', this)">Edit</button>
                                    <button class="btn btn-primary btn-sm mb-1" onclick="perpanjang(this)">Perpanjang</button>
                                    <button class="btn btn-danger btn-sm mb-1" onclick="status(0, this)">Nonaktifkan</button>
                                    `
                        } else {
                            return `
                                    <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal" onclick="modal('edit', this)">Edit</button>
                                    <button class="btn btn-primary btn-sm mb-1" onclick="perpanjang(this)">Perpanjang</button>
                                    <button class="btn btn-success btn-sm mb-1" onclick="status(1, this)">Aktifkan</button>
                                    `
                        }
                    }
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
            $("#status").val(row[6].innerHTML.toLowerCase() == "aktif" ? "1" : "0");
            document.getElementById("submit").setAttribute("onclick", "editM()");
            $("#modalTitle").html("Edit Data");
        } else {
            $("#nik").val("");
            $("#nama").val("");
            $("#nomor_telepon").val("");
            $("#alamat").val("");
            $("#tanggal_registrasi").val("");
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
            url: base_url + "member/create",
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

    function perpanjang(context) {
        const id = context.parentNode.parentNode.getElementsByTagName("td")[0].innerHTML;

        Swal.fire({
            title: "Perpanjang",
            text: "Perpanjang Berapa Bulan?",
            input: "number",
            icon: "warning",
            showCancelButton: true,
            inputPlaceHolder: "Masukan jumlah bulan"
        }).then(function(result) {
            if (result.value == null || result.value <= 0) {
                toastr.warning("Mohon untuk mengisi jumlah yang valid")
            } else {
                const formData = new FormData();
                formData.append("perpanjang", result.value);
                $.ajax({
                    type: "post",
                    url: base_url + "member/perpanjang/" + id + "/",
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
        })
    }

    function status(status, context) {
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah anda yakin?",
            icon: "warning",
            showCancelButton: true
        }).then(function(result) {
            if (result.isConfirmed) {
                const id = context.parentNode.parentNode.getElementsByTagName("td")[0].innerHTML;
                $.post(base_url + "member/" + (status == 1 ? "activate" : "inactivate") + "/" + id + "/")
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
            url: base_url + "member/edit",
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
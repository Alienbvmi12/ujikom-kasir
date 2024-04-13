<script>
    const base_url = "<?= base_url() ?>";
    let default_user = {
        nama: "<?= $sess->user->nama ?>",
        username: "<?= $sess->user->username ?>",
        email: "<?= $sess->user->email ?>",
    }

    function editMode($state) {
        if (!$state) {
            $("#ok").addClass("d-none");
            $("#cancel").addClass("d-none");
            $("#edit").removeClass("d-none");

            const formArr = document.getElementById("form").getElementsByTagName("input");;

            for (let item of formArr) {
                console.log(item);
                item.setAttribute("readonly", true);
                item.setAttribute("disabled", true);
            }
        } else {
            $("#ok").removeClass("d-none");
            $("#cancel").removeClass("d-none");
            $("#edit").addClass("d-none");

            const formArr = document.getElementById("form").getElementsByTagName("input");

            for (let item of formArr) {
                item.removeAttribute("readonly", false);
                item.removeAttribute("disabled", false);
            }
        }
    }

    function submit(state) {
        if (state) {
            editM();
        } else {
            const formArr = document.getElementById("form").getElementsByTagName("input");

            for (let item of formArr) {
                item.value = default_user[item.id];
            }
            editMode(false);
        }
    }

    function editMode2($state) {
        if (!$state) {
            $("#ok2").addClass("d-none");
            $("#cancel2").addClass("d-none");
            $("#edit2").removeClass("d-none");

            const formArr = document.getElementById("form2").getElementsByTagName("input");

            for (let item of formArr) {
                item.setAttribute("readonly", true);
                item.setAttribute("disabled", true);
            }
        } else {
            $("#ok2").removeClass("d-none");
            $("#cancel2").removeClass("d-none");
            $("#edit2").addClass("d-none");

            const formArr = document.getElementById("form2").getElementsByTagName("input");

            for (let item of formArr) {
                item.removeAttribute("readonly", false);
                item.removeAttribute("disabled", false);
            }
        }
    }

    function submit2(state) {
        if (state) {
            editPass();
        } else {
            editMode2(false);
        }
    }

    function editM() {
        const form = document.getElementById("form");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "profile/edit",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("<b>Berhasil</b> <br> " + response.message);
                    default_user = {
                        nama: response.data.nama,
                        username: response.data.username,
                        email: response.data.email,
                    }
                    editMode(false);
                } else {
                    toastr.error("<b>Gagal</b> <br> " + response.message);
                }
            },
            error: function(xhr) {
                toastr.error("<b>Error</b> <br> " + xhr.responseJSON.message);

            }
        });
    }

    function editPass() {
        const form = document.getElementById("form2");
        const formData = new FormData(form)
        $.ajax({
            type: "post",
            url: base_url + "profile/edit_password",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("<b>Berhasil</b> <br> " + response.message);
                    const formArr = document.getElementById("form2").getElementsByTagName("input");

                    for (let item of formArr) {
                        item.value = "";
                    }
                    editMode2(false);
                } else {
                    toastr.error("<b>Gagal</b> <br> " + response.message);
                }
            },
            error: function(xhr) {
                toastr.error("<b>Error</b> <br> " + xhr.responseJSON.message);
            }
        });
    }
</script>
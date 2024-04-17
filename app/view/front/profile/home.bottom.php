<script>
    const base_url = "<?= base_url() ?>";

    // function editMode2($state) {
    //     if (!$state) {
    //         $("#ok2").addClass("d-none");
    //         $("#cancel2").addClass("d-none");
    //         $("#edit2").removeClass("d-none");

    //         const formArr = document.getElementById("form2").getElementsByTagName("input");

    //         for (let item of formArr) {
    //             item.setAttribute("readonly", true);
    //             item.setAttribute("disabled", true);
    //         }
    //     } else {
    //         $("#ok2").removeClass("d-none");
    //         $("#cancel2").removeClass("d-none");
    //         $("#edit2").addClass("d-none");

    //         const formArr = document.getElementById("form2").getElementsByTagName("input");

    //         for (let item of formArr) {
    //             item.removeAttribute("readonly", false);
    //             item.removeAttribute("disabled", false);
    //         }
    //     }
    // }

    function submit2(state) {
        // if (state) {
        editPass();
        // } else {
        //     editMode2(false);
        // }
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
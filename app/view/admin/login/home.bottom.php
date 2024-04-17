<script>
    $(document).ready(function() {
        $("#login_form").on("submit", function(evt) {
            evt.preventDefault();
            const email = $("#email").val()
            const password = $("#password").val()
            NProgress.start()
            $.post("<?= base_url() ?>admin/login/login/", {
                email: email,
                password: password
            }).done(function(data) {
                if (data.status == 200) {
                    toastr["info"]("Login sukses!! mengarahkan ke dashboard")
                    toastr["success"](data.message)
                    window.location.href = "<?= base_url() ?>admin"
                } else {
                    toastr["error"](data.message);
                }
                NProgress.done();
            }).fail(function(xhr) {
                toastr["error"](xhr.responseJSON.message);
                NProgress.done();
            })
        });
    });
</script>
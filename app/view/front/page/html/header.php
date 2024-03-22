<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">K-Sir App</a>
        <button class="btn me-auto ms-5" type="button" onclick="$('#sidebar').toggleClass('d-none')">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-regular fa-user"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" href="<?= base_url()?>logout">Logout</a>
            </div>
        </div>

    </div>
</nav>
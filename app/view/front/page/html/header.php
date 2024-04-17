<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
        <button class="btn me-auto" type="button" onclick="$('#sidebar').toggleClass('d-none')">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown">
            <button class="btn dropdown-toggle text-white" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-regular fa-user"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="triggerId">
                <a class="dropdown-item" href="<?= base_url()?>profile/">Profile</a>
                <a class="dropdown-item bg-danger text-white" href="<?= base_url()?>logout/">Logout</a>
            </div>
        </div>

    </div>
</nav>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <?php $this->getAdditionalBefore(); ?>
    <?php $this->getAdditional(); ?>
    <?php $this->getAdditionalAfter(); ?>
</head>

<body>
    <?php $this->getJsFooter(); ?>
    <?php $this->getJsReady(); ?>
    <header>
        <!-- place navbar here -->
        <?php $this->getThemeElement('page/html/header', $__forward) ?>
    </header>
    <main>
        <div class="d-flex flex-row">
            <div class="d-flex flex-column bg-light pt-3" style="width : 250px" id="sidebar">
                <!-- Hover added -->
                <b class="mx-3 text-">Menu</b>
                <nav class="nav flex-column mt-3">
                    <a class="nav-link text-secondary <?= $active === 'dashboard' ? 'text-dark' : '' ?>" href="<?= base_url() ?>"><i class="fa-solid fa-house"></i> Dashboard</a>
                    <?php if (isset($sess->user->role)) {
                        if ($sess->user->role == 0) { ?>
                            <a class="nav-link text-secondary <?= $active === 'petugas' ? 'text-dark' : '' ?>" href="<?= base_url() ?>admin/petugas"><i class="fa-solid fa-user"></i> Kelola Petugas</a>
                    <?php }
                    } ?>
                    <?php if (isset($sess->user->role)) {
                        if ($sess->user->role == 0) { ?>
                            <a class="nav-link text-secondary <?= $active === 'member' ? 'text-dark' : '' ?>" href="<?= base_url() ?>admin/member"><i class="fa-solid fa-address-card"></i> Kelola Member</a>
                        <?php } else {
                        ?>
                            <a class="nav-link text-secondary <?= $active === 'member' ? 'text-dark' : '' ?>" href="<?= base_url() ?>member"><i class="fa-solid fa-address-card"></i> Kelola Member</a>
                    <?php
                        }
                    } ?>
                    <a class="nav-link text-secondary <?= $active === 'produk' ? 'text-dark' : '' ?>" href="<?= base_url() ?>produk"><i class="fa-solid fa-boxes-stacked"></i> Kelola Produk</a>
                    <?php if (isset($sess->user->role)) {
                        if ($sess->user->role == 0) { ?>
                            <a class="nav-link text-secondary <?= $active === 'diskon' ? 'text-dark' : '' ?>" href="<?= base_url() ?>diskon"><i class="fa-solid fa-tag"></i> Kelola Diskon</a>
                    <?php }
                    } ?>
                    <a class="nav-link text-secondary <?= $active === 'transaksi' ? 'text-dark' : '' ?>" href="<?= base_url() ?>transaksi"><i class="fa-solid fa-cash-register"></i> Transaksi</a>
                    <a class="nav-link text-secondary <?= $active === 'laporan' ? 'text-dark' : '' ?>" href="<?= base_url() ?>laporan"><i class="fa-solid fa-file-lines"></i> Laporan Penjualan</a>
                </nav>
            </div>
            <div class="w-100 container py-4">
                <?php $this->getThemeContent() ?>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
        <?php $this->getThemeElement('page/html/footer', $__forward) ?>
    </footer>
</body>

</html>
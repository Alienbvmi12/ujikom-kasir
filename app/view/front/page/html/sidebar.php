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
                <a class="nav-link text-secondary <?= $active === 'member' ? 'text-dark' : '' ?>" href="<?= base_url() ?>petugas/member"><i class="fa-solid fa-address-card"></i> Kelola Member</a>
        <?php
            }
        } ?>
        <a class="nav-link text-secondary <?= $active === 'produk' ? 'text-dark' : '' ?>" href="<?= base_url() ?>produk"><i class="fa-solid fa-boxes-stacked"></i> Kelola Produk</a>
        <?php if (isset($sess->user->role)) {
            if ($sess->user->role == 0) { ?>
                <a class="nav-link text-secondary <?= $active === 'diskon' ? 'text-dark' : '' ?>" href="<?= base_url() ?>admin/diskon"><i class="fa-solid fa-tag"></i> Kelola Diskon</a>
        <?php }
        } ?>
        <a class="nav-link text-secondary <?= $active === 'transaksi' ? 'text-dark' : '' ?>" href="<?= base_url() ?>transaksi"><i class="fa-solid fa-cash-register"></i> Transaksi</a>
        <a class="nav-link text-secondary <?= $active === 'laporan' ? 'text-dark' : '' ?>" href="<?= base_url() ?>laporan"><i class="fa-solid fa-file-lines"></i> Laporan Penjualan</a>
    </nav>
</div>
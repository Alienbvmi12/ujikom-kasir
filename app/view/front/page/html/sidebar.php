<div class="d-flex flex-column bg-dark pt-3" style="width : 250px;" id="sidebar">
    <!-- Hover added -->
    <h3 class="text-white mx-4 mb-5" href="<?=base_url()?>">K-Sir App</h3>
    <b class="mx-3 text-white">Menu</b>
    <div class="d-flex flex-column mt-3 p-2">
        <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'dashboard' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>"><i class="fa-solid fa-house"></i> Dashboard</a>
        <?php
        if ($this->is_admin()) { ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'petugas' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>admin/petugas"><i class="fa-solid fa-user"></i> Kelola Petugas</a>
        <?php }
        ?>
        <?php
        if ($this->is_admin()) { ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'member' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>admin/member"><i class="fa-solid fa-address-card"></i> Kelola Member</a>
        <?php } else {
        ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'member' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>petugas/member"><i class="fa-solid fa-address-card"></i> Kelola Member</a>
        <?php
        }
        ?>
        <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'produk' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>produk"><i class="fa-solid fa-boxes-stacked"></i> Kelola Produk</a>
        <?php
        if ($this->is_admin()) { ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'diskon' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>admin/diskon"><i class="fa-solid fa-tag"></i> Kelola Diskon</a>
        <?php } else {
        ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'diskon' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>petugas/diskon"><i class="fa-solid fa-tag"></i> Diskon</a>
        <?php
        }
        ?>
        <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'transaksi' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>transaksi"><i class="fa-solid fa-cash-register"></i> Transaksi</a>
        <?php
        if ($this->is_admin()) { ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'laporan' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>admin/penjualan"><i class="fa-solid fa-file-lines"></i> Laporan Penjualan</a>
        <?php } else {
        ?>
            <a class="text-decoration-none rounded-3 py-2 px-2 <?= $active === 'laporan' ? 'bg-light text-dark' : 'text-white' ?>" href="<?= base_url() ?>petugas/penjualan"><i class="fa-solid fa-file-lines"></i> Histori Transaksi</a>
        <?php
        }
        ?>
    </div>
</div>
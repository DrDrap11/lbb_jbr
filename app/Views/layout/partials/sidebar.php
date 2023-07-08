<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
    </li>
    <li class="menu-header">Master</li>
    <?php if (session()->get('role') == 'superadmin') : ?>
        <li class="nav-item">
            <a href="<?= base_url('dashboard/master/user') ?>" class="nav-link"><i class="fas fa-user"></i><span>Master Users</span></a>
        </li>
    <?php endif ?>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/master/cabang') ?>" class="nav-link"><i class="fas fa-building"></i><span>Master Cabang</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/master/akun') ?>" class="nav-link"><i class="fas fa-building"></i><span>Master Akun</span></a>
    </li>
    <li class="menu-header">Data</li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/kolektibilitas') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data Kolektibilitas</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/mutasi') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data Mutasi</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/pos2') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data POS2</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/liabilitas') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data Liabilitas</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/laba') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data Laba</span></a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url('dashboard/data/neraca') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Data Neraca</span></a>
    </li>
</ul>
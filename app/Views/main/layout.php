<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory App 3</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
        .main-sidebar.sidebar-dark-primary.elevation-4 {
            background-color: #c45161 !important;
        }

        .form-inline .input-group .form-control-sidebar {
            background-color: #efc4d6;
        }

        .form-inline .input-group .btn-sidebar {
            background-color: #efc4d6;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>/index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input id="navbar-search-input" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>/index3.html" class="brand-link">
                <img src="<?= base_url() ?>/dist/img/arrow.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Inventory App</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>/dist/img/profil.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?= session()->namauser; ?>
                        </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input id="sidebar-search-input" class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul id="sidebar-menu" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <?php if (session()->idlevel == 1) : ?>
                            <li class="nav-header">Menu</li>
                            <li class="nav-item">
                                <a href="<?= site_url('Category/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-tasks text-primary"></i>
                                    <p class="text">Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('Unit/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-angle-double-right text-warning"></i>
                                    <p class="text">Unit</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('Product/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-duotone fa-ice-cream"></i>
                                    <p class="text">Product</p>
                                </a>
                            </li>
                            <li class="nav-header">Transaction</li>
                            <li class="nav-item">
                                <a href="<?= site_url('barangMasuk/data'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-arrow-circle-down text-primary"></i>
                                    <p class="text">Incoming Goods</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('barangkeluar/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-arrow-circle-up text-warning"></i>
                                    <p class="text">Outgoing Goods</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('laporan/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-file text-warning"></i>
                                    <p class="text">Report Transaction</p>
                                </a>
                            </li>
                        <?php endif;  ?>

                        <!-- USER LEVEL 2 -->
                        <?php if (session()->idlevel == 2) : ?>
                            <li class="nav-header">Transaction</li>
                            <li class="nav-item">
                                <a href="<?= site_url('barangMasuk/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-arrow-circle-down text-primary"></i>
                                    <p class="text">Incoming Goods</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('barangkeluar/index'); ?>" class="nav-link">
                                    <i class="nav-icon fa fa-arrow-circle-up text-warning"></i>
                                    <p class="text">Outgoing Goods</p>
                                </a>
                            </li>
                        <?php endif;  ?>

                        <li class="nav-item">
                            <a href="<?= site_url('login/logout'); ?>" class="nav-link">
                                <i class="nav-icon fa fa-sign-out-alt text-primary"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                <?= $this->renderSection('judul') ?>
                            </h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $this->renderSection('subJudul') ?>
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= $this->renderSection('isi') ?>

                    </div>
                    <!-- /.card-body -->

                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2024 <a href="https://www.instagram.com/bulbpeppa_sk/">Ashri Aulia</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#sidebar-search-input').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#sidebar-menu li.nav-item').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>
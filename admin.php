<?php
require 'function.php';
require 'cek.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kelola Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <div style="display: flex; align-items: center;">
                <img src="assets/img/Logo_SCR.png" alt="Logo" width="50" height="50">
                    <div style="margin-left: 10px; text-align: center;">
                        <span style="font-size: 20px; display: block;">INVENTARIS</span>
                        <span style="font-size: 12px; display: block;">Laboratorium</span>
                    </div>
            </div>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                            Data Barang
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                            Kelola Admin
                        </a>
                    </div>

                    </div>
                    <div class="sb-sidenav-footer">
                    <a class="nav-link" href="logout.php">
                        Logout
                    </a>
                    </div>
                </nav>
                </div>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Data Admin</h1>
                       <!-- Tambahkan card untuk total barang -->
                       <div class="row">
                       <div class="container">
                    </div>

                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                            <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Tambah Admin
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username Admin</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilsemuadataadmin = mysqli_query($conn,"select * from login");
                                            $i = 1;
                                            while($data = mysqli_fetch_array($ambilsemuadataadmin)){
                                                $uname = $data['username'];
                                                $iduser = $data['iduser'];
                                                $pw = $data['password'];
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$uname;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#perbarui<?=$iduser;?>">
                                                    Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?=$iduser;?>">
                                                    Hapus
                                                    </button>

                                                </td>
                                            </tr>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="perbarui<?=$iduser;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Admin</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="text" name="usernameadmin" value="<?=$uname;?>" class="form-control" placeholder="Email" required>
                                                    <br>
                                                    <input type="password" name="passwordadmin" value="<?=$pw;?>" class="form-control" placeholder="Password">
                                                    <br>
                                                    <input type="hidden" name="id" value="<?=$iduser;?>">
                                                    <button type="submit" class="btn btn-primary" name="updateadmin">Submit</button>
                                                    </div>
                                                    </form>

                                                </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="hapus<?=$iduser;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Admin</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus <?=$uname;?>?
                                                    <br>
                                                    <br>
                                                    <input type="hidden" name="id" value="<?=$iduser;?>">
                                                    <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
                                                    </div>
                                                    </form>

                                                </div>
                                                </div>
                                            </div>
                                           

                                                <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
                                                <script
                                                src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
                                                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                                                crossorigin="anonymous"
                                                ></script>
                                                <script
                                                src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
                                                integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
                                                crossorigin="anonymous"
                                                ></script>

                                            <?php
                                            };
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                            <!-- Button to Open the Modal -->
                                
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>

            <!-- Tambah Modal -->
            <div class="modal fade" id="myModal">
            <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Admin</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
            <input type="text" name="username" placeholder="Username" class="form-control" required>
            <br>
            <input type="password" name="password" placeholder="Password" class="form-control" required>
            <br>
            <button type="submit" class="btn btn-primary" name="addadmin">Submit</button>
            </div>
            </form>

        </div>
        </div>
    </div>
</html>

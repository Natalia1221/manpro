<?php
require 'function.php';
require 'cek.php'; 

//Mendapatkan ID Barang yg dipassing di halaman sebelumnya 
$idbarang = $_GET['id']; //get id barang

//Get informasi barang berdasarkan DB
$get = mysqli_query($conn,"select * from stock where idbarang = '$idbarang'");
$fetch = mysqli_fetch_assoc($get);

//set variable
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];

 //cek apakah ada gambar atau tidak
 $gambar = $fetch['image']; //ambil gambar
 if($gambar==null){
     //jika tidak ada gambar
     $img = 'No Photo';
 } else {
     //jika ada gambar
     $img = '<img src="images/'.$gambar.'" class="zoomable">';
 }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 200px;
                height: 200px;
            }
            .zoomable:hover{
                transform: scale(1.5);
                transition: 0.5s ease;
            }
        </style>
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
                        <h1 class="mt-4">Detail Barang</h1>
                       <!-- Tambahkan card untuk total barang -->
                       <div class="row">
                       <div class="container">
                        
                    </div>

                        </div>
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <h3><?=$namabarang;?></h3>
                                <?=$img;?>
                            </div>
                            <div class="card-body">

                            <div class="row">
                                <div class="col md-3">Deskripsi</div>
                                <div class="col md-9">: <?=$deskripsi;?></div>
                            </div>

                            <div class="row">
                                <div class="col md-3">Stock</div>
                                <div class="col md-9">: <?=$stock;?></div>
                            </div>

                            <br><hr>

                                <h3>Barang Masuk</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $ambildatamasuk = mysqli_query($conn,"select * from masuk where idbarang='$idbarang'");
                                                $i = 1;

                                                while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                                    $tanggal = $fetch['tanggal'];
                                                    $keterangan = $fetch['keterangan'];
                                                    $jumlah = $fetch['jumlah'];
                                            
                                            ?>

                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$keterangan;?></td>
                                                <td><?=$jumlah;?></td>
                                            </tr>

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
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
            <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
            <br>
            <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
            <br>
            <input type="number" name="stock" placeholder="Jumlah Barang" class="form-control" required>
            <br>
            <input type="file" name="file" class="form-control">
            <br>
            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
            </div>
            </form>

        </div>
        </div>
    </div>
</html>

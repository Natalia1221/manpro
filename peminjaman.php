<?php
require 'function.php';
require 'cek.php';

if(isset($_POST['barangpeminjaman'])){
    $barangnya = $_POST['barangnya'];
    $jumlah = $_POST['jumlah'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $peminjam = $_POST['peminjam'];
    $no_telepon = $_POST['no_telepon'];

    $query = "INSERT INTO peminjaman (idbarang, jumlah, penanggung_jawab, peminjam, no_telepon, status) VALUES ('$barangnya','$jumlah','$penanggung_jawab','$peminjam','$no_telepon','Belum dikembalikan')";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: peminjaman.php");
        die();
    }else{
        echo "Gagal menambahkan data peminjaman.";
    }
}

if(isset($_POST['updatepeminjaman'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi' WHERE idbarang='$idbrg'";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: peminjaman.php");
        die();
    }else{
        echo "Gagal mengupdate data peminjaman.";
    }
}

if(isset($_POST['hapuspeminjaman'])){
    $idpeminjaman = $_POST['idpeminjaman'];

    $query = "DELETE FROM peminjaman WHERE idpeminjaman='$idpeminjaman'";
    $result = mysqli_query($conn, $query);

    if($result){
        header("Location: peminjaman.php");
        die();
    }else{
        echo "Gagal menghapus data peminjaman.";
    }
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
    <title>Data Peminjaman</title>
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
                        <span style="font-size: 20px; display: block;">Inventaris</span>
                        <span style="font-size: 10px; display: block;">Lab SCR</span>
                    </div>
            </div>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
       
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
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
                <a class="nav-link" href="peminjaman.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                    Data Peminjaman
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
                    <h1 class="mt-4">Data Peminjaman</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                        <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Tambah Data Peminjaman
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Bentuk Peminjaman</th>
                                            <th>Jumlah</th>
                                            <th>Penanggung Jawab</th>
                                            <th>Peminjam</th>
                                            <th>No Telepon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $ambilsemuadatastock = mysqli_query($conn,"SELECT p.*, s.namabarang FROM peminjaman p JOIN stock s ON s.idbarang = p.idbarang ORDER BY p.idpeminjaman DESC");
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $jumlah = $data['jumlah'];
                                            $penanggungjawab = $data['penanggung_jawab'];
                                            $peminjam = $data['peminjam'];
                                            $no_telepon = $data['no_telepon'];
                                            $status = $data['status'];
                                            $idbrg = $data['idbarang'];
                                            $idpeminjaman = $data['idpeminjaman'];
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td><?=$penanggungjawab;?></td>
                                            <td><?=$peminjam;?></td>
                                            <td><?=$no_telepon;?></td>
                                            <td><?=$status;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idpeminjaman?>">
                                                Edit
                                                </button>
                                                <input type="hidden" name="idpeminjamanygmaudihapus" value="<?=$idpeminjaman?>"> 
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idpeminjaman?>">
                                                Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- The Modal -->
                                        <div class="modal fade" id="edit<?=$idpeminjaman;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Update Data Peminjaman</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <form method="post">
                                            <div class="modal-body">
                                                <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
                                                <br>
                                                <input type="text" name="deskripsi" value="<?=$jumlah;?>" class="form-control" required>
                                                <br>
                                                <button type="submit" class="btn btn-primary" name="updatepeminjaman">Submit</button>
                                            </div>
                                            </form>

                                            </div>
                                        </div>
                                        </div>


                                        <?php
                                        };
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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

<!-- The Modal -->
<div class="modal" id="myModal">
<div class="modal-dialog">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data Peminjaman</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
    <form method="post">
    <?php
    $ambilsemuadatanya = mysqli_query($conn,"SELECT * FROM stock");
    ?>
        <select name="barangnya" class="form-control">
        <?php
        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
            $namabarangnya = $fetcharray['namabarang'];
            $idbarangnya = $fetcharray['idbarang'];
        ?>
            <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
        <?php
        }
        ?>
        </select>
        <br>
        <input type="number" name="jumlah" placeholder="Jumlah" class="form-control" required>
        <br>
        <input type="text" name="penanggung_jawab" placeholder="Penanggung Jawab" class="form-control" required>
        <br>
        <input type="text" name="peminjam" placeholder="Peminjam" class="form-control" required>
        <br>
        <input type="text" name="no_telepon" placeholder="No Telepon" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary" name="barangpeminjaman">Submit</button>
    </form>
    </div>

    </div>
</div>
</div>

<!-- The Modal -->
<?php
    $ambilsemuadatastock = mysqli_query($conn,"SELECT * FROM stock");
    while($data=mysqli_fetch_array($ambilsemuadatastock)){
        $idb = $data['idbarang'];
?>
<div class="modal" id="delete<?=$idb;?>">
<div class="modal-dialog">
    <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
        <h4 class="modal-title">Hapus Barang?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
        Apakah Anda yakin ingin menghapus <?=$namabarang;?>
        <br>
        <br>
        <form method="post">
        <input type="hidden" name="idb" value="<?=$idb;?>">
        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
        </form>
    </div>

    </div>
</div>
</div>
<?php
};
?>

</html>

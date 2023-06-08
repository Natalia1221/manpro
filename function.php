<?php
session_start();

//Membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","lb_scr");

// Fungsi untuk menghitung total barang
function getTotalBarang()
{
    global $conn;
    $query = "SELECT COUNT(*) AS total FROM stock";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// Fungsi untuk menghitung total barang masuk
function getTotalBarangMasuk()
{
    global $conn;
    $query = "SELECT SUM(stock) AS total FROM stock";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

//Fungsi untuk menghitung total peminjaman
function getTotalPeminjaman()
{
    global $conn;
    $query = "SELECT COUNT(*) AS total FROM peminjaman";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// Fungsi untuk menghitung total barang peminjaman
function getTotalBarangPeminjaman()
{
    global $conn;
    $query = "SELECT SUM(jumlah) AS total FROM peminjaman";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

//Menambah data baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //bagian gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //mengambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //mengambil ekstensinya
    $ukuran = $_FILES['file']['size']; //mengambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi filenya

    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yg dienkripsi dgn ekstensinya

    //proses upload gambar
    if(in_array($ekstensi, $allowed_extension) === true){
        //validasi ukuran filenya
        if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'images/'.$image);

            $addtotable = mysqli_query($conn,"insert into stock (namabarang, deskripsi, stock, image) values('$namabarang','$deskripsi','$stock','$image')");
            if($addtotable){
                header('location:index.php');
            } else {
                echo 'Gagal';
                header('location:index.php');
            }
        } else {
            //file lebih dari 1.5 MB
            echo '
            <script>
                alert("Ukuran terlalu besar");
                window.locatio.href="index.php";
            </script>
            ';
        }
    } else {
        //jika filenya tidak jpg/png
        echo '
            <script>
                alert("File harus png/jpg");
                window.locatio.href="index.php";
            </script>
            ';
    }

    
};

//Menambah barang masuk
if(isset($_POST['addbarangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$jumlah;

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, jumlah, penerima, keterangan) values('$barangnya','$jumlah','$penerima','$keterangan')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Menambah barang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $jumlah = $_POST['jumlah'];

    $cekstocksekarang = mysqli_query($conn,"select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$jumlah;

    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, jumlah, penerima) values('$barangnya','$jumlah','$penerima')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock ='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:peminjaman.php');
    } else {
        echo 'Gagal';
        header('location:peminjaman.php');
    }
}

//Update info barang Dashboard
if(isset($_POST['updatebarang'])){
    $idbrg = $_POST['idbrg'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    
    //bagian gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //mengambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //mengambil ekstensinya
    $ukuran = $_FILES['file']['size']; //mengambil size filenya
    $file_tmp = $_FILES['file']['tmp_name']; //mengambil lokasi filenya
 
    //penamaan file -> enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yg dienkripsi dgn ekstensinya

    if($ukuran==0){
        //jika tdk ingin upload
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang ='$idbrg'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
    }
    } else {
        //jika ingin
        move_uploaded_file($file_tmp, 'images/'.$image);
        $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang ='$idbrg'");
        if($update){
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
    }
    }
}

//Menghapus Item Dashboard
if(isset($_POST['hapusbarang'])){
    $idbrg = $_POST['idbrg'];

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idbrg'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn,"delete from stock where idbarang ='$idbrg'");
    if($delete){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//Update Data Barang Masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idbrg = $_POST['idbrg'];
    $idm = $_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbrg'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stocksekarang = $stocknya['stock'];

    $jumlahskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $jumlahnya = mysqli_fetch_array($jumlahskrg);
    $jumlahskrg = $jumlahnya['jumlah'];

    if ($jumlah > $jumlahskrg) {
        $selisih = $jumlah - $jumlahskrg;
        $kurangi = $stocksekarang - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangi' WHERE idbarang='$idbrg'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET jumlah='$jumlah', keterangan='$keterangan' WHERE idmasuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
        } else {
            echo 'Gagal';
            header('Location: masuk.php');
        }
    } else {
        $selisih = $jumlahskrg - $jumlah;
        $kurangi = $stocksekarang + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock SET stock='$kurangi' WHERE idbarang='$idbrg'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET jumlah='$jumlah', keterangan='$keterangan' WHERE idmasuk='$idm'");

        if ($kurangistocknya && $updatenya) {
            header('Location: masuk.php');
        } else {
            echo 'Gagal';
            header('Location: masuk.php');
        }
    }
}

// Menghapus Barang Masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idbrg = $_POST['idbrg'];
    $jumlah = $_POST['jumlah'];
    $idm = $_POST['idm'];
    $keterangan = $_POST['keterangan'];

    // Ambil data stok barang
    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbrg'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    // Hitung selisih stok setelah penghapusan barang masuk
    $selisih = $stok - $jumlah;

    // Update stok barang
    $updating = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idbrg'");
    
    // Hapus data barang masuk
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk = '$idm'");

    if ($updating && $hapusdata) {
        header('location: masuk.php');
    } else {
        header('location: masuk.php');
    }
}


//Menambah Data Peminjaman
if(isset($_POST['pinjam'])){
    $idbarang = $_POST['barangnya'];
    $idp = $_POST['idpeminjaman'];
    $jumlah = $_POST['jumlah'];
    $peminjam = $_POST['peminjam'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $nohp = $_POST['no_telepon'];

    //ambil stock sekarang
    $stok_terkini = mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
    $stok_nya = mysqli_fetch_array($stok_terkini);
    $stok = $stok_nya['stock'];

    //mengurangi stock
    $new_stock = $stok-$jumlah;

    //mulai query database
    $insertpinjam = mysqli_query($conn, "INSERT INTO peminjaman (idbarang,jumlah,peminjam,no_telepon,penanggung_jawab) 
    values('$idbarang','$jumlah','$peminjam','$nohp','$penanggung_jawab')");

    //mengurangi stock ditable dashboard
    $kurangistock = mysqli_query($conn, "update stock set stock='$new_stock' where idbarang='$idbarang'");

    if($insertpinjam&&$kurangistock){
        //jika berhasil
        echo '
            <script>
                alert("Berhasil");
                window.locatio.href="peminjaman.php";
            </script>
            ';
    } else {
        //jika gagal
        echo '
            <script>
                alert("Gagal");
                window.locatio.href="peminjaman.php";
            </script>
            ';
    }
}

// Menyelesaikan Peminjaman
if(isset($_POST['barangkembali'])){
    $idpeminjaman = $_POST['idpeminjaman'];
    $idbarang = $_POST['idbarang'];

    // Eksekusi
    $update_status = mysqli_query($conn, "UPDATE peminjaman SET status='Kembali' WHERE idpeminjaman='$idpeminjaman'");

    if($update_status){
        // Ambil data jumlah dari id peminjaman
        $stok_peminjaman = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman='$idpeminjaman'");
        $stok_peminjamannya = mysqli_fetch_array($stok_peminjaman);
        $jumlah_peminjaman = $stok_peminjamannya['jumlah'];

        // Ambil stock sekarang
        $stok_saat_ini = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
        $stok_nya = mysqli_fetch_array($stok_saat_ini);
        $stok = $stok_nya['stock'];

        // Mengembalikan stock
        $new_stock = $stok + $jumlah_peminjaman;

        // Update stock
        $kembalikan_stock = mysqli_query($conn, "UPDATE stock SET stock='$new_stock' WHERE idbarang='$idbarang'");

        if($kembalikan_stock){
            // Jika berhasil
            echo '
                <script>
                    alert("Berhasil");
                    window.location.href="peminjaman.php";
                </script>
                ';
        } else {
            // Jika gagal mengembalikan stock
            echo '
                <script>
                    alert("Gagal mengembalikan stock");
                    window.location.href="peminjaman.php";
                </script>
                ';
        }
    } else {
        // Jika gagal mengupdate status peminjaman
        echo '
            <script>
                alert("Gagal mengupdate status peminjaman");
                window.location.href="peminjaman.php";
            </script>
            ';
    }
}



//Tambah Admin Baru
if(isset($_POST['addadmin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn,"insert into login (username, password) values ('$username','$password')");

    if($queryinsert){
        //if berhasil
        header('location:admin.php');
    } else {
        //jika gagal insert ke database
        header('location:admin.php');
    }
}

//Edit Data Admin
if(isset($_POST['updateadmin'])){
    $usernamebaru = $_POST['usernameadmin'];
    $passwordbaru = $_POST['passwordadmin'];
    $idnya = $_POST['id'];

    $queryupdate = mysqli_query($conn,"update login set username='$usernamebaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

//Hapus Data Admin
if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn, "DELETE FROM login WHERE iduser='$id'");

    if($querydelete){
        header('location:admin.php');
    } else {
        header('location:admin.php');
    }
}

//Meminjam Barang
?>
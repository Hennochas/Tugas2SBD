<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$idSiswa           = "";
$namaSiswa         = "";
$tanggalLahirSiswa = "";
$alamatSiswa       = "";
$noTelpSiswa       = "";
$sukses            = "";
$error             = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['idSiswa'];
   $sql1 = "delete from siswa where idSiswa = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $idSiswa = $_GET['idSiswa'];
    $sql1 = "select * from siswa where idSiswa = '$idSiswa'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $idSiswa = $r1['idSiswa'];
    $namaSiswa = $r1['namaSiswa'];
    $tanggalLahirSiswa = $r1['tanggalLahirSiswa'];
    $alamatSiswa = $r1['alamatSiswa'];
    $noTelpSiswa = $r1['noTelpSiswa'];

    if($idSiswa ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $idSiswa = $_POST['idSiswa'];
    $namaSiswa = $_POST['namaSiswa'];
    $tanggalLahirSiswa = $_POST['tanggalLahirSiswa'];
    $alamatSiswa = $_POST['alamatSiswa'];
    $noTelpSiswa = $_POST['noTelpSiswa'];
    if($idSiswa && $namaSiswa && $tanggalLahirSiswa && $alamatSiswa && $noTelpSiswa){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update siswa set namaSiswa = '$namaSiswa',tanggalLahirSiswa = '$tanggalLahirSiswa',alamatSiswa = '$alamatSiswa',noTelpSiswa = '$noTelpSiswa' where idSiswa = '$idSiswa'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into siswa(idSiswa,namaSiswa,tanggalLahirSiswa,alamatSiswa,noTelpSiswa) values('$idSiswa','$namaSiswa','$tanggalLahirSiswa','$alamatSiswa','$noTelpSiswa')";
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1){// Untuk Insert
                $sukses = "Berhasil Memasukkan Data !";
            }else{
                $error = "Gagal memasukkan Data !";
            }
        }
    }else{
        $error = "Silahkan Masukkan Semua Data !";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }

        .mb-3 {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                CRUD TABLE (SISWA)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;siswa.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;siswa.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="idSiswa" class="form-label">ID Siswa</label>
                        <input type="text" class="form-control" id="idSiswa" name= "idSiswa" value="<?php echo $idSiswa ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="namaSiswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="namaSiswa" name="namaSiswa" value="<?php echo $namaSiswa ?>">
                        <div class="form-text">Max 50 Char</div>
                    <div class="mb-3">
                        <label for="tanggalLahirSiswa" class="form-label">Tanggal Lahir Siswa</label>
                        <input type="text" class="form-control" id="tanggalLahirSiswa" name="tanggalLahirSiswa" value="<?php echo $tanggalLahirSiswa ?>">
                        <div class="form-text">YYYY-MM-DD</div>
                    <div class="mb-3">
                        <label for="alamatSiswa" class="form-label">Alamat Siswa</label>
                        <input type="text" class="form-control" id="alamatSiswa"name="alamatSiswa" value="<?php echo $alamatSiswa ?>">
                        <div class="form-text">Max 250 Char</div>
                    <div class="mb-3">
                        <label for="noTelpSiswa" class="form-label">Nomor Telepon Siswa</label>
                        <input type="text" class="form-control" id="noTelpSiswa" name="noTelpSiswa" value="<?php echo $noTelpSiswa ?>">
                        <div class="form-text">Max 13 Angka</div>
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Siswa
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">ID Siswa</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Tanggal Lahir Siswa</th>
                            <th scope="col">Alamat Siswa</th>
                            <th scope="col">No. Telp Siswa</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from siswa order by idSiswa asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $idSiswa = $r2['idSiswa'];
                                $namaSiswa = $r2['namaSiswa'];
                                $tanggalLahirSiswa = $r2['tanggalLahirSiswa'];
                                $alamatSiswa = $r2['alamatSiswa'];
                                $noTelpSiswa = $r2['noTelpSiswa'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $idSiswa ?></td>
                                    <td scope = "row"><?php echo $namaSiswa ?></td>
                                    <td scope = "row"><?php echo $tanggalLahirSiswa ?></td>
                                    <td scope = "row"><?php echo $alamatSiswa ?></td>
                                    <td scope = "row"><?php echo $noTelpSiswa ?></td>
                                    <td scope = "row">
                                        <a href="siswa.php?op=edit&idSiswa=<?php echo $idSiswa?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="siswa.php?op=delete&idSiswa=<?php echo $idSiswa?>"onclick="return confirm('Yakin mau delete data')">
                                            <button type = "button" class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php 

                            } 
                            ?>
                        </tbody>
                    </thead>
                </table> 
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
</body>

</html>
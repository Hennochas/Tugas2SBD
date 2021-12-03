<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$idPresensi             = "";
$IdKelasMapel           = "";
$pertemuanKe            = "";
$idSiswa                = "";
$tanggalPertemuan       = "";
$idGuru                 = "";
$sukses                 = "";
$error                  = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['idPresensi'];
   $sql1 = "delete from presensi where idPresensi = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $idPresensi = $_GET['idPresensi'];
    $sql1 = "select * from presensi where idPresensi = '$idPresensi'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $idPresensi = $r1['idPresensi'];
    $IdKelasMapel = $r1['IdKelasMapel'];
    $pertemuanKe = $r1['pertemuanKe'];
    $idSiswa = $r1['idSiswa'];
    $tanggalPertemuan = $r1['tanggalPertemuan'];
    $idGuru = $r1['idGuru'];

    if($idPresensi ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $idPresensi = $_POST['idPresensi'];
    $IdKelasMapel = $_POST['IdKelasMapel'];
    $pertemuanKe = $_POST['pertemuanKe'];
    $idSiswa = $_POST['idSiswa'];
    $tanggalPertemuan = $_POST['tanggalPertemuan'];
    $idGuru = $_POST['idGuru'];
    if($idPresensi && $IdKelasMapel && $pertemuanKe && $idSiswa && $tanggalPertemuan && $idGuru){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update presensi set IdKelasMapel = '$IdKelasMapel',pertemuanKe = '$pertemuanKe',idSiswa = '$idSiswa',tanggalPertemuan = '$tanggalPertemuan', idGuru = '$idGuru' where idPresensi = '$idPresensi'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into presensi(idPresensi,IdKelasMapel,pertemuanKe,idSiswa,tanggalPertemuan,idGuru) values('$idPresensi','$IdKelasMapel','$pertemuanKe','$idSiswa','$tanggalPertemuan','$idGuru')";
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
    <title>Guru</title>
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
                CRUD TABLE (PRESENSI)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;Presensi.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;Presensi.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="idPresensi" class="form-label">ID Presensi</label>
                        <input type="text" class="form-control" id="idPresensi" name= "idPresensi" value="<?php echo $idPresensi ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="IdKelasMapel" class="form-label">ID Kelas Mapel</label>
                        <input type="text" class="form-control" id="IdKelasMapel" name="IdKelasMapel" value="<?php echo $IdKelasMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="pertemuanKe" class="form-label">Pertemuan Ke</label>
                        <input type="text" class="form-control" id="pertemuanKe" name="pertemuanKe" value="<?php echo $pertemuanKe ?>">
                        <div class="form-text">Max 2 INT</div>
                    <div class="mb-3">
                        <label for="idSiswa" class="form-label">ID Siswa</label>
                        <input type="text" class="form-control" id="idSiswa"name="idSiswa" value="<?php echo $idSiswa ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="tanggalPertemuan" class="form-label">Tanggal Pertemuan</label>
                        <input type="text" class="form-control" id="tanggalPertemuan" name="tanggalPertemuan" value="<?php echo $tanggalPertemuan ?>">
                        <div class="form-text">YYYY-MM-DD</div>
                    <div class="mb-3">
                        <label for="idGuru" class="form-label">ID Guru</label>
                        <input type="text" class="form-control" id="idGuru" name="idGuru" value="<?php echo $idGuru ?>">
                        <div class="form-text">Max 4 Char</div>    
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Presensi
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">ID Presensi</th>
                            <th scope="col">ID Kelas Mapel</th>
                            <th scope="col">Pertemuan Ke</th>
                            <th scope="col">ID Siswa</th>
                            <th scope="col">Tanggal Pertemuan</th>
                            <th scope="col">ID Guru</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from presensi order by idPresensi asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $idPresensi = $r2['idPresensi'];
                                $IdKelasMapel = $r2['IdKelasMapel'];
                                $pertemuanKe = $r2['pertemuanKe'];
                                $idSiswa = $r2['idSiswa'];
                                $tanggalPertemuan = $r2['tanggalPertemuan'];
                                $idGuru = $r2['idGuru'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $idPresensi ?></td>
                                    <td scope = "row"><?php echo $IdKelasMapel ?></td>
                                    <td scope = "row"><?php echo $pertemuanKe ?></td>
                                    <td scope = "row"><?php echo $idSiswa ?></td>
                                    <td scope = "row"><?php echo $tanggalPertemuan ?></td>
                                    <td scope = "row"><?php echo $idGuru?></td>
                                    <td scope = "row">
                                        <a href="Presensi.php?op=edit&idPresensi=<?php echo $idPresensi?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="Presensi.php?op=delete&idPresensi=<?php echo $idPresensi?>"onclick="return confirm('Yakin mau delete data')">
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
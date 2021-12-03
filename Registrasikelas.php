<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$IdSiswa               = "";
$idKelasMapel          = "";
$nilaiAkhir            = "";
$predikat              = "";
$sukses                = "";
$error                 = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['IdSiswa'];
   $sql1 = "delete from registrasikelas where IdSiswa = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $IdSiswa = $_GET['IdSiswa'];
    $sql1 = "select * from registrasikelas where IdSiswa = '$IdSiswa'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $IdSiswa = $r1['IdSiswa'];
    $idKelasMapel = $r1['idKelasMapel'];
    $nilaiAkhir = $r1['nilaiAkhir'];
    $predikat = $r1['predikat'];

    if($IdSiswa ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $IdSiswa = $_POST['IdSiswa'];
    $idKelasMapel = $_POST['idKelasMapel'];
    $nilaiAkhir = $_POST['nilaiAkhir'];
    $predikat = $_POST['predikat'];
    if($IdSiswa && $idKelasMapel && $nilaiAkhir && $predikat ){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update registrasikelas set idKelasMapel = '$idKelasMapel',nilaiAkhir = '$nilaiAkhir',predikat = '$predikat' where IdSiswa = '$IdSiswa'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into registrasikelas(IdSiswa,idKelasMapel,nilaiAkhir,predikat) values('$IdSiswa','$idKelasMapel','$nilaiAkhir','$predikat')";
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
    <title>Kelas Mapel</title>
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
                CRUD TABLE (REGISTRASI KELAS)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;Registrasikelas.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;Registrasikelas.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="IdSiswa" class="form-label">ID Siswa</label>
                        <input type="text" class="form-control" id="IdSiswa" name= "IdSiswa" value="<?php echo $IdSiswa ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="idKelasMapel" class="form-label">ID Kelas Mapel</label>
                        <input type="text" class="form-control" id="idKelasMapel" name="idKelasMapel" value="<?php echo $idKelasMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="nilaiAkhir" class="form-label">Nilai Akhir</label>
                        <input type="text" class="form-control" id="nilaiAkhir" name="nilaiAkhir" value="<?php echo $nilaiAkhir ?>">
                        <div class="form-text">Max 3 INT</div>
                    <div class="mb-3">
                        <label for="predikat" class="form-label">Predikat</label>
                        <input type="text" class="form-control" id="predikat"name="predikat" value="<?php echo $predikat ?>">
                        <div class="form-text">Max 2 Char</div>
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
                            <th scope="col">Predikat</th>
                            <th scope="col">Nilai Akhir</th>
                            <th scope="col">Predikat</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from registrasikelas order by IdSiswa asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $IdSiswa = $r2['IdSiswa'];
                                $idKelasMapel = $r2['idKelasMapel'];
                                $nilaiAkhir = $r2['nilaiAkhir'];
                                $predikat = $r2['predikat'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $IdSiswa ?></td>
                                    <td scope = "row"><?php echo $idKelasMapel ?></td>
                                    <td scope = "row"><?php echo $nilaiAkhir ?></td>
                                    <td scope = "row"><?php echo $predikat ?></td>
                                    <td scope = "row">
                                        <a href="Registrasikelas.php?op=edit&IdSiswa=<?php echo $IdSiswa?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="Registrasikelas.php?op=delete&IdSiswa=<?php echo $IdSiswa?>"onclick="return confirm('Yakin mau delete data')">
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
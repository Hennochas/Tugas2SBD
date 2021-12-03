<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$IdJadwal               = "";
$hari                   = "";
$sesi                   = "";
$IdKelasMapel           = "";
$sukses                 = "";
$error                  = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['IdJadwal'];
   $sql1 = "delete from jadwal where IdJadwal = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $IdJadwal = $_GET['IdJadwal'];
    $sql1 = "select * from jadwal where IdJadwal = '$IdJadwal'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $IdJadwal = $r1['IdJadwal'];
    $hari = $r1['hari'];
    $sesi = $r1['sesi'];
    $IdKelasMapel = $r1['IdKelasMapel'];

    if($IdJadwal ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $IdJadwal = $_POST['IdJadwal'];
    $hari = $_POST['hari'];
    $sesi = $_POST['sesi'];
    $IdKelasMapel = $_POST['IdKelasMapel'];
    if($IdJadwal && $hari && $sesi && $IdKelasMapel ){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update jadwal set hari = '$hari',sesi = '$sesi',IdKelasMapel = '$IdKelasMapel' where IdJadwal = '$IdJadwal'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into jadwal(IdJadwal,hari,sesi,IdKelasMapel) values('$IdJadwal','$hari','$sesi','$IdKelasMapel')";
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
                CRUD TABLE (JADWAL)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;Jadwal.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;Jadwal.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="IdJadwal" class="form-label">ID Jadwal</label>
                        <input type="text" class="form-control" id="IdJadwal" name= "IdJadwal" value="<?php echo $IdJadwal ?>">
                        <div class="form-text">Max 11 INT</div>
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari" value="<?php echo $hari ?>">
                        <div class="form-text">Max 15 Char</div>
                    <div class="mb-3">
                        <label for="sesi" class="form-label">Sesi</label>
                        <input type="text" class="form-control" id="sesi" name="sesi" value="<?php echo $sesi ?>">
                        <div class="form-text">Max 1 INT</div>
                    <div class="mb-3">
                        <label for="IdKelasMapel" class="form-label">ID Kelas Mapel</label>
                        <input type="text" class="form-control" id="IdKelasMapel"name="IdKelasMapel" value="<?php echo $IdKelasMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Jadwal
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">ID Jadwal</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Sesi</th>
                            <th scope="col">ID Kelas Mapel</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from jadwal order by IdJadwal asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $IdJadwal = $r2['IdJadwal'];
                                $hari = $r2['hari'];
                                $sesi = $r2['sesi'];
                                $IdKelasMapel = $r2['IdKelasMapel'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $IdJadwal ?></td>
                                    <td scope = "row"><?php echo $hari ?></td>
                                    <td scope = "row"><?php echo $sesi ?></td>
                                    <td scope = "row"><?php echo $IdKelasMapel ?></td>
                                    <td scope = "row">
                                        <a href="Jadwal.php?op=edit&IdJadwal=<?php echo $IdJadwal?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="Jadwal.php?op=delete&IdJadwal=<?php echo $IdJadwal?>"onclick="return confirm('Yakin mau delete data')">
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
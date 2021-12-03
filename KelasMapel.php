<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$IdKelasMapel           = "";
$kodeMapel              = "";
$kelas                  = "";
$IdGuru                 = "";
$sukses                 = "";
$error                  = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['IdKelasMapel'];
   $sql1 = "delete from kelasmapel where IdKelasMapel = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $IdKelasMapel = $_GET['IdKelasMapel'];
    $sql1 = "select * from kelasmapel where IdKelasMapel = '$IdKelasMapel'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $IdKelasMapel = $r1['IdKelasMapel'];
    $kodeMapel = $r1['kodeMapel'];
    $kelas = $r1['kelas'];
    $IdGuru = $r1['IdGuru'];

    if($IdKelasMapel ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $IdKelasMapel = $_POST['IdKelasMapel'];
    $kodeMapel = $_POST['kodeMapel'];
    $kelas = $_POST['kelas'];
    $IdGuru = $_POST['IdGuru'];
    if($IdKelasMapel && $kodeMapel && $kelas && $IdGuru ){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update kelasmapel set kodeMapel = '$kodeMapel',kelas = '$kelas',IdGuru = '$IdGuru' where IdKelasMapel = '$IdKelasMapel'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into kelasmapel(IdKelasMapel,kodeMapel,kelas,IdGuru) values('$IdKelasMapel','$kodeMapel','$kelas','$IdGuru')";
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
                CRUD TABLE (KELAS MAPEL)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;KelasMapel.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;KelasMapel.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="IdKelasMapel" class="form-label">ID Kelas Mapel</label>
                        <input type="text" class="form-control" id="IdKelasMapel" name= "IdKelasMapel" value="<?php echo $IdKelasMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="kodeMapel" class="form-label">Kode Mapel</label>
                        <input type="text" class="form-control" id="kodeMapel" name="kodeMapel" value="<?php echo $kodeMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $kelas ?>">
                        <div class="form-text">Max 50 Char</div>
                    <div class="mb-3">
                        <label for="IdGuru" class="form-label">ID Guru</label>
                        <input type="text" class="form-control" id="IdGuru"name="IdGuru" value="<?php echo $IdGuru ?>">
                        <div class="form-text">Max 4 Char</div>
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Kelas Mapel
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">ID Kelas Mapel</th>
                            <th scope="col">Kode Mapel</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">ID Guru</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from kelasmapel order by IdKelasMapel asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $IdKelasMapel = $r2['IdKelasMapel'];
                                $kodeMapel = $r2['kodeMapel'];
                                $kelas = $r2['kelas'];
                                $IdGuru = $r2['IdGuru'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $IdKelasMapel ?></td>
                                    <td scope = "row"><?php echo $kodeMapel ?></td>
                                    <td scope = "row"><?php echo $kelas ?></td>
                                    <td scope = "row"><?php echo $IdGuru ?></td>
                                    <td scope = "row">
                                        <a href="KelasMapel.php?op=edit&IdKelasMapel=<?php echo $IdKelasMapel?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="KelasMapel.php?op=delete&IdKelasMapel=<?php echo $IdKelasMapel?>"onclick="return confirm('Yakin mau delete data')">
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
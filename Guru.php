<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$IdGuru           = "";
$namaGuru         = "";
$tanggalLahirGuru = "";
$alamatGuru       = "";
$noTelpGuru       = "";
$sukses            = "";
$error             = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['IdGuru'];
   $sql1 = "delete from guru where IdGuru = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $IdGuru = $_GET['IdGuru'];
    $sql1 = "select * from guru where IdGuru = '$IdGuru'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $IdGuru = $r1['IdGuru'];
    $namaGuru = $r1['namaGuru'];
    $tanggalLahirGuru = $r1['tanggalLahirGuru'];
    $alamatGuru = $r1['alamatGuru'];
    $noTelpGuru = $r1['noTelpGuru'];

    if($IdGuru ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $IdGuru = $_POST['IdGuru'];
    $namaGuru = $_POST['namaGuru'];
    $tanggalLahirGuru = $_POST['tanggalLahirGuru'];
    $alamatGuru = $_POST['alamatGuru'];
    $noTelpGuru = $_POST['noTelpGuru'];
    if($IdGuru && $namaGuru && $tanggalLahirGuru && $alamatGuru && $noTelpGuru){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update guru set namaGuru = '$namaGuru',tanggalLahirGuru = '$tanggalLahirGuru',alamatGuru = '$alamatGuru',noTelpGuru = '$noTelpGuru' where IdGuru = '$IdGuru'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into guru(IdGuru,namaGuru,tanggalLahirGuru,alamatGuru,noTelpGuru) values('$IdGuru','$namaGuru','$tanggalLahirGuru','$alamatGuru','$noTelpGuru')";
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
                CRUD TABLE (GURU)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;Guru.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;Guru.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="IdGuru" class="form-label">ID Guru</label>
                        <input type="text" class="form-control" id="IdGuru" name= "IdGuru" value="<?php echo $IdGuru ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="namaGuru" class="form-label">Nama Guru</label>
                        <input type="text" class="form-control" id="namaGuru" name="namaGuru" value="<?php echo $namaGuru ?>">
                        <div class="form-text">Max 50 Char</div>
                    <div class="mb-3">
                        <label for="tanggalLahirGuru" class="form-label">Tanggal Lahir Guru</label>
                        <input type="text" class="form-control" id="tanggalLahirGuru" name="tanggalLahirGuru" value="<?php echo $tanggalLahirGuru ?>">
                        <div class="form-text">YYYY-MM-DD</div>
                    <div class="mb-3">
                        <label for="alamatGuru" class="form-label">Alamat Guru</label>
                        <input type="text" class="form-control" id="alamatGuru"name="alamatGuru" value="<?php echo $alamatGuru ?>">
                        <div class="form-text">Max 250 Char</div>
                    <div class="mb-3">
                        <label for="noTelpGuru" class="form-label">Nomor Telepon Guru</label>
                        <input type="text" class="form-control" id="noTelpGuru" name="noTelpGuru" value="<?php echo $noTelpGuru ?>">
                        <div class="form-text">Max 13 Angka</div>
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Guru
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">ID Guru</th>
                            <th scope="col">Nama Guru</th>
                            <th scope="col">Tanggal Lahir Guru</th>
                            <th scope="col">Alamat Guru</th>
                            <th scope="col">No. Telp Guru</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from guru order by IdGuru asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $IdGuru = $r2['IdGuru'];
                                $namaGuru = $r2['namaGuru'];
                                $tanggalLahirGuru = $r2['tanggalLahirGuru'];
                                $alamatGuru = $r2['alamatGuru'];
                                $noTelpGuru = $r2['noTelpGuru'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $IdGuru ?></td>
                                    <td scope = "row"><?php echo $namaGuru ?></td>
                                    <td scope = "row"><?php echo $tanggalLahirGuru ?></td>
                                    <td scope = "row"><?php echo $alamatGuru ?></td>
                                    <td scope = "row"><?php echo $noTelpGuru ?></td>
                                    <td scope = "row">
                                        <a href="Guru.php?op=edit&IdGuru=<?php echo $IdGuru?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="Guru.php?op=delete&IdGuru=<?php echo $IdGuru?>"onclick="return confirm('Yakin mau delete data')">
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
<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$kodeMapel           = "";
$namaMapel           = "";
$sukses             = "";
$error              = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if ($op == 'delete'){
   $op = $_GET['kodeMapel'];
   $sql1 = "delete from mapel where kodeMapel = '$op'";
   $q1 = mysqli_query($koneksi,$sql1);
   if($q1){
       $sukses = "Berhasil Hapus Data";
   }else{
       $error = "Gagal menghapus data";
   }

}

if($op == 'edit'){
    $kodeMapel = $_GET['kodeMapel'];
    $sql1 = "select * from mapel where kodeMapel = '$kodeMapel'";
    $q1 = mysqli_query($koneksi,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $kodeMapel = $r1['kodeMapel'];
    $namaMapel = $r1['namaMapel'];

    if($kodeMapel ==''){
        $error = "Data Tidak Ditemukan";      
    }
}


if(isset($_POST['Simpan'])){ //Untuk create
    $kodeMapel = $_POST['kodeMapel'];
    $namaMapel = $_POST['namaMapel'];
    if($kodeMapel && $namaMapel ){
        if($op == 'edit'){// Untuk Update
            $sql1 = "update mapel set namaMapel = '$namaMapel' where kodeMapel = '$kodeMapel'";
            $q1 = mysqli_query($koneksi,$sql1); 
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{
            $sql1 = "insert into mapel(kodeMapel,namaMapel) values('$kodeMapel','$namaMapel')";
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
    <title>Mapel</title>
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
                CRUD TABLE (MAPEL)
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:3;Mapel.php");
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:3;Mapel.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="kodeMapel" class="form-label">Kode Mapel</label>
                        <input type="text" class="form-control" id="kodeMapel" name= "kodeMapel" value="<?php echo $kodeMapel ?>">
                        <div class="form-text">Max 4 Char</div>
                    <div class="mb-3">
                        <label for="namaMapel" class="form-label">Nama Mapel</label>
                        <input type="text" class="form-control" id="namaMapel" name="namaMapel" value="<?php echo $namaMapel ?>">
                        <div class="form-text">Max 25 Char</div>
                </form>
                <div class="col-12">
                    <input type="submit" name="Simpan" value="Simpan Data" class="btn btn-primary">
                </div>
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Tabel Mapel
                </div>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">Kode Mapel</th>
                            <th scope="col">Nama Mapel</th>
                            <th scope="col">Action</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from mapel order by kodeMapel asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $kodeMapel = $r2['kodeMapel'];
                                $namaMapel = $r2['namaMapel'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $kodeMapel ?></td>
                                    <td scope = "row"><?php echo $namaMapel ?></td>
                                    <td scope = "row">
                                        <a href="Mapel.php?op=edit&kodeMapel=<?php echo $kodeMapel?>">
                                            <button type ="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        <a href="Mapel.php?op=delete&kodeMapel=<?php echo $kodeMapel?>"onclick="return confirm('Yakin mau delete data')">
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
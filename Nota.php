<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas2sbd";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$Iuran              = "";
$idSiswa            = "";
$Tanggal            = "";
$Harga              = "";
$Keterangan         = "";
$sukses             = "";
$error              = "";

if(isset($_POST['Cari'])){ //Untuk create
    $idSiswa = $_POST['idSiswa'];
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
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
        }
        .form-text {
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                NOTA
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                
                }
                ?>
                <table class= "table">
                    <thead>
                        <tr>
                            <th scope="col">Iuran</th>
                            <th scope="col">ID Siswa</th>
                            <th scope="col">Tanggal </th>
                            <th scope="col">Harga</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                        <tbody>
                            <?php
                            $x = 0;
                            $sql2 = "select * from viewtransaksi where idSiswa = '$idSiswa' order by Iuran asc";
                            $q2   = mysqli_query($koneksi,$sql2);
                            while($r2 = mysqli_fetch_array($q2)){
                                $Iuran = $x + 1;
                                $idSiswa = $r2['idSiswa'];
                                $Tanggal = $r2['Tanggal'];
                                $Harga = $r2['Harga'];
                                $Keterangan = $r2['Keterangan'];
                                
                                ?>
                                <tr>
                                    <td scope = "row"><?php echo $Iuran ?></td>
                                    <td scope = "row"><?php echo $idSiswa ?></td>
                                    <td scope = "row"><?php echo $Tanggal ?></td>
                                    <td scope = "row"><?php echo $Harga ?></td>
                                    <td scope = "row"><?php echo $Keterangan ?></td>
                                    <td scope = "row">
                                    </td>
                                </tr>
                                <?php 

                            } 
                            ?>
                        </tbody>
                    </thead>
                </table> 
            </div>

            <!-- untuk mengeluarkan data-->
            <div class="card">
            <div class="card-header text-white bg-secondary">
                    Pencaharian
                </div>
                <form action="" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="idSiswa" name= "idSiswa" value="<?php echo $idSiswa ?>">
                        <div class="form-text">Berdasarkan ID Siswa</div>
                        <a href="Nota.php?op=search&idSiswa=<?php echo $idSiswa?>">
                        <input type="submit" name="Cari" value="Cari" class="btn btn-info">
                                        </a>

                </div>
            </div>
        </div>
</body>

</html>
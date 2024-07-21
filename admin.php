<?php
require 'koneksi.php';

$tgl = date("Y-m-d");
$connection = mysqli_query($koneksi, "SELECT * FROM data_tamu WHERE tanggal LIKE '%$tgl%' ORDER BY id DESC");

if (isset($_POST['bsimpan'])) {
    $tgl = date("Y-m-d");
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $noHP = htmlspecialchars($_POST['noHP'], ENT_QUOTES);

    $simpan = mysqli_query($koneksi, "INSERT INTO data_tamu (tanggal, nama, alamat, tujuan, noHP) VALUES ('$tgl', '$nama', '$alamat', '$tujuan', '$noHP')");

    if ($simpan) {
        echo "<script>alert('Simpan data sukses'); document.location='?';</script>";
    } else {
        echo "<script>alert('Simpan data gagal'); document.location='?';</script>";
    }
}
?>

<?php

session_start();

if(empty($_SESSION['username']) or empty($_SESSION['password'])){
    echo "<script>alert('isi dahulu form di laman login'); document.location='index.php'  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buku tamu</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-success">
    <div class="container">
        <div class="head text-center">
            <img src="assets/img/undraw_rocket.svg" alt="" width="100px">
            <h2 class="text-white mt-2">buku tamu</h2>
        </div>

        <div class="row mt-2">
            <div class="col-lg-7 mb-3">
                <div class="card shadow bg-gradient-light">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Identitas pengunjung</h1>
                        </div>
                        
                        <form class="user" method="POST" action="">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="nama" placeholder="nama pengunjung" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="alamat" placeholder="alamat pengunjung" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="tujuan" placeholder="tujuan pengunjung" required>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" name="noHP" placeholder="nomor hp pengunjung" required>
                            </div>
                            <button class="btn btn-primary btn-user btn-block" type="submit" name="bsimpan">
                                simpan data
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="small">by amba | 2024 - <?= date('Y') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-3">
                <div class="card shadow ">
                    <div class="card-body">

                   

                        <div class="text-center">
                            <h4 class="h4 text-gray-900 mb-4">Statistic pengunjung</h4>
                        </div>
                        <?php

                        // deklarasi tanggal

                        $tgl_sekarang = date("Y-m-d");

                        // tgl kemarin
                        $kemarin = date("Y-m-d",strtotime('-1 day',strtotime(date("Y-m-d"))));

                        // 1 minggu yg lalu
                        $seminggu = date("Y-m-d h:i:s" , strtotime("-1 week +1 day" , strtotime($tgl_sekarang)));

                        $bulan_ini = date("m");
                        // his jam menit detik h: jam , i: menit , s : detik
                        $sekarang = date("Y-m-d h:i:s");

                        // persiapan querry tampilkan jumlah data pengunjung

                        $tgl_sekarang = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM data_tamu where tanggal like '%$tgl_sekarang%'"
                        ));
                        $kemarin = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM data_tamu where tanggal like '%$kemarin%'"
                        ));
                        $seminggu = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM data_tamu where tanggal BETWEEN '%$seminggu%' and '%$sekarang%'"
                        ));
                        $sebulan = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM data_tamu where month(tanggal) = '$bulan_ini'"
                        ));
                        $keseluruhan = mysqli_fetch_array(mysqli_query(
                            $koneksi,
                            "SELECT count(*) FROM data_tamu "
                        ));

                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td>Hari ini </td>
                                <td>: <?= $tgl_sekarang[0]?> </td>
                            </tr>
                            <tr>
                                <td>Kemarin </td>
                                <td>: <?= $kemarin[0]?> </td>
                            </tr>
                            <tr>
                                <td>Minggu ini </td>
                                <td>: <?= $seminggu[0] ?> </td>
                            </tr>
                            <tr>
                                <td>Bulan ini </td>
                                <td>: <?= $sebulan[0] ?> </td>
                            </tr>
                            <tr>
                                <td>Keseluruhan </td>
                                <td>: <?= $keseluruhan[0]?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung [<?= date("d-m-Y") ?>]</h6>
            </div>
            <div class="card-body">
            <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table"></i> rekapitulasi pengunjung</a>
            <a href="logout.php" class="btn btn-danger mb-3"><i class="fa fa-sign-out-alt"></i> logout</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No hp</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomer = 1;
                            foreach ($connection as $data):
                            ?>
                            <tr>
                                <td><?= $nomer++ ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td><?= $data['alamat'] ?></td>
                                <td><?= $data['tujuan'] ?></td>
                                <td><?= $data['noHP'] ?></td>
                                <td><?= $data['tanggal'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/demo/datatables-demo.js"></script>
</body>

</html>

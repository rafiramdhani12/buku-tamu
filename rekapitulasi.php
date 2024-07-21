<?php
require 'koneksi.php';

if (isset($_POST['bsimpan'])) {
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $noHP = htmlspecialchars($_POST['noHP'], ENT_QUOTES);
    $tgl = date("Y-m-d");

    $simpan = mysqli_query($koneksi, "INSERT INTO data_tamu (tanggal, nama, alamat, tujuan, noHP) VALUES ('$tgl', '$nama', '$alamat', '$tujuan', '$noHP')");

    if ($simpan) {
        echo "<script>alert('Simpan data sukses'); document.location='?';</script>";
    } else {
        echo "<script>alert('Simpan data gagal'); document.location='?';</script>";
    }
}

$tgl_sekarang = date("Y-m-d");
$connection = null;

if (isset($_POST['btampilkan'])) {
    $tgl1 = $_POST['tanggal1'];
    $tgl2 = $_POST['tanggal2'];
    $connection = mysqli_query($koneksi, "SELECT * FROM data_tamu WHERE tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY id DESC");
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

    <title>Rekapitulasi</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-success">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4 mt-3">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Pengunjung</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" class="text-center">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Dari Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal1" value="<?= isset($_POST['tanggal1']) ? $_POST['tanggal1'] : date("Y-m-d") ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Sampai Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal2" value="<?= isset($_POST['tanggal1']) ? $_POST['tanggal1'] : date("Y-m-d") ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary form-control" name="btampilkan"><i class="fa fa-search"></i> Tampilkan </button>
                                </div>
                                <div class="col-md-2">
                                    <a href="admin.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Kembali </a>
                                </div>
                            </div>
                        </form>

                        <?php if (isset($_POST['btampilkan'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengunjung</th>
                                        <th>Alamat</th>
                                        <th>Tujuan</th>
                                        <th>No HP</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nomer = 1;
                                    if ($connection) {
                                        foreach ($connection as $data):
                                    ?>
                                    <tr>
                                        <td><?= $nomer++ ?></td>
                                        <td><?= htmlspecialchars($data['nama']) ?></td>
                                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                                        <td><?= htmlspecialchars($data['tujuan']) ?></td>
                                        <td><?= htmlspecialchars($data['noHP']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <center>
                                <form action="exportexcel.php" method="POST">
                                    <div class="col-md-4">

                                        <input type="hidden" name="tanggalA" value="<?=@$_POST['tanggal1']?>">
                                        <input type="hidden" name="tanggalB" value="<?=@$_POST['tanggal2']?>">
                                        <button class="btn btn-success form-control" name="bexport"><i class="fa fa-download"></i> Export Data Excell</button>
                                    </div>
                                </form>
                            </center>
                        </div>
                        <?php endif ?>
                    </div>
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

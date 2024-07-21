<?php 
include "koneksi.php";

// persiapan untuk excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Export Excel Data Pengunjung.xls");
header("Pragma: no-cache");
header("Expires:0");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="6">Rekapitulasi data pengunjung</th>
        </tr>
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
        
        $tgl1 = $_POST['tanggalA'];
        $tgl2 = $_POST['tanggalB'];

        $tampil = mysqli_query($koneksi, "SELECT * FROM data_tamu where tanggal BETWEEN '$tgl1' and '$tgl2' order by tanggal asc");
        $nomer = 1 ;

        while($data = mysqli_fetch_array($tampil)){
            ?>
              <tr>
                                        <td><?= $nomer++ ?></td>
                                        <td><?= htmlspecialchars($data['nama']) ?></td>
                                        <td><?= htmlspecialchars($data['alamat']) ?></td>
                                        <td><?= htmlspecialchars($data['tujuan']) ?></td>
                                        <td><?= htmlspecialchars($data['noHP']) ?></td>
                                        <td><?= htmlspecialchars($data['tanggal']) ?></td>
                                    </tr>
        <?php } ?>
        
    </tbody>
</table>
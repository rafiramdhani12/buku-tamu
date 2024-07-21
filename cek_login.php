<?php 

session_start();

include "koneksi.php";

@$pass = md5($_POST['password']);
@$username = mysqli_escape_string($koneksi,$_POST['username']);
@$password = mysqli_escape_string($koneksi,$pass);

$login = mysqli_query($koneksi, "SELECT * FROM tuser where username = '$username' and password = '$password' and status = 'admin' ");

$data = mysqli_fetch_array($login);

if($data){
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password'];

    header('location:admin.php');
} else {
    echo "<script>alert('Maaf login tidak berhasil silahkan masukan password dan username dengan benar');document.location='index.php';</script>  " ;
}

?>
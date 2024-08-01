<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$pemilik  = $_POST['pemilik'];
$nomor  = $_POST['nomor'];
$saldo  = $_POST['saldo'];

mysqli_query($koneksi, "insert into bank values (NULL,'$nama','$nomor','$pemilik','$saldo')");
header("location:bank.php");
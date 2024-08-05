<?php
include '../koneksi.php';
$id  = $_POST['id'];
$tanggal  = $_POST['tanggal'];
$jenis  = $_POST['jenis'];
$kategori  = $_POST['kategori'];
$nominal  = $_POST['nominal'];
$keterangan  = $_POST['keterangan'];
$bank  = $_POST['bank'];

$rand = rand();
$allowed =  array('jpg', 'jpeg', 'pdf', 'png');
$filename = $_FILES['trnfoto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

$transaksi = mysqli_query($koneksi, "select * from transaksi where transaksi_id='$id'");
$t = mysqli_fetch_assoc($transaksi);
$bank_lama = $t['transaksi_bank'];
$foto_lama = $t['transaksi_foto'];

$rekening = mysqli_query($koneksi, "select * from bank where bank_id='$bank_lama'");
$r = mysqli_fetch_assoc($rekening);

// Kembalikan nominal ke saldo bank lama

if ($t['transaksi_jenis'] == "Pemasukan") {
	$kembalikan = $r['bank_saldo'] - $t['transaksi_nominal'];
	mysqli_query($koneksi, "update bank set bank_saldo='$kembalikan' where bank_id='$bank_lama'");
} else if ($t['transaksi_jenis'] == "Pengeluaran") {
	$kembalikan = $r['bank_saldo'] + $t['transaksi_nominal'];
	mysqli_query($koneksi, "update bank set bank_saldo='$kembalikan' where bank_id='$bank_lama'");
}


if ($jenis == "Pemasukan") {

	$rekening2 = mysqli_query($koneksi, "select * from bank where bank_id='$bank'");
	$rr = mysqli_fetch_assoc($rekening2);
	$saldo_sekarang = $rr['bank_saldo'];
	$total = $saldo_sekarang + $nominal;
	mysqli_query($koneksi, "update bank set bank_saldo='$total' where bank_id='$bank'");
} elseif ($jenis == "Pengeluaran") {

	$rekening2 = mysqli_query($koneksi, "select * from bank where bank_id='$bank'");
	$rr = mysqli_fetch_assoc($rekening2);
	$saldo_sekarang = $rr['bank_saldo'];
	$total = $saldo_sekarang - $nominal;
	mysqli_query($koneksi, "update bank set bank_saldo='$total' where bank_id='$bank'");
}

if ($filename == "") {
	// menghapus foto transaksi lama

	mysqli_query($koneksi, "update transaksi set transaksi_tanggal='$tanggal', transaksi_jenis='$jenis', transaksi_kategori='$kategori', transaksi_nominal='$nominal', transaksi_keterangan='$keterangan', transaksi_bank='$bank' where transaksi_id='$id'") or die(mysqli_error($koneksi));
	header("location:transaksi.php?alert=berhasilupdate");
} else {
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if (!in_array($ext, $allowed)) {
		header("location:transaksi.php?alert=gagal");
	} else {
		$target_dir = realpath(dirname(__FILE__) . '/../gambar/bukti/');
		$target_file = $target_dir . '/' . $rand . '_' . $filename;

		if (move_uploaded_file($_FILES['trnfoto']['tmp_name'], $target_file)) {
			$file_gambar = $rand . '_' . $filename;
			mysqli_query($koneksi, "insert into transaksi values (NULL,'$tanggal','$jenis','$kategori','$nominal','$keterangan','$file_gambar','$bank')");
			header("location:transaksi.php?alert=berhasil");
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
}

// mysqli_query($koneksi, "update transaksi set transaksi_tanggal='$tanggal', transaksi_jenis='$jenis', transaksi_kategori='$kategori', transaksi_nominal='$nominal', transaksi_keterangan='$keterangan', transaksi_bank='$bank' where transaksi_id='$id'") or die(mysqli_error($koneksi));
// header("location:transaksi.php");
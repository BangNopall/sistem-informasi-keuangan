<?php
include '../koneksi.php';

$id         = $_POST['id'];
$tanggal    = $_POST['tanggal'];
$jenis      = $_POST['jenis'];
$kategori   = $_POST['kategori'];
$nominal    = $_POST['nominal'];
$keterangan = $_POST['keterangan'];
$bank       = $_POST['bank'];

$rand       = rand();
$allowed    = array('jpg', 'jpeg', 'pdf', 'png');
$filename   = $_FILES['trnfoto']['name'];
$ext        = pathinfo($filename, PATHINFO_EXTENSION);

// Get existing transaction data
$transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE transaksi_id='$id'");
$t = mysqli_fetch_assoc($transaksi);
$bank_lama = $t['transaksi_bank'];
$foto_lama = $t['transaksi_foto'];

// Get old bank account details
$rekening = mysqli_query($koneksi, "SELECT * FROM bank WHERE bank_id='$bank_lama'");
$r = mysqli_fetch_assoc($rekening);

// Revert old transaction amount to the old bank balance
if ($t['transaksi_jenis'] == "Pemasukan") {
    $kembalikan = $r['bank_saldo'] - $t['transaksi_nominal'];
} else if ($t['transaksi_jenis'] == "Pengeluaran") {
    $kembalikan = $r['bank_saldo'] + $t['transaksi_nominal'];
}
mysqli_query($koneksi, "UPDATE bank SET bank_saldo='$kembalikan' WHERE bank_id='$bank_lama'");

// Update the new bank account balance
$rekening2 = mysqli_query($koneksi, "SELECT * FROM bank WHERE bank_id='$bank'");
$rr = mysqli_fetch_assoc($rekening2);
$saldo_sekarang = $rr['bank_saldo'];

if ($jenis == "Pemasukan") {
    $total = $saldo_sekarang + $nominal;
} elseif ($jenis == "Pengeluaran") {
    $total = $saldo_sekarang - $nominal;
}
mysqli_query($koneksi, "UPDATE bank SET bank_saldo='$total' WHERE bank_id='$bank'");

if ($filename == "") {
    // Update transaction without changing the photo
    mysqli_query($koneksi, "UPDATE transaksi SET transaksi_tanggal='$tanggal', transaksi_jenis='$jenis', transaksi_kategori='$kategori', transaksi_nominal='$nominal', transaksi_keterangan='$keterangan', transaksi_bank='$bank' WHERE transaksi_id='$id'") or die(mysqli_error($koneksi));
    header("Location: transaksi.php?alert=berhasilupdate");
} else {
    if (!in_array($ext, $allowed)) {
        header("Location: transaksi.php?alert=gagal");
    } else {
        // Remove old photo
        if (file_exists('../gambar/bukti/' . $foto_lama)) {
            unlink('../gambar/bukti/' . $foto_lama);
        }

        $upload_path = realpath(dirname(__FILE__) . '/../gambar/bukti/') . '/';
        $target_file = $upload_path . $rand . '_' . $filename;

        if (move_uploaded_file($_FILES['trnfoto']['tmp_name'], $target_file)) {
            $xgambar = $rand . '_' . $filename;
            mysqli_query($koneksi, "UPDATE transaksi SET transaksi_tanggal='$tanggal', transaksi_jenis='$jenis', transaksi_kategori='$kategori', transaksi_nominal='$nominal', transaksi_keterangan='$keterangan', transaksi_foto='$xgambar', transaksi_bank='$bank' WHERE transaksi_id='$id'");
            header("Location: transaksi.php?alert=berhasilupdate");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

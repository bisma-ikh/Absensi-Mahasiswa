<?php
// Memanggil library php qrcode
include "../../../phpqrcode/qrlib.php"; 

// Mengambil nilai dari parameter 'id' pada URL menggunakan $_GET
$text = isset($_GET['id']) ? $_GET['id'] : '';
$kode = "http://localhost:8080/absensi/public/view/mhs/manual.php?id=$text";
// Path untuk menyimpan file QR code
$filePath = "../../img/qrcode.png";

// Perintah untuk membuat qrcode dan menyimpannya ke dalam file
QRcode::png($kode, $filePath);

// Menampilkan gambar QR code di halaman web dengan gaya CSS untuk pusat
echo "<div style='position: relative; display: flex; justify-content: center; align-items: center; height: 100vh;'>";
echo "<img style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -70%); z-index: 1; width: 16%' src='$filePath' alt='QR Code'>";
echo "<img style='width: 40%' src='../../img/border.png'>";
// echo "<h3 style=' position: absolute; z-index: 2; bottom: 60px; left: 50%; transform: translateX(-50%); text-decoration: none'>Absen Menggunakan Link <a style='text-decoration: none;' href='http://localhost:8080/absensi/public/view/mhs/manual.php?id=$text'>Klik disini</a></p>";
echo "</div>";

?>


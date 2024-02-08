<?php

include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['ruang']))||
        (empty($_POST['dosen']))||(empty($_POST['mhs']))||
        (empty($_POST['mk']))||(empty($_POST['jam']))){
      header("Location:../../../public/view/admin/tambahjadwal.php");
    } else {
      $result = req($_POST);
      if($result === 0) {
        echo "<script>
        alert('Data Berhasil diubah!');
        document.location.href = '../../../public/view/admin/jadwal.php';
        </script>";
      } else {
        echo "<script>
        alert('$result');
        document.location.href = '../../../public/view/admin/tambahjadwal.php';
        </script>";
      }
    }
}

function req($data) {
  global $conn;

  $id = $_GET['id'];
  $mhs = mysqli_real_escape_string($conn, $data["mhs"]);
  $dosen = mysqli_real_escape_string($conn, $data["dosen"]);
  $mk = mysqli_real_escape_string($conn, $data["mk"]);
  $ruang = mysqli_real_escape_string($conn, $data["ruang"]);
  $jam = mysqli_real_escape_string($conn, $data["jam"]);
  $kode_jadwal = generateUniqueCode(); // Fungsi untuk menghasilkan kode jadwal unik

  // Query SQL untuk memasukkan data ke dalam tabel jadwal
  $sql = "INSERT INTO jadwal (kode_jadwal, nim, nip, kode_mk, ruang, waktu, updated_at) 
          VALUES ('$kode_jadwal', '$mhs', '$dosen', '$mk', '$ruang', '$jam', '')";
    $result = mysqli_query($conn, "DELETE FROM jadwal WHERE kode_jadwal = '$id'");

  if(mysqli_query($conn, $sql)) {
    return 0; // Jika berhasil
  } else {
    return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
  }
}

// Fungsi untuk menghasilkan kode jadwal unik (contoh implementasi)
function generateUniqueCode() {
    // Implementasikan logika untuk menghasilkan kode jadwal unik di sini
    // Misalnya, Anda bisa menggunakan timestamp atau kombinasi dengan angka acak
    return uniqid();
}

?>

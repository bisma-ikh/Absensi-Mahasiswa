<?php

include '../../../env/env.php';

if(isset($_POST['simpan'])) {
  if((empty($_POST['ruang']))||(empty($_POST['dosen']))||
    (empty($_POST['mhs']))||(empty($_POST['mk']))||
    (empty($_POST['jam']))||(empty($_POST['hari']))) {
    // Jika ada input yang kosong, arahkan kembali ke halaman tambahjadwal.php dengan parameter yang diperlukan
    header("Location: ../../../public/view/admin/tambahjadwal.php?id=" . $_POST["mhs"] . "&prodi=" . $_POST["kode"]);
  } else {
      $result = req($_POST);
      if($result === 0) {
          echo "<script>
          alert('Data Berhasil diinput!');
          document.location.href = '../../../public/view/admin/jadwal.php';
          </script>";
      } else {
          // Jika terjadi kesalahan, arahkan kembali ke halaman tambahjadwal.php dengan parameter dari $_POST
          echo "<script>
          alert('$result');
          document.location.href = '../../../public/view/admin/tambahjadwal.php?id=" . $_POST["mhs"] . "&prodi=" . $_POST["kode"] . "';
          </script>";
      }
  }
}



function req($data) {
    global $conn;

    $nim = mysqli_real_escape_string($conn, $data["mhs"]);
    $hari = mysqli_real_escape_string($conn, $data["hari"]);
    $nip = mysqli_real_escape_string($conn, $data["dosen"]);
    $mk = mysqli_real_escape_string($conn, $data["mk"]);
    $ruang = mysqli_real_escape_string($conn, $data["ruang"]);
    $jam = mysqli_real_escape_string($conn, $data["jam"]);
    $kode_jadwal = '';

    // Check the time and set kode_jadwal accordingly
    if ($jam >= "08:00" && $jam <= "15:45") {
        $kode_jadwal = "Reguler-1";
    } elseif ($jam >= "19:00" && $jam <= "20:45") {
        $kode_jadwal = "Reguler-2";
    }

    // Query SQL untuk memeriksa apakah jadwal dengan data yang sama sudah ada
    $check_query = "SELECT * FROM jadwal WHERE nim = '$nim' AND kode_mk = '$mk'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Jika data yang sama sudah ada, kembalikan pesan kesalahan
        return "Mahasiswa sudah terdaftar pada mata kuliah yang dipilih.";
    }

    // Query SQL untuk memeriksa ketersediaan dosen dan ruang pada waktu yang sama
    $check_queryds = "SELECT * FROM jadwal WHERE nip = '$nip' AND waktu = '$hari,$jam' AND nim = '$nim'";
    $resultds = mysqli_query($conn, $check_queryds);

    if (mysqli_num_rows($resultds) > 0) {
        // Jika data yang sama sudah ada, kembalikan pesan kesalahan
        return "Dosen sudah terdaftar pada waktu yang sama.";
    }

    // Jika data belum ada, lakukan penyisipan ke dalam tabel jadwal
    $sql = "INSERT INTO jadwal (kode_jadwal, nim, nip, kode_mk, ruang, waktu) 
            VALUES ('$kode_jadwal', '$nim', '$nip', '$mk', '$ruang', '$hari,$jam')";

    if(mysqli_query($conn, $sql)) {
        return 0; // Jika penyisipan berhasil
    } else {
        return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
    }
}



// Fungsi untuk menghasilkan kode jadwal unik (contoh implementasi)
// $kode_jadwal = generateUniqueCode(); 
// function generateUniqueCode() {
//     // Implementasikan logika untuk menghasilkan kode jadwal unik di sini
//     // Misalnya, Anda bisa menggunakan timestamp atau kombinasi dengan angka acak
//     return uniqid();
// }

?>

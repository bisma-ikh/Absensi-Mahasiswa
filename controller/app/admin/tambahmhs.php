<?php

include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['nim']))||(empty($_POST['nama']))||
        (empty($_POST['no']))||(empty($_POST['kd_prodi']))){
      header("Location:../../../public/view/admin/tambahmhs.php");
    } else {
      $result = req($_POST);
      if($result === 0) {
        echo "<script>
        alert('Data Berhasil diinput!');
        document.location.href = '../../../public/view/admin/mahasiswa.php';
        </script>";
      } else {
        echo "<script>
        alert('$result');
        document.location.href = '../../../public/view/admin/tambahmhs.php';
        </script>";
      }
    }
}

function req($data) {
  global $conn;

  $nim = $_POST["nim"];
  $nama = $_POST["nama"];
  $no = $_POST["no"];
  $kd_prodi = $_POST["kd_prodi"];

  // Query SQL untuk memeriksa apakah NIM sudah terdaftar sebelumnya
  $check_query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
  $result = mysqli_query($conn, $check_query);

  // Jika NIM sudah terdaftar, kembalikan pesan error
  if(mysqli_num_rows($result) > 0) {
      return "NIM sudah terdaftar!";
  } else {
      // Jika NIM belum terdaftar, lakukan operasi INSERT
      $insert_query = "INSERT INTO mahasiswa (nim, nama, phone, kode_prodi) VALUES ('$nim', '$nama', '$no', '$kd_prodi')";

      if(mysqli_query($conn, $insert_query)) {
          return 0; // Jika berhasil
      } else {
          return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
      }
  }
}


?>

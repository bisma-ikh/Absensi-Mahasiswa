<?php
include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['kode']))||(empty($_POST['nama']))||
        (empty($_POST['sks']))||(empty($_POST['smt']))||
        (empty($_POST['prodi']))){
      header("Location: ../../../public/view/admin/editmk.php?id=" . $_GET['id']);
      exit; // Hentikan eksekusi skrip setelah redirect
    } else {
      $result = req($_POST);
      if($result === 0) {
        echo "<script>
        alert('Data Berhasil diinput!');
        document.location.href = '../../../public/view/admin/mk.php';
        </script>";
      } else {
        echo "<script>
        alert('$result');
        document.location.href = '../../../public/view/admin/editmk.php?id=" . $_GET['id'] . "';
        </script>";
      }
    }
}


function req($data) {
    global $conn;

    $id = $_GET['id'];
    $nama = mysqli_real_escape_string($conn, $data["nama"]);
    $sks = mysqli_real_escape_string($conn, $data["sks"]);
    $smt = mysqli_real_escape_string($conn, $data["smt"]);
    $prodi = mysqli_real_escape_string($conn, $data["prodi"]);
    $kode = mysqli_real_escape_string($conn, $data["kode"]);
    $waktu = '';

    // Query SQL untuk memeriksa apakah NIM sudah terdaftar sebelumnya
    $check_query = "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode' AND id != $id"; // Perhatikan penggunaan operator != untuk memeriksa kecuali id yang sedang diubah
    $result = mysqli_query($conn, $check_query);

    // Jika NIM sudah terdaftar, kembalikan pesan error
    if(mysqli_num_rows($result) > 0) {
        return "Kode Matkul sudah terdaftar!";
    } else {
        // Jika NIM belum terdaftar atau sama dengan NIM yang sedang diubah, lanjutkan dengan pembaruan data
        $sql = "UPDATE mata_kuliah SET nama='$nama', sks='$sks', semester='$smt', updated_at='$waktu', kode_mk='$kode' WHERE id=$id";

        if(mysqli_query($conn, $sql)) {
            return 0; // Jika berhasil
        } else {
            return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
        }
    }
}

?>

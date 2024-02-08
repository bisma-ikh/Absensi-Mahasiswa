<?php
include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['nim']))||
        (empty($_POST['nama']))||(empty($_POST['prodi']))||
        (empty($_POST['no']))){
      header("Location:../../../public/view/admin/editmhs.php?id=" . $_GET['id']);
    } else {
      $result = req($_POST);
      if($result === 0) {
        echo "<script>
        alert('Data Berhasil diubah!');
        document.location.href = '../../../public/view/admin/mahasiswa.php';
        </script>";
      } else {
        echo "<script>
        alert('$result');
        document.location.href = '../../../public/view/admin/editmhs.php?id=" . $_GET['id'] . "';
        </script>";
      }
    }
}

function req($data) {
    global $conn;

    $id = $_GET['id'];
    $nama = mysqli_real_escape_string($conn, $data["nama"]);
    $nim = mysqli_real_escape_string($conn, $data["nim"]);
    $no = mysqli_real_escape_string($conn, $data["no"]);
    $prodi = mysqli_real_escape_string($conn, $data["prodi"]);
    $waktu = '';

    // Query SQL untuk memeriksa apakah NIM sudah terdaftar sebelumnya
    $check_query = "SELECT * FROM mahasiswa WHERE nim = '$nim' AND id != $id"; // Perhatikan penggunaan operator != untuk memeriksa kecuali id yang sedang diubah
    $result = mysqli_query($conn, $check_query);

    // Jika NIM sudah terdaftar, kembalikan pesan error
    if(mysqli_num_rows($result) > 0) {
        return "NIM sudah terdaftar!";
    } else {
        // Jika NIM belum terdaftar atau sama dengan NIM yang sedang diubah, lanjutkan dengan pembaruan data
        $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', phone='$no', updated_at='$waktu', kode_prodi='$prodi' WHERE id=$id";

        if(mysqli_query($conn, $sql)) {
            return 0; // Jika berhasil
        } else {
            return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
        }
    }
}


?>

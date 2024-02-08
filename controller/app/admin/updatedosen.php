<?php
include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['nip']))||(empty($_POST['nama']))||
      (empty($_POST['prodi']))||(empty($_POST['no']))){
      header("Location:../../../public/view/admin/editdosen.php?id=" . $_GET['id']);
    } else {
      $result = req($_POST);
      if($result === 0) {
        echo "<script>
        alert('Data Berhasil diubah!');
        document.location.href = '../../../public/view/admin/dosen.php';
        </script>";
      } else {
        echo "<script>
        alert('$result');
        document.location.href = '../../../public/view/admin/editdosen.php?id=" . $_GET['id'] . "';
        </script>";
      }
    }
}

function req($data) {
    global $conn;

    $id = $_GET['id'];
    $nama = mysqli_real_escape_string($conn, $data["nama"]);
    $nip = mysqli_real_escape_string($conn, $data["nip"]);
    $no = mysqli_real_escape_string($conn, $data["no"]);
    $prodi = mysqli_real_escape_string($conn, $data["prodi"]);
    $waktu = date('Y-m-d H:i:s'); // Waktu saat ini

    // Query SQL untuk memeriksa apakah NIP sudah terdaftar sebelumnya
    $check_query = "SELECT * FROM dosen WHERE nip = '$nip' AND id != $id"; // Perhatikan penggunaan operator != untuk memeriksa kecuali id yang sedang diubah
    $result = mysqli_query($conn, $check_query);

    // Jika NIP sudah terdaftar, kembalikan pesan error
    if(mysqli_num_rows($result) > 0) {
        return "NIP sudah terdaftar!";
    } else {
        // Jika NIP belum terdaftar atau sama dengan NIP yang sedang diubah, lanjutkan dengan pembaruan data
        $sql = "UPDATE dosen SET nama='$nama', nip='$nip', phone='$no', updated_at='$waktu', kode_prodi='$prodi' WHERE id=$id";

        if(mysqli_query($conn, $sql)) {
            return 0; // Jika berhasil
        } else {
            return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
        }
    }
}
?>

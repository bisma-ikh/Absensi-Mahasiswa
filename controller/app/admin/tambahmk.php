<?php

include '../../../env/env.php';

if(isset($_POST['simpan'])) {
    if((empty($_POST['kode']))||(empty($_POST['nama']))||
        (empty($_POST['sks']))||(empty($_POST['smt']))||
        (empty($_POST['prodi']))){
      header("Location:../../../public/view/admin/tambahmk.php");
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
        document.location.href = '../../../public/view/admin/tambahmk.php';
        </script>";
      }
    }
}

function req($data) {
    global $conn;

    $sks = $_POST["sks"];
    $nama = $_POST["nama"];
    $prodi = $_POST["prodi"];
    $smt = $_POST["smt"];
    $kode = $_POST["kode"];

    // Query SQL untuk memeriksa apakah kode_mk sudah terdaftar sebelumnya
    $check_query = "SELECT * FROM mata_kuliah WHERE kode_mk = '$kode'";
    $result = mysqli_query($conn, $check_query);

    // Jika kode_mk sudah terdaftar, kembalikan pesan error
    if(mysqli_num_rows($result) > 0) {
        return "Kode Matkul sudah terdaftar!";
    } else {
        // Jika kode_mk belum terdaftar, lakukan operasi INSERT
        $insert_query = "INSERT INTO mata_kuliah (kode_mk, nama, sks, semester, kode_prodi) VALUES ('$kode', '$nama', '$sks', '$smt', '$prodi')";

        if(mysqli_query($conn, $insert_query)) {
            return 0; // Jika berhasil
        } else {
            return "Error: " . mysqli_error($conn); // Jika terjadi kesalahan
        }
    }
}


?>

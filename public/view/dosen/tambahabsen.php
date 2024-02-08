<?php 
include '../../../env/env.php';

if(isset($_POST['simpan'])){
    // Mendapatkan data dari formulir
    $id_user = $_POST['id_user'];
    $kode_jadwal = $_POST['kode'];
    $foto = $_POST['foto'];
    $waktu = $_POST['jam'];

    // Menyiapkan pernyataan SQL INSERT
    $sql = "INSERT INTO absensi (id_user, kode_jadwal, foto, waktu) VALUES ('$id_user', '$kode_jadwal', '$foto', '$waktu')";

    // Menjalankan query INSERT
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Absensi sudah dimulai');
        document.location.href = 'tabelabsen.php?id=$kode_jadwal';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Menutup koneksi ke database
    mysqli_close($conn);
}
?>

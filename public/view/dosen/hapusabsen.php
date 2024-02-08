<?php 
include '../../../env/env.php';

if(isset($_GET['id'])){
    // Mendapatkan data dari formulir
    $kode = $_GET['id'];

    // Menyiapkan pernyataan SQL INSERT
    $sql = "DELETE FROM absensi WHERE kode_jadwal = '$kode'";


    // Menjalankan query INSERT
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Sesi Absensi Telah Selesai');
        document.location.href = 'jadwal.php';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Menutup koneksi ke database
    mysqli_close($conn);
}
?>

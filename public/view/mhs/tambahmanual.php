<?php 
include '../../../env/env.php';

if(isset($_POST['simpan'])){
    // Mendapatkan data dari formulir
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $ket = $_POST['ket'];
    $waktu = $_POST['jam'];

    // Menyiapkan pernyataan SQL SELECT untuk memeriksa keberadaan data yang sama
    $check_query = "SELECT * FROM daftar WHERE nim = '$nim'";
    $result = mysqli_query($conn, $check_query);

    // Memeriksa apakah data sudah ada
    if (mysqli_num_rows($result) > 0) {
        // Jika sudah ada, beri pesan bahwa mahasiswa sudah absen
        echo "<script>
            alert('Mahasiswa Sudah Absen.');
            document.location.href = 'manual.php';
            </script>";
    } else {
        // Jika belum ada, jalankan query INSERT
        $sql = "INSERT INTO daftar (nim, nama, waktu, keterangan) VALUES ('$nim','$nama', '$waktu', '$ket')";
        // Menjalankan query INSERT
        if (mysqli_query($conn, $sql)) {
            echo "<script>
            alert('Absen berhasil.');
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Menutup koneksi ke database
    mysqli_close($conn);
}

?>

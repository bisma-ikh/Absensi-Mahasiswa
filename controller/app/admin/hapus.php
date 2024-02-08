<?php
// include database connection file
include_once("../../../env/env.php");

// Get id from URL to delete that user
$id = $_GET['id'];
$no = $_GET['id'];

// Check if data exists in the 'jadwal' table before deletion
$check_jadwal = mysqli_query($conn, "SELECT * FROM jadwal WHERE nim=$id");

if (mysqli_num_rows($check_jadwal) > 0) {
    // If data exists in 'jadwal' table, prompt user or handle accordingly
    echo '<script>alert("Data masih terkait dengan jadwal. Anda tidak dapat menghapusnya. lihat Jadwal "); window.location.href = "../../../public/view/admin/jadwal.php";</script>';
} else {
    // If data doesn't exist in 'jadwal' table, proceed with deletion
    // Delete user row from table based on given id
    $result = mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim=$id");
    $result1 = mysqli_query($conn, "DELETE FROM user WHERE id_user=$id");

    if ($result && $result1) {
        // If deletion is successful
        echo '<script>alert("Penghapusan berhasil."); window.location.href = "../../../public/view/admin/mahasiswa.php";</script>';
    } else {
        // If deletion fails
        echo '<script>alert("Penghapusan gagal. Silakan coba lagi."); window.location.href = "../../../public/view/admin/mahasiswa.php";</script>';
    }
}

?>
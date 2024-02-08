<?php
// include database connection file
include_once("../../../env/env.php");

// Get id from URL to delete that user
$id = $_GET['id'];
$no = $_GET['id'];

$result1 = mysqli_query($conn, "DELETE FROM jadwal WHERE id =$no");
if ($result1) {
    // Jika penghapusan berhasil
    echo '<script>alert("Penghapusan berhasil."); window.location.href = "../../../public/view/admin/jadwal.php";</script>';
} else {
    // Jika penghapusan gagal
    echo '<script>alert("Penghapusan gagal. Silakan coba lagi."); window.location.href = "../../../public/view/admin/jadwal.php";</script>';
}

?>
<?php
// include database connection file
include_once("../../../env/env.php");

// Get id from URL to delete that user
$id = $_GET['id'];
$no = $_GET['id'];

// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM mata_kuliah WHERE id=$id");

if ($result) {
    // Jika penghapusan berhasil
    echo '<script>alert("Penghapusan berhasil."); window.location.href = "../../../public/view/admin/mk.php";</script>';
} else {
    // Jika penghapusan gagal
    echo '<script>alert("Penghapusan gagal. Silakan coba lagi."); window.location.href = "../../../public/view/admin/mk.php";</script>';
}


?>
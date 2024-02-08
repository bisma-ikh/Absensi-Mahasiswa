<?php
include '../../env/env.php';

if (isset($_POST['submit'])) {
    $id_user = $_POST['id'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($password1 !== $password2) {
        echo "<script>
        alert('Password Tidak Sesuai!!!');
        document.location.href = '../../public/reset.php';
        </script>";
        exit;
    }

    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

    $query = "UPDATE user SET password = ? WHERE id_user = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $id_user);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo "<script>
        alert('Password Berhasil Dirubah!');
        document.location.href = '../../index.php';
        </script>";
    } else {
        echo "<script>
        alert('Gagal Merubah Password!!!');
        document.location.href = '../../public/reset.php';
        </script>: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>

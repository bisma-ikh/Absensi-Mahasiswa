<?php
include '../../env/env.php';

if (isset($_POST['next'])) {
    $email = $_POST['email'];

    // Perform a database query to retrieve data based on the provided email
    $query = "SELECT id_user, email FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $email);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($id) {
        // Data found, redirect to the next step with the retrieved data
        session_start();
        $_SESSION['id_user'] = $id;
        $_SESSION['email'] = $email;
        header("location:../../public/reset.php"); // Replace with the actual next step page
        exit;
    } else {
        echo "<script>
        alert('Email tidak ditemukan!!!');
        document.location.href = '../../public/forget.php';
        </script>";
    }
}
?>

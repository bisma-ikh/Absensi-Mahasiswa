<?php
include '../env/env.php';
session_start();
if (empty($_SESSION['email'])) {
    header("location:login.php");
    exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (head content) ... -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/forget.css">
    <link rel="icon" href="img/icon.png">
    <!-- font awesome icons -->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    />
    <title>Lupa Password</title>
</head>
<body>
    <div class="container">
        <div class="signin-signup">
            <form action="../controller/reset/updatepw.php" class="sign-in-form" method="post">
                <h2 class="title">Rubah Password</h2>
                <input type="hidden" value="<?php echo $_SESSION["id_user"]; ?>" name="id" readonly>
                <?php
                if (!empty($_SESSION['id_user'])) {
                    $userId = $_SESSION['id_user'];

                    // Perform a database query to retrieve the user's name using the ID
                    $query = "SELECT email FROM user WHERE id_user = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "i", $userId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $name);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);
                }
                ?>

                <!-- ... (previous code) ... -->

                <!-- Display the retrieved name -->
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" value="<?php echo isset($name) ? $name : ''; ?>" readonly>
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password Baru" name="password1" autofocus required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Konfirmasi Password Baru" name="password2" autofocus required>
                </div>
                <input type="submit" value="Rubah" class="btn" name="submit">
            </form>
        </div>   
    </div>
</body>
</html>

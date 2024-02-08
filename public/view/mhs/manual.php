<?php
include_once("../../../env/env.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    
	<!-- My CSS -->
    <link rel="stylesheet" href="../../css/auto.css">
    <link rel="icon" href="../../img/iconn.png">

	<title>Absen</title>
</head>
<body>

	<div class="container">
        <div class="signin-signup">
            <form action="tambahmanual.php" class="sign-in-form" method="post">
                <input type="hidden" value="hadir" name="ket">
                <input type="hidden" name="jam" id=jam>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="text" placeholder="Masukan NIM" name="nim" required autofocus>
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Masukan Nama" name="nama" required autofocus>
                </div>
                <input type="submit" value="Ok" class="btn" name="simpan">
            </form>
        </div>
    </div>
    <script>
    // Mendapatkan elemen input jam
    var inputJam = document.getElementById("jam");

    // Mendapatkan waktu saat ini dalam zona waktu Jakarta
    var currentTime = new Date();
    var jakartaTime = new Date(currentTime.toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));

    // Mendapatkan jam dan menit saat ini
    var hours = jakartaTime.getHours().toString().padStart(2, "0"); // Menambahkan nol di depan jika jam hanya satu digit
    var minutes = jakartaTime.getMinutes().toString().padStart(2, "0"); // Menambahkan nol di depan jika menit hanya satu digit

    // Mengatur nilai input jam menjadi waktu saat ini dalam zona waktu Jakarta
    inputJam.value = hours + ":" + minutes;
    </script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>
<?php
include_once("../../../env/env.php");
session_start();
if (empty($_SESSION['id_user']) || empty($_SESSION['role'])) {
  header("location:../../../index.php");
  exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
}

// Prepare the statement for the user query
$query = "SELECT * FROM user WHERE id_user = ?";
$stmt = mysqli_prepare($conn, $query);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "s", $_SESSION['id_user']);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($conn);
    // Handle error, misalnya redirect ke halaman error atau tampilkan pesan kesalahan
}

// Prepare the statement for the mahasiswa query
$querymhs = "SELECT * FROM mahasiswa WHERE nim = ?";
$stmtmhs = mysqli_prepare($conn, $querymhs);

// Bind the parameter
mysqli_stmt_bind_param($stmtmhs, "s", $_SESSION['id_user']);

// Execute the statement
mysqli_stmt_execute($stmtmhs);

// Get the result
$resultmhs = mysqli_stmt_get_result($stmtmhs);

if ($resultmhs) {
    $usermhs = mysqli_fetch_assoc($resultmhs);
} else {
    echo "Error: " . mysqli_error($conn);
    // Handle error, misalnya redirect ke halaman error atau tampilkan pesan kesalahan
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- My CSS -->
	<link rel="stylesheet" href="../../css/edit.css">
    <link rel="icon" href="../../img/iconn.png">

	<title>Dashborad</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand" style="padding-top: 10px">
			<img src="../../img/iconn.png" style="width: 50px; margin: 10px">
			<span class="text">UNIBA</span>
		</a>
		<ul class="side-menu top">
			<li class= "active">
				<a href="absensi.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Absensi</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu a">
			<li>
				<a href="#" class="logout" onclick=confirmLogout()>
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<form method="post">
				<div class="form-input">
					<button style="display: none;">
						<i class='bx bx-search' ></i>
					</button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<div class="samping" style="display: flex; align-items: center; ;">
				<p class="list" style="color: var(--dark)"><i class='bx bx-user text-lg'></i></p>
				<p class="list" style="color: var(--dark); margin-left: 20px"><?php echo $usermhs['nama']?><small><br><?php echo $userData["id_user"]?></small></p>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
            <div class="table-data">
				<div class="order">
                    <form action="tambahdaftar.php" method="POST" onsubmit="return validateForm()">
                        <input type="hidden" value="<?php echo $userData["id_user"] ?>" name="nim" required>
                        <input type="hidden" value="<?php echo $usermhs['nama'] ?>" name="nama" required>
                        <input type="hidden" class="form-control-plaintext" name="jam" id="jam" required>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-3">
                                <select class="form-select" aria-label="Default select example" name="ket" id="ket">
                                    <option selected>Pilih Keterangan...</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin">Izin</option>
                                </select>
                            </div>

                        </div>
                        <div class="mb-3-row">
                            <div class="col-sm-12 d-flex justify-content-end">
                                <a href="absensi.php" style="margin-right: 10px;" type="submit" class="btn btn-outline-danger" name="batal">Batal</a>
                                <button type="submit" class="btn btn-outline-primary" name="simpan">Simpan</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
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

    function openBarcodeAbsen() {
        // Membuka halaman Barcode-Absen.php di jendela baru dengan lebar dan tinggi yang ditentukan
        window.open('Barcode-Absen.php?id=<?php echo $_GET['id'] ?>', '_blank', 'width=800, height=600');
    }
    </script>
	<script src="../../js/script.js"></script>
	<script src="../../js/user/logout.js"></script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>
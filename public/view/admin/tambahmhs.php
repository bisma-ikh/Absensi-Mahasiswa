<?php
include_once("../../../env/env.php");
session_start();
if (empty($_SESSION['id_user']) || empty($_SESSION['role'])) {
  header("location:../../../index.php");
  exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
}

$userId = mysqli_real_escape_string($conn, $_SESSION['id_user']);
$query = "SELECT * FROM user WHERE id_user = '$userId'";
$result = mysqli_query($conn,$query);
if ($result) {
    $userData = mysqli_fetch_assoc($result);
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

	<title>Master Data</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
        <a href="admin.php" class="brand" style="padding-top: 10px">
            <img src="../../img/iconn.png" style="width: 50px; margin: 10px">
            <span class="text">UNIBA</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="../../admin.php">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
                </a>
            </li>
            <li class= "active">
                <a href="masterdata.php">
                <i class='bx bxs-data' ></i>
                <span class="text">Master Data</span>
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
				<p class="list" style="color: var(--dark); margin-left: 20px"><?php echo $userData["role"]?><small><br><?php echo $userData["id_user"]?></small></p>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Master Data</h1>
					<ul >
						<li style="margin-left: -30px;">
							<a href="mahasiswa.php" style="color: var(--dark)">Back</a>
						</li>
					</ul>
				</div>
			</div>
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Mahasiswa</h3>
					</div>

                    <form action="../../../controller/app/admin/tambahmhs.php" method="POST" onsubmit="return validateForm()">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">NIM</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nim" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="no" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Prodi</label>
                            <div class="col-sm-3">
                                <select class="form-select" aria-label="Default select example" name="kd_prodi" id="kd_prodi">
                                    <option selected>Pilih Prodi...</option>
                                    <?php 
                                    $queryprodi = mysqli_query($conn, "SELECT * FROM prodi");
                                    while ($prodi = mysqli_fetch_array($queryprodi)) {
                                        echo "<option value='" . $prodi['kode_prodi'] . "'>" . $prodi['nama'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3-row">
                            <div class="col-sm-12 d-flex justify-content-end">
                                <a href="mahasiswa.php" style="margin-right: 10px;" type="submit" class="btn btn-outline-danger" name="batal">Batal</a>
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
        function validateForm() {
            var selectedProdi = document.getElementById('kd_prodi').value;

            if (selectedProdi === 'Pilih Prodi...') {
                alert('Pilih Prodi terlebih dahulu');
                return false; // Form tidak akan disubmit
            }
            return true; // Form akan disubmit
        }
    </script>
    <script src="../../js/script.js"></script>
	<script src="../../js/admin/logout.js"></script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>
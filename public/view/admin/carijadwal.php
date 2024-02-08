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
							<a href="masterdata.php" style="color: var(--dark)">Back</a>
						</li>
					</ul>
				</div>
			</div>
            <div class="table-data">
				<div class="order">
                    <div class="head">
						<h3>List Mahasiswa</h3>
					</div>
					<table>
						<thead>
                            
							<tr>
								<th>NIM</th>
								<th>Nama</th>
								<th>Phone</th>
								<th>Prodi</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Menampilkan data dari hasil query
							$querymhs = "SELECT * FROM mahasiswa ORDER BY created_at DESC";
							$resultmhs = mysqli_query($conn, $querymhs);
							while ($mhs = mysqli_fetch_assoc($resultmhs)) {
								echo "<tr>";
								echo "<td>" . mysqli_real_escape_string($conn, $mhs['nim']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mhs['nama']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mhs['phone']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mhs['kode_prodi']) . "</td>";
								echo "<td><a style='color: var(--blue);' href='tambahjadwal.php?id=" . mysqli_real_escape_string($conn, $mhs['nim']) . "&prodi=". mysqli_real_escape_string($conn, $mhs['kode_prodi'])."'>Tambah Jadwal</a></td>";
								echo "<tr>";
							}
							?>
						</tbody>
					</table>
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="jadwal.php" style="margin-right: 10px;" type="submit" class="btn btn-outline-danger" name="batal">Batal</a>
                    </div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
    <script>
        function validateForm() {
            var kelas = document.getElementById('kelas').value;
            var dosen = document.getElementById('dosen').value;
            var mhs = document.getElementById('mhs').value;
            var mk = document.getElementById('mk').value;
            var ruang = document.getElementById('ruang').value;
            var jam = document.getElementById('jam').value;

            // Periksa apakah salah satu elemen formulir kosong
            if (kelas === '' || dosen === '' || mhs === '' || mk === '' || ruang === ''|| jam === '') {
                alert('Harap Melengkapi semua kolom.');
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
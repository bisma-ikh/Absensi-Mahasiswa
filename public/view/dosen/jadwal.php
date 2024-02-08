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
$querymhs = "SELECT * FROM dosen WHERE nip = ?";
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

	<title>Absensi</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
	<a href="#" class="brand" style="padding-top: 10px">
			<img src="../../img/iconn.png" style="width: 50px; margin: 10px">
			<span class="text">UNIBA</span>
		</a>
		<ul class="side-menu top">
			<li >
				<a href="dosen.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class= "active">
				<a href="jadwal.php">
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
			<div class="head-title">
				<div class="left">
					<h1>Absensi</h1>
					<ul class="breadcrumb">
						<li>
							<a href="">Dashboard</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info" style="margin-left: -30px">
				<li>
					<a href="dosen.php">
						<i class='bx bxs-dashboard' ></i>
					</a>
					<span class="text">
						<a href="dosen.php">
							<h3>Dashboard</h3>
							<p>Dashboard</p>
						</a>
					</span>
				</li>
				<li>
					<a href="jadwal.php">
						<i class='bx bxs-notepad'></i>
					</a>
					<span class="text">
						<a href="jadwal.php">
							<h3>Absensi</h3>
							<p>Dashboard</p>
						</a>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List Kelas</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Matakuliah</th>
								<th>Ruangan</th>
								<th>Waktu</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = $userData["id_user"];
							$queryjadwal = "SELECT jadwal.waktu, jadwal.ruang, MIN(jadwal.kode_jadwal) AS kode_jadwal, mata_kuliah.nama AS nama_mk
											FROM jadwal
											INNER JOIN mata_kuliah ON jadwal.kode_mk = mata_kuliah.kode_mk
											WHERE nip = '$no'
											GROUP BY jadwal.ruang, jadwal.kode_mk
											ORDER BY jadwal.created_at DESC";
			
							$resultjadwal = mysqli_query($conn, $queryjadwal);
							while ($jadwal = mysqli_fetch_assoc($resultjadwal)) {
								echo "<tr>";
								echo "<td>" . mysqli_real_escape_string($conn, $jadwal['nama_mk']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $jadwal['ruang']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $jadwal['waktu']) . "</td>";
								echo "<td style='display: flex; justify-content: end;'>
										
										<a 
											class='btn btn-outline-primary' href='formabsen.php?id=" . mysqli_real_escape_string($conn, $jadwal['kode_jadwal']) . "'>Mulai Absen
										</a>
									</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<script src="../../js/script.js"></script>
	<script src="../../js/user/logout.js"></script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>
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
					<ul>
						<li>
							<a href="../../admin.php" style="color: var(--dark)">Dashboard</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info" style="margin-left: -30px">
				<li>
					<a href="dosen.php">
						<i class='bx bx-user-pin'></i>
					</a>
					<span class="text">
						<a href="dosen.php">
							<h3>Dosen</h3>
							<p>Master Data</p>
						</a>
					</span>
				</li>
				<li>
					<a href="mahasiswa.php">
                        <i class='bx bxs-user'></i>
					</a>
					<span class="text">
						<a href="mahasiswa.php">
							<h3>Mahasiswa</h3>
							<p>Master Data</p>
						</a>
					</span>
				</li>
				<li>
					<a href="mk.php">
						<i class='bx bx-note'></i>
					</a>
					<span class="text">
						<a href="mk.php">
							<h3>Matakuliah</h3>
							<p>Master Data</p>
						</a>
					</span>
				</li>
				<li>
					<a href="jadwal.php">
						<i class='bx bx-notepad'></i>
					</a>
					<span class="text">
						<a href="jadwal.php">
							<h3>Jadwal</h3>
							<p>Master Data</p>
						</a>
					</span>
				</li>
			</ul>
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List Matkul</h3>
                        
                        <a href="tambahmk.php" type="button" class="btn btn-outline-primary">Tambah Matkul +</a>
					</div>
					<table>
						<thead>
                            
							<tr>
								<th>Kode MK</th>
								<th>Nama</th>
								<th>SKS</th>
								<th>Semester</th>
								<th>Prodi</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Menampilkan data dari hasil query
							$querymk = "SELECT * FROM mata_kuliah ORDER BY created_at DESC";
							$resultmk = mysqli_query($conn, $querymk);
							while ($mk = mysqli_fetch_assoc($resultmk)) {
								echo "<tr>";
								echo "<td>" . mysqli_real_escape_string($conn, $mk['kode_mk']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mk['nama']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mk['sks']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mk['semester']) . "</td>";
								echo "<td>" . mysqli_real_escape_string($conn, $mk['kode_prodi']) . "</td>";
								echo "<td> <a style='color: var(--blue); font-size: 25px' href='editmk.php?id=" . mysqli_real_escape_string($conn, $mk['id']) . "'>
							 				<i class='bx bx-edit'></i></a>
							 			</td>";
								echo "<td> <a style='color: var(--red); font-size: 25px; cursor: pointer;' onclick='confirmDelete(" . mysqli_real_escape_string($conn, $mk['id']) . ")'>
								 			<i class='bx bxs-trash'></i></a>
								 		</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
                    <!-- Button trigger modal -->
                    
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
    <script>
        function confirmLogout() {
        var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
        if (confirmLogout) {
            window.location.href = "../../../controller/app/logout.php"; // Redirect ke halaman logout jika "OK" ditekan
        } else {
            // Tindakan jika "Cancel" ditekan (opsional)
            // Misalnya: tidak melakukan apa-apa atau menutup dialog
        }
        }
		function confirmDelete(id) {
			var result = confirm("Apakah Anda yakin ingin menghapus data user ini?");
			if (result) {
				// Jika pengguna menekan "OK", redirect ke skrip penghapusan dengan mengirimkan ID
				window.location.href = '../../../controller/app/admin/hapusmk.php?id=' + id;
			} else {
				// Jika pengguna menekan "Cancel", tidak ada tindakan yang diambil
			}
		}
	</script>
    <script src="../../js/script.js"></script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>